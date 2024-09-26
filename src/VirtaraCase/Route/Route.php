<?php

namespace VirtaraCase\Route;

use App\Controllers\HomeController;
use VirtaraCase\Enums\RouteCallbackTypes;
use VirtaraCase\Request\Dto\RequestObject;
use VirtaraCase\Request\Request;
use VirtaraCase\Traits\UseMakeTrait;

class Route
{
    use UseMakeTrait;

    private static array $routes = [];

    /**
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function add(RequestObject $requestObject): self
    {
        Request::make()->addRoute($requestObject->getUri());

        if ($requestObject->getCallback() instanceof \Closure) {
            self::$routes[] = [
                'route'       => $requestObject->getUri(),
                'type'        => RouteCallbackTypes::CLOSURE,
                'callback'    => $requestObject->getCallback(),
                'middlewares' => $requestObject->getMiddlewares(),
                'method'      => $requestObject->getMethod(),
            ];

            return $this;
        }

        self::$routes[] = [
            'route'       => $requestObject->getUri(),
            'type'        => RouteCallbackTypes::CONTROLLER,
            'controller'  => $requestObject->getCallback(),
            'middlewares' => $requestObject->getMiddlewares(),
            'method'      => $requestObject->getMethod(),
        ];

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        foreach (self::$routes as $route) {
            if (! Request::make()->isCorrectRoute($route['route'])) {
                continue;
            }

            if (Request::make()->getMethod() !== $route['method']) {
                continue;
            }

            foreach ($route['middlewares'] as $middleware) {
                if (! class_exists($middleware)) {
                    throw new \Exception('Middleware not found');
                }
                $middleware = new $middleware();
                $middleware->handle();
            }

            if ($route['type'] === RouteCallbackTypes::CLOSURE) {
                $content = $route['callback']();
            } else {
                if (! is_array($route['controller'])) {
                    throw new \Exception('Controller must be an array');
                }
                $content = $this->handleController($route['controller']);
            }
            $this->handleContent($content);

            return;
        }

        $this->handleContent($this->handleController([HomeController::class, 'index']));
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * @throws \Exception
     */
    protected function handleController($controller1): string|array
    {
        if (! class_exists($controller1[0])) {
            throw new \Exception('Controller not found');
        }
        if (! method_exists($controller1[0], $controller1[1])) {
            throw new \Exception('Method not found');
        }
        $controller = new $controller1[0](Request::make()->getParameters());
        $content = $controller->{$controller1[1]}();

        if (! is_string($content) && ! is_array($content) && ! is_object($content)) {
            throw new \Exception('Controller method must return a view or array');
        }

        return $content;
    }

    protected function handleContent(string|array|object $content): void
    {
        if (is_array($content)) {
            header('Content-Type: application/json');
            echo json_encode($content);

            return;
        }
        header('Content-Type: text/html');
        echo $content;
    }
}