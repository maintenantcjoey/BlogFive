<?php
/**
 * File Request.php.
 */

namespace Blog\Http;


class Request
{
    private $posts;

    private $method;

    /**
     * @var self
     */
    private static $request = null;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->posts = $_POST;
    }

    public static function getInstance()
    {
        if (self::$request === null) {
            self::$request = new self();
        }

        return self::$request;
    }

    public static function isPost()
    {
        $request = self::getInstance();

        return 'POST' === $request->method;
    }

    public static function get($key)
    {
        return isset(self::posts()[$key]) ? htmlspecialchars(self::posts()[$key]) : null;

    }

    public static function posts()
    {
        $request = self::getInstance();

        return $request->getPosts();
    }

    public function getPosts()
    {
        return $this->posts;
    }

}