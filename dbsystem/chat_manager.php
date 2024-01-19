<?php

require_once 'dbc.php';

session_start();

function createChat($name) {
    $connection = DBC::getConnection();

    $groupStatus = $connection->prepare("call get_group(?, @can_create);");
    $groupStatus->bind_param("s", $name);
    $groupStatus->execute();
    $groupStatus->store_result();

    $getGroupStatus = $connection->prepare("select @can_create;");
    $getGroupStatus->execute();
    $getGroupStatus->bind_result($exists);
    $getGroupStatus->fetch();
    $getGroupStatus->free_result();

    if($exists != null){
        $createChat = $connection->prepare("insert into group_chat(name) value (?);");
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

    $getGroupStatus = $connection->prepare("SELECT count(name) FROM group_chat WHERE name = ?;");
    $getGroupStatus->bind_param("s", $name);
    $getGroupStatus->execute();
    $getGroupStatus->bind_result($exists);
    $getGroupStatus->fetch();
    $getGroupStatus->free_result();

    if ($exists > 0)
    {
        $url = 'http://localhost/api/group/' . $name;
        $ch = curl_init($url);
        $headers = [
            'Authorization: Allowed',
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        $apiResponse = json_decode($response, true);
        $_SESSION["messages"] = $apiResponse;
        $_SESSION["chat_name"] = $name;
    }
    else{
        $_SESSION["status"] = "Chat does not exist, try creating one";
    }
}

if (isset($_POST["create"]))
{
    createChat($_POST["name"]);
}
if (isset($_POST["join"]))
{
    joinChat($_POST["name"]);
}

header("Location: ../pages/chat");

?>

//  send message
//  websocket