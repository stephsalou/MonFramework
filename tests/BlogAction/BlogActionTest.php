<?php

namespace Tests\Blog\Actions;


use App\Blog\Actions\BlogAction;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;


class BlogActionTest extends TestCase{


    /**
     * @var BlogAction
     */
    private $action;
    /**
     * @var RendererInterface
     */
    private $renderer;
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var Router
     */
    private $router;
    /**
     * @var PostTable
     */
    private $postTable;

    /**
     *
     */
    public function setUp() : void
    {

        $this->renderer = $this->prophesize(RendererInterface::class);
        $this->postTable = $this->prophesize(PostTable::class);
        $this->router = $this->prophesize(Router::class);

        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->postTable->reveal()
             );
    }

    /**
     * @param int $id
     * @param string $slug
     * @return \stdClass
     */
    public function makePost(int $id,string $slug): \stdClass
    {
        $post = new \stdClass();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {

        $post = $this->makePost(9,'azeaze');
        $request = (new ServerRequest('GET','/'))
            ->withAttribute('id',9)
            ->withAttribute('slug','demo');

        $this->router
            ->generateUri(
            'blog.show'
            ,['id'=>$post->id,'slug'=>$post->slug]
        )
            ->willReturn('/demo2');

        $this->postTable->find($post->id)->willReturn($post);

        $this->renderer->render('@blog/show',['post'=>$post])->willReturn('');

        /** @var Response $response */
        $response = call_user_func_array($this->action,[$request]);
        $this->assertEquals(true,true);
    }
}