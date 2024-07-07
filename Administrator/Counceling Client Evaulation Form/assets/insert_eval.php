<?php 
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    require ('../../../assets/PHPMailer/src/PHPMailer.php');
    require ('../../../assets/PHPMailer/src/SMTP.php');
    require ('../../../assets/PHPMailer/src/Exception.php');


    $id = $_POST['id'];
    $a_id = $_POST['a_id'];
    $eval = $_POST['evaluation'];
    $reco = $_POST['recommendation'];
    

    $insert = $conn->query("INSERT INTO forevaluation(evaluator_id, appointment_id, evaluation, recommendation) VALUES
    ('$id', '$a_id', '$eval', '$reco')");
    if($insert){
        $select = $conn->query("SELECT * FROM schedules WHERE id = '$a_id'");
        while($details = mysqli_fetch_assoc($select)){
            $mailTo = $details['email_add'];
            $client_id = $details['client_id'];

            //Message to recipient
            $body ="
            <h1>Your appointment has been evaluated</h1>
            <p>Please check your profile's appointment records and view the recommendation by your counselor. <br>
            

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
        //para magkaron ng notif sa website
        $notification = $conn->query("INSERT INTO clientnotification(ClientAccountID, NotificationTitle, NotificationMessage, ClientNotificationStatusID, DateTimeStamp)
        VALUES('$client_id', 'Appointment Evaluated', 'You have a new evaluation on your previous appointment.', '2', NOW())");
        
        $update = $conn->query("UPDATE schedules SET stat = 'Evaluated' WHERE id = '$a_id'");
        if($update){
            echo "<script>window.location.href='../../Counceling Client Page/?msg=mgs001'</script>";
        }
    }else{
        echo "<script>window.location.href='../../Counceling Client Page/?msg=mgs002'</script>";
        exit();
    }



?>