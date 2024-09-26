<?php

namespace VirtaraCase\ViewEngine;

use VirtaraCase\General\App;
use VirtaraCase\Traits\UseMakeTrait;

class ViewEngine
{
    use UseMakeTrait;

    const VIEW_PATH = '/views';
    const VIEW_EXTENSION = 'osengine.php';

    public string $view;

    public array $data = [];

    public function render(): string
    {
        $viewPath = App::make()->getRootPath().self::VIEW_PATH.'/'.$this->view.'.'.self::VIEW_EXTENSION;
        $headerPath = App::make()->getRootPath().self::VIEW_PATH.'/partials/header.'.self::VIEW_EXTENSION;
        $footerPath = App::make()->getRootPath().self::VIEW_PATH.'/partials/footer.'.self::VIEW_EXTENSION;

        if (! file_exists($viewPath)) {
            throw new \Exception('View file not found');
        }
        $this->data['config'] = App::make()->getConfig();

        ob_start();
        extract($this->data);
        if (file_exists($headerPath)) {
            include $headerPath;
        }

        include $viewPath;

        if (file_exists($footerPath)) {
            include $footerPath;
        }

        return ob_get_clean();
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setView(string $view): ViewEngine
    {
        $this->view = $view;

        return $this;
    }

    public function setData(array $data): ViewEngine
    {
        $this->data = $data;

        return $this;
    }
}