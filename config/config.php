<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\Factory\TwigRendererFactory;
use Framework\Router;
use function DI\create;
use function DI\get;
use function DI\factory;
use function DI\autowire;
var_dump(TwigRendererFactory::class);
//var_dump((new TwigRendererFactory)());
var_dump(get_class_methods(TwigRendererFactory::class));
die();
return [
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
//    RendererInterface::class =>object(TwigRenderer::class)->constructor(get('views.path')),
    Router::class => autowire(),
//    TwigRendererFactory::class => create(),
//    RendererInterface::class => factory(function(\Psr\Container\ContainerInterface $container){
//        return new TwigRenderer($container->get('views.path'));
////        return $container->get(TwigRendererFactory::class);
//    }),
//    RendererInterface::class => factory([TwigRendererFactory::class,'create']),
    RendererInterface::class => factory(new TwigRendererFactory()),
];