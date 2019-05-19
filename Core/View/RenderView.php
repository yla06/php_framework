<?php
namespace View;

class RenderView
{
    use BlockTrait;  //аналог require_once
    
    protected static $_layout;
    protected static $_tpl;

    public static function render( $tpl ) 
    {
        self::$_tpl = $tpl;
        unset( $tpl );
        
        extract( Storage::getAllData() );
        if(file_exists( EVRIKA_ROOT . '/App/View/Page/' . self::$_tpl . '.php' ) )
              require_once EVRIKA_ROOT . '/App/View/Page/' . self::$_tpl . '.php';
        
        else 
            throw new \Exceptions\DevelException( 'View файл "' .self::$_tpl. '" не найден' );
            
        if( null === self::$_layout)
            exit;
        
        RenderLayout::render();
    }
    
    protected static function setLayout( $name)
    {
        self::$_layout = $name;
    }
    
    public static function getLayout( )
    {
        return self::$_layout;
    }
    
    public static function getBlock( $name )
    {
        return ( isset( self::$_block[ $name ] ) ) ? self::$_block[ $name ] : null;
    }
    
    public static function issetBlock( $name )
    {
        return isset( self::$_block[ $name ] );
    }
    
    public static function getToken()
    {
        return '';
    }
}

