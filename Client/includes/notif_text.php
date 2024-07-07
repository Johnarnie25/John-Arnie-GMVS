<?php
session_start();

$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($connection->connect_error) {
    die('Error: ('. $connection->connect_errno.') '.$connection->connect_error);
}

$id = $_SESSION['StudID'];
if (isset($id)) {
    $sql = mysqli_query($connection, "SELECT clientNotif.NotificationTitle, clientNotif.NotificationMessage, nStatus.NotificationStatusDescription 
        FROM clientnotification AS clientNotif
        INNER JOIN notificationstatus AS nStatus 
        ON clientNotif.ClientNotificationStatusID = nStatus.NotificationStatusID 
        WHERE clientNotif.ClientAccountID = '$id' ORDER BY DateTimeStamp DESC LIMIT 10");
        
    while ($row = mysqli_fetch_assoc($sql)) {
        $nTitle = $row["NotificationTitle"];
        $nMSG = $row["NotificationMessage"];
        $nStatus = $row["NotificationStatusDescription"];
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

    $connection->close();
}
?>
