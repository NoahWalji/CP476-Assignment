<?php
    require 'sql-connect.php';

    class Authentication {

        public static function userSignup($username, $email, $password, $repassword) {
            $conn = dbConnect();
            $message = "";
        
            $sql = "SELECT * FROM users WHERE username='$username'";
            $usernameCheck = mysqli_query($conn, $sql);
    
            $sql = "SELECT * FROM users WHERE email='$email'";
            $emailCheck = mysqli_query($conn, $sql);
    
            if ($password != $repassword) {
                $message = "The entered passwords do not match";
            }
    
            else if (mysqli_num_rows($usernameCheck) == 0 && mysqli_num_rows($emailCheck) == 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username,email,password) VALUES ('$username', '$email', '$hash')";
                $result = mysqli_query($conn, $sql);
                header("location: ../login.php");
                exit;
            }
    
            else {
                $message = "A user with this email and/or username already exists!";
            }
    
            return $message;
        }

        public static function userLogin($email, $password) {    
            // If user logged in already: redirect
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                header("location: ../index.php");
                exit;
            }

            // DB connect and access user
            $conn = dbConnect();
            $message = "";
            $sql = "SELECT * FROM users WHERE email='$email'";
            $userLogin = $conn->query($sql);
    
            // If user is found verify password and add session data
            if (mysqli_num_rows($userLogin) == 1) {
                $userData = $userLogin->fetch_assoc();
                if (password_verify($password, $userData["password"])) {
                    $message = "Successfully logged in. Welcome: " . $userData["username"];
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $userData["username"];
                    $_SESSION["uid"] = $userData["uid"];
                    header("location: ../index.php");
                    exit;
                }
    
                else {
                    $message = "An incorrect password was entered. Please try again.";
                }
            }
    
            else {
                $message = "This email address is not registered to the site.";
            }
    
            return $message;
        }

        public static function userLogout() {
            // Reset session data and redirect
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                $_SESSION = array();
                session_destroy();
        
            }
        }
    }

?>