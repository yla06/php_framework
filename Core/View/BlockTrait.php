<?php
namespace View;

trait BlockTrait
{
    protected static $_block = [];
    protected static $_curr_block;
    
     protected static function startBlock( $name )
    {
        if( self::$_curr_block !== null )
            throw new \Exceptions\DevelException( 'Двойная декларация блока' );
            
        self::$_curr_block = $name;
        ob_start();
    }
    
    protected static function endBlock( )
    {
        if( self::$_curr_block === null )
            throw new \Exceptions\DevelException( 'Вызов завершения блока без его старта' );
        
        self::$_block[self::$_curr_block] = ob_get_clean();
        self::$_curr_block = null; 
    }
}
