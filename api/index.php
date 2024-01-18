<?php

require_once 'api.php';

$request = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = 'false';
}

if ($_SESSION['logged'] == 'false') {
    unauthorizedResponse();
}

$segments = getUrlSegments($request);

if (count($segments) < 1 || count($segments) > 2) {
    notFoundResponse();
}

$endpoint = $segments[0];

switch ($endpoint){
    case 'group':
        isset($segments[1]) ? getMessageByRoom($segments[1]) : getMessageByRoom(NULL);
        break;
    case 'user':
        break;
    case 'word':
        break;
    default:
        notFoundResponse();
        break;
}

?>