<?php
namespace View;

class Form
{
    const METHOD_POST = 'post';
    const METHOD_GET  = 'get';
    
    protected $_fields;
    protected $_method = self::METHOD_POST;
    protected $_action = '';
    
    public function __construct( \Validate\ModelGroup $group) { // в конструкторы не бажано викидати исключения
        foreach ($group ->getFields() as $field ) 
        {
         $this -> _fields[$field -> getName()] = $field;   
        } 
    }
    
    public function setAction( $action )
    {
        $this -> _action = $action;
    }
    
    public function getAction( )
    {
        return $this -> _action;
    }

    public function setMethod( $method ) 
    {
        if( $method != self::METHOD_GET or $method != self::METHOD_POST )
            throw new \Exceptions\DevelException( 'Bad method' );
        
            $this -> _method = $method; 
    }
    
    public function getMethod( ) 
    {
       return $this -> _method; 
    }
    
    public function setField( array $rule ) 
    {
        $attr = ( isset( $rule[3] ) ? $rule[3] : [] );
        $this -> _fields[$rule[0]] = new \Validate\Field( $rule[0], $rule[1], $rule[2], $attr );
        return $this;
    }
    
    public function renderForm() 
    {
        echo '<form action="' . $this -> _action . '" method="' . $this -> _method . '">';
        foreach ($this -> _fields as $name => $field) {
            $this ->renderFieldBox( $name );
        }

        echo '</form>';
    }
    
    public function renderFieldBox($name) 
    {
        $this ->renderFieldLabel($name);
        $this ->renderField($name);
        $this ->renderFieldInfo($name);  
        
    }
    
    public function renderField($field_name) 
    {
        $element = $this -> _fields[$field_name] -> getValidateElement();
        $attr    = $this -> _fields[$field_name] -> getValidateAttr();
        
        switch ( $element )
        {
            case 'text':
            case 'password':
            case 'file':
            case 'radio':
            case 'checkbox':
            case 'submit':
            case 'reset':
                $s_attr = '';
                
                foreach ( $attr as $name => $value )
                {
                    if ( in_array( $name, ['require', 'class', 'id', 'maxlength', 'disabled', 'readonly', 'checked'] ) )
                            $s_attr .=' ' . $name . '="' . $value . '"';
                }    
                
                $val = ( $element != 'submit') ? $this -> _fields[$field_name] -> getData() : $this -> _fields[$field_name] -> getLabel();
                echo '<input  value ="'  . $val. '" type="' . $element . '" name="' .$field_name . '"' . $s_attr. ' />';
                break;
            
            case 'textarea':
                $s_attr = '';
                
                foreach ( $attr as $name => $value )
                {
                    if ( in_array( $name, ['require', 'class', 'id', 'disabled', 'readonly'] ) )
                            $s_attr .=' ' . $name . '="' . $value . '"';
                }    
                echo '<textarea name="' .$field_name  . '"' . $s_attr. '>' . $this -> _fields[$field_name] -> getData() . '</textarea>';
                break;
            case 'select':
            case 'selectm':
                $s_attr = '';
                
                foreach ( $attr as $name => $value )
                {
                    if ( in_array( $name, ['require', 'class', 'id', 'disabled', 'readonly', 'multiple'] ) )
                            $s_attr .=' ' . $name . '="' . $value . '"';
                }    
                
                $values = ( isset( $attr['values'] ) ) ? $attr['values'] : [];
                    
                echo '<select name="' .$field_name  . '"' . $s_attr. '>';
                
                foreach ( $values as $label => $value )
                    echo '<option value="' . $value . '">' . $label . '</option>';
                
                echo '</select>';
                break;
            default:
                throw  new \Exceptions\DevelException( 'Bad element' );
                break;
        }
        
        echo '<br />';
    }
    
    public function renderFieldInfo($name) 
    {
        $error = $this-> _fields[$name] ->getError();
        
        if ( $error )
            echo '<div style="color: red">' . $error . '</div>';
    }
    
    public function renderFieldLabel($name) 
    {
        if( 'submit' != $this -> _fields[$name] ->getValidateElement() )
          echo "<div>" . $this -> _fields[$name] ->getLabel( ) . "</div>";
    }
}
