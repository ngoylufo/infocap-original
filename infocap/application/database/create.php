<?php
/*
*  -----------------------------------------------------------------------------
*  Small Database :: PHP
*  -----------------------------------------------------------------------------
*  Copyright notices and stuff...
*
*  @package    Small Database :: PHP
*  @author     Ngoy Pedro C. Lufo (change this for the overall project)
*  @version    0.0.1 development
*  @copyright  Copyright (c) 2018, Ngoy Pedro C. Lufo.
*/
namespace Small\Database;
/**
* <b>Create: Query<b/>
*
* Responsible for inserting records into the connected database.
*
* @version 0.0.1 development
*/
class Create extends Query
{
    private function _insert(string $table, array $data)
    {
        $columns = $this->listify(array_keys($data));
        $values = ':' . str_replace(', ', ', :', $columns);
        $this->query_string = "INSERT INTO $table ($columns) VALUES ($values);";
        // echo "$this->query_string";

        $this->execute($data);
    }

    protected function execute(array $data=null)
    {
        $this->prepare();
        parent::execute($data);
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    public function Insert(string $table, array $data)
    {
        $this->_insert($table, $data);
    }

    public function InsertMany(string $table, array $dataset)
    {
        foreach ($dataset as $data)
            $this->_insert($table, $data);
    }

    public function getInsertId()
    {
        return $this->Conn->lastInsertId();
    }
}
