<?php

require 'public/index.php';

$migrations = [];

$seeds = [];

foreach ($modules as $module) {
    if (!is_null($module::MIGRATIONS) && is_string($module::MIGRATIONS)) {
        $migrations[] = $module::MIGRATIONS;
    }
    if(!is_null($module::MIGRATIONS) && is_string($module::MIGRATIONS)){
        $seeds[]=$module::SEEDS;
    }

}
return [
    'paths'=>[
        'migrations' => $migrations,
        'seeds' => $seeds
    ],
    'environments'=>[
        'development'=>[
            'adapter'=> 'mysql',
            'host'=> $app->getContainer()->get('database.host'),
            'name'=> $app->getContainer()->get('database.name'),
            'user'=> $app->getContainer()->get('database.username'),
            'pass'=> $app->getContainer()->get('database.password'),
            'port'=> 3306,
            'charset'=> 'utf8'
            ]

    ]

];
