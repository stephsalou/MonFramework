<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 02/02/2020
 * Time: 13:17
 */

namespace Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 *
 * extensions for text on twig
 * Class TextExtension
 * @package Framework\Twig
 */
class TextExtension extends AbstractExtension
{


    /**
     * @return TwigFilter[]
     */
    public function getFilters() : array
    {
        return [
            new TwigFilter('excerpt', [$this,'excerpt'])
        ];
    }


    /**
     * return content excepept
     * @param string|string $content
     * @param int|int $maxLength
     * @return string|string
     */
    public function excerpt(string $content, int $maxLength = 100) : string
    {

        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace).'...';
        }
        return $content;
    }
}
