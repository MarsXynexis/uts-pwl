<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (isset($url[0])) {
            if ($url[0] === 'logout') {
                $this->controller = 'Login';
                $this->method = 'logout';

                unset($url[0]);

            } else {
                $formattedController = str_replace(' ', '', ucwords(str_replace('-', ' ', $url[0])));

                if (file_exists('controllers/' . $formattedController . '.php')) {
                    $this->controller = $formattedController;

                    unset($url[0]);

                } elseif (file_exists('controllers/' . $url[0] . '.php')) {
                    $this->controller = $url[0];

                    unset($url[0]);
                }
            }
        }

        if (file_exists('controllers/' . $this->controller . '.php')) {
            require_once 'controllers/' . $this->controller . '.php';

            $this->controller = new $this->controller;

            if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                $this->method = $url[1];

                unset($url[1]);
            }

            $this->params = $url ? array_values($url) : [];

            call_user_func_array([$this->controller, $this->method], $this->params);
        }
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');

            $url = filter_var($url, FILTER_SANITIZE_URL);

            return explode('/', $url);
        }

        return [];
    }
}
