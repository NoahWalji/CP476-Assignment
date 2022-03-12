<?php
    require("Authentication.php");
    session_start();
    ajaxAction();


    function ajaxAction() {
        if (isset($_POST["ajaxCall"])) {
            $ajax = $_POST["ajaxCall"];

            if ($ajax == "login") {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $message = Authentication::userLogin($email, $password);
                return $message;
            } 

            else if ($ajax == "signup") {
                $email = $_POST["email"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $repassword = $_POST["repassword"];
                $message = Authentication::userSignup($username, $email, $password, $repassword);
                return $message;
            }
    
            else if ($ajax == "logout") {
                Authentication::userLogout();
            }
        }

        else {
            return "false";
        }
    }
?>