<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 17/02/2020
 * Time: 20:26
 */

namespace Framework\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('field', [$this, 'field'],
                [
                    'is_safe' => ['html'],
                    'needs_context' => true
                ]),
        ];
    }

    /**
     * generate Html code for field
     * @param array $context
     * @param string $key
     * @param mixed $value
     * @param null|string $label
     * @param array $options
     * @return string
     */
    public function field(array $context, string $key, $value, ?string $label=null, array $options = []): string
    {

        $type = $options['type'] ?? 'text';
        $error = $this->getErrorHtml($context, $key);
        $class = 'form-group';
        $attributes = [
            'class' => 'form-control',
            'name' => $key,
            'id' => $key
        ];
        if ($error) {
            $class .= ' has-danger';
            $attributes['class'] .= ' is-invalid';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($attributes, $value);
        } else {
            $input = $this->input($attributes, $value);
        }
        return "
            <div class=\"" . $class . "\">
                <label for=\"{$key}\">{$label}</label>
                {$input}
                {$error}
            </div>
            ";
    }


    /**
     * get fill errors and generate html code
     * @param $context
     * @param $key
     * @return string
     */
    private function getErrorHtml($context, $key): string
    {
        $error = $context['errors'][$key] ?? false;
        if ($error) {
            return "<small class=\"form-text text-muted\">{$error}</small>";
        }
        return "";
    }

    /**
     * make a basic input type text Html field
     * @param array $attributes
     * @param null|string $value
     * @return string
     */
    private function input(array $attributes, ?string $value = null): string
    {
        return "<input type=\"text\" ".$this->getHtmlFromArray($attributes)." value=\"{$value}\">";
    }

    /**
     * generate a basic textarea html field
     * @param array $attributes
     * @param null|string $value
     * @return string
     */
    private function textarea(array $attributes, ?string $value = null): string
    {
        return "<textarea ".$this->getHtmlFromArray($attributes)." rows=\"8\" >{$value}</textarea>";
    }

    /**
     * generate attributes of html field with array of attributes
     * @param array $attributes
     * @return string
     */
    private function getHtmlFromArray(array $attributes){
        return implode(' ',array_map(function($key,$value){
            return "{$key}=\"{$value}\"";
        },array_keys($attributes),$attributes));
    }
}