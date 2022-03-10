<?php
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        $_SESSION = array();
        session_destroy();
        header("location: login.php");

    }
?>