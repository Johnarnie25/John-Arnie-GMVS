<?php
    // for Connection.php
   $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    } 

    $id = $_POST['id'];
    $roleCouncheck = $_POST['roleCouncheck'];
    $status = $_POST['status'];

    //insert sa database
    $update = $conn->query("UPDATE adminaccountinfo SET AdminUserRoleID ='$roleCouncheck', 
    AccountStatusID = '$status' WHERE AdminAccountID = '$id' ");
    if($update){
        echo "msg001";
        
    }else{
        echo "msg002";
    }

?> 
