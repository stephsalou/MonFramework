<?php

namespace App\Blog;

use Framework\PHPRenderer;
use Framework\Renderer\RendererInterface;
use Framework\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{


    private $renderer;

    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('blog', __DIR__.DIRECTORY_SEPARATOR.'views');
        $router->get('/blog', [$this,'index'], 'blog.index');
        $router->get('/blog/{slug:[a-zA-Z0-9\-]+}', [$this,'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request): string
    {

        return $this->renderer->render('@blog/index');
    }


    public function show(ServerRequestInterface $request): string
    {

        return $this->renderer->render('@blog/show', [
            'slug'=>$request->getAttribute('slug'),
        ]);
    }
}