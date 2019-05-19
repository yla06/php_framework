<?php
namespace App\Property;

class Textarea extends Text
{
  protected $_attr = [
    'required'  => true,
    'minlength' => 1,
    'textarea'  => true,
    'maxlength' => 65000,
  ];
  
  protected  $_element = Text::ELEM_TEXTAREA;
}
