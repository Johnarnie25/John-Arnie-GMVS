<?php
    session_start();
  $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    $id = $_SESSION['AdminID'];
    if(isset($id)){
        $sql = "UPDATE adminnotification SET AdminNotificationStatusID = 1 WHERE AdminAccountID = '$id' AND AdminNotificationStatusID = 2";
        $res = mysqli_query($conn, $sql);
        if ($res){
            echo 'success';
        }else{
            echo 'error';
        }
    }
    
?>