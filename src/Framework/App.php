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
     * @param ServerRequest $request
     * @return ResponseInterface
     */
    public function run(ServerRequest $request) : ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('Location', substr($uri, 0, -1));
        }
        if ($uri == '/blog') {
            return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
        }
        return $response = new Response(404, [], '<h1>Erreur 404</h1>');
    }
}
