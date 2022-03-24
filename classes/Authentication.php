<?php
    require_once 'sql-connect.php';
    class Authentication {

        public static function userSignup($nickname, $email, $password, $repassword) {
            $conn = dbConnect();
            $message = "";
        
            $sql = "SELECT * FROM users WHERE nickname=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$nickname);
            $prepared->execute();
            $usernameCheck = $prepared->get_result();
    
            $sql = "SELECT * FROM users WHERE email=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$email);
            $prepared->execute();
            $emailCheck = $prepared->get_result();
    
            if ($password != $repassword) {
                $message = "The entered passwords do not match";
            }
    
            else if (mysqli_num_rows($usernameCheck) == 0 && mysqli_num_rows($emailCheck) == 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (nickname,email,password,profile_image) VALUES (?, ?, ?, 'images/default-pfp.png')";
                $prepared = $conn->prepare($sql);
                $prepared->bind_param("sss",$nickname,$email,$hash);
                $prepared->execute();
                return "";
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
            $sql = "SELECT * FROM users WHERE email=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$email);
            $prepared->execute();
            $userLogin = $prepared->get_result();
    
            // If user is found verify password and add session data
            if (mysqli_num_rows($userLogin) == 1) {
                $userData = $userLogin->fetch_assoc();
                if (password_verify($password, $userData["password"])) {
                    $message = "Successfully logged in. Welcome: " . $userData["nickname"];
                    $_SESSION["loggedin"] = true;
                    $_SESSION["nickname"] = $userData["nickname"];
                    $_SESSION["uid"] = $userData["uid"];
                    $_SESSION["pfp"] = $userData["profile_image"];
                    return "";
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

        public static function getUserData($uid) {
            $conn = dbConnect();
            $sql = "SELECT * FROM users WHERE uid = ?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("i",$uid);
            $prepared->execute();
            $userData = $prepared->get_result()->fetch_assoc();

            return $userData;
        }

        public static function changeUserSettings($nickname, $email, $password, $repassword, $file) {
            $conn = dbConnect();
            $message = "";
            $uid = $_SESSION["uid"];
        
            $sql = "SELECT * FROM users WHERE nickname=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$nickname);
            $prepared->execute();
            
            $usernameCheck = $prepared->get_result();
    
            $sql = "SELECT * FROM users WHERE email=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$email);
            $prepared->execute();
            
            $emailCheck = $prepared->get_result();

            $parameters = array();
            $types = "";
    
            if ($password != $repassword) {
                $message = "The entered passwords do not match";
            }
    
            else if (mysqli_num_rows($usernameCheck) == 0 && mysqli_num_rows($emailCheck) == 0) {
                $sql = "UPDATE users SET ";

                if ($nickname != "" ) {
                    $sql .= "nickname = ?,";
                    array_push($parameters,$nickname);
                    $types .= "s";

                }

                if ($email != "") {
                    $sql .= "email =  ?,"; 
                    array_push($parameters,$email);
                    $types .= "s";
                }


                if ($password != "") {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $sql .= "password = ?,";
                    array_push($parameters,$hash);
                    $types .= "s";
                }



                if ($file != null) {
                    $ext = pathinfo($file["name"], PATHINFO_EXTENSION);
                    $target = $_SERVER['DOCUMENT_ROOT']."/images/".$_SESSION["uid"]."-".time().".".$ext;
                    $img_src = "/images/".$_SESSION["uid"]."-".time().".".$ext;
                    $sql .= "profile_image = ?";
                    array_push($parameters,$img_src);
                    $types .= "s";
                    if(file_exists($target)) unlink($target);
                    move_uploaded_file($file["tmp_name"], $target);
                    $_SESSION["pfp"] = $target;

                    $fileSql = "SELECT * FROM users WHERE uid=?";
                    $prepared = $conn->prepare($fileSql);
                    $prepared->bind_param("i",$uid);
                    $prepared->execute();
                    $oldResult = $prepared->get_result();
                    
                    $oldPfp = $oldResult->fetch_assoc()["profile_image"];

                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$oldPfp)) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$oldPfp);
                    }
                }


                $sql = rtrim($sql, ',');
                $sql .= " WHERE uid= ?";
                array_push($parameters,$_SESSION["uid"]);
                $types .= "i";
                $prepared = $conn->prepare($sql);
                $prepared->bind_param($types, ...$parameters);
                $prepared->execute();
                $result = $prepared->get_result();

                if ($nickname != "") {
                    $_SESSION["nickname"] = $nickname;
                }


                return "";
            }
    
            else {
                $message = "A user with this email and/or username already exists!";
            }
    
            return $message;
        }
    }

?>
