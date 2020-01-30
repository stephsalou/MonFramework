<?php
/**
 * Created by PhpStorm.
 * User: Sandra
 * Date: 18/01/2020
 * Time: 11:11
 */

use DI\ContainerBuilder;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

require dirname(__DIR__).'/vendor/autoload.php';

$modules = [
    \App\Blog\BlogModule::class,
];

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__).DIRECTORY_SEPARATOR.'config/config.php');

foreach ($modules as $module) {
    if (!is_null($module::DEFINITIONS) && is_string($module::DEFINITIONS)) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$builder->addDefinitions(dirname(__DIR__).DIRECTORY_SEPARATOR.'config.php');

$container = $builder->build();

$app = new App($container, $modules);

if (php_sapi_name() !== 'cli') {
    $response = $app->run(ServerRequest::fromGlobals());

    \Http\Response\send($response);
}
