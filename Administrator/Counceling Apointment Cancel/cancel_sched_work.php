<?php

$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    require ('../../assets/PHPMailer/src/PHPMailer.php');
    require ('../../assets/PHPMailer/src/SMTP.php');
    require ('../../assets/PHPMailer/src/Exception.php');


    $id = $_POST['id'];
    $client_id = $_POST['client_id'];
    $cancel_reason = $_POST['cancel_reason'];
    $find = $conn->query("SELECT * FROM adminaccountinfo WHERE AdminAccountID = '$id'");
    $row = mysqli_fetch_array($find);
    $finalNameFormat = $row['AdminFirstName'] . ' ' . $row['AdminLastName'];
    $appointmentID = $_POST['a_id']; // get id through query string
    $stat ='Cancelled';
    $query = "UPDATE schedules SET stat ='$stat', remarks ='$id', cancel_id ='$id', cancel_reason = '$cancel_reason' WHERE id = '$appointmentID'";
    $get = "SELECT * FROM schedules WHERE id = '$appointmentID'";
    $data2=mysqli_query($conn, $get);
    $data=mysqli_query($conn, $query);
    $notification = $conn->query("INSERT INTO clientnotification(ClientAccountID, NotificationTitle, NotificationMessage, ClientNotificationStatusID, DateTimeStamp)
    VALUES('$client_id', 'Appointment Cancelled', 'Sorry, your pending appointment has been cancelled because of $cancel_reason.', '2', NOW())");
    echo "success";
    if($data && $data2)
    {
                while($row = $data2->fetch_array()){
                //pagsesendan ng email
                $mailTo = $row['email_add'];
                //Message to recipient
                $start = date("d/m/Y h:i A", strtotime($row['start_app']));
                $end = date("h:i A", strtotime($row['end_app']));
                $body ="
                <h1>Sorry, your appointment got cancelled</h1>
                <p>We're deeply sorry, your appointment on". " <u>" . $start . " - " . $end . "</u> " . "is cancelled by <u>Counselor ". $finalNameFormat ."</u>.<br> 
                The reason was:' ".$cancel_reason." ' .<br>
                Please book another schedule again.</p>
                <hr />

                    <p>© All rights reserved</p>"; //Body
            
                   
                    $mail = new PHPMailer\PHPMailer\PHPMailer();

                    $mail->SMTPDebug = 3;
                    $mail->isSMTP();
                    $mail->Host = "smtp.gmail.com";
                    $mail->SMTPAuth = true;
                    $mail->Username = "csdlcsdl09@gmail.com"; // Your Gmail account
                    $mail->Password = "hkzfdajdykiwnsaj"; // Your Gmail account password
                    $mail->SMTPSecure = "tls";
                    $mail->Port = 587;
                    $mail->From = "csdlcsdl09@gmail.com"; // Your Gmail account
                    $mail->FromName = "Your Appointment in CSDL";
    
                    $mail->addAddress($mailTo, "Test");
                    $mail->isHTML(true);
                    $mail->Subject = "Your Appointment in CSDL";
                    $mail->Body = $body;
    
                    if (!$mail->send()) {
                        echo "Mailer Error: " . $mail->ErrorInfo;
                    } else {
                        echo "Message has been sent";
                    }
                }
                echo "<script>window.location.href='../Counceling Apointment Approval/?msg=mgs003'</script>";
                exit();
            
    }
    else
    {
        echo "<script>window.location.href='../Counceling Apointment Approval/?msg=mgs002'</script>"; // display error message if not delete
    }

    exit();

?>