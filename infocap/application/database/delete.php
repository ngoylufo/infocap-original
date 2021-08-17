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
* <b>Delete: Query</b>
*/
class Delete extends Query
{

    protected function execute(array $data=null)
    {
        $this->prepare();
        $this->bind_values();
        parent::execute();
    }

    private function _delete($table, $terms, $params=null)
    {
        $this->query_string = "DELETE FROM $table $terms";
        $this->parse_params($params);
        $this->execute();
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    public function Delete($table, $terms, $params=null)
    {
        $this->_delete($table, $terms, $params);
    }

    public function DeleteMany($table, $terms, array $paramset)
    {
        foreach ($paramset as $params)
            $this->_delete($table, $terms, $params);
    }
}
