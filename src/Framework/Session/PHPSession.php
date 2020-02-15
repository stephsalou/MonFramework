<?php
/**
 * Created by PhpStorm.
 * User: Steph
 * Date: 15/02/2020
 * Time: 10:23
 */

namespace Framework\Session;

class PHPSession implements SessionInterface
{


    /**
     * Ensure starting of session
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
             session_start();
        }
    }

    /**
     * get data in session
     * @param string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
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
        $this->ensureStarted();
        $_SESSION[$key]=$value;
    }

    /**
     * delete a data in session
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}
