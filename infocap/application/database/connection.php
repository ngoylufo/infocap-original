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
use PDO, PDOStatement, PDOException;
/**
* <b>Connection</b>
*
* Responsible for establishing and managing the connection to the database.
* Provides an interface for interacting with the established connection and or
* database.
*
* @version 0.0.1 development
*/
class Connection
{
    /* Main Configurations Settings */
    private $config;
    /* Database Connection Options */
    private $options;
    /* Database Connection Driver */
    private $Driver;

    /* PDO Connection Object */
    private $Conn;
    /* Connection Attributes */
    private $attributes;

    /**
    * <b>Object Constructor</b>
    *
    * Constructs a new instance of a <b>Connection</b> object by parsing the
    * main configurations file which details the method used for connecting, the
    * data connection driver to use and basic connection options. An instance of
    * the database driver is created and the database connection options parsed.
    *
    * @version 0.0.1 development
    */
    public function __construct()
    {
        $this->parse_configurations();
        $this->instanciate_database_driver();
        $this->parse_connection_options();
    }

    /**
    * <b>Parse Configurations</b>
    *
    * Parses the main configurations file if it exists dies otherwise.
    *
    * @version 0.0.1 development
    * @return void
    */
    private function parse_configurations()
    {
        # Main Configurations File
        $config_file = __DIR__."/config/config.ini";

        if (!file_exists($config_file))
            die("Couldn't parse configurations file: <b>file not found</b>");

        # Parse Configurations File Minding Sections!
        $config = parse_ini_file($config_file, true);
        $this->config = $config;
    }

    /**
    * <b>Instanciate Database Driver</b>
    *
    * Stores a reference to a new database connection driver instance for access
    * by the <b>Connection</b> object. The options for the database driver is
    * merged with the main configurations.
    *
    * @version 0.0.1 development
    * @return void
    */
    private function instanciate_database_driver()
    {
        $drv = $this->config['driver'];
        # Parse Configurations File Minding Sections!
        $this->config[$drv] = parse_ini_file("config/$drv.dsn", true);
        $cls = "Small\Database\Driver\\" . strtoupper($drv);

        $this->Driver = new $cls($this->config[$drv], $this->config['login']);
    }

    /**
    * <b>Parse Database Connection Options</b>
    *
    * Retrieves the database connection options stored int configurations
    * attribute in order to process are store these correctly.
    *
    * @version 0.0.1 development
    * @return void
    */
    private function parse_connection_options()
    {
        $this->options = array();
        $options = array_merge($this->config['options'],
                            $this->config[$this->config['driver']]['options']);
        foreach ($options as $attr => $val)
        {
            $value = (strstr($val, '_') ? constant("PDO::{$val}") : (int) $val);
            $this->options += array(constant("PDO::$attr") => $value);
        }
    }

    /**
    * <b>Connect</b>
    *
    * Attempts to establish a database connection using the connection method
    * set in the configurations and other information provided by the driver.
    *
    * @version 0.0.1 development
    * @return void
    */
    private function connect()
    {
        $method = $this->config['method'];
        list($dsn, $user, $pass) = $this->Driver->parse_dsn($method);

        try {
            $this->Conn = new PDO($dsn, $user, $pass, $this->options);
            $this->set_connection_attributes();
        } catch (Exception $pdo) {
            sysException($pdo);
        }
    }

    /**
    * <b>Set Connection Attributes</b>
    *
    * Iterates through an array of connection attributes to determine which of
    * these are supported by the database connected to.
    *
    * @version 0.0.1 development
    * @return void
    */
    private function set_connection_attributes()
    {
        $attributes = array("AUTOCOMMIT", "CASE", "CLIENT_VERSION",
            "CONNECTION_STATUS", "CURSOR_NAME", "CURSOR", "DEFAULT_FETCH_MODE",
            "DRIVER_NAME", "EMULATE_PREPARES", "ERRMODE", "FETCH_CATALOG_NAMES",
            "FETCH_TABLE_NAMES", "MAX_COLUMN_LEN", "ORACLE_NULLS", "PERSISTENT",
            "PREFETCH", "TIMEOUT", "SERVER_VERSION", "SERVER_INFO",
            "STATEMENT_CLASS", "STRINGIFY_FETCHES");

        $this->attributes = array();
        foreach ($attributes as $attr)
        {
            $constant = constant("PDO::ATTR_$attr");
            try {
                $this->Conn->getAttribute($constant);
                $this->attributes['supported'][] = "PDO::ATTR_$attr";
            } catch (PDOException $pdo) {
                $this->attributes['unsupported'][] = "PDO::ATTR_$attr";
            }
        }
    }

    /*
    * --------------------------------------------------------------------------
    * Public Interface
    * --------------------------------------------------------------------------
    */

    /**
    * <b>Initialize</b>
    *
    * Initializes a database connection if none exists. The method returns true
    * if there is an active connection.
    *
    * @version 0.0.1 development
    * @return bool
    */
    public function Initialize(): bool
    {
        if (!$this->Conn)
            $this->connect();
        return ($this->Conn ? true : false);
    }

    /**
    * <b>Connected</b>
    *
    * Checks for an active connection.
    *
    * @version 0.0.1 development
    * @return bool
    */
    public function connected(): bool
    {
        return ($this->Conn ? true : false);
    }

    /**
    * <b>Get attribute</b>
    *
    * Returns the value of the specified attribute.
    *
    * @version 0.0.1 development
    * @return string|int The value of the connection attribute.
    */
    public function getAttribute(string $attr)
    {
        $attr = "PDO::ATTR_".strtoupper($attr);
        if (!in_array($attr, $this->attributes['supported']))
            return "Unsupported";
        return $this->Conn->getAttribute($attr);
    }

    /**
    * <b>Prepare</b>
    *
    * Prepares a query returning a prepared statement.
    *
    * @version 0.0.1 development
    * @param string $query The string we wish to be prepared.
    * @return PDOStatement
    */
    public function prepare(string $query): PDOStatement
    {
        return $this->Conn->prepare($query);
    }

    /**
    * <b>Close</b>
    *
    * Closes the connection to the database.
    *
    * @version 0.0.1 development
    * @return void
    */
    public function Close()
    {
        $this->Conn = null;
    }
}
