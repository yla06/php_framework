<?php
namespace Model;

abstract class ModelAbstract implements ModelInterface
{
    private $_data;
    
    public function save()
    {
        
    }
    
    public function insert()
    {
        $data = $this ->returnData();
        
        if( ! $data )
            throw new \Exceptions\DevelException( 'Нет установленых значений полей модели' );
        
        $sql = "INSERT INTO {$this -> _table} SET";
        
        $pl = [];
        
        foreach ( $data as $alias => $value ) 
        {
            $sql .="`{$this -> _rules[$alias][0]}` = :{$alias}, ";
            $pl[$alias] = $value;
        }
        
        $sql = rtrim( $sql, ', ');
        return \Database\DB::query( $sql, $pl );
    }
    
    public function update()
    {
        $data = $this ->returnData();
        $id = $data[$this -> _pk];
        unset( $data[$this -> _pk] );
        
        if( ! $data )
            throw new \Exceptions\DevelException( 'Нет установленых значений полей модели' );
        
        $sql = "UPDATE `{$this -> _table}` SET ";
        $pl = [$this -> _pk => $id];
        
        foreach ( $data as $alias => $value ) 
        {
            $sql .="`{$this -> _rules[$alias][0]}` = :{$alias}, ";
            $pl[$alias] = $value;
        }
        
        $sql = rtrim( $sql, ', ');
        
        $sql .= " WHERE `{$this -> _rules[$this -> _pk][0]}` = :{$this -> _pk} ";
        
        return \Database\DB::query( $sql, $pl );
    }
    
    public function delete( $id = null)
    {
        $sql = " DELETE FROM `{$this -> _table}` WHERE `{$this -> _rules[$this -> _pk][0]}` = :{$this -> _pk} ";
        
        return \Database\DB::query( $sql, [$this -> _pk => $id] );
    }
    
    public function __call( $name, $arguments )
    {
        if( 0 === strpos( $name, 'set' ) )
        {
            $alias = $this ->checkAlias( substr( $name, 3) );

                if( count( $arguments ) != 1 )
                    throw new \Exceptions\DevelException( 'Too much arguments ' . __CLASS__. '::' . $name . '()' );
                
                $this -> _data[$alias] = $arguments[0]; 
        }
        else if( 0 === strpos( $name, 'get' ) )
        {
            $alias = $this ->checkAlias( substr( $name, 3) );
            
            if ( count( $arguments ) != 0 )
                throw new \Exceptions\DevelException( 'Too much arguments ' . __CLASS__ . '::' . $name . '()' );

            return $this -> _data[ $alias ];

        }
        else 
            throw new \Exceptions\DevelException( 'Call to undefined method ' . __CLASS__. '::' . $name . '()');
    }
    private function  checkAlias( $alias)
    {
        $alias = lcfirst( $alias );

        if( ! isset( $this -> _rules[$alias] ) )
            throw new
             \Exceptions\DevelException( 'No alias ' . $alias );
        
        return $alias;
    }
    
    public function returnData()
    {
        return ( isset($this -> _data) ) ? $this -> _data : [];
    }
    
    public function loadData( array $data) {
        $a_aliases = [];
        
        foreach ( $this -> _rules as $alias => $row)
            $a_aliases[$row[0]] = $alias;
        
        foreach ($data as $row_name => $value) {
            $this -> _data[ $a_aliases[ $row_name ] ] = $value;
        }
        return $this;    
    }
    
    public function exportRule($alias) 
    {
        return $this -> _rules[$alias];
    }
}

