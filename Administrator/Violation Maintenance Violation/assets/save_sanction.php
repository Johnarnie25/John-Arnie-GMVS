<?php
// INSERTING A DATA TO DATABASE FROM WEB PAGE
include_once 'dbconnection.php';

$Sanction = isset($_POST['sanctions']) ? $_POST['sanctions'] : null;
if(empty($Sanction)){
    echo '<span class="alert_icon orange">
            <i class="fa-solid fa-exclamation"></i>
        </span>
        <span class="alert_text">
            Please Fill up the Form
        </span>';
} else {
    $existSanction = '';
    $check_sanc = mysqli_query($conn, "SELECT Sanctions from forthesanctions WHERE Sanctions = '$Sanction'");

    if($check_sanc && mysqli_num_rows($check_sanc) > 0) {
        echo '<span class="alert_icon red">
                    <i class="fa-solid fa-exclamation"></i>
                </span>
                <span class="alert_text">
                    Violation is Already Exists
                </span>';
    } else {
        $sql = "INSERT INTO forthesanctions (Sanctions) VALUES ('$Sanction')";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            echo '<span class="alert_icon orange">
                        <i class="fa-solid fa-exclamation"></i>
                    </span>
                    <span class="alert_text">
                        Something Error in Connection
                    </span>';
        } else {
            echo '<span class="alert_icon green">
                    <i class="fa-solid fa-check"></i>
                </span>
                <span class="alert_text">
                    Add Violation Successfully
                </span>';
        }
    }
}
?>
