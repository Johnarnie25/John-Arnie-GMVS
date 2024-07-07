<?php
    session_start();
   $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    $id = $_SESSION['StudID'];
    if(isset($id)){
        $sql = mysqli_query($conn, "SELECT clientNotif.NotificationTitle, clientNotif.NotificationMessage, nStatus.NotificationStatusDescription 
        FROM clientnotification AS clientNotif
        INNER JOIN notificationstatus AS nStatus 
        ON clientNotif.ClientNotificationStatusID = nStatus.NotificationStatusID 
        WHERE clientNotif.ClientAccountID = '$id' ");
        
        while ($row = mysqli_fetch_array( $sql )) {
            $nTitle = $row["NotificationTitle"]; $nMSG = $row["NotificationMessage"]; $nStatus = $row["NotificationStatusDescription"]; 
        ?>
            <a class="notif_bttntiles" href="">
                <h4 class="notif_bttntitle"><?php echo $nTitle ?></h4>
                <div class="notif_bttntext <?php echo $nStatus ?>">
                    <span class="notif_bttntxt"><?php echo $nMSG ?></span>
                    <span class="notif_bttntxt"><?php echo $nStatus ?></span>
                </div>
                <hr class="notif_bttnline">
            </a>
        <?php 
        }

        $conn->close();
    }
    
?>