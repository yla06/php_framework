<?php
namespace Validate;

class Field
{
  /**
   * @var string название параметра которое надо получить и обработать с данных,
   * что приходят от пользователя. То есть, когда надо принять данные например
   * user_name с суперглобального массива _GET или _POST мы пишем:
   * $foo = $_GET['user_name'] или $bar = $_POST['user_name'] в этом случае
   * user_name и есть названием параметра который надо принять. Метод приема(get, post, etc)
   * определяется позже
   */
  protected $_name;
  /**
   * @var object ValidateAbstract объект валидатора который будет производить проверку
   * полученных данных
   */
  protected $_validate;
  /**
   * @var mixed свойство для хранения данных, что пришли от пользователя. Автоматом
   * заполняет свое значение в момент вызова метода getDataMethod
   */
  protected $_data;
  /**
   * @var string контейнер для записи теста ошибок при валидации данных филда. То,
   * что будет возвращать класс валидатор при проверке данных в случае ошибки будет
   * сохранено здесь
   */
  protected $_error;
  
  /**
   * @var string контейнер для записи названия поля формы
   */
  protected $_label;
  
  /**
   * Системные константы которые указывают допустимые методы приема данных от пользователя
   */
  const METHOD_POST    = 1;
  const METHOD_GET     = 2;
  const METHOD_COOKIE  = 3;
  const METHOD_REQUEST = 4;
  /**
   *
   * @param text $name название параметра
   * @param text $validate название класса валидатора
   * @param array $attr дополнительные атрибуты для валидатора
   */
  public final function __construct( $name, $validate, $label, array $attr = [] )
  {
    $this -> _name  = $name;
    $this -> _label = $label;
    /**
     * Этот код создает "на лету" объект валидатора и устанавливает в него возможные
     * атрибуты, которые надо учитывать при валидации для написания универсальных валидаторов
     */
    $validate = "\\App\\Property\\" . ucfirst( $validate );
    $this -> _validate = new $validate;
    $this -> _validate -> setAttribute( $attr );
  }
  /**
   * @return mixed геттер свойства _data
   */
  public function getData(  )
  {
    return $this -> _data;
  }
  public function setData( $data )
  {
    return $this -> _data = $data;
  }
  /**
   * @return text геттер свойства _error
   */
  public function getError(  )
  {
    return $this -> _error;
  }
  /**
   * @return text геттер свойства _name
   */
  public function getName(  )
  {
    return $this -> _name;
  }
  /**
   * Основной метод валидации данных
   *
   * @param int $method принимает одну из возможных констант Field::METHOD_*
   * @return boolean
   */
  public function validate( $method = Field::METHOD_POST )
  {
    /**
     * Получение данных с нужного суперглобального массива по имени _name
     * Данные после получения попадают в свойство _data
     */
    $this -> getDataMethod( $method );
    /**
     * Посылаем на валидацию данные $this -> _data в валидатор, который записан
     * в свойство _validate и получаем результат валидации
     */
    $status = $this -> _validate -> check( $this -> _data );
    /**
     * Если по результат валидации есть строкой, это означает, что метод валидации
     * данных check возвратил текст ошибки. Когда ошибок валидации нет, он возвращает
     * булево true
     */
    if ( is_string( $status ) )
    {
      $this -> _error = $status;
      return false;
    }
    else
      return true;
  }
  /**
   * Данный метод используется для получения единого массива с данными того
   * суперглобального массива, который нужен для приема данных. Далее эти данные
   * будут использованы в методе getDataMethod для получения нужных данных по их ключу
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   * @return array
   */
  protected function getAllDataFromMethod( $method )
  {
    switch ( $method )
    {
      case Field::METHOD_POST :    return $_POST;
      case Field::METHOD_GET :     return $_GET;
      case Field::METHOD_COOKIE :  return $_COOKIE;
      case Field::METHOD_REQUEST : return $_REQUEST;
      default : return [];
    }
  }
  /**
   * Метод который получает данные от пользователя
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   */
  protected function getDataMethod( $method )
  {
    $type = $this -> _validate -> getType();
    $data = $this -> getAllDataFromMethod( $method );
    switch ( $type )
    {
      case ValidateAbstract::TYPE_STRING:
        $this -> _data = ( isset( $data[$this -> _name] ) and is_string( $data[$this -> _name] ) )
          ? trim( $data[$this -> _name] ) : '';
        break;
      case ValidateAbstract::TYPE_ARRAY:
        $this -> _data = ( isset( $data[$this -> _name] ) and is_array( $data[$this -> _name] ) )
          ? $data[$this -> _name] : [];
        break;
      case ValidateAbstract::TYPE_FILE:
        $this -> _data = ( isset( $_FILES[$this -> _name] ) ) ? $_FILES[$this -> _name] : [];
        break;
      default : exit( 'Error! Undefined type' );
    }
  }
  
  public function getLabel() 
  {
      return $this -> _label;
  }
  
  public function getValidateElement() 
  {
      return $this -> _validate -> getElement();
  }
  
  public function getValidateAttr() 
  {
      return $this -> _validate -> getAttr();
  }
}
