<?php

namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\Module;
//use Framework\PHPRenderer;
use Framework\Renderer\RendererInterface;
use Framework\Router;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__.DIRECTORY_SEPARATOR.'config.php';


    const MIGRATIONS = __DIR__.'/db/migrations';


    const SEEDS = __DIR__.'/db/seeds';

    public function __construct(string $prefix = null, Router $router, RendererInterface $renderer)
    {
        if (is_null($prefix)) {
            $prefix='/blog';
        }
        $renderer->addPath('blog', __DIR__.DIRECTORY_SEPARATOR.'views');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix.'/{slug:[a-zA-Z0-9\-]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    }
}
