<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 21/01/2020
 * Time: 15:33
 */

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    public function addPath(string $namespace, string $path = null) : void
    {
        $this->twig->getLoader()->addPath($path, $namespace);
    }

    public function render(string $view, array $params = []) : string
    {
        // TODO: Implement render() method.
        return $this->twig->render($view.'.twig', $params);
    }

    public function addGlobal(string $key, $value) : void
    {
        $this->twig->addGlobal($key, $value);
    }
}
