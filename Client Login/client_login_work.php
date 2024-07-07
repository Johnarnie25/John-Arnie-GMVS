<?php
session_start();
// Error message
$error = "Username or Password is incorrect. Please try again";

// Connection to the database
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($conn->connect_error) {
    die('Error: (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

// When the submit button in the login form is clicked
if (isset($_POST['submit'])) {
    // Get username and password from the form
    $username = $_POST['stud_num'];
    $pass = $_POST['password'];

    // Fetch user data from the database based on the provided username
    $sql_fetch = "SELECT * FROM tbl_clients WHERE stud_num = ?";
    $stmt = $conn->prepare($sql_fetch);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user with the provided username exists
    if ($row = $result->fetch_assoc()) {
        // Verify the password
        if (password_verify($pass, $row['ClientPassword'])) {
            // Password is correct, set session and redirect to the home page
            $_SESSION['stud_num'] = $username;
            header('location: ../client/client home/?login=success');
            exit();
        } else {
            // Password is incorrect
            echo '<script>alert("Wrong Password")</script>';
        }
    } else {
        // No user found with the provided username
        $_SESSION["error"] = $error;
    }

    // Close the statement
    $stmt->close();
}

// Redirect to the login page in case of any errors
header("location: index.php");
exit();
?>