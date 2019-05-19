<?php
namespace App\Controller;

class StaticController extends General
{
    public function contactAction() 
    {
        
//        $this -> setData( 'foo', 123 );
//        $this -> setData( 'bar', [1,2,3] );
//        
//        $this ->setArrayData([
//            'baz' => 777,
//            'quz' => [3,2,1],
//        ]);
        
        $this -> setData( 'foo', 123 )
              -> setData( 'bar', [1,2,3] )
              -> setArrayData([
                 'baz' => 777,
                 'quz' => [3,2,1],
                ] );
        
//        $foo = 'Hello';
//        \View\Storage::setData( 'bar', $foo );
//        $this ->setData( 'var', 'world');
//        
//        echo '<pre>';
//        print_r(\View\Storage::getAllData());
//        echo '</pre>';
        
//        $this ->setTpl('Static/Test');
      
    }
}
