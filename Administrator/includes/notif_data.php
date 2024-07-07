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
        $sql = "SELECT * FROM adminnotification WHERE AdminAccountID = '$id' AND AdminNotificationStatusID = 2";
        $result = $conn->query($sql);
        $fetch = $result->num_rows;
        if($fetch > 0){
            echo '<span class="badge" id="notifCount">'.$fetch.'</span>';
        }
        elseif($fetch > 10){
            echo '<span class="badge" id="notifCount">10+</span>';
        }
        $conn->close();
    }
    
?>