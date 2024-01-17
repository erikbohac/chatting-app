<?php

$request = $_SERVER['REQUEST_URI'];

if ($_SESSION['logged'] == 'false') {
    unauthorizedResponse();
}

switch ($request){
    case '/api/...':
        echo json_encode(['message' => 'API endpoint A']);
        break;
    default:
        notFoundResponse();
        break;
}

?>