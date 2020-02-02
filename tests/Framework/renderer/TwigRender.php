<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/01/2020
 * Time: 15:39
 */

namespace Tests\Framework;


use Framework\Renderer\Factory\TwigRendererFactory;
use Framework\Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;


class RendererTest extends TestCase
{
    private $renderer;

    public function setUp(): void
    {
//        __DIR__."/views"
        $this->renderer = new TwigRendererFactory();
    }


    public function testRenderTheRigthPath()
    {
        $this->renderer->addPath('blog',__DIR__."/views");
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Salut les gens',$content);
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Salut les gens',$content);
    }


    public function testRenderWithPrams()
    {
        $content = $this->renderer->render('demoparams',[
            'nom'=>'stephane',
        ]);
        $this->assertEquals('Salut stephane',$content);
    }

    public function testGlobalParamaters()
    {
        $this->renderer->addGlobal('nom','stephane');
        $content = $this->renderer->render('demoparams');
        $this->assertEquals('Salut stephane',$content);
    }

    public function testGetAssetsContent()
    {
        $path = "C:/Users/Sandra/Desktop/steph/project_php/grafikart/MonFramework/assets/style/bootstrap.css";

        $data = file_get_contents($path);

        var_dump($data);
        die();
    }
}
