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
        $sql = mysqli_query($conn, "SELECT adminNotif.NotificationTitle, adminNotif.NotificationMessage, nStatus.NotificationStatusDescription 
        FROM adminnotification AS adminNotif
        INNER JOIN notificationstatus AS nStatus 
        ON adminNotif.AdminNotificationStatusID = nStatus.NotificationStatusID 
        WHERE adminNotif.AdminAccountID = '$id' ORDER BY DateTimeStamp DESC LIMIT 10");
        
        while ($row = mysqli_fetch_array( $sql )) {
            $nTitle = $row["NotificationTitle"]; $nMSG = $row["NotificationMessage"]; $nStatus = $row["NotificationStatusDescription"]; 
            $nNMSG = mb_strimwidth($nMSG, 0, 25, "...");
        ?>
        <a class="notif_tiles" href="">
            <h5 class="notif_title"><?php echo $nTitle ?></h5>
            <div class="notif_text <?php echo $nStatus ?>">
                <p class="notif_txt"><?php echo $nNMSG ?></p>
                <p class="notif_txt"><?php echo $nStatus ?></p>
            </div>
            <hr class="notif-line">
        </a>
            
        <?php 
        }

        $conn->close();
    }
    
?>