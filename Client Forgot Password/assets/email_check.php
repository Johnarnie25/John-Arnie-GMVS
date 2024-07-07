<?php


$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($conn->connect_error) {
    die('Error : (' . $conn->connect_errno . ') ' . $conn->connect_error);
}
?>

<?php
require '../../assets/PHPMailer/src/PHPMailer.php';
require '../../assets/PHPMailer/src/SMTP.php';
require ('../../assets/PHPMailer/src/Exception.php');
if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $sql_fetch = mysqli_query($conn, "SELECT * FROM clientaccountinfo WHERE ClientEmailAdd = '$email'");

    if (mysqli_num_rows($sql_fetch) > 0) {
        function generateRandomString($length = 6) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $myRandomString = generateRandomString(6);

        $updateUser = $conn->query("UPDATE clientaccountinfo SET code = '$myRandomString' WHERE ClientEmailAdd = '$email'");

        if ($updateUser) {
            while ($row = $sql_fetch->fetch_array()) {
                $mailTo = $row['ClientEmailAdd'];

                $body = "
                    <h1>Here's your code</h1>
                    <p>The code will only last for 5 minutes, please use it as soon as possible. <br>
                    <br>
                    <u>" . $myRandomString . "</u></a>
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
            echo "Error confirming record";
        }
    } else {
        echo "<script>window.location.href='../index.php?error=No email found'</script>";
        exit();
    }
}

?>
