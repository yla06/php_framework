<?php
namespace Model;

class Manager
{
    public static function init( $model_name )
    {
        $model = "App\\Model\\{$model_name}";
        
        if( false === \Autoload::nameSpaceExists( $model ) )
            throw new \Exceptions\DevelException( 'Model "' . $model. '" not found' );
        
        return new ManagerHelper( $model );
    }
}

