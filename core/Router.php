<?php
class Router {
    private $routes = [];

    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    public function delete($uri, $action) {
        $this->addRoute('DELETE', $uri, $action);
    }

    public function put($uri, $action) {
        $this->addRoute('PUT', $uri, $action);
    }

    public function patch($uri, $action) {
        $this->addRoute('PATCH', $uri, $action);
    }

    private function addRoute($method, $uri, $action) {
        $this->routes[] = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'action' => $action
        ];
    }

    public function dispatch($requestedUri, $method) {
        $requestedUri = parse_url($requestedUri, PHP_URL_PATH);
        $requestedUri = '/' . trim($requestedUri, '/');

        $basePath = '/MindHeaven/public';

        if (str_starts_with($requestedUri, $basePath)) {
            $requestedUri = substr($requestedUri, strlen($basePath));
        }

        $requestedUri = trim($requestedUri, '/');
      
        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                // Check for exact match first
                if ($route['uri'] === $requestedUri) {
                    return $this->runAction($route['action']);
                }
                
                // Check for parameterized routes
                if (strpos($route['uri'], '{') !== false) {
                    $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['uri']);
                    if (preg_match('#^' . $pattern . '$#', $requestedUri, $matches)) {
                        // Extract parameters and add them to $_GET
                        $paramNames = [];
                        preg_match_all('/\{([^}]+)\}/', $route['uri'], $paramNames);
                        
                        for ($i = 1; $i < count($matches); $i++) {
                            if (isset($paramNames[1][$i-1])) {
                                $_GET[$paramNames[1][$i-1]] = $matches[$i];
                            }
                        }
                        
                        return $this->runAction($route['action']);
                    }
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found - No route matched.";
    }

    private function runAction($action) {
        list($controllerName, $methodName) = explode('@', $action);

        if (!class_exists($controllerName)) {
            die("Controller '$controllerName' not found.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $methodName)) {
            die("Method '$methodName' not found in controller '$controllerName'.");
        }

        return call_user_func([$controller, $methodName]);
    }
}