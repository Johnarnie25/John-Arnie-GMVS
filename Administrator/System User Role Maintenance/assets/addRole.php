<?php
    // for Connection.php
  $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }

    $roleNameCheck = $_POST['roleNameCheck'];
    $roleNameCheckNew = strtoupper($roleNameCheck);
    $studCouncheck = $_POST['studCouncheck'];
    $studViolationcheck = $_POST['studViolationcheck'];
    $sysMainsCheck = $_POST['sysMainsCheck'];

    //insert sa database
    $insert="INSERT INTO adminuserrole (AdminUserRole, AdminPageStudentCounceling, AdminPageViolation,
    AdminMaintenance, StatusID) VALUES ('$roleNameCheckNew','$studCouncheck','$studViolationcheck','$sysMainsCheck','1')";
    $query_run = mysqli_query($conn, $insert);
    if($query_run){
        echo "msg004";
        
    }else{
        echo "msg005";
    }

?> 
