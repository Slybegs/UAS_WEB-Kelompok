<?php

namespace App\Helpers;

class Router
{
    public const MethodMap = [
        'create' => 'GET',
        'data' => 'GET',
        'edit' => 'GET',
        'delete' => 'DELETE',
        'index' => 'GET',
        'store' => 'POST',
        'update' => 'PUT',
        'print' => 'GET',
    ];

    public const DefaultActionMap = [
        'GET' => 'index',
        'POST' => 'store',
        'PUT' => 'update'
    ];

    public const NAMESPACE = 'app/Modules/';

    public static function getCurrentUrlPath()
    {
        $fullPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $parts = explode('/', $fullPath);
        array_shift($parts);
        $parts = array_pad($parts, 3, '');

        [$model, $subPath, $action] = $parts;
        $id = null;
        if (isset($subPath) && ctype_digit($subPath)) {
            $id = $subPath;
            $subPath = 'update';
        }
        return [
            'fullPath' => $fullPath,
            'model' => $model,
            'subPath' => $subPath,
            'action' => strtolower($action ?: $subPath),
            'id' => $id,
            'method' => array_key_exists('_method', $_POST) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD']
        ];
    }

    public static function getResource($route) {
        $defaultAction = self::DefaultActionMap[$route['method']] ?? '';
        $action = $route['action'] ?: $defaultAction;
        $routeMethod = self::MethodMap[$action] ?: '';
        if ($routeMethod === $route['method']) {
            return self::NAMESPACE . ucfirst($route['model']) . '/' . $action . '.php';;
        }

        http_response_code(404);
        return 'views/errors/404.php';
    }
}