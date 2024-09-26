<?php

require_once __DIR__.'/vendor/autoload.php';

if (php_sapi_name() === 'cli') {
    echo 'CLI not allowed bro!';
    exit;
}

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\DieMiddleware;
use VirtaraCase\Enums\RequestTypes;
use VirtaraCase\General\App;
use VirtaraCase\Request\Dto\RequestObject;
use VirtaraCase\Request\Request;
use VirtaraCase\Route\Route;

App::make()
   ->init();
Request::make()->initFromServerArrays();
try {
    $route = Route::make();

    $route->add(
        RequestObject::make()
                     ->setMethod(RequestTypes::GET)
                     ->setUri('/')
                     ->setCallback([
                         HomeController::class,
                         'index',
                     ])
    );

    $route->add(
        RequestObject::make()
                     ->setMethod(RequestTypes::GET)
                     ->setUri('/user/{id}')
                     ->setCallback([
                         UserController::class,
                         'show',
                     ])
    );
    $route->add(
        RequestObject::make()
                     ->setMethod(RequestTypes::GET)
                     ->setUri('/user-list')
                     ->setCallback([
                         UserController::class,
                         'list',
                     ])
    );
    $route->add(
        RequestObject::make()
                     ->setMethod(RequestTypes::GET)
                     ->setUri('/api/v1/user/list')
                     ->setCallback([
                         UserController::class,
                         'apiList',
                     ])
    );

    $route->add( // if id is 1, it will die
        RequestObject::make()
                     ->setMethod(RequestTypes::GET)
                     ->setUri('/test-middleware/{id}')
                     ->setMiddlewares([DieMiddleware::class])
                     ->setCallback([
                         UserController::class,
                         'notDie',
                     ])
    );

    $route->add(
        RequestObject::make()
              ->setMethod(RequestTypes::GET)
              ->setUri('/mahmut/{sayi_1}/osman/{sayi_2}')
              ->setCallback([
                  HomeController::class,
                  'test',
              ])
    );
    $route->add(
        RequestObject::make()
                     ->setMethod(RequestTypes::POST)
                     ->setUri('/user/store')
                     ->setCallback([
                         UserController::class,
                         'store',
                     ])
    );

    $route->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
