<?php
    // for Connection.php
   $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    } 

    $id = $_POST['id'];
    $roleNameCheck = $_POST['roleNameCheck'];
    $roleNameCheckNew = strtoupper($roleNameCheck);
    $studCouncheck = $_POST['studCouncheck'];
    $studViolationcheck = $_POST['studViolationcheck'];
    $sysMainsCheck = $_POST['sysMainsCheck'];
    $status = $_POST['status'];

    //insert sa database
    $update = $conn->query("UPDATE adminuserrole SET AdminUserRole ='$roleNameCheckNew', AdminPageStudentCounceling = '$studCouncheck',
     AdminPageViolation ='$studViolationcheck', AdminMaintenance ='$sysMainsCheck', StatusID ='$status' WHERE AdminUserRoleID = '$id' ");
    if($update){
        echo "msg001";
        
    }else{
        echo "msg002";
    }

?> 
