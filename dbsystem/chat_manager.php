<?php

require_once 'dbc.php';

session_start();

function createChat($name) {
    $connection = DBC::getConnection();

    $groupStatus = $connection->prepare("CALL get_group(?, @can_create);");
    $groupStatus->bind_param("s", $name);
    $groupStatus->execute();
    $groupStatus->store_result();

    $getGroupStatus = $connection->prepare("SELECT @can_create;");
    $getGroupStatus->execute();
    $getGroupStatus->bind_result($exists);
    $getGroupStatus->fetch();
    $getGroupStatus->free_result();

    if($exists == 1){
        $query = "INSERT INTO group_chat(name) VALUE (?);";
        $createChat = $connection->prepare($query);
        $createChat->bind_param("s", $name);
        $createChat->execute();
        $createChat->close();
        $_SESSION["status"] = "Chat successfully created";
    }
    else{
        $_SESSION["status"] = "Chat with this name already exists";
    }
}

function joinChat($name) {
    $connection = DBC::getConnection();

    $query = "SELECT count(name) FROM group_chat WHERE name = ?;";
    $getGroupStatus = $connection->prepare($query);
    $getGroupStatus->bind_param("s", $name);
    $getGroupStatus->execute();
    $getGroupStatus->bind_result($exists);
    $getGroupStatus->fetch();
    $getGroupStatus->free_result();

    if ($exists > 0)
    {
        obtainMessages();
        $_SESSION["chat_name"] = $name;
    }
    else{
        $_SESSION["status"] = "Chat does not exist, try creating one";
    }
}

function obtainMessages() {
    $url = 'http://localhost/api/group/' . $name;
    $ch = curl_init($url);
    $headers = [
        'Authorization: Allowed',
        'Content-Type: application/json',
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $apiResponse = json_decode($response, true);
    $_SESSION["messages"] = $apiResponse;
}

function sendMessage($message, $chat, $author) {
    $connection = DBC::getConnection();

    $query = "CALL insert_message (?, ?, ?);";
    $sendMessage = $connection->prepare($query);
    $sendMessage->bind_param("sss", $message, $chat, $author);
    $sendMessage->execute();
    $sendMessage->close();
}


if (isset($_POST["create"]))
{
    createChat($_POST["name"]);
}
if (isset($_POST["join"]))
{
    joinChat($_POST["name"]);
}
if (isset($_POST["message_send"]))
{
    sendMessage($_POST["message"], $_SESSION["chat_name"], $_SESSION["username"]);
    obtainMessages(); //No websocket
}

header("Location: ../pages/chat");

?>