<?php
    require("Authentication.php");
    require("Channel.php");
    session_start();
    ajaxAction();


    function ajaxAction() {
        if (isset($_POST["ajaxCall"])) {
            $ajax = $_POST["ajaxCall"];

            // Login Ajax Script
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

            // Signup Ajax Script
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
    
            // Logout Ajax Script
            else if ($ajax == "logout") {
                Authentication::userLogout();
            }

            // User Settings Change Ajax Script
            else if ($ajax == "userChange") {
                $email = $_POST["email"];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $repassword = $_POST["repassword"];
                $file = null;
                if(file_exists($_FILES['pfp']['tmp_name']) && is_uploaded_file($_FILES['pfp']['tmp_name'])) {
                    $file = $_FILES["pfp"];
                }
                $message = Authentication::changeUserSettings($username,$email,$password,$repassword, $file);
                if ($message === "") {
                    $_SESSION["error"] = "<div class=\"alert alert-success\" role=\"alert\">Successfully updated changed settings!</div>";
                    header("location: ../settings.php");
                }

                else {
                    $_SESSION["error"] = "<div class=\"alert alert-danger\" role=\"alert\">$message</div>";
                    header("location: ../settings.php");
                }
            }

            else if ($ajax == "getChannels") {
                $channels = Channel::getChannels();
                echo json_encode($channels);
            }

            else if ($ajax == "addChannel") {
                $channelName = $_POST["channelName"];
                Channel::channel_create($channelName);
                header("location: ../index.php");
            }

            else if ($ajax == "getMessages") {
                $channelName = $_POST["channelName"];
                $messages = Channel::getChannelMessages($channelName);
                echo json_encode($messages);
            }
        }

        else {
            return "false";
        }
    }
?>