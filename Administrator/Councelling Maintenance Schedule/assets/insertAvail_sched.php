<?php 
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    $id = $_POST['id'];
    $start_t = $_POST['start_time'];
    $end_t = $_POST['end_time'];
    $start_d = $_POST['start_date'];
    $end_d = $_POST['end_date'];

    $sql = "UPDATE avail_sched SET start_time = '$start_t', end_time = '$end_t', start_date = '$start_d', end_date = '$end_d'
    WHERE meta_field = '$id'";
    $run = mysqli_query($conn, $sql);

    if($run){
        echo '<span class="alert_icon green">
                    <i class="fa-solid fa-check"></i>
                </span>
                <span class="alert_text">
                    Update Schedule Successful
                </span>';
    }else{
        echo '<span class="alert_icon red">
                    <i class="fa-solid fa-exclamation"></i>
                </span>
                <span class="alert_text">
                    Update Schedule Unsuccessfully
                </span>';
    }

?>