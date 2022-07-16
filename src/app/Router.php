<?php

namespace Capangas\Touchfic\app;
use Capangas\Touchfic\app\AuthMiddleware;

/**
 * Classe do roteador
 */
class Router
{
    protected $post;
    protected $get;

    public function __construct() {
        $this->post = array();
        $this->get = array();
        $this->get('/error', '/views/error.php');
    }

    public function post($path, $file, $auth = false)
    {
        $this->post[$path] = $file;
        if ($auth) {
            AuthMiddleware::auth($path);
        }
    }

    public function get($path, $file, $auth = false)
    {
        $this->get[$path] = $file;
        if ($auth) {
            AuthMiddleware::auth($path);
        }
    }

    public function sendPage($path, $routeType)
    {
        if (array_key_exists($path, $routeType)) {
            if (AuthMiddleware::check($path)) {
                AuthMiddleware::authenticated();
            }
            include(__DIR__ . '/..' . $routeType[$path]);
            exit;
        }
        include(__DIR__ . '/..' . $this->get['/error']);
    }

    public function send()
    {
        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            $this->sendPage($path, $this->post);
        }
        else if ($method === 'GET') {
            $this->sendPage($path, $this->get);
        }
    }

}
