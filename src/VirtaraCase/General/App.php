<?php

namespace VirtaraCase\General;

use Composer\Autoload\ClassLoader;
use VirtaraCase\Traits\UseMakeTrait;

class App
{
    use UseMakeTrait;

    public string $rootPath;

    protected array $config;

    public function init(): self
    {
        $this->setRootPath();
        $this->loadConfig();

        return $this;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setRootPath(): self
    {
        $this->rootPath = dirname((new \ReflectionClass(ClassLoader::class))->getFileName(), 3);

        return $this;
    }

    protected function loadConfig(): void
    {
        $this->config = require $this->rootPath.'/configs/app.config.php';
    }
}