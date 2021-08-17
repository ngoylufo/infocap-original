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
 * MySQL database driver.
 */
class MYSQL extends Driver
{
    public function __construct(array $config, array $login)
    {
        parent::__construct($config, $login);
        $this->driver = 'mysql';
    }

    protected function parse_dsn_string(): string
    {
        extract($this->config);
        $host = $host ? "host=$host;" : ($socket ? "unix_socket=$socket;" : '');
        if (!$host)
            die("No 'HOST' or 'UNIX_SOCKET' defined for the connection!");
        $port = ($port && !($socket) ? "port=$port;" : '');
        $charset = ($charset ? "charset={$charset}" : '');

        return "{$this->driver}:{$host}{$port}dbname={$schema};{$charset}";
    }
}
