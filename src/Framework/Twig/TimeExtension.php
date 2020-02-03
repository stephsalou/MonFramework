<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 02/02/2020
 * Time: 13:50
 */

namespace Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TimeExtension extends AbstractExtension
{

    /**
     * @return TwigFunction[]
     */
    public function getFilters() : array
    {
        return [
            new TwigFilter('ago', [$this,'ago'], ['is_safe'=>['html']])
        ];
    }

    public function ago(\DateTime $dateTime, string $format = 'd/m/Y H:i')
    {

        return '<span class="timeago" datetime="'.$dateTime->
        format(\DateTime::ISO8601).'">'.$dateTime->format($format).'</span>';
    }
}
