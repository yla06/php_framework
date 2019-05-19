<?php
namespace Route;
class Router
{
  const CONTROLLER = 1;
  const ACTION     = 2;
  protected static $_default_controller = 'Index';
  protected static $_default_action     = 'Index';
  protected static $_furl = [];
  protected static $_rules = [];
  public static function setRule( $uri, array $settings )
  {
    if ( ! isset( $settings[0] ) or ! is_string( $settings[0] ) or ! self::checkName( $settings[0] ) )
      throw new \Exceptions\DevelException('Имя контроллера должно быть A-z0-9');
    if ( ! isset( $settings[1] ) or ! is_string( $settings[1] ) or ! self::checkName( $settings[1] ) )
      throw new \Exceptions\DevelException('Имя метода должно быть A-z0-9');
    self::$_rules[ $uri ] = [
      'controller' => $settings[0],
      'action'     => $settings[1],
    ];
  }
  public static function getRule( $uri )
  {
    return ( isset( self::$_rules[$uri] ) ) ? self::$_rules[$uri] : null;
  }
  public static function removeRule( $uri )
  {
    unset( self::$_rules[$uri] );
  }
  public static function findRule(  )
  {
    $uri = preg_replace( '#(\.{2,}|\.\/|/\.+)#ui', '', addslashes(
      str_replace( "?{$_SERVER['QUERY_STRING']}", '', $_SERVER['REQUEST_URI'] )
    ) );
    if ( isset( self::$_rules[ $uri ] ) )
      return self::$_rules[ $uri ];
    else
    {
      self::$_furl = explode( '/', $uri );
      return [
        'controller' => self::validate( self::CONTROLLER ),
        'action'     => self::validate( self::ACTION ),
      ];
    }
  }
  public static function setDefaultController( $name )
  {
    self::$_default_controller = $name;
  }
  public static function getDefaultController(  )
  {
    return self::$_default_controller;
  }
  public static function setDefaultAction( $name )
  {
    self::$_default_action = $name;
  }
  public static function getDefaultAction(  )
  {
    return self::$_default_action;
  }
  protected static function validate( $type )
  {
    if ( isset( self::$_furl[$type] ) and self::$_furl[$type] )
    {
      if ( self::checkName( self::$_furl[$type] ) )
        $data = self::$_furl[$type];
      else
        $data = null;
    }
    else
      $data = ( self::CONTROLLER == $type ) ? self::$_default_controller : self::$_default_action;
    return $data;
  }
  protected static function checkName( $data )
  {
    return preg_match( '#^[a-z][a-z0-9]{0,19}$#i', $data );
  }
}
