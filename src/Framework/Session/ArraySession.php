<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 15/02/2020
 * Time: 16:22
 */

namespace App\Framework\Session;

use Framework\Session\SessionInterface;

class ArraySession implements SessionInterface
{

    private $session = [];

    /**
     * get data in session
     * @param string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {

        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }
        return $default;
    }

    /**
     * add data in session
     * @param string $key
     * @param  mixed $value
     * @return void
     */
    public function set(string $key, $value): void
    {

        $this->session[$key]=$value;
    }

    /**
     * delete a data in session
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {

        unset($this->session[$key]);
    }
}
