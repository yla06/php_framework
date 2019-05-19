<?php
namespace View;

class RenderLayout
{
    use BlockTrait;
     
    public static function render()
    {
       
        if( file_exists( EVRIKA_ROOT . '/App/View/Layout/' . RenderView::getLayout() . '.php' ) )
              require_once EVRIKA_ROOT . '/App/View/Layout/' . RenderView::getLayout() . '.php';
          else 
             throw new \Exceptions\DevelException( 'Layout файл "' . RenderView::getLayout() . '" не найден' );
    }
    
    protected static function declareBlock( $name )
    {
        if ( RenderView::issetBlock($name) ) 
            echo RenderView::getBlock ($name);
    }
    
    protected static function endBlock( )
    {
        if( self::$_curr_block === null )
            throw new \Exceptions\DevelException( 'Вызов завершения блока без его старта' );
       
        $buffer = ob_get_clean();
        if ( RenderView::issetBlock(self::$_curr_block) ) 
            echo RenderView::getBlock (self::$_curr_block);
        
        else 
           echo $buffer;
        
        
        
        
        self::$_curr_block = null; 
        
    }
}
