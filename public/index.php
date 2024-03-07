<?php

use app\controllers as c;
use app\services\Localization;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

(new Localization());

$routes = [
    'POST' => [
        'email_verification' => [c\connections\Signup::class, 'sendVerificationURL'],
        'signup' => [c\connections\Signup::class, 'signup'],
        'login' => [c\connections\Login::class, 'login'],
        'recovery' => [c\connections\Recovery::class, 'recovery'],
        'recovery_email_verification' => [c\connections\Recovery::class, 'sendVerificationURL'],
        'create-game' => [c\admin\Admin::class, 'createGame'],
        'update-game' => [c\admin\Admin::class, 'updateGame'],
        'save-localization' => [c\admin\Localization::class, 'save'],
        'answer' => [c\games\Result::class, 'redirect'],
    ],
    'GET' => [
        '/home' => [c\home\Home::class, 'execute'],
        '/login' => [c\connections\Login::class, 'execute'],
        '/signup' => [c\connections\Signup::class, 'execute'],
        '/signup/([^/]+)' => [c\connections\Signup::class, 'verificationURL'],
        '/recovery' => [c\connections\Recovery::class, 'execute'],
        '/recovery/([^/]+)' => [c\connections\Recovery::class, 'verificationURL'],
        '/logout' => [c\connections\Logout::class, 'execute'],
        '/' => [c\intro\Intro::class, 'execute'],
        '/young' => [c\npc\Young::class, 'execute'],
        '/old' => [c\npc\Old::class, 'execute'],
        '/adult' => [c\npc\Adult::class, 'execute'],
        '/admin' => [c\admin\Admin::class, 'execute'],
        '/admin/localization' => [c\admin\Localization::class, 'execute'],
        '/admin/games' => [c\admin\Games::class, 'execute'],
        '/games/([^/]+)' => [c\games\Games::class, 'execute'],
        '/games/([^/]+)/result' => [c\games\Result::class, 'execute'],
    ],
    'API' => [
        '/api/dialogues' => [c\api\Dialogues::class, 'execute'],
        '/api/hint' => [c\api\Hint::class, 'execute'],
        '/api/games' => [c\api\Games::class, 'execute'],
        '/api/language' => [c\api\Language::class, 'execute'],
        '/api/progress' => [c\api\Progress::class, 'execute'],
    ]
];

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

    $data = [
        'path' => $path,
        'post' => $_POST ?? [],
        'files' => $_FILES ?? [],
    ];

    if ($query) parse_str($query, $data['query']);

    if (str_starts_with($path, '/api') && isset($routes['API'][$path])) {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            list($controller, $action) = $routes['API'][$path];
            (new $controller())->$action($data);
            exit();
        }
        header('HTTP/1.0 403 Forbidden');
        exit();
    }

    if ($method === 'POST') {
        foreach ($routes['POST'] as $postKey => $controllerAction) {
            if (isset($_POST[$postKey])) {
                list($controller, $action) = $controllerAction;
                (new $controller())->$action($data);
                exit();
            }
        }
    }

    if ($method === 'GET') {
        foreach ($routes['GET'] as $route => $controllerAction) {
            if ($route === $path || preg_match('~^' . $route . '$~', $path)) {
                list($controller, $action) = $controllerAction;
                (new $controller())->$action($data);
                exit();
            }
        }
    }

    (new c\errors\Errors())->notFound();
    exit();
} catch (Exception) {
    header('HTTP/1.0 500 Internal Server Error');
    exit();
}
