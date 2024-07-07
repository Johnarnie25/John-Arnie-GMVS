<?php
// INSERTING A DATA TO DATABASE FROM WEB PAGE
include_once 'dbconnection.php';

$Violations = isset($_POST['violations']) ? $_POST['violations'] : null;
if(empty($Violations)){
    echo '<span class="alert_icon orange">
            <i class="fa-solid fa-exclamation"></i>
        </span>
        <span class="alert_text">
            Please Fill up the Form
        </span>';
} else {
    $existViolation = '';
    $check_viol = mysqli_query($conn, "SELECT Violations from fortheviolations WHERE Violations = '$Violations'");
    
    if($check_viol && mysqli_num_rows($check_viol) > 0) {
        echo '<span class="alert_icon red">
                    <i class="fa-solid fa-exclamation"></i>
                </span>
                <span class="alert_text">
                    Violation is Already Exists
                </span>';
    } else {
        $sql = "INSERT INTO `fortheviolations` (`Violations`) VALUE ('$Violations')";
        $result = mysqli_query($conn, $sql);
        if($result){
            echo '<span class="alert_icon green">
                    <i class="fa-solid fa-check"></i>
                </span>
                <span class="alert_text">
                    Add Violation Successfully
                </span>';
        } else {
            echo '<span class="alert_icon orange">
                        <i class="fa-solid fa-exclamation"></i>
                    </span>
                    <span class="alert_text">
                        Something Error in Connection
                    </span>';
        }
    }
}
?>   
