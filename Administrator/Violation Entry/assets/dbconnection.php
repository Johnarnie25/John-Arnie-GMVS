<?php
//connect to the database
    
$location = "localhost";
    $name = "u872502285_gmvs";
    $password = "Gmvs_123";
    $database = "u872502285_gmvs";

    $conn = new mysqli($location, $name, $password, $database);

    if($conn->connect_error){
        echo "Connection Error";
    }
    
?>