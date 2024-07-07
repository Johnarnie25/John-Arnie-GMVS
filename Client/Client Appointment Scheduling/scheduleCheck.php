<?php 
session_start(); 
// DB Connection
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
}

date_default_timezone_set("Asia/Manila");
$dateNow = date("Y-m-d H:i:s");

// Pagkuha ng data mula sa forms
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email_add'];
    $id = $_POST['id'];
    $reason = $_POST['reason'];
    $start_app_time = $_POST['start_app_time'];
    $start_app_date = $_POST['start_app_date'];
    $start_time_edited = date("H:i:s", strtotime($start_app_time));
    $date_edited = date("Y-m-d", strtotime($start_app_date));
    $stat = 'Pending';
    $remarks = $_POST['counselor_id'];

    $start_app = date("Y-m-d H:i:s", strtotime("$start_app_date $start_time_edited"));
    $end_app = date("Y-m-d H:i:s", strtotime("$start_app_date $start_time_edited +1 hour"));

    // Check if the appointment date is in the past
    if ($start_app < $dateNow){
        header("Location: index.php?msg=The date you picked is invalid");
        exit();
    }

    // Check if the email is provided
    if (empty($email)) {
        // Retrieve the email from client account info table
        $get = $conn->query("SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
        while($row = mysqli_fetch_assoc($get)) {
            $email = $row['ClientEmailAdd'];
        }
    }

    // Check for overlapping appointments
    $sql = "SELECT * FROM schedules
            WHERE remarks = '$remarks'
            AND (
                (start_app <= '$start_app' AND end_app > '$start_app') OR
                (start_app < '$end_app' AND end_app >= '$end_app') OR
                ('$start_app' <= start_app AND '$end_app' >= end_app)
            )";
    $result = mysqli_query($conn, $sql);

    // Check if there are overlapping appointments
    if (mysqli_num_rows($result) > 0) {
        header("Location: index.php?msg=mgs002");
        exit();
    } else {
        // Insert appointment into schedules table
        $sql2 = "INSERT INTO schedules (title, email_add, client_id, app_date, start_app, end_app, stat, remarks, reason)
                 VALUES ('$name', '$email', '$id', '$date_edited', '$start_app', '$end_app', '$stat', '$remarks', '$reason')";
        $notification = $conn->query("INSERT INTO adminnotification (AdminAccountID, NotificationTitle, NotificationMessage, AdminNotificationStatusID, DateTimeStamp)
                                      VALUES ('$remarks', 'New Appointment', 'You have a new appointment, check appointment approval page.', '2', NOW())");
        $result2 = mysqli_query($conn, $sql2);
        if ($result2) {
            header("Location: index.php?msg=mgs001");
            exit();
        } else {
            header("Location: index.php?msg=Unknown error occurred. $conn->error");
            exit();
        }
    }
}
?>
