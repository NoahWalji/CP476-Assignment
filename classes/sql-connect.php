<?php
    function dbConnect() {
        
        // MySQL Connection Info
        $servername = "naabe.cloud";
        $username = "cp476";
        $password = "cp476";
        $db = "db_cp476";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);
    
        // Check connection
        if ($conn->connect_error) {
            echo "Cannot connect to the SQL Database";
        }

        return $conn;
    }
?>