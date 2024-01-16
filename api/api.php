<?php

$request = $_SERVER['REQUEST_URI'];

if ($_SESSION['logged'] == 'false') {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

switch ($request){
    case '/api/a':
        echo json_encode(['message' => 'API endpoint A']);
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'Not Found']);
        break;
}

?>