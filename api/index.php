<?php

require_once 'api.php';

$request = $_SERVER['REQUEST_URI'];
$headers = getallheaders();

$segments = getUrlSegments($request);

if (count($segments) < 1 || count($segments) > 2) {
    notFoundResponse();
}

if (!isset($headers['Authorization']) || $headers['Authorization'] !== 'Allowed') {
    unauthorizedResponse();
}

$endpoint = $segments[0];
header('Content-Type: application/json');

switch ($endpoint){
    case 'group':
        isset($segments[1]) ? $data = getMessageByRoom($segments[1]) : $data = getMessageByRoom(NULL);
        echo json_encode($data);
        break;
    case 'user':
        isset($segments[1]) ? $data = getMessageByUser($segments[1]) : notFoundResponse();
        echo json_encode($data);
        break;
    case 'word':
        isset($segments[1]) ? $data = getMessageByWord($segments[1]) : notFoundResponse();
        echo json_encode($data);
        break;
    default:
        notFoundResponse();
        break;
}

?>