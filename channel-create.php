<?php
    require 'sql-connect.php';
    // Connect to the Database 
    $conn = dbConnect();
    $message = "";
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $channelName = $_POST["channelName"];
        $channelDescription = $_POST["channelDescription"];
        $username = $_SESSION["uid"];

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
    <form action="channel-create.php" method="post">
        <label for="channelName">Channel Name:</label><br>
        <input type="channelName" id="channelName" name="channelName" required><br>
        <label for="channelDescription">Channel Description:</label><br>
        <input type="text" id="channelDescription" name="channelDescription" required><br>
        <input type="submit" value="Create Channel">
    </form>
</body>
</html>