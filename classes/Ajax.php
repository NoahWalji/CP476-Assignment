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

                if ($message === "") {
                    header("location: ../index.php");
                }

                else {
                    $_SESSION["error"] = "<div class=\"alert alert-danger\" role=\"alert\">$message</div>";
                    header("location: ../login.php");
                }


            } 

            else if ($ajax == "signup") {
                $email = $_POST["email"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $repassword = $_POST["repassword"];
                $message = Authentication::userSignup($username, $email, $password, $repassword);
                if ($message === "") {
                    $_SESSION["error"] = "<div class=\"alert alert-success\" role=\"alert\">Successfully signed up. Please login below!</div>";
                    header("location: ../login.php");
                }

                else {
                    $_SESSION["error"] = "<div class=\"alert alert-danger\" role=\"alert\">$message</div>";
                    header("location: ../signup.php");
                }
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