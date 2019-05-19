<?php
namespace View;

class Storage
{
    private static $_data = [];
    
    public static function setData( $name, $value, $secure = true ) 
    {
        self::$_data[$name] = ( $secure ) ? self::xss( $value ) : $value;
    }
    
    public static function getData($name) 
    {
        return ( isset ( self::$_data[$name] ) ) ? self::$_data[$name] : null;
    }
    
    public static function remover( $name) 
    {
        unset( $_data[$name] );
    }
    public static function getAllData( ) 
    {
        return self::$_data;
    }
    public static function removerAllData( ) 
    {
       self::$_data= [];
    }
 /**
   * Метод обработки печатных данных от XSS
   *
   * @param mixed $data
   * @return mixed
   */
  private static function xss( $data )
  {
    if ( is_array( $data ) )
    {
      array_walk_recursive(
        $data,
        function( &$item, $key ){
          $item = htmlspecialchars( $item );
        }
      );
      return $data;
    }

    return htmlspecialchars( $data );
  }
 
}

