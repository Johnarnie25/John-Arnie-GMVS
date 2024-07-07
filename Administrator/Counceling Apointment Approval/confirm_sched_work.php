
<?php
    session_start();
   $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    require ('../../assets/PHPMailer/src/PHPMailer.php');
    require ('../../assets/PHPMailer/src/SMTP.php');
    require ('../../assets/PHPMailer/src/Exception.php');

    $cZLinkIdUser = $_SESSION['AdminID'];
    $findLink = $conn->query("SELECT * FROM counsellingzoomlink WHERE AdminAccountID = '$cZLinkIdUser'");
    $rowlink = mysqli_fetch_array($findLink);
    $link = $rowlink['CounseZLink'];

    $id = $_GET['id'];
    $client_id = $_GET['client_id'];
    $find = $conn->query("SELECT * FROM adminaccountinfo WHERE AdminAccountID = '$id'");
    $row = mysqli_fetch_array($find);
    $finalNameFormat = $row['AdminFirstName'] . ' ' . $row['AdminLastName'];
    $appointmentID = $_GET['a_id']; // get id through query string
    $stat ='To be Evaluate';
    $query = "UPDATE schedules SET stat ='$stat', remarks ='$id', CounseZLink = '$link' WHERE id = '$appointmentID'";
    $get = "SELECT * FROM schedules WHERE id = '$appointmentID'";
    $data2=mysqli_query($conn, $get);
    $data=mysqli_query($conn, $query);
    $notification = $conn->query("INSERT INTO clientnotification(ClientAccountID, NotificationTitle, NotificationMessage, ClientNotificationStatusID, DateTimeStamp)
    VALUES('$client_id', 'Appointment Confirmed', 'Your pending appointment has been approved.', '2', NOW())");
    if($data && $data2)
    {
                while($row = $data2->fetch_array()){
                //pagsesendan ng email
                $mailTo = $row['email_add'];
                //Message to recipient
                $start = date("d/m/Y h:i A", strtotime($row['start_app']));
                $end = date("h:i A", strtotime($row['end_app']));
                $body ="
                <h1>Your appointment is confirmed!</h1>
                <p>Your appointment of <u>".$start." - ".$end."</u> "." is confirmed by Counselor <u>".$finalNameFormat."</u>. <br>
                    Please be in the waiting room <u>15 minutes earlier</u> than the scheduled time.</p>
                    <a href='$link' target='_blank' class='btn'>Link here</a>

                    <hr />

                    <p id='contact'>© All rights reserved</p>"; //Body
            
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
            echo "<script>window.location.href='../Counceling Apointment Approval/?msg=mgs001'</script>";
            exit();
    }
    else
    {
        echo "<script>window.location.href='../Counceling Apointment Approval/?msg=mgs002'</script>"; // display error message if not delete
    }

    exit();
?>