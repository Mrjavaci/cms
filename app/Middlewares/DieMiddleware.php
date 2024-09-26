<?php

namespace App\Middlewares;

use VirtaraCase\Middleware\Middleware;

class DieMiddleware extends Middleware
{
    public function handle()
    {
        if (isset($this->parameters['id']) && $this->parameters['id'] == 1) {
            die('You are not allowed to see this page');
        }
    }
}