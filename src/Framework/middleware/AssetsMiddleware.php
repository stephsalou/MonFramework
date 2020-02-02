<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 01/02/2020
 * Time: 11:15
 */

namespace Framework\Middleware;

use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Container\ContainerInterface;

class AssetsMiddleware
{

    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var Router
     */
    private $router;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(RendererInterface $renderer, Router $router, ContainerInterface $container)
    {

        $this->renderer = $renderer;
        $this->router = $router;
        $this->container = $container;
    }

    public function __invoke(Request $request)
    {
        $name = $request->getAttribute('name');
        $name = str_replace('-', '.', $name);
        $path = $request->getAttribute('path');
        $type = $request->getAttribute('type');
        $type = str_replace('/', '.', $type);
        $type_test = $this->getRealType($type);
//        var_dump($type,$name,$type_test);
//        die();
        if ($type_test=== 'css') {
            return $this->getCss($name, $path, $type);
        } elseif ($type_test==='js') {
            return $this->getJs($name, $path, $type);
        } else {
            return new Response(404, [], '<h1>File not FOund </h1> ');
        }
    }

    public function getCss($name, $path, $type)
    {
        try {
            $filepath =  'assets' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name . '.'.$type;
            $dir = $this->
                container->
                get('base_dir') . DIRECTORY_SEPARATOR .$filepath;
            $data = file_get_contents($dir);
//        var_dump($data);
            return new Response(200, [
                'Content-Type' => 'text/css'
            ], $data);
        } catch (\Exception $e) {
            $message ='<h1>File NOT EXIST </h1><pre>'.$e->getMessage().$e->getLine().$e->getTraceAsString().'</pre>';
            return new Response(404, [], $message);
        }
    }

    public function getJs($name, $path, $type)
    {
        $filepath =  'assets' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name . '.'.$type;
        $dir = $this->
            container->
            get('base_dir') . DIRECTORY_SEPARATOR .$filepath;
        try {
            $data = file_get_contents($dir);
            //        var_dump($data);
            return new Response(200, [
                'Content-Type' => 'text/javascript'
            ], $data);
        } catch (\Exception $e) {
            $message = '<h1>File NOT EXIST </h1><pre>'.$e->getMessage().$e->getLine().$e->getTraceAsString().'</pre>';
            return new Response(404, [], $message);
        }
    }

    private function getRealType($type)
    {
        $lenght = explode('.', $type);
        if (count($lenght) >= 2) {
            return $lenght[count($lenght)-1];
        }
        return $type;
    }
}
