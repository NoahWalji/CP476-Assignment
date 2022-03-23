<?php
    require_once 'sql-connect.php';
    
    class Channel {

        public static function channel_create($channelName) {
            $conn = dbConnect();
            $message = "";
    
            $sql = "SELECT * FROM channels WHERE channel_name=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$channelName);
            $prepared->execute();
            $result = $prepared->get_result();
    
            if (mysqli_num_rows($result) == 0) {
                $sql = "INSERT INTO channels (channel_name) VALUES (?)";
                $prepared = $conn->prepare($sql);
                $prepared->bind_param("s",$channelName);
                $prepared->execute();
    
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
            $prepared = $conn->prepare($sql);
            $prepared->execute();
            $listOfChannels = [];
            $result = $prepared->get_result();
            while ($channel = mysqli_fetch_array($result)) { 
                $listOfChannels[] = $channel["channel_name"];
            }

            return $listOfChannels;
        }

        public static function getChannelMessages($channelName) {
            $conn = dbConnect();
            $sql = "SELECT C.channel_name,M.channel_id, M.contents, U.nickname, U.profile_image, M.time FROM users AS U INNER JOIN messages AS M ON M.author = U.uid INNER JOIN channels AS C ON C.channel_id = M.channel_id WHERE channel_name =?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$channelName);
            $prepared->execute();
            $result = $prepared->get_result();
            $channelMessage= array();

            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $channelMessage[] = $row;
            }

            return $channelMessage;

        }

        public static function send_message($channelName, $message, $uid) {
            $conn = dbConnect();
            $sql = "SELECT * FROM channels WHERE channel_name=?";
            $prepared = $conn->prepare($sql);
            $prepared->bind_param("s",$channelName);
            $prepared->execute();
            $result = $prepared->get_result();
    
            if (mysqli_num_rows($result) == 1) {
                $channelId = $result->fetch_assoc()["channel_id"];
                $sql = "INSERT INTO messages (author,channel_id,contents) VALUES (?, ?, ?)";
                $prepared = $conn->prepare($sql);
                $prepared->bind_param("iis",$uid,$channelId,$message);
                $prepared->execute();
            }
    
            return $message;
        }
    }

?>