<?php
    $title = 'Appointment Scheduling';
    $page = 'client_app_sched';
    include_once('../includes/header.php');

    // Database connection
    $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    // Check connection
    if ($conn->connect_error){
        die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
    } 

    // Get user ID from session
    $id = $_SESSION['StudID'];
    $name = "";

    // Fetch user information from database
    $sql_fetch = mysqli_query($conn, "SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
    
    // Check if user information exists
    if(mysqli_num_rows($sql_fetch) > 0) {
        $row = mysqli_fetch_assoc($sql_fetch);
        $name = $row['ClientAccountID'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Add necessary HTML head content here -->
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="content">
        <div class="appoint_form">
            <div class="title_content">
                <h3>Appointment Schedule</h3>
            </div>
            <div class="content_appoint">
                <form action="dateSelection.php" method="POST">
                    <div class="form_content">
                        <!-- message if ever recorded or taken yung sched -->
                        <?php if (isset($_GET['msg'])) { ?>
                            <input class="input" type="hidden" id="msg" name="msg" value="<?php echo $_GET['msg']; ?>">
                        <?php } ?>

                        <p>Fill up the following to appoint a Schedule: </p>
                        <!-- Hide the "Do you want to be Anonymous" section -->
                        <label class="label" for="#">Enter Full Name: </label>
                        <input class="input" type="text" id="name" name="name" value="" required>
                        <br>
                        <input class="input" type="hidden" id="id" name="id" value="<?= $name ?>">
                        <!-- Include the hidden input for "anonymous" with value set to "No" -->
                        <input class="input" type="hidden" id="anonymous" name="anonymous" value="No">
                        <input type="hidden" id="email_add" name="email_add" value="">
                        
                        <div class="eval">
                            <label for="#" class="label">What's bothering you? </label>
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_recommendation" class="fa-solid "></i>
                            <div class="input " id="input_fst_name">
                                <textarea class="input-field evalInput" placeholder="Reason for taking Appointment" name="reason" id="reason" required maxlength="80"></textarea>
                            </div>
                        </div>
                        
                        <div class="input_container">
                            <label class="label" for="#">Counselor: </label>
                            <select class="input" required name="counselor_id" id="counselor_id">
                                <option disabled value="" selected="selected">Select a Counselor</option>
                                <?php 
                                    $query = "SELECT adminAcc.AdminAccountID, adminAcc.AdminLastName,
                                             adminAcc.AdminFirstName, adminAcc.AdminMiddleName
                                            FROM adminaccountinfo as adminAcc
                                            INNER JOIN counsellingzoomlink AS cZlink 
                                            ON adminAcc.AdminAccountID = cZlink.AdminAccountID WHERE cZlink.CounseZLink IS NOT NULL";
                                    $result1 = mysqli_query($conn, $query);
                                    while($row2 = mysqli_fetch_assoc($result1)) {
                                ?>
                                    <option value="<?php echo $row2["AdminAccountID"];?>">
                                        <?php echo $row2['AdminLastName'].', '. $row2['AdminFirstName'].' '.$row2['AdminMiddleName']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                     
                    </div>
                    <div class="form_action">
                        <button type="submit" name="submit" class="form_bttn">Next</button>
                    </div>
                
                </form>
            </div>
            
        </div>
    </div>

    <div class="alert " id="alert_bottomappointment">
        <div class="alert_content">
            <div class="alert_content_text" id="alert_contentappointment">
                
            </div>
            <button class="alert_close" id="alert_Close_bottappointment"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

</body>

</html>
