<?php

namespace Framework\Router;

/**
 * UnMAtch Route
 * Class Route
 * @package Framework\Router
 */


class Route
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var callable
     */
    private $callable;
    /**
     * @var array
     */
    private $parameters;

    public function __construct(string $name, callable $callable, array $parameters)
    {

        $this->name = $name;
        $this->callable = $callable;
        $this->parameters = $parameters;
    }

    /**
     *
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback():callable
    {
        return $this->callable;
    }

    /**
     * retrieve the URL parameters
     * parameters array
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
