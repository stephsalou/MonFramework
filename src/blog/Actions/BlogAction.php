<?php

namespace App\Blog\Actions;

use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{


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

    public function __construct(RendererInterface $renderer, \PDO $pdo, Router $router)
    {

        $this->renderer = $renderer;
        $this->pdo = $pdo;
        $this->router = $router;
    }

    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index();
        }
    }

    public function index(): string
    {
        $posts = $this->pdo
            ->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 10")
            ->fetchAll();
        return $this->renderer->render('@blog/index', ['posts'=>$posts]);
    }


    /**
     * show an article
     * @param Request $request
     * @return string|Response
     */
    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $query = $this->pdo->prepare('SELECT * FROM posts WHERE id = ?');
        $query->execute([$request->getAttribute('id')]);
        $post = $query->fetch();

        if ($post->slug !== $slug) {
            $redirectUri = $this->router->generateUri('blog.show', [
                'slug'=>$post->slug,
                'id'=>$post->id
            ]);
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', $redirectUri);
        }
        return $this->renderer->render('@blog/show', [
            'post'=>$post
        ]);
    }
}
