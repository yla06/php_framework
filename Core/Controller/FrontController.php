<?php
namespace Controller;

use \Exceptions\DevelException;

class FrontController
{
    private static $init = false;
    
    public static function init( )
    {
        if ( self::$init === true )
            throw new DevelException( 'FrontController уже был запущен ранее' );
        
        self::$init = true;
        $route = \Route\Router::findRule();
        
        if( ! isset( $route[ 'controller' ], $route[ 'action' ]))
                self::e404();
        
        $controller = "App\\Controller\\" . ucfirst( mb_strtolower( $route['controller'] ) ) . "Controller";
        $action     = mb_strtolower( $route['action'] ) . "Action";
        
        if( false === \Autoload::nameSpaceExists( $controller ) )
            self::e404();
        
        $rc = new \ReflectionClass( $controller ) ;
        
        if( false === $rc -> hasMethod( $action ) )
            self::e404();
        $cont = new $controller;
        
        if( false === $cont instanceof PageControllerAbstract )
            throw new DevelException( 'Контроллер ' . $controller . ' не наследует PageControllerAbstract' );
        
        $cont -> setTpl( ucfirst( mb_strtolower( $route['controller'] ) ) . '/' . ucfirst( mb_strtolower( $route['action'] ) ) );
        $cont -> $action();
        $cont -> render();
        
//        echo '<pre>';
//        print_r($controller);
//        echo '</pre>';
//        
//        echo '<pre>';
//        print_r($action);
//        echo '</pre>';
        
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
    }
    
    protected static function e404()
    {
        http_response_code( 404 );
        //exit( 'Not Found' );
        \View\RenderView::render( 404 );
    }
}
