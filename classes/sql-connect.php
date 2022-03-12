<?php
    function dbConnect() {
        
        // MySQL Connection Info
        $servername = "localhost";
        $username = "root";
        $password = "cp476group";
        $db = "cp476";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
    
        // Check connection
        if ($conn->connect_error) {
            echo "Cannot connect to the SQL Database";
        }

        return $conn;
    }
?>