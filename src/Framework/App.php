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

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
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
     * @param string[] $modules
     * @param array $dependencies
     */
    public function __construct(array $modules = [], array $dependencies = [])
    {
        $this->router = new Router();
        if (array_key_exists('renderer', $dependencies)) {
            $dependencies['renderer']->addGlobal('router', $this->router);
        }
        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router, $dependencies['renderer']);
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
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        $route = $this->router->match($request);
        if (is_null($route)) {
            return $response = new Response(404, [], '<h1>Erreur 404</h1>');
        }
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);
        $response = call_user_func_array($route->getCallback(), [$request]);
        if (is_string($response)) {
            return new Response(200, [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        } else {
            throw new \Exception('The response is not a string or an instance of ResponseInterface');
        }
    }
}
