<?php


namespace App\Admin;

use Framework\Module;
use Framework\Renderer\RendererInterface;

class AdminModule extends Module{


    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * AdminModule constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;

        $this->renderer->addPath('admin',__DIR__.'/views');
    }

}