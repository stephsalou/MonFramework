<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 25/01/2020
 * Time: 13:52
 */

namespace Framework\Renderer\Factory;

use Framework\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigRendererFactory
{

    public function __invoke(ContainerInterface $container) : TwigRenderer
    {
        $view_path = $container->get('views.path');
        $loader = new FilesystemLoader($view_path);
        $twig = new Environment($loader, ['debug'=>true]);
        $twig->addExtension(new DebugExtension());
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }
        return new TwigRenderer($twig);
    }
}
