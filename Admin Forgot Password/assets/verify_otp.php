
<?php 
$connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
if ($connection->connect_error) {
    die('Error : (' . $connection->connect_errno . ') ' . $connection->connect_error);
}

if(isset($_POST['submit'])){
    $otp = $_POST['otp'];
    $email = $_POST['email'];

    $query = $connection->query("SELECT * from adminaccountinfo WHERE code = '$otp' ");
    
    if(mysqli_num_rows($query) > 0){
        header ("Location:new_pass.php?email=$email");
        exit();
    }else{
        header( "Location:verify_otp.php?error=The entered OTP is invalid&email=$email");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!---icon--->
    <script src="https://kit.fontawesome.com/dcd5bb0e38.js" crossorigin="anonymous"></script> <!---icon--->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    
    <link href="css/login_style.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <div class="body_content">
        <a class="back_bttn" href="../../Client Forgot Password/"><i class="fas fa-arrow-left"></i></a>
        <div class="login_form">
            <div class="welcome_text">
            <img class="logo" src="img/big icon.png" alt="AU LOGO">
                <h2>Guidance Monitoring System</h2>
                <p>For Phinma Araullo Unniverity South Campus
                </p>
                <h2>OTP Verification</h2>
                <p> <?php if (isset($_GET['error'])) { ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>

                                <?php if (isset($_GET['success'])) { ?>
                                    <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?></p>
            </div>
            
           
            <form id="loginForm" method="POST">
                <div class="input_group">
                    <div class="input_container " >
                        <div class="input " id="input_username">
                            <input class="input-field" type="text" placeholder="Enter OTP" name="otp" id="otp">
                            <input type="hidden" name="email" id="email" value="<?= $_GET['email'] ?>">
                            <i id="i_username" ></i>
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bttn_group">
                    <div class="login_bttn">
                        <button type="submit" name="submit" class="selection_bttn"><i class="fas fa-sign-in-alt"></i> Proceed</button>
                    </div>
                </div>
            </form>

        </div>

    </div>
    
</body>
</html>