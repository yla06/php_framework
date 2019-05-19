<?php
define( 'EVRIKA_HEADTIME', microtime( true ) );
define ( 'EVRIKA_HEAD_MEMORY_USG', memory_get_usage( ) );//показуєскільки затрачаться памяті

chdir( '../' );//вказуэ системы вийти на рывень вище папки public_html
define( 'EVRIKA_ROOT', getcwd( ) );

require_once EVRIKA_ROOT . '/Core/Debug.php';
require_once EVRIKA_ROOT . '/Core/Autoload.php';

Autoload::setFileExts( ['php'] );
Autoload::setNamespaces([
    'App'        => EVRIKA_ROOT . "/App",
    'Exceptions' => EVRIKA_ROOT . "/Core/Exceptions",
    'Route'      => EVRIKA_ROOT . "/Core/Route",
    'Controller' => EVRIKA_ROOT . "/Core/Controller",
    'View'       => EVRIKA_ROOT . "/Core/View",
    'Model'      => EVRIKA_ROOT . "/Core/Model",
    'Database'   => EVRIKA_ROOT . "/Core/Database",
    'Validate'   => EVRIKA_ROOT . "/Core/Validate",
    
]);

spl_autoload_register( ['\Autoload', 'loadClass'] );

set_exception_handler( ['Exceptions\BaseException', 'exceptionHandler'] );
set_error_handler( ['Exceptions\BaseException', 'errorHandler'], E_ALL );


require_once EVRIKA_ROOT . '/App/Config/Global.php';

//echo '<pre>';
//print_r(1);
//echo '</pre>';
//exit(  'Stoped: <b>' . mf_get_spath() . '</b>' ); перевіряємо час і память

