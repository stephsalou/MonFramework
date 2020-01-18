<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 18/01/2020
 * Time: 11:27
 */

namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

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
        $app = new App();
        $request = new ServerRequest('GET','/blog');
        $response = $app->run($request);
        $this-> assertStringContainsString('<h1>Bienvenue sur le blog</h1>',(string)$response->getBody());
        $this->assertEquals(200,$response->getStatusCode());
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