<?php

namespace VirtaraCase\Database;

use VirtaraCase\General\App;
use VirtaraCase\Traits\UseMakeTrait;

class Database
{
    use UseMakeTrait;

    private \PDO $connection;

    public function __construct()
    {
        $config = App::make()->getConfig()['db'];
        $this->connection = new \PDO(
            "{$config['driver']}:host={$config['host']};port={$config['port']};dbname={$config['database']}",
            $config['user'],
            $config['password']
        );
    }

    public function getConnection()
    {
        return $this->connection;
    }
}