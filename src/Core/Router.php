<?php
   namespace Blogg\Core;

   use Blogg\Core\Request; 

    class Router
    {
        private $routeMap;
        private static $regexPatters = [
            'number' => '\d+',
            'string' => '\w'
        ];

        public function __construct()
        {
            $json = file_get_contents(
                __DIR__ . '/../../config/routes.json'
            );
            $this->routeMap = json_decode($json, true);
        }

        public function route(Request $request): string
        {
            $path = $request->getPath();
            foreach ($this->routeMap as $route => $info) {
                $regexRoute = $this->getRegexRoute($route, $info);
                if (preg_match("@^/$regexRoute$@", $path)) {
                    return $this->executeController(
                        $route,
                        $path,
                        $info,
                        $request
                    );
                }
            }
            return 'ERROR: Path not found';
        }

        private function getRegexRoute(string $route, array $info): string
        {
            if (isset($info['params'])) {
                foreach ($info['params'] as $name => $type) {
                    $route = str_replace(':' . $name, self::$regexPatters[$type], $route);
                }
            }

            return $route;
        }

        private function executeController(
            string $route,
            string $path,
            array $info,
            Request $request
        ): string {
            $controllerName = '\Blogg\Controllers\\' . $info['controller'] . 'Controller';
            // Blogg\Controllers\PostController
            $controller = new $controllerName($request);

            $params = $this->extractParams($route, $path);
            return call_user_func_array([$controller, $info['method']], $params);
        }

        private function extractParams(string $route, string $path): array
        {
            $params = [];

            $pathParts = explode('/', $path);
            $routeParts = explode('/', $route);

            foreach ($routeParts as $key => $routePart) {
                if (strpos($routePart, ':') === 0) {
                    $name = substr($routePart, 1);
                    $params[$name] = $pathParts[$key+1];
                }
            }

            return $params;
        }
    }
