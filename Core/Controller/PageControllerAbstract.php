<?php
namespace Controller;

class PageControllerAbstract
{ 
    private static $_tpl; //містить назву шаблону
    
    public static function setTpl( $name ) 
    {
        self::$_tpl = $name;
    }
    
    public static function getTpl( ) 
    {
        return self::$_tpl;
    }
    
    public function setData ( $name, $value, $secure = true) 
    {
        \View\Storage::setData( $name, $value, $secure );
        return $this;
    }
    public function setArrayData ( Array $data) 
    {
        foreach ( $data as $key => $value )
        {
            $this -> setData( $key, $value );
            return $this;
        }
    }
    
    public function render( $tpl = false ) 
    {
        if( $tpl )
            self::setTpl ( $tpl );
        
        \View\RenderView::render( self::getTpl() );
       
    }
    protected function createForm( $name, \Validate\ModelGroup $group, $method = null ) {
        
        $form = new \View\Form( $group );
        
        if( isset( $method ))
            $form -> setMethod( $method );
        
        \View\RenderForm::setForm($name, $form);
        return $form;
    }
}

