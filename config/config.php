<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\Factory\TwigRendererFactory;
use Framework\Router;
use function DI\create;
use function DI\get;
use function DI\factory;
use Framework\Router\RouterTwigExtension;


return [
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    Router::class => create(),
    RendererInterface::class => factory(TwigRendererFactory::class),
];