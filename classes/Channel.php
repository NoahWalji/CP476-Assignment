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

        public static function getChannelMessages($channelName) {
            $conn = dbConnect();
            $sql = "SELECT C.channel_name,M.channel_id, M.contents, U.nickname, U.profile_image, M.time FROM users AS U INNER JOIN messages AS M ON M.author = U.uid INNER JOIN channels AS C ON C.channel_id = M.channel_id WHERE channel_name ='$channelName'";
            $channelMessage= array();
            $query = mysqli_query($conn, $sql);

            while($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $channelMessage[] = $row;
            }

            return $channelMessage;

        }

        public static function send_message($channelName, $message, $uid) {
            $conn = dbConnect();
            $sql = "SELECT * FROM channels WHERE channel_name='$channelName'";
            $channelNameCheck = $conn->query($sql);
    
            if (mysqli_num_rows($channelNameCheck) == 1) {
                $channelId = $channelNameCheck->fetch_assoc()["channel_id"];
                $sql = "INSERT INTO messages (author,channel_id,contents) VALUES ('$uid',$channelId,'$message')";
                $result = mysqli_query($conn, $sql);
            }
    
            return $message;
        }
    }

?>