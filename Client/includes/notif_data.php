<?php
session_start();

$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($connection->connect_error) {
    die('Error: ('. $connection->connect_errno.') '.$connection->connect_error);
}

// Use prepared statements to prevent SQL injection
$id = isset($_SESSION['StudID']) ? $_SESSION['StudID'] : null;

if ($id !== null) {
    $sql = "SELECT * FROM clientnotification WHERE ClientAccountID = ? AND ClientNotificationStatusID = 2";
    
    // Use prepared statement
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    
    // Get the result and check the number of rows
    $result = $stmt->get_result();
    $fetch = $result->num_rows;

    // Limit the displayed count to 10
    $notificationCount = ($fetch > 10) ? '10+' : $fetch;

    if ($fetch > 0) {
        echo '<span class="badge" id="notifCount">' . $notificationCount . '</span>';
    }

    $stmt->close();
}

$connection->close();
?>
