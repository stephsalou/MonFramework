<?php

/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 03/02/2020
 * Time: 11:36
 */


namespace Tests;

use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class DatabaseTestCase extends TestCase
{
    /**
     * @var PDO
     */
    protected $pdo;

    protected bool $seeds = true;

    private Manager $manager;

    public function setUp() :void
    {
        $pdo = new PDO('sqlite::memory:',null,null,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $configArray = require('phinx.php');
        $configArray['environments']['test']=[
            'adapter'=> 'sqlite',
            'connection'=>$pdo,
            'memory'=>true,
            'name'=>'test'
        ];
        $config = new Config($configArray);
        $manager = new Manager($config,new StringInput('migrate -e test'), new NullOutput());
        $manager->migrate('test');
        $this->manager = $manager;


        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        $this->pdo = $pdo;
    }

    public function seedDatabase(){

        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_BOTH);
        $this->manager->seed('test');

        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }

}