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
use PDO, PDOException;
/**
* <b>Query</b>
*
* Abstract class defining the basic functionality to classes responsible for
* executing queries against the database connected to.
*
* @version 0.0.1 development
*/
abstract class Query
{
    /* The raw query string used to create the PDOStatement. */
    protected $query_string;
    /* The data with which to INSERT|UPDATE a record. */
    protected $data;
    /* The set of values to bind to our query statement. */
    protected $params;
    public $success;

    /* PDO Connection Object */
    protected static $Conn;
    /* PDOStatement */
    protected $Query;

    /**
    * <b>Object Constructor</b>
    *
    * Constructs a new instance of a <b>Query</b> object establishing the global
    * database connection if this does not exist already.
    *
    * @version 0.0.1 development
    */
    public function __construct()
    {
        if (!self::$Conn)
            self::$Conn = new Connection;
        $this->connect();
    }

    /**
    * <b>Connect</b>
    *
    * Intializes the database connection.
    *
    * @version 0.0.1 development
    * @return void
    */
    protected function connect()
    {
        self::$Conn->Initialize();
    }

    /**
    * <b>Object Destructor</b>
    *
    * Ensures that we disconnect from the database upon object destruction.
    *
    * @version 0.0.1 development
    * @return void
    */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
    * <b>Disconnect</b>
    *
    * Close connection to the database and nullifies all references.
    *
    * @version 0.0.1 development
    * @return void
    */
    protected function disconnect()
    {
        self::$Conn->Close();
        $this->Query = null;
    }

    /**
    * <b>Prepare</b>
    *
    * Prepares a query string.
    *
    * @version 0.0.1 development
    * @return PDOStatement
    */
    protected function prepare()
    {
        $this->Query = self::$Conn->prepare($this->query_string);
    }

    /**
    * <b>Parse Params</b>
    */
    protected function parse_params($params)
    {
        if (is_array($params)):
            $this->params = $params;
        else:
            parse_str($params, $this->params);
        endif;
    }

    /**
    * <b>Parse Params</b>
    */
    protected function bind_values()
    {
        if ($this->params)
        {
            foreach ($this->params as $column => $value)
            {
                if ($column == 'limit' || $column == 'offset')
                    $value = (int) $value;

                try {
                    $param = (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                    $this->Query->bindValue(":$column", $value, $param);
                } catch (PDOException $pdo) {
                    sysException($pdo);
                }
            }
        }
    }

    /**
    * <b>Parse Params</b>
    */
    protected function listify($values)
    {
        $pattern = "/(\s*)[&#](\s*)/";

        if (!is_array($values))
            return ($values ? preg_replace($pattern, ', ', $values) : "*");
        return implode(', ', $values);
    }

    /**
    * <b>Parse Params</b>
    */
    protected function execute(array $data=null)
    {
        try {
            $this->Query->execute($data);
            $this->success = true;
        } catch (PDOException $pdo) {
            $this->success = false;
        }
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    public function success()
    {
        return $this->success;
    }
}
