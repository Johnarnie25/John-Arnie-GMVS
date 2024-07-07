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
            <a class="notif_tiles" href="">
                <h5 class="notif_title"><?php echo $nTitle ?></h5>
                <div class="notif_text <?php echo $nStatus ?>">
                    <p class="notif_txt"><?php echo $nMSG ?></p>
                    <p class="notif_txt"><?php echo $nStatus ?></p>
                </div>
                <hr class="notif-line">
            </a>
            
        <?php 
        }

        $conn->close();
    }
    
?>