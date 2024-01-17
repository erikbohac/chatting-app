<?php

function unauthorizedResponse() {
    header("HTTP/1.1 401 Unauthorized");
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

function notFoundResponse() {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(['error' => 'Not Found']);
    exit();
}

?>