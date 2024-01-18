<?php

require_once './dbsystem/dbc.php';

function getUrlSegments($url) {
    $parsed_url = parse_url($url);
    $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
    $path_segments = explode('/', trim($path, '/'));
    array_shift($path_segments);
    return $path_segments;
}

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

function getMessageByRoom($room) {
    $connection = DBC::getConnection();

    $query = "SELECT * FROM group_chat WHERE CASE WHEN IFNULL(?, '') = '' THEN 1 ELSE name = ? END;"
    $getValues = $connection->prepare($query);
    $getValues->bind_param("ss", $room, $room);
    $getValues->execute();
    $result = $getValues->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $getValues->close();
    $connection->close();

    return $rows;
}

?>