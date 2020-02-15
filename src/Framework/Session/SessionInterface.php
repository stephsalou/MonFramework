<?php


namespace Framework\Session;

interface SessionInterface
{

    /**
     * get data in session
     * @param string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * add data in session
     * @param string $key
     * @param  mixed $value
     * @return void
     */
    public function set(string $key, $value):void;


    /**
     * delete a data in session
     * @param string $key
     * @return void
     */
    public function delete(string $key):void;
}
