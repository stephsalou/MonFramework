<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 18/01/2020
 * Time: 20:08
 */

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
     * @param callable $callable
     * @param string $name
     */
    public function get(string $path, callable $callable, string $name)
    {

        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }
    /**
     * @param ServerRequestInterface $request
     * @return Route|null
     */
    public function match(ServerRequestInterface $request) : ?Route
    {
//        try{

            $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        } else {
            return null;
        }
//        }catch(\Exception $e){
//            print($e);
//            return null;
//        }
    }


    /**
     *@return string|null
     */
    public function generateUri(string $name, array $params) : ?string
    {
        return $this->router->generateUri($name, $params);
    }
}
