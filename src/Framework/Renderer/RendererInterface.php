<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 21/01/2020
 * Time: 15:18
 */
namespace Framework\Renderer;

interface RendererInterface
{

    public function addPath(string $namespace, string $path = null) : void;


    public function render(string $view, array $params = []) : string;


    public function addGlobal(string $key, $value) : void;
}
