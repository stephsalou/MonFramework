<?php

namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class BlogAction
{


    /**
     * @var RendererInterface
     */

    /**
     * @var Router
     */
    private $router;
    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {

        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
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
        $posts = $this->postTable->findPaginated();
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

        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug'=>$post->slug,
                'id'=>$post->id
            ]);
        }
        return $this->renderer->render('@blog/show', [
            'post'=>$post
        ]);
    }
}
