<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 18/01/2020
 * Time: 11:11
 */

use App\Blog\BlogModule;
use Framework\App;
use Framework\Renderer\PHPRenderer;
use Framework\Renderer\TwigRenderer;
use GuzzleHttp\Psr7\ServerRequest;

require "../vendor/autoload.php";

$renderer = new TwigRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');



$app = new App([
    BlogModule::class
], [
    'renderer' => $renderer,
]);

$response = $app->run(ServerRequest::fromGlobals());

\Http\Response\send($response);
