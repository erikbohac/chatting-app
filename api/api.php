<?php

require_once realpath(__DIR__ . '/../dbsystem/dbc.php');

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

    $query = "SELECT message.id, message.message, users.name, group_chat.name AS 'group' FROM message INNER JOIN users ON users.id = message.user_id INNER JOIN group_chat ON group_chat.id = message.group_id WHERE CASE WHEN IFNULL(?, '') = '' THEN 1 ELSE group_id = (SELECT id from group_chat WHERE name = ?) END ORDER BY id;";
    $getValues = $connection->prepare($query);
    $getValues->bind_param("ss", $room, $room);
    $getValues->execute();
    $result = $getValues->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $getValues->close();
    $connection->close();

    return $rows;
}

function getMessageByUser($user) {
    $connection = DBC::getConnection();

    $query = "SELECT * FROM message WHERE user_id = (SELECT id FROM users WHERE name = ?);";
    $getValues = $connection->prepare($query);
    $getValues->bind_param("s", $user);
    $getValues->execute();
    $result = $getValues->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $getValues->close();
    $connection->close();

    return $rows;
}

function getMessageByWord($word) {
    $connection = DBC::getConnection();

    $query = "SELECT * FROM message WHERE message LIKE CONCAT('%', ?, '%')";
    $getValues = $connection->prepare($query);
    $getValues->bind_param("s", $word);
    $getValues->execute();
    $result = $getValues->get_result();

    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $getValues->close();
    $connection->close();

    return $rows;
}

?>