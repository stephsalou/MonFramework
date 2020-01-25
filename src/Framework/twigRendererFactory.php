<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 22/01/2020
 * Time: 23:14
 */

namespace Framework\Renderer\Factory;

use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Framework\Router\RouterTwigExtension;

class TwigRendererFactory
{

    public function __invoke(ContainerInterface $container) : TwigRenderer
    {
        $view_path = $container->get('views.path');
        $loader = new FilesystemLoader($view_path);
        $twig = new Environment($loader);
        $twig->addExtension($container->get(RouterTwigExtension::class));
        return new TwigRenderer($loader, $twig);
    }
}
