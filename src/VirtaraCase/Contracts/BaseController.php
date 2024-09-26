<?php

namespace VirtaraCase\Contracts;

interface BaseController
{
    public function view(string $template, array $data = []);
}