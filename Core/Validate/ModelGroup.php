<?php
namespace Validate;

class ModelGroup
{
     protected $_fields = [];
     protected $_model = [];
     
  public function __construct( \Model\ModelAbstract $model, array $a_fields )
  {
         $this -> _model = $model;
    foreach ( $a_fields as $alias )
    {
      $rule = $model ->exportRule($alias);
      
      $attr = ( isset( $rule[3] ) ? $rule[3] : [] );
      $this -> _fields[ $alias ] = new Field( $rule[0], $rule[1], $rule[2], $attr );
    }
  }
  
  public function getAllData()
  {
    $a_data = [];
    foreach ( $this -> _fields as $field )
      $a_data[ $field -> getName() ] = $field -> getData();
    return $a_data;
  }
  
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
  
  public function isValid( $method = Field::METHOD_POST )
  {
    $valid = true;
    foreach ( $this -> _fields as $alias => $field )
    {
      if ( false === $field -> validate( $method ) )
        $valid = false;
      else 
      {
          $setter = "set" . ucfirst( $alias );
          $this -> _model -> $setter( $field -> getData() );
      }    
    }
    return $valid;
  }
  
  public function getFieldData( $name )
  {
    return $this -> _fields[ $name ] -> getData();
  }
  
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
  
  public function getFields()
  {
       return $this -> _fields;
  }
  
  public function getField( $name ) 
  {
       if( ! isset( $this -> _fields[$name] ) ) 
           throw new \Exceptions\DevelException( 'Field not exists' );

        return $this -> _fields[$name];
  }
}
