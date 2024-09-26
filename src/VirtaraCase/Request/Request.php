<?php

namespace VirtaraCase\Request;

use VirtaraCase\Traits\UseMakeTrait;

class Request
{
    use UseMakeTrait;

    private string $method;

    private string $uri;

    private array $server;

    private array $parameters;

    public function initFromServerArrays(): self
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->server = $_SERVER;
        $this->parameters = $_REQUEST;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function addRoute(string $route): void
    {
        if ($this->isCorrectRoute($route)) {
            $this->parameters = array_merge($this->parameters, $this->explodeRoute($route));
        }
    }

    /**
     * @throws \Exception
     */

    public function isCorrectRoute(string $route): bool
    {
        if ($route === '/' && $this->uri === '/') {
            return true;
        }

        $routeParts = explode('/', trim($route, '/'));
        $uriParts = explode('/', trim($this->uri, '/'));

        if (count($routeParts) !== count($uriParts)) {
            return false;
        }

        foreach ($routeParts as $key => $part) {
            if (preg_match('/{.*}/', $part)) {
                continue;
            }

            if (! isset($uriParts[$key]) || $part !== $uriParts[$key]) {
                return false;
            }
        }

        return true;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @throws \Exception
     */
    private function explodeRoute(string $route): array
    {
        if ($this->uri === '/' || $this->uri === '' || $route === '/') {
            return [];
        }

        $routeParts = explode('/', trim($route, '/'));
        $uriParts = explode('/', trim($this->uri, '/'));
        $parameters = [];

        foreach ($routeParts as $key => $value) {
            if (preg_match('/{.*\?}/', $value)) {
                $paramName = str_replace(['{', '}', '?'], '', $value);
                $parameters[$paramName] = $uriParts[$key] ?? null;
            } elseif (preg_match('/{.*}/', $value)) {
                if (! isset($uriParts[$key])) {
                    throw new \Exception('Invalid route');
                }
                $parameters[str_replace(['{', '}'], '', $value)] = $uriParts[$key];
            }
        }

        return $parameters;
    }
}