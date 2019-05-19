<?php
namespace Model;

class ManagerHelper
{
    protected $_model;
    protected $_properties;
    
    public function __construct($name) {
        $this -> _model = $name ;
        
        $class = new \ReflectionClass( $this -> _model );
        $this -> _properties = $class ->getDefaultProperties();
    }
    
    public function find( $pk )
    {
      $sql = "SELECT * FROM `{$this -> _properties['_table']}` WHERE `{$this -> _properties['_rules'][$this -> _properties['_pk']][0]}` =:pk";
        
      $data = \Database\DB::query($sql, ['pk' => $pk]);
      
      if( ! $data -> rowCount(  ))
          return false;
     
      $model = new $this -> _model;
      $model -> loadData( $data -> fetch() );
      return $model;
      
    }
    protected function prepareSelect( $data )
    {
        if( ! $data -> rowCount(  ))
          return [];
        
        $a_return = [];
        
        while( $row = $data -> fetch( ) )
        {
           $model = new $this -> _model;
           $model -> loadData( $row ); 
           $a_return[] = $model;
        }       
        return $a_return;
    }        

    public function findAll() {
        $sql = "SELECT * FROM `{$this -> _properties['_table']}` ";
        $data = \Database\DB::query( $sql );
        
        return $this -> prepareSelect( $data );
    }
    
    public function findBy( array $arg ) {
        $sql = "SELECT * FROM `{$this -> _properties['_table']}` WHERE ";
        $pl = [];
        
        foreach ( $arg as $alias => $value )
        {
         $sql .= "`{$this -> _properties['_rules'][$alias][0]}` =:{$alias} AND ";   
         $pl[$alias] = $value;
        }    
        
        $sql = rtrim( $sql, 'AND' );
        $data = \Database\DB::query( $sql, $pl );
        
        return $this -> prepareSelect( $data );
    }
    
    public function updateBy( array $set, array $where ){
        $sql = "UPDATE  `{$this -> _properties['_table']}`  SET";
        
        $pl = [];
        
        foreach ( $set as $alias => $value )
        {
         $sql .= "`{$this -> _properties['_rules'][$alias][0]}` =:{$alias}, ";   
         $pl[$alias] = $value;
        }    
        $sql = rtrim( $sql, ', ' ) . " WHERE ";
        
        foreach ( $where as $alias => $value )
        {
         $sql .= "`{$this -> _properties['_rules'][$alias][0]}` =:{$alias} AND ";   
         $pl[$alias] = $value;
        }    
        $sql = rtrim( $sql, ' AND ' );
        
        return \Database\DB::query( $sql, $pl );
    }
    
    public function deleteBy( array $where ){
        $sql = "DELETE FROM  `{$this -> _properties['_table']}` WHERE ";
        
        $pl = [];
        
        foreach ( $where as $alias => $value )
        {
         $sql .= "`{$this -> _properties['_rules'][$alias][0]}` =:{$alias} AND ";   
         $pl[$alias] = $value;
        }    
        $sql = rtrim( $sql, ' AND ' );
        
        return \Database\DB::query( $sql, $pl );
    }
}
