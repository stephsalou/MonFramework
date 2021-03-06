<?php


/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 18/01/2020
 * Time: 11:19
 * @category: test
 * @package : framework
 * @author: stephane salou
 * @Licence: MIT
 * @link : github.com/stephsalou/monframework
 * p
 */

namespace Framework;

use Framework\Middleware\AssetsMiddleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class App
 * @package Framework
 *
 */
class App
{


    /**
     *
     * List of Module
     * @var array
     *
     */
    private $modules;

    /**
     * @var Router
     */
    private $router;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     * @param string[] $modules
     */
    public function __construct($container, array $modules = [])
    {
        $this->container = $container;
        foreach ($modules as $module) {
            $this->modules[] = $this->container->get($module);
        }
    }

    /**
     * @param ServerRequest $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function run(ServerRequest $request) : ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        $parsedBody = $request->getParsedBody();
        if (array_key_exists('_method', $parsedBody) &&
            in_array($parsedBody['_method'], ['DELETE','PUT'])
        ) {
            $request = $request->withMethod($parsedBody['_method']);
        }
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        $static_path = '/static/{path:[a-zA-Z0-9\-\.\_]+}/{name:[a-zA-Z0-9\-\.\_]+}/{type:[a-zA-Z0-9\-\.\_\/]+}';
        $this->router = $this->container->get(Router::class);
        $this->
        router->
        get($static_path, AssetsMiddleware::class, 'static.files');
        $route = $this->router->match($request);
        if (is_null($route)) {
            return $response = new Response(404, [], '<h1>Erreur 404</h1>');
        }
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $callback =$route->getCallback();

        if (is_string($callback)) {
            $callback = $this->container->get($callback);
        }
        $response = call_user_func_array($callback, [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of ResponseInterface');
        }
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }
}
