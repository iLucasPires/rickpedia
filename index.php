<?php

include_once 'config/Database.php';
include_once 'controllers/UserController.php';

session_start();

function getCurrentUri(): string
{
    $uri = $_SERVER['REQUEST_URI'];
    $uri = strtok($uri, '?');
    return rawurldecode(parse_url($uri, PHP_URL_PATH));
}

function verifyLogin(string $uri): void
{
    $session = $_SESSION['user'] ?? null;

    if ($session && ($uri === '/login' || $uri === '/register')) {
        header('Location: /');
        exit();
    }

    if (!$session && $uri !== '/login' && $uri !== '/register') {
        header('Location: /login');
        exit();
    }
}

$uri = getCurrentUri();
verifyLogin($uri);

switch ($uri) {
    case '/':
        UserController::index();
        break;
    case '/login':
        UserController::login();
        break;
    case '/logout':
        UserController::logout();
        break;
    case '/register':
        UserController::register();
        break;
    case '/character':
        UserController::character();
        break;
    default:
        http_response_code(404);
        require_once 'views/error.php';
        break;
}