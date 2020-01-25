<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 24/01/2020
 * Time: 13:18
 */

namespace Framework\Router;

use Framework\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterTwigExtension extends AbstractExtension
{

    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }

    public function getFunctions()
    {

        return [
            new TwigFunction('path', [$this,'pathFor'])
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
