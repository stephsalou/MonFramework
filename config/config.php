<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\Factory\TwigRendererFactory;
use Framework\Router;
use function DI\create;
use function DI\get;
use function DI\factory;
use Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;


return [
    'database.host'=>'localhost',
    'database.username'=>'steph',
    'database.password'=>'root',
    'database.name'=>'grafikartpoo',
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    Router::class => create(),
    RendererInterface::class => factory(TwigRendererFactory::class),
    \PDO::class => function(ContainerInterface $container){
        return new PDO('mysql:host='.$container->get('database.host').';dbname='.$container->get('database.name'),
            $container->get('database.username'),
            $container->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];