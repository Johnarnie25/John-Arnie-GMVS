<?php
session_start();

$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($connection->connect_error) {
    die('Error: (' . $connection->connect_errno . ') ' . $connection->connect_error);
}

$id = $_SESSION['StudID'];

if (isset($id)) {
    $sql = $connection->query("SELECT clientNotif.NotificationTitle, clientNotif.NotificationMessage, nStatus.NotificationStatusDescription 
        FROM clientnotification AS clientNotif
        INNER JOIN notificationstatus AS nStatus 
        ON clientNotif.ClientNotificationStatusID = nStatus.NotificationStatusID 
        WHERE clientNotif.ClientAccountID = '$id' ORDER BY DateTimeStamp DESC");

    while ($row = $sql->fetch_assoc()) {
        $nTitle = htmlspecialchars($row["NotificationTitle"]);
        $nMSG = htmlspecialchars($row["NotificationMessage"]);
        $nStatus = htmlspecialchars($row["NotificationStatusDescription"]);
?>
        <a class="notif_bttntiles" href="">
            <h4 class="notif_bttntitle"><?php echo $nTitle; ?></h4>
            <div class="notif_bttntext <?php echo $nStatus; ?>">
                <span class="notif_bttntxt"><?php echo $nMSG; ?></span>
                <span class="notif_bttntxt"><?php echo $nStatus; ?></span>
            </div>
            <hr class="notif_bttnline">
        </a>
<?php
    }

    $connection->close();
}
?>
