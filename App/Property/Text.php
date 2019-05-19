<?php
namespace App\Property;

class Text extends \Validate\ValidateAbstract
{
  protected $_attr = [
    'required'  => true,
    'minlength' => 1,
    'textarea'  => false,
    'maxlength' => 65000,
  ];
  
  protected  $_element = Text::ELEM_TEXT;
  
  public function check( $data )
  {
    if ( $this -> _attr['required'] === false and $data === '' )
      return true;
    if ( $this -> _attr['required'] === true and $data === '' )
      return 'Вы не передали данные';
    if ( false === $this -> _attr['textarea'] and false !== strpos( $data, "\n" ) )
      return 'В Вашем тексте обнаружены переносы строк';
    $len = mb_strlen( $data );
    if ( $this -> _attr['minlength'] > $len )
      return "Ваш текст должен быть минимум {$this -> _attr['minlength']} символов";
    if ( $this -> _attr['maxlength'] < $len )
      return "Ваш текст должен быть максимум {$this -> _attr['maxlength']} символов";
    return true;
  }
}
