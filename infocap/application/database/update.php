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
* <b>Update: Query</b>
*
* Responsible for updating database records.
*
* @version 0.0.1 development
*/
class Update extends Query
{
    protected function execute(array $data=null)
    {
        $this->prepare();
        parent::execute();
    }

    private function _update($table, array $data, $terms)
    {
        foreach ($data as $column => $value)
            $dataset[] = "$column=:$column";
        $dataset = $this->listify($dataset);
        $this->query_string = "UPDATE $table SET $dataset $terms;";

        $data = array_merge($this->params, $data);
        $this->execute($data);
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    public function Update($table, array $data, $terms=null, $params=null)
    {
        $this->parse_params($params);
        $this->_update($table, $data, $terms);
    }

    public function UpdateMany($table, array $dataset, $terms=null, array $params)
    {
        foreach ($dataset as $index => $data)
        {
            $this->parse_params($params[$index]);
            $this->_update($table, $data, $terms);
        }
    }
}
