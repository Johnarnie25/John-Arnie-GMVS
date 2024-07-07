<?php
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($conn->connect_error) {
    die('Error : (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

session_start();

// Error message
$error = "Username or Password is incorrect. Please try again";

// When the submit button in the login form is clicked
if (isset($_POST['submit'])) {
    // Giving variables to username and password
    $username = $_POST['username'];
    $pass = $_POST['password'];

    // Fetching the data from the database using a prepared statement
    $sql_fetch = "SELECT * FROM tbl_admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql_fetch);
    $stmt->bind_param('ss', $username, $pass);
    $stmt->execute();
    $stmt->store_result();

    // Checking if the username and password match the database
    if ($stmt->num_rows > 0) {
        // If the username and password are correct, set session variable and redirect
        $_SESSION['username'] = $username;
        header('location: ../administrator/counceling_dashboard/');
        exit;
    } else {
        // If the username and password are incorrect, set error session variable and redirect
        $_SESSION["error"] = $error;
        header("location: index.php");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>