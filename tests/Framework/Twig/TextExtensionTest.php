<?php


namespace Tests\Framework\Twig;

use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

class TextExtensionTest extends TestCase{

    /**
     * @var TextExtension
     */
    private $textExtension;

    public function setUp() : void
    {
        $this->textExtension = new TextExtension();
    }

    public function testExcerptWithShortText()
    {

        $text = "Salut";
        $this->assertEquals($text,$this->textExtension->excerpt($text,10));

    }

    public function testExcerptWithLongText()
    {

        $text = "Salut les gens";
        $this->assertEquals('Salut...',$this->textExtension->excerpt($text,7));
        $this->assertEquals('Salut les...',$this->textExtension->excerpt($text,12));

    }



}