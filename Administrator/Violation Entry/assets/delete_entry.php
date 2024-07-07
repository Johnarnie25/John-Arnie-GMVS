<?php
include('dbconnection.php');

$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($connection->connect_error) {
    die('Error : ('. $connection->connect_errno.') '.$connection->connect_error);
}

if (isset($_GET['entry_id'])) {
    $entry_id = $_GET['entry_id'];

    // SQL to delete a record
    $sql = "DELETE FROM forviolationentries WHERE entry_id = $entry_id";

    if ($connection->query($sql) === TRUE) {
        echo "Record deleted successfully";
        // Redirect to the main page
        header("Location: ../index.php?");
    } else {
        echo "Error deleting record: " . $connection->error;
    }

    $connection->close();
} else {
    echo "Invalid request";
}
?>
