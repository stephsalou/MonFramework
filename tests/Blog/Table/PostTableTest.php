<?php

namespace Tests\App\Blog\Table;


use App\Blog\Entity\Post;
use App\Blog\Table\PostTable;
use Phinx\Migration\Manager;
use Tests\DatabaseTestCase;

class PostTableTest extends DatabaseTestCase{

    /**
     * @var PostTable
     */
    private $postTable;

    public function setUp() :void
    {
        parent::setUp();
        $this->postTable = new PostTable($this->pdo);
    }

    public function testFind()
    {

        $this->seedDatabase();
        $post = $this->postTable->find(1);
        $this->assertInstanceOf(Post::class,$post);
    }

    public function testFindNotFoundRecord()
    {
        $post = $this->postTable->find(1000);
        $this->assertNull($post);
    }


    public function testUpdate(){
        $this->seedDatabase();
        $this->postTable->update(1,['name'=>'salut','slug'=>'demo']);
        $post = $this->postTable->find(1);
        $this->assertEquals('salut',$post->name);
        $this->assertEquals('demo',$post->slug);
    }


    public function testInsert(){

        $this->postTable->insert(['name'=>'salut','slug'=>'demo']);
        $post = $this->postTable->find(1);
        $this->assertEquals('salut',$post->name);
        $this->assertEquals('demo',$post->slug);
    }


    public function testDelete(){

        $this->postTable->insert(['name'=>'salut','slug'=>'demo']);
        $this->postTable->insert(['name'=>'hola','slug'=>'los-amigos']);
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(2,(int)$count);
        $this->postTable->delete($this->pdo->lastInsertId());
        $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
        $this->assertEquals(1,(int)$count);
    }
}