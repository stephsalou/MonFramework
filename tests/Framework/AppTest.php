<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 18/01/2020
 * Time: 11:27
 */

namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

class AppTest extends TestCase {


    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET','/azeaze/');
        $response = $app->run($request);
        $this->assertContains('/azeaze',$response->getHeader('Location'));
        $this->assertEquals(301,$response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App([
            BlogModule::class
        ]);
        $request = new ServerRequest('GET','/blog');
        $response = $app->run($request);
        $this-> assertStringContainsString('<h1>Bienvenue sur le blog</h1>',(string)$response->getBody());
        $this->assertEquals(200,$response->getStatusCode());


        //tes et slug
        $request_single = new ServerRequest('GET','/blog/article-de-test');
        $response_single = $app->run($request_single);
        $this->assertStringContainsString('<h1>Bienvenue sur l\'article article-de-test</h1>',(string)$response_single->getBody());
        $this->assertEquals(200,$response_single->getStatusCode());

    }

    public function testThrowExceptionIfNoResponseSent()
    {

        $app = new App([
            ErroredModule::class
        ]);
        $request = new ServerRequest('GET','/demo');
        $this->expectException(\Exception::class);
        $app->run($request);

    }
    public function testConvertStringToResponse()
    {

        $app = new App([
            StringModule::class
        ]);
        $request = new ServerRequest('GET','/demo');
        $reponse = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class,$reponse);
        $this->assertEquals('DEMO',(string)$reponse->getBody());

    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET','/aze');
        $response = $app->run($request);
        $this-> assertStringContainsString('<h1>Erreur 404</h1>',(string)$response->getBody());
        $this->assertEquals(404,$response->getStatusCode());
    }
}