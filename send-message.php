<?php
    require 'sql-connect.php';
    // Connect to the Database 
    $conn = dbConnect();
    $message = "";
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $channelName = $_POST["channelName"];
        $message = $_POST["message"];
        $uid = $_SESSION["uid"];

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
?>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<title>CP476 Assignment: Signup</title>
</head>
<body>
    <form action="send-message.php" method="post">
        <label for="channelName">Channel Name:</label><br>
        <input type="channelName" id="channelName" name="channelName" required><br>
        <label for="message">Message:</label><br>
        <input type="text" id="message" name="message" required><br>
        <input type="submit" value="Send Message">
    </form>
</body>
</html>