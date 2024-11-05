<?php

use App\http\response\BaseResponse;
use App\routers\Router;

require_once __DIR__ . '/vendor/autoload.php';

$params = explode('/', $_GET['q']);
$types = $params[0];
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: *");
header("Content-Type: application/json");
try {
    $router = new Router();
    echo $router->route($types)->run();
} catch (Exception $e) {
    http_response_code(404);
    $response = new BaseResponse();
    $response->success = false;
    $response->setMessages($e->getMessage());
    echo json_encode($response);
}
