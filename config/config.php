<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\Factory\TwigRendererFactory;
use Framework\Router;
use function DI\object;
use function DI\get;
use function DI\factory;
return [
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
//    RendererInterface::class =>object(TwigRenderer::class)->constructor(get('views.path')),
    Router::class => object(),
    TwigRendererFactory::class => object(),
    RendererInterface::class => factory(function(\Psr\Container\ContainerInterface $container){
//        return new TwigRenderer($container->get('views.path'));
        return $container->get(TwigRendererFactory::class);
    }),
//    RendererInterface::class => factory(TwigRendererFactory::class),
];