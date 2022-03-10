<?php
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        echo("Hello Logged In User " . $_SESSION["username"]);
    }

    else {
        echo("Hello Guest!");
    }
?>
<html>
<head>
<title>CP476 Assignment</title>
</head>
<body>
</body>
</html>