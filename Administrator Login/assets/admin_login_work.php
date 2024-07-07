<?php
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($conn->connect_error) {
    die('Error : (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

session_start();

// Giving variables to password and username and sanitizing input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);

$_SESSION['AdminID'] = '';
$_SESSION['Page'] = '';

// Fetching the data from the database using prepared statements to prevent SQL injection
$sql_fetch = $conn->prepare("SELECT AdminAccountID, AdminUsername, AdminPassword FROM adminaccountinfo WHERE AdminUsername = ? AND AdminPassword = ?");
$sql_fetch->bind_param('ss', $username, $pass);
$sql_fetch->execute();
$sql_fetch->store_result();

// Checking if the password and username match the database
if ($sql_fetch->num_rows > 0) {
    // If the username and password are correct, display this
    $sql_fetch->bind_result($adminID, $adminUsername, $adminPassword);
    $sql_fetch->fetch();

    $_SESSION['AdminID'] = $adminID;
    $_SESSION['Page'] = 'Admin';
    echo "exists";
} else {
    // If the username and password are incorrect, display this
    echo "Not exists";
}

$sql_fetch->close();
$conn->close();
?>