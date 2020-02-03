<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 02/02/2020
 * Time: 13:56
 */

namespace Tests\Framework\Twig;


use Framework\Twig\TextExtension;
use Framework\Twig\TimeExtension;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase
{


    /**
     * @var TimeExtension
     */

    private $timeExtention;

    public function setUp() : void
    {
        $this->timeExtention = new TimeExtension();
    }

    public function testDateFormat()
    {
        $date = new \DateTime();
        $format = 'd/m/Y H:i';
        $result = '<span class="timeago" datetime="'.$date->format(\DateTime::ISO8601).'">'.$date->format($format).'</span>';
        $this->assertEquals($result,$this->timeExtention->ago($date));

    }


}