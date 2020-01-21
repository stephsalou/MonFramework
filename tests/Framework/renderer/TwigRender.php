<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 19/01/2020
 * Time: 15:39
 */

namespace Tests\Framework;


use Framework\Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;


class RendererTest extends TestCase
{
    private $renderer;

    public function setUp(): void
    {
        $this->renderer = new TwigRenderer(__DIR__."/views");
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
}
