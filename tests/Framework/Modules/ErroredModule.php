<?php

/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/01/2020
 * Time: 13:57
 */
namespace Tests\Framework\Modules;

use Framework\Router;

class ErroredModule
{
    public function __construct(Router $router)
    {
        $router->get('/demo',function(){
            return new \stdClass();
        },'demo');
    }

}