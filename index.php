<?php session_start();?>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="scripts/main.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>CP476 Assignment</title>
</head>
<body>
    <?php
        require("nav.php");
        require("add-channel.html");
        
    ?>
    <span style="display:none;"id="userNameValue"><?php echo($_SESSION["nickname"]); ?></span>
    <span style="display:none;"id="pfpValue"><?php echo($_SESSION["pfp"]); ?></span>
    <span style="display:none;"id="uidValue"><?php echo($_SESSION["uid"]); ?></span>
    <span style="display:none;"id="channelNameValue"></span>
    <div class="">
        <?php
            $loggedIn = isset($_SESSION["loggedin"]) === true ? true : false;

            if (!$loggedIn) {
            echo("<div class='alert alert-warning' role='alert'>Warning: In order to chat, please login or create an account!</div>");
            }
        ?>
        <div style="display:none;" id="error-message" class='alert alert-danger' role='alert'>Error: Please select a channel before sending a message</div>
        <div class="row">
            <div class="col-md-2">
                <div class="list-group channelList">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChannel"><i class="fa fa-plus" aria-hidden="true"></i> Add Channel</button>
                </div>
            </div>
            <div class="col">
                <div class="card chatDiv">
                    <div class="card-body">
                        <ul class="list-group messagesGroup"></ul>
                    </div>
                </div>
                    <form id="sendMessage">
                        <div class="input-group">
                            <input required type="text" name="message" class="form-control" id="message" placeholder="Enter a chat message">
                            <button type="submit" class="textSubmit btn btn-primary" <?php if (!$loggedIn) {echo("disabled");}?>><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
