<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 24/01/2020
 * Time: 13:18
 */

namespace Framework\Router;

use Framework\Router;
use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterTwigExtension extends AbstractExtension
{

    /**
     * @var Router
     */
    private $router;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(Router $router, ContainerInterface $container)
    {

        $this->router = $router;
        $this->container = $container;
    }

    public function getFunctions()
    {

        return [
            new TwigFunction('path', [$this,'pathFor']),
            new TwigFunction('assets', [$this,'loadAssets'])
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }

    public function loadAssets($path, $name)
    {

        $dir = $this->container->get('base_dir');
        return $dir.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$name;
    }
}
