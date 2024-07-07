<?php
//connect to the database
    
$location = "localhost";
    $name = "u872502285_gmvs";
    $password = "Gmvs_123";
    $database = "u872502285_gmvs";

    $conn2 = new mysqli($location, $name, $password, $database);

    if($conn2->connect_error){
        echo "Connection Error";
    }
    
?>