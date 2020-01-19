<?php

/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/01/2020
 * Time: 13:57
 */
namespace Tests\Framework\Modules;

use Framework\Router;

class StringModule
{
    public function __construct(Router $router)
    {
        $router->get('/demo',function(){
            return 'DEMO';
        },'demo');
    }

}