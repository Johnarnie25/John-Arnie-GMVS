<?php
    session_start();
    // for Connection.php
  $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }

    $id = $_SESSION['AdminID'];
    $prepass = $_POST['prepass']; 
    $npass = $_POST['npass']; 
    $conpass = $_POST['conpass'];
    $pass = '';
 
    $check_pass = mysqli_query($conn, "SELECT AdminPassword from adminaccountinfo WHERE AdminAccountID = '$id'");
    
    while($detail = mysqli_fetch_assoc($check_pass))
    {
        $pass = $detail['AdminPassword']; 
        if($prepass == $pass){
            if($npass == $conpass){
                //insert sa database
                $updateInfo="UPDATE adminaccountinfo SET AdminPassword = '$npass' WHERE AdminAccountID = '$id'";
                $query_run = mysqli_query($conn, $updateInfo);
                if($query_run){
                echo '<span class="alert_icon green">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    <span class="alert_text">
                        Change Password Successfully
                    </span>';
                }else{
                echo "something is wrong" . $updateInfo . $conn->error;
                }
            }
            else{
                echo "errorConPass";
            }
        }
        else{
            echo "errorPrePass";
        }
    }
    


?> 