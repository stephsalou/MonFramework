<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 18/01/2020
 * Time: 20:08
 */

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 *
 * Register and Match route
 * Class Router
 * @package Framework
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function get(string $path, $callable, ?string $name = null)
    {

        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     * @param string $path
     * @param callable|string $callable
     * @param string $name
     */
    public function post(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['POST'], $name));
    }

    public function delete(string $path, $callable, ?string $name = null)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['DELETE'], $name));
    }


    /**
     * Generate crud Url
     * @param string $prefixPath
     * @param $callable
     * @param string $prefixName
     */
    public function crud(string $prefixPath, $callable, string $prefixName): void
    {
        $this->get("$prefixPath", $callable, "$prefixName.index");
        $this->get("$prefixPath/new", $callable, "$prefixName.create");
        $this->get("$prefixPath/{id:\d+}", $callable, "$prefixName.edit");
        $this->delete("$prefixPath/{id:\d+}", $callable, "$prefixName.delete");
        $this->post("$prefixPath/{id:\d+}", $callable);
        $this->post("$prefixPath/new", $callable);
    }
    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
//        try{
//            var_dump($request);
//            die();
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }

        return null;
//        }catch(\Exception $e){
//            print($e);
//            return null;
//        }
    }


    /**
     * @return string|null
     */
    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
