<?php
    require_once 'sql-connect.php';
    
    class Channel {

        public static function channel_create($channelName) {
            $conn = dbConnect();
            $message = "";
    
            $sql = "SELECT * FROM channels WHERE channel_name='$channelName'";
            $channelNameCheck = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($channelNameCheck) == 0) {
                $sql = "INSERT INTO channels (channel_name) VALUES ('$channelName')";
                $result = mysqli_query($conn, $sql);
    
                $message = "Channel successfully created";
            }
    
            else {
                $message = "A channel with this name already exists!";
            }
    
            return $message;
        }

        public static function getChannels() {
            $conn = dbConnect();
            $sql = "SELECT channel_name FROM channels";
            $listOfChannels = [];
            $query = mysqli_query($conn, $sql);
            while ($channel = mysqli_fetch_array($query)) { 
                $listOfChannels[] = $channel["channel_name"];
            }

            return $listOfChannels;
        }

        public static function send_message($channelName, $message, $uid) {
            $conn = dbConnect();
            $message = "";
            $sql = "SELECT * FROM channels WHERE channel_name='$channelName'";
            $channelNameCheck = mysqli_query($conn, $sql);
    
            if (mysqli_num_rows($channelNameCheck) == 1) {
                $sql = "INSERT INTO messages (sender_id,message) VALUES ('$uid', '$message')";
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