<?php

session_start();

$request = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = 'false';
}

function req_error()
{
    require __DIR__ . '/pages/errors/404.php';
    exit();
}

switch ($request){
    case '/':
        $redirect = '/pages/home.php';
        break;
    case '/home':
        $redirect = '/pages/home.php';
        break;
    case '/pages/chat':
        if ($_SESSION['logged'] == 'true') {
            $redirect = '/pages/chat.php';
            break;
        }
        req_error();
    case '/pages/logout':
        if ($_SESSION['logged'] == 'true') {
            $redirect = '/pages/logout.php';
            break;
        }
        req_error();
        break;
    case '/pages/login':
        if ($_SESSION['logged'] == 'false') {
            $redirect = '/pages/login.php';
            break;
        }
        req_error();
    case '/pages/register':
        if ($_SESSION['logged'] == 'false') {
            $redirect = '/pages/register.php';
            break;
        }
        req_error();
    default:
        req_error();
}

$_SESSION['site'] = $redirect;

require_once __DIR__ . '/pages/cores/header.php';
require_once __DIR__ . $redirect;
require_once __DIR__ . '/pages/cores/footer.php';

?>