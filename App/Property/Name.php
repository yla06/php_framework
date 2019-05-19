<?php
namespace App\Property;

class Name extends \Validate\ValidateAbstract
{
    public function check( $data )
  {
    if ( ! $data )
      return 'Вы не передали имя';
 
    if ( mb_strlen( $data ) > 20 )
      return 'Имя не должно быть больше 20 символов';
 
    return true;
  }
}

