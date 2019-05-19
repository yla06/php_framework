<?php
namespace Exceptions;

class BaseException extends \Exception
{
     /**
   *
   * @param \Exception $e
   */
    public static function exceptionHandler( $e )
    {
      self::log( 'exception', $e -> getMessage(), $e -> getFile(), $e -> getLine(), $e -> getTrace() );
      self::stop( $e -> getMessage(), $e -> getFile(), $e -> getLine(), $e -> getTrace() );
    }

    public static function errorHandler( $errno, $errstr, $errfile, $errline )
    {
      $debug = debug_backtrace();
      self::log( 'error', $errstr, $errfile, $errline, $debug );
      self::stop( $errstr, $errfile, $errline, $debug );
    }
    protected static function stop( $desc, $file, $line, $trace )
    {
        require EVRIKA_ROOT . '/Core/Exceptions/Oops.php';
        exit;
    }
    
    protected static function log($type, $desc, $file, $line, $trace) {
        return true;
    }
}


