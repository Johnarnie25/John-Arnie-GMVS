<?php

// This is the connection process, referencing connection.php
$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($connection->connect_error) {
    die('Error : (' . $connection->connect_errno . ') ' . $connection->connect_error);
}

require('../../assets/PHPMailer/src/PHPMailer.php');
require('../../assets/PHPMailer/src/SMTP.php');
require ('../../assets/PHPMailer/src/Exception.php');

if (isset($_POST['submit'])) {
    // Giving variable to password and username
    $email = $_POST['email'];

    // Fetching the data from the database
    $sql_fetch = mysqli_query($connection, "SELECT * FROM adminaccountinfo WHERE AdminEmailAdd = '$email'");

    if (mysqli_num_rows($sql_fetch) > 0) {
        // Creating a random code
        function generateRandomString($length = 6)
        {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        // Usage
        $myRandomString = generateRandomString(6);

        // Updating the column code in the database for verification purposes
        $updateUser = $connection->query("UPDATE adminaccountinfo SET code = '$myRandomString' WHERE AdminEmailAdd = '$email'");

        if ($updateUser) {
            while ($row = $sql_fetch->fetch_array()) {
                // Sending an email
                $mailTo = $row['AdminEmailAdd'];

                // Message to recipient
                $body = "
                <h1>Here's your code</h1>
                <p>The code will only last for 5 minutes, please use it as soon as possible. <br>
                <br>
                <u>" . $myRandomString . "</u></a>
                <hr />
                <p>© All rights reserved</p>"; // Body

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
                $mail->FromName = "Forgot Password Code";

                $mail->addAddress($mailTo, "Test");
                $mail->isHTML(true);
                $mail->Subject = "Forgot Password";
                $mail->Body = $body;

                if (!$mail->send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                } else {
                    echo "Message has been sent";
                }
            }
            echo "<script>window.location.href='verify_otp.php?success=An OTP has been sent to your email&email=$email'</script>";
            exit();
        } else {
            echo "Error confirming record: " . $connection->error; // Display error message if the update fails
        }
    } else {
        echo "<script>window.location.href='../index.php?error=No email found'</script>";
        exit();
    }
}
?>

