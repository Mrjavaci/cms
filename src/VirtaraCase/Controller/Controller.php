<?php

namespace VirtaraCase\Controller;

use JetBrains\PhpStorm\NoReturn;
use VirtaraCase\Contracts\BaseController;
use VirtaraCase\Database\Database;
use VirtaraCase\Validation\Validation;
use VirtaraCase\ViewEngine\ViewEngine;

abstract class Controller implements BaseController
{
    public array $parameters;

    public Database $database;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->database = Database::make();
    }

    public function view(string $template, array $data = []): string
    {
        return ViewEngine::make()
                         ->setView($template)
                         ->setData($data)
                         ->render();
    }

    public function validate(array $rules): void
    {
        Validation::make()->validate($rules);
    }

    #[NoReturn]
    public function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }
}