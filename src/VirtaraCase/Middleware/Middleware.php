<?php

namespace VirtaraCase\Middleware;

use VirtaraCase\Contracts\BaseMiddleware;
use VirtaraCase\Database\Database;
use VirtaraCase\Request\Request;

abstract class Middleware implements BaseMiddleware
{
    public array $parameters;

    public Database $database;

    public function __construct()
    {
        $this->database = Database::make();
        $this->parameters = Request::make()->getParameters();
    }
}