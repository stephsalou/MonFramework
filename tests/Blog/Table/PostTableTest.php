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
    private $postTAble;

    public function setUp() :void
    {
        parent::setUp();
        $this->postTAble = new PostTable($this->pdo);
    }

    public function testFind()
    {

        $this->seedDatabase();
        $post = $this->postTAble->find(1);
        $this->assertInstanceOf(Post::class,$post);
    }

    public function testFindNotFoundRecord()
    {
        $post = $this->postTAble->find(1000);
        $this->assertNull($post);
    }
}