<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 18/01/2020
 * Time: 11:11
 */

use Framework\App;

require "../vendor/autoload.php";

$app =new App();

$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);