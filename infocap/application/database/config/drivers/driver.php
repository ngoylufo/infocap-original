<?php
/*
 *  ---------------------------------------------------------------------------
 *  Small :: PHP
 *  ---------------------------------------------------------------------------
 *  Copyright notices and stuff...
 *
 *  @package    Small :: PHP
 *  @author     Ngoy Pedro C. Lufo
 *  @version    0.0.1 development
 *  @copyright  Copyright (c) 2018, Some Software.
 */
namespace Small\Database\Driver;

/**
 * Database driver.
 */
abstract class Driver
{
    /** Driver options and configurations */
    protected $config;
    /** User login info, namely the username and password. */
    protected $login;
    /** Driver name? */
    protected $driver;

    /**
    * <b>Object constructor</b>
    *
    * Constructs a new instance of a database driver storing the configuration
    * options and user login credentials.
    *
    * @param array The configurations settings.
    * @param string $login The login credentials.
    * @version  0.0.1
    * @author   Ngoy Pedro C. Lufo (maybe change this as well)
    */
    public function __construct(array $config, array $login)
    {
        $this->config = $config;
        $this->login = $login;
    }

    /**
    * <b>Parse DSN</b>
    *
    * Parses the data source name using the method provided and returns an
    * array containig the dsn string and user login redentials.
    *
    * @param string $method The method used for the dsn string.
    * @version  0.0.1
    * @author   Ngoy Pedro C. Lufo (maybe change this as well)
    */
    public function parse_dsn(string $method): array
    {
        switch ($method):
            case 'alias':
                $dsn = $this->config['alias'];
                break;
            case 'uri':
                $dsn = $this->parse_uri_string();
                break;
            default:
                $dsn = $this->parse_dsn_string();
                break;
        endswitch;

        return array($dsn, $this->login['username'],
                     $this->login['password']);
    }

    /**
    * <b>Parse uri string</b>
    *
    * Returns the uri defining the location of the file wherein the dsn is
    * stored.
    *
    * @param string $method The method used for the dsn string.
    * @version  0.0.1
    * @author   Ngoy Pedro C. Lufo (maybe change this as well)
    */
    protected function parse_uri_string(): string
    {
        $get_contents = (bool) $this->config['uri_get_content'];
        // $protocol = $this->config['uri_protocol'];
        $uri = $this->config['uri'];

        if ($get_contents && file_exists($uri))
            return trim(file_get_contents($uri));
        return "uri:file:///$uri";
    }

    /**
    * <b>Parse uri string</b>
    *
    * Returns the uri defining the location of the file wherein the dsn is
    * stored.
    *
    * @param string $method The method used for the dsn string.
    * @version  0.0.1
    * @author   Ngoy Pedro C. Lufo (maybe change this as well)
    */
    abstract protected function parse_dsn_string(): string;
}
