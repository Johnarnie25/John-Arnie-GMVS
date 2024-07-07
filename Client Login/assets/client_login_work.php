<?php
session_start();

// This is the connection process, referencing to connection.php
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($conn->connect_error) {
    die('Error: (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

// Giving variable to password and username
$stud_num = mysqli_real_escape_string($conn, $_POST['stud_num']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$_SESSION['StudID'] = '';
$_SESSION['Page'] = '';

// Fetching the data from the database using prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT ClientAccountID, ClientStudentNo, ClientPassword FROM clientaccountinfo WHERE ClientStudentNo = ? AND ClientPassword = ?");
$stmt->bind_param("ss", $stud_num, $pass);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($clientAccountID, $clientStudentNo, $clientPassword);

// Checking if the password and username match the database
if ($stmt->num_rows > 0 && $stmt->fetch()) {
    // If the pass and username are correct, set session variables and output "exists"
    $_SESSION['StudID'] = $clientAccountID;
    $_SESSION['Page'] = 'Client';
    echo "exists";
} else {
    // If the pass and username are incorrect, output "Not exists"
    echo "Not exists";
}

// Close the statement
$stmt->close();
// Close the connection
$conn->close();
?>