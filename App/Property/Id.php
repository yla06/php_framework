<?php
namespace App\Property;

class Id extends \Validate\ValidateAbstract
{
    protected $_element = Text::ELEM_TEXT;
    
    public function check( $data )
  {
    if ( ! $data )
      return 'Вы не передали ID';
    if ( ! ctype_digit( $data ) )
      return 'Вы передали ID который не есть числом';
    if ( $data > 4294967295 )
      return 'ID слишком большой';
    return true;
  }
}


