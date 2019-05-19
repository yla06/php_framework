<?php
namespace View;

class RenderForm
{
    private static $_forms = [];
    
    public static function setForm( $name, Form $form )
    {
        if( isset( self::$_forms[$name] ) )
            throw new \Exceptions\DevelException( 'Form exists' );
        
        self::$_forms[$name] = $form;
    }
    
    public static function getForm( $name )
    {
        if( ! isset( self::$_forms[$name] ) )
            throw new \Exceptions\DevelException( 'Form not exists' );
           
        return self::$_forms[$name];
    }
        
    public static function removeForm( $name )
    {
        nset( self::$_forms[$name] );
    }
        
    public static function issetForm( $name )
    {
        return isset( self::$_forms[$name] );
    }
}


