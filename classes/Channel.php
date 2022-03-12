<?php
    require 'sql-connect.php';
    
    class Channel {

        public static function channel_create($channelName, $channelDescription, $username) {
            $conn = dbConnect();
            $message = "";
    
            $sql = "SELECT * FROM channels WHERE channel_name='$channelName'";
            $channelNameCheck = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($channelNameCheck) == 0) {
                $sql = "INSERT INTO channels (channel_name,description,creator) VALUES ('$channelName', '$channelDescription', '$username')";
                $result = mysqli_query($conn, $sql);
    
                $sql = "CREATE TABLE channel_$channelName (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, sender_id int, message varchar(255), sent_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)";
                $result = mysqli_query($conn, $sql);
    
                $message = "Channel successfully created";
            }
    
            else {
                $message = "A channel with this name already exists!";
            }
    
            return $message;
        }

        public static function send_message($channelName, $message, $uid) {
            $conn = dbConnect();
            $message = "";
            $sql = "SELECT * FROM channels WHERE channel_name='$channelName'";
            $channelNameCheck = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($channelNameCheck) == 1) {
                $sql = "INSERT INTO channel_$channelName (sender_id,message) VALUES ('$uid', '$message')";
                $result = mysqli_query($conn, $sql);
                $message = "Message sent";
            }
    
            else {
                $message = "A channel with this name does not exists!";
            }
    
            echo $message;
        }
    }

?>