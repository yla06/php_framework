<?php
namespace Validate;

class Group
{
  /**
   * @var array в этом свойстве сохраняются в виде ассоциативного многомерного
   * массива объекты группы
   */
  protected $_fields = [];
  /**
   * @param array $a_fields описание филдов
   */
  public function __construct( array $a_fields )
  {
    /**
     * Перебор всех филдов и создание "на лету" объектов класса Field на основе
     * описания полей.
     */
    foreach ( $a_fields as $values )
    {
      $attr                        = ( isset( $values[ 2 ] ) ? $values[ 2 ] : [] );
      $this -> _fields[ $values[ 0 ] ] = new Field( $values[ 0 ], $values[ 1 ], $attr );
    }
  }
  /**
   * @return array метод для получения привычного массива $a_data
   */
  public function getAllData()
  {
    $a_data = [];
    foreach ( $this -> _fields as $field )
      $a_data[ $field -> getName() ] = $field -> getData();
    return $a_data;
  }
  /**
   * @return array метод для получения привычного массива $a_error
   */
  public function getAllError()
  {
    $a_error = [];
    foreach ( $this -> _fields as $field )
    {
      if ( is_string( $field -> getError() ) )
        $a_error[ $field -> getName() ] = $field -> getError();
    }
    return $a_error;
  }
  /**
   * Метод что перебирает филды и поочередно посылает их на валидацию. Если хотя бы
   * один филд не пройдет валидацию, вся группа будет считаться как такая, что не прошла
   * валидацию
   *
   * @param int $method метод приема данных записанный в константах Field::METHOD_*
   * @return boolean
   */
  public function isValid( $method = Field::METHOD_POST )
  {
    $valid = true;
    foreach ( $this -> _fields as $field )
    {
      if ( false === $field -> validate( $method ) )
        $valid = false;
    }
    return $valid;
  }
  /**
   * Метод для получения данных одного филда по его имени
   * @param string $name имя филда данные которого надо получить
   * @return mixed
   */
  public function getFieldData( $name )
  {
    return $this -> _fields[ $name ] -> getData();
  }
  /**
   * Метод для получения ошибки одного филда по его имени
   * @param string $name имя филда ошибку которого надо получить
   * @return mixed
   */
  public function getFieldError( $name )
  {
    return $this -> _fields[ $name ] -> getError();
  }
  public function fill( array $a_data )
  {
    foreach ( $a_data as $name => $value )
    {
      if ( isset( $this -> _fields[ $name ] ) )
        $this -> _fields[ $name ] -> setData( $value );
    }
    return $this;
  }
}
