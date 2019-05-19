<?php
namespace Validate;

abstract class ValidateAbstract
{
  /**
   * Системные константы которые указывают на тип валидатора.
   *
   * TYPE_STRING используется по умолчанию для всех дочерних классов валидаторов
   * и определяет, что вадидатор работает со строками
   *
   * TYPE_ARRAY используется для валидаторов которые работают с массивами
   *
   * TYPE_FILE используется для валидаторов загружаемых файлов
   *
   * при необходимости создать валидатор для массива или файла, необходимо в нем
   * перегрузить свойство класса:
   * protected $_type = ValidateAbstract::TYPE_FILE; //Для файла
   * protected $_type = ValidateAbstract::TYPE_ARRAY; // Для массива
   */
  const TYPE_STRING = 1;
  const TYPE_ARRAY  = 2;
  const TYPE_FILE   = 3;
  
  const ELEM_TEXT       = 'text';
  const ELEM_TEXTAREA   = 'textarea';
  const ELEM_PASSWORD   = 'password';
  const ELEM_FILE       = 'file';
  const ELEM_RADIO      = 'radio';
  const ELEM_CHECKBOX   = 'checkbox';
  const ELEM_SELECT     = 'select';
  const ELEM_SELECTM    = 'selectm';
  const ELEM_SUBMIT     = 'submit';
  const ELEM_RESET      = 'reset';
  
  protected $_element;
  /**
   * @var int свойство указывающее на тип валидатора с которым он работает.
   */
  protected $_type = ValidateAbstract::TYPE_STRING;
  /**
   * @var array свойство стандартных для всех атрибутов валидаторов
   */
  protected $_attr = [
    'required' => true,
  ];
  /**
   * Указываем, что при создании дочерних классов в них необходимо переопределить
   * метод проверки данных поскольку он должен быть индивидуальных для каждого
   * валидатора
   */
  public abstract function check( $data );
  /**
   * @return int Геттер свойства _type
   */
  public function getType(  )
  {
    return $this -> _type;
  }
  /**
   * Метод для установки и переопределения стандартных атрибутов валидатора
   * Должен передаться как массив
   *
   * @param array $attr устанавливаемые атрибуты валидатора
   * @return boolean|$this
   */
  public function setAttribute( array $attr )
  {
    $this -> _attr = array_merge( $this -> _attr, $attr );
    return $this;
  }
  
  public function getAttr()
  {
      return $this -> _attr;
  }
  
  public function getElement()
  {
      return $this -> _element;
  }
}
