<?php session_start(); require("nav.php");?>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>CP476 Assignment</title>
</head>
<body>
    <div class="container">
        <?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']); } ?>
        <form action="classes/Ajax.php" method="post">
        <div class="form-group">
            <label for="username">Nickname:</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter a nickname">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter an email address">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="password">Re-enter Password</label>
            <input type="password" name="repassword" class="form-control" id="repassword" placeholder="Re-enter Password">
        </div>
        <input type="hidden" value="signup" name="ajaxCall"/>
        <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>
</body>
</html>