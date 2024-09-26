<?php

namespace VirtaraCase\Request\Dto;

class RequestObject
{
    private string $method;

    private string $uri;

    private array $middlewares = [];

    private \Closure|array $callback;

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function getCallback(): array|\Closure
    {
        return $this->callback;
    }

    public function setMethod(string $method): RequestObject
    {
        $this->method = $method;

        return $this;
    }

    public function setUri(string $uri): RequestObject
    {
        $this->uri = $uri;

        return $this;
    }

    public function setMiddlewares(array $middlewares): RequestObject
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    public function setCallback(array|\Closure $callback): RequestObject
    {
        $this->callback = $callback;

        return $this;
    }

    public static function make(): self
    {
        return new self();
    }
}