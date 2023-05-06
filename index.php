<?php

error_reporting(E_ALL);

ini_set('display_errors', 1);

require 'vendor/autoload.php';

use App\Helpers\Router;
use App\Helpers\Session;
use App\Models\Admin;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('views');

$twig = new Environment($loader, [
    'debug' => true,
]);
$twig->addExtension(new DebugExtension());


//remove trailing slash from uri
if( ($_SERVER['REQUEST_URI'] != "/") and preg_match('{/$}',$_SERVER['REQUEST_URI']) ) {
    header ('Location: '.preg_replace('{/$}', '', $_SERVER['REQUEST_URI']));
    exit();
}

$route = Router::getCurrentUrlPath();
$request = $route['method'] . ' ' . $route['fullPath'];

$twig->addGlobal('urlPrefix', $route['model']);

$session = new Session();
$userId = $session->get('userId');

$match = true;
if (!empty($userId)) {
    $admin = new Admin();
    $admin = $admin->find($userId);
    $twig->addGlobal('user', $admin);

    switch ($request) {
        case 'GET /' :
        case 'GET ' :
            require 'app/Modules/dashboard.php';
            break;
        case 'GET /login' :
            header("Location: /");
            break;
        case 'GET /logout':
            require 'app/Modules/Auth/logout.php';
            break;
        default:
            $match = false;
            break;
    }
    if ($match) {
        return;
    }
    $resourceRoute = ['admin', 'customer', 'product', 'sales', 'report'];
    if (in_array($route['model'], $resourceRoute)) {
        $id = $route['id'];
        $resource = Router::getResource($route);
        require $resource;
        return;
    }

    http_response_code(404);
    return 'views/errors/404.php';
} else {
    // Guest Route
    switch ($request) {
        case 'GET /login' :
            require 'app/Modules/Auth/showLoginForm.php';
            break;
        case 'POST /login' :
            require 'app/Modules/Auth/login.php';
            break;
        default:
            $match = false;
            break;
    }
    if (!$match) {
        header("Location: /login");
    } else {
        return;
    }
}

