<?php

require_once 'dbc.php';

session_start();

function verifyUser($email, $pass) {
    if(password_verify($pass, verifyPass($email))){
        $_SESSION["logged"] = "true";
        header("Location: ../pages/logout");
    }
    else{
        $_SESSION["error"] = "Invalid Email or Password";
        header("Location: ../pages/login");
    }
}

function verifyPass($email) : string {
    $connection = DBC::getConnection();

    $getHashStatement = $connection->prepare("call get_hash(?, @hashx)");
    $getHashStatement->bind_param("s", $email);
    $getHashStatement->execute();
    $getHashStatement->store_result();

    $getHashResultStatement = $connection->prepare("select @hashx");
    $getHashResultStatement->execute();
    $getHashResultStatement->bind_result($hash);
    $getHashResultStatement->fetch();
    $getHashResultStatement->free_result();

    if($hash != null){
        return $hash;
    }
    else{
        return '';
    }
}

verifyUser($_POST["email"], $_POST["pass"]);

?>