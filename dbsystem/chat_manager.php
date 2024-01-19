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
    //  get username
    //  send message
    //  join chat - get message
    //  websocket
}

if (isset($_POST["create"]))
{
    createChat($_POST["name"]);
}
if (isset($_POST["join"]))
{
    echo 'join';
}

header("Location: ../pages/chat");

?>