<?php 
 $conn = new mysqli('localhost', 'u872502285_gmvs','Gmvs_123','u872502285_gmvs');
 if ($conn->connect_error){
     die(
        'Error : ('. $conn->connect_errno.') '.$conn->connect_error
     );
 }
?>