<?php
namespace Src;

class Router {

    private array $routes = [];

    public function add(string $method, string $path, callable $handler) {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function run() {
        $basePath = '/api-php-native/public'; // ganti sesuai folder project/public
        $uri = str_replace($basePath, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                call_user_func($route['handler']);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["success" => false, "error" => "Route not found"]);
    }
}


