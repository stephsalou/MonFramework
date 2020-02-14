<?php

namespace App\Blog;

use App\Blog\Actions\AdminBlogAction;
use App\Blog\Actions\BlogAction;
use Framework\Module;
//use Framework\PHPRenderer;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Container\ContainerInterface;

class BlogModule extends Module
{

    const DEFINITIONS = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

    const MIGRATIONS = __DIR__ . '/db/migrations';

    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(ContainerInterface $container)
    {


        //if ($prefix === null) {
        //    $prefix='/blog';
        //}
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . DIRECTORY_SEPARATOR . 'views');
        $router = $container->get(Router::class);
        $prefix = $container->get('blog.prefix');
        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix . '/{slug:[a-zA-Z0-9\-]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');

        if ($container->has('admin.prefix')) {
            $prefix = $container->get('admin.prefix');
            $router->crud("$prefix>posts", AdminBlogAction::class, 'blog.admin');
            $router->get("$prefix/posts", AdminBlogAction::class, 'blog.admin.index');
            $router->get("$prefix/posts/new", AdminBlogAction::class, 'blog.admin.create');
            $router->get("$prefix/posts/{id:\d+}", AdminBlogAction::class, 'blog.admin.edit');
            $router->delete("$prefix/posts/{id:\d+}", AdminBlogAction::class, 'blog.admin.delete');
            $router->post("$prefix/posts/{id:\d+}", AdminBlogAction::class);
            $router->post("$prefix/posts/new", AdminBlogAction::class);
        }
    }
}
