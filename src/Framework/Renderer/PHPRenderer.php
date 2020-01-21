<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/01/2020
 * Time: 15:38
 */

namespace Framework\Renderer;

class PHPRenderer implements RendererInterface
{

    const DEFAULT_NAMESPACE = "__MAIN";

    private $paths = [];
    /**
     * variable globally accessible for all views
     * @var array
     */
    private $globals = [];

    public function __construct(string $defaultPath = null)
    {
        if (!is_null($defaultPath)) {
            $this->addPath($defaultPath);
        }
    }

    /**
     * add a path to load views
     * @param string $namespace
     * @param string|null $path
     *
     */
    public function addPath(string $namespace, string $path = null) : void
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }


    /**
     * to render a views
     * the path can be add with namespace with better performance on addPatch method
     * $this->render('@blog/views');
     * $this->render('views');
     * @param string|string $view
     * @param array $params
     * @return string|string
     */
    public function render(string $view, array $params = []): string
    {
        if ($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view).'.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }


        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    /**
     * add Glabal parameters to all view
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key, $value): void
    {
        $this->globals[$key]=$value;
    }

    private function hasNamespace(string $view) : bool
    {
        return $view[0] === '@';
    }

    private function getNamespace(string $view) : string
    {
        return substr($view, 1, strpos($view, '/')-1);
    }

    private function replaceNamespace(string $view) : string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
