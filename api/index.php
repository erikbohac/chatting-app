<?php

require_once 'api.php';

$request = $_SERVER['REQUEST_URI'];

$segments = getUrlSegments($request);

if (count($segments) < 1 || count($segments) > 2) {
    notFoundResponse();
}

if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = 'false';
}

if ($_SESSION['logged'] == 'false') {
    unauthorizedResponse();
}

$endpoint = $segments[0];

switch ($endpoint){
    case 'group':
        isset($segments[1]) ? getMessageByRoom($segments[1]) : getMessageByRoom(NULL);
        break;
    case 'user':
        isset($segments[1]) ? getMessageByUser($segments[1]) : notFoundResponse();
        break;
    case 'word':
        isset($segments[1]) ? getMessageByWord($segments[1]) : notFoundResponse();
        break;
    default:
        notFoundResponse();
        break;
}

?>