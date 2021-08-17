<?php
/*
 *  ---------------------------------------------------------------------------
 *  Small :: PHP
 *  ---------------------------------------------------------------------------
 *  Copyright notices and stuff...
 *
 *  @package    Small :: PHP
 *  @author     Ngoy Pedro C. Lufo
 *  @version    v0.0.1 development
 *  @copyright  Copyright (c) 2018, Some Software.
 */
namespace Small\Database\Driver;

/**
 * PostgreSQL database driver.
 */
class PostgreSQL extends Driver
{
    public function __construct(array $config, array $login)
    {
        parent::__construct($config, $login);
        $this->driver = 'pgsql';
    }

    protected function parse_dsn_string(): string
    {
        extract($this->config);
        if (!$host)
            die("No 'HOST' defined for the connection!");
        $host = "host=$host;";
        $port = $port ? "port=$port;" : null;
        $user = "user={$this->login['username']};";
        $pass = "password={$this->login['password']}";

        return "{$this->driver}:$host{$port}dbname=$schema;$user$pass";
    }
}
