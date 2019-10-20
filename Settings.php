<?php

class Settings
{
    private $databaseServerName = 'localhost';
    private $databaseUserName = 'root';
    private $databasePassword = '';
    private $databaseName = '1dv610-l2';

    public function __construct()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );
        if (in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return;
        } else {
            $this->databaseServerName = getenv('DATABASE_SERVER_NAME');
            $this->databaseUserName = getenv('DATABASE_USERNAME');
            $this->databasePassword = getenv('DATABASE_PASSWORD');
            $this->databaseName = getenv('DATABASE_NAME');
        }
    }

    public function getDatabaseServerName()
    {
        return $this->databaseServerName;
    }

    public function getDatabaseUsername()
    {
        return $this->databaseUserName;
    }

    public function getDatabasePassword()
    {
        return $this->databasePassword;
    }

    public function getDatabaseName()
    {
        return $this->databaseName;
    }
}
