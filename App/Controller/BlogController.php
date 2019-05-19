<?php
namespace App\Controller;

class BlogController extends General
{
    public function addAction( ) {
     $group = new \Validate\Group( [
        [ 'title',  'text' ],
        [ 'text',   'text', [ 'required' => false, 'maxlength' => 255 ] ],
     ] );
     
     if( isset( $_POST['submit_blog_add']) and $group -> isValid( \Validate\Field::METHOD_POST ) )
     {
         $blog = new \App\Model\Blog;
         $blog -> setTitle( $group -> getFieldData( 'title' ) );
         $blog -> setText( $group -> getFieldData( 'text' ) );
         
         if( $blog -> insert() )
             exit( header( 'Location: /blog' ) );
     }
     
     $this -> setData( 'a_error', $group -> getAllError() );
     $this -> setData( 'a_data',  $group -> getAllData() );
    }
    
    public function add2Action() {
        $group = new \Validate\ModelGroup( $blog = new \App\Model\Blog, ['title', 'text'] );
        
        if( $blog = \Model\Manager::init( 'Blog' ) -> find( 9 ) )
              exit( header( 'Location: /blog' ) );  
        
        if( isset( $_POST['submit_blog_add']) and $group -> isValid( \Validate\Field::METHOD_POST ) and $blog -> insert() )
             exit( header( 'Location: /blog' ) );
        
        $this -> setTpl( 'Blog/Add' );
    }
    
    public function createAction( ) {
        
        $group = new \Validate\ModelGroup( $blog = new \App\Model\Blog, ['title', 'text'] );
        
        $form = $this 
               -> createForm( 'add', $group ) 
               -> setField( ['submit_blog_add', 'submit', 'Добавить запись'] );
        
        if ( isset( $_POST['submit_blog_add'] )
            and $group -> isValid( \Validate\Field::METHOD_POST )
            and $blog -> insert() 
        )
            
        exit( header( 'Location: /blog' ) );
        
       // exit('Stoped: <b>' . mf_get_spath() . '</b>');
    }
    public function indexAction()
    {
        
//       $blog = new \App\Model\Blog;
//       $blog -> setTitle( 'Ylia' );
//       $blog -> setText( 'Chavliuk' );
//       $blog -> insert();
//       
//       $blog = new \App\Model\Blog;
//       $blog -> setId( 7 );
//       $blog -> setTitle( 'Hello!' );
//       $blog -> update();
        
//       $blog = new \App\Model\Blog;
//       $blog -> delete( 7 );
//       
        
//          $blog = \Model\Manager::init( 'Blog' ) -> find( 15 );
//          $blog -> setTitle( 'Hello' );
//          $blog -> update();
         
        
//        $blog = \Model\Manager::init( 'Blog' ) ->findAll();
//        foreach ($blog as $model) {
//            $model -> setText( $model -> getText() . '-Ylia-' );
//            $model -> update();
//        }
//        $blog = \Model\Manager::init( 'Blog' ) ->findBy( ['title' => 'Hello'] );
//        echo '<pre>';
//        print_r($blog);
//        echo '</pre>';
        
//        \Model\Manager::init('Blog') -> updateBy( ['text' => '100'], ['title' => 'hello']);
        
//        \Model\Manager::init('Blog') -> deleteBy( ['title' => '161']);
        
       exit( 'Stoped: <b>' . mf_get_spath() . '</b>' );
    }
}

