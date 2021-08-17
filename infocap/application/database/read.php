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
* <b>Read: Query</b>
*
* Responsible for selecting records from database tables.
*
* @version 0.0.1 development
*/
class Read extends Query
{
    protected function execute(array $data=null)
    {
        $this->prepare();
        $this->bind_values();
        parent::execute($data);
        $this->success = (bool) $this->getRowCount();
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    public function Select($table, $columns='*', $terms=null, $params=null)
    {
        # Make Sure Columns Are Proper!
        $columns = $this->listify($columns);
        $this->query_string = "SELECT $columns FROM $table $terms;";
        $this->parse_params($params);
        $this->execute();
    }

    public function Distinct($table, $columns='*', $terms=null, $params=null)
    {
        # Make Sure Columns Are Proper!
        $columns = $this->listify($columns);
        $this->query_string = "SELECT DISTINCT $columns FROM $table $terms";
        $this->parse_params($params);
        $this->execute();
    }

    public function BindValues($values)
    {
        if (!is_array($values))
            $values = parse_str($values);

        $this->params = array_merge($this->params, $values);
        $this->bind_values();
    }

    public function ExecuteQuery()
    {
        if ($this->Query)
            $this->execute();
    }

    public function getRowCount() {
        return $this->Query->rowCount();
    }

    public function getResultSet()
    {
        return $this->Query->fetchAll();
    }
}
