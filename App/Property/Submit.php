<?php
namespace App\Property;

class Submit extends \Validate\ValidateAbstract
{
    protected $_element = Text::ELEM_SUBMIT;
    
    public function check( $data )
  {
    return true;
  }
}


