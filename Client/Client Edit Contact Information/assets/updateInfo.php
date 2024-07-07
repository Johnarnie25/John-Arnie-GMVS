<?php
    session_start();
    // for Connection.php
   $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }

    $stud_ID = $_SESSION['StudID'];
    $add = $_POST['add']; 
    $cNom = $_POST['cNom'];
    $cguard = $_POST['cguard'];
    $cguardNum = $_POST['cguardNum'];
    $email = $_POST['email'];
    

    //insert sa database
    $updateInfo="UPDATE clientaccountinfo SET ClientAddress = '$add', ClientContactNo = '$cNom', ClientGuardian = '$cguard',
     ClientGuardianNo = '$cguardNum', ClientEmailAdd = '$email' WHERE ClientAccountID = '$stud_ID'";
    $query_run = mysqli_query($conn, $updateInfo);
    if($query_run){
        echo '<span class="alert_icon green">
                    <i class="fa-solid fa-check"></i>
                </span>
                <span class="alert_text">
                    Edit Information Successful
                </span>';
    }else{
        echo '<span class="alert_icon red">
                    <i class="fa-solid fa-exclamation"></i>
                </span>
                <span class="alert_text">
                    Edit Information Unsuccessful
                </span>';
    }

?> 