<?php
    require 'sql-connect.php';
    // Connect to the Database 
    $conn = dbConnect();
    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $repassword = $_POST["repassword"];

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
        }

        else {
            $message = "A user with this email and/or username already exists!";
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
    <form action="signup.php" method="post">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="password">Re-enter Password:</label><br>
        <input type="password" id="repassword" name="repassword" required><br>
        <input type="submit" value="Sign Up">
    </form>
</body>
</html>