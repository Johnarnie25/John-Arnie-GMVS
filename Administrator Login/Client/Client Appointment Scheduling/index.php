<?php
    $title = 'Appointment Scheduling';
    $page = 'client_app_sched';
    include_once('../includes/header.php');
    
    $id = $_SESSION['StudID'];
    $sql_fetch = mysqli_query($conn, "SELECT * from clientaccountinfo WHERE ClientAccountID = '$id'");
    $name = "";
    while($row = mysqli_fetch_assoc($sql_fetch)) {
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
                            <input type="hidden" id="msg" name="msg" value="<?php echo htmlspecialchars($_GET['msg']); ?>">
                        <?php } ?>
                        <p>Fill up the following to appoint a Schedule: </p>
                        <label class="label" for="name">Enter Nickname (Optional):</label>
                        <input class="input" type="text" id="name" name="name" value="">
                        <br>
                        <label class="label" for="anonymous">Do you want to be Anonymous or Not:</label>
                        <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($name) ?>">
                        <input type="hidden" id="email_add" name="email_add" value="">
                        <div class="input_radio">
                            <div class="bttn_radio">
                                <input class="bttn_input" type="radio" id="yes" name="anonymous" value="Yes" checked>
                                <label class="bttn_input" for="yes">Yes</label>
                            </div>
                            <div class="bttn_radio">
                                <input class="bttn_input" type="radio" id="no" name="anonymous" value="No">
                                <label class="bttn_input" for="no">No</label>
                            </div>
                        </div>
                        <div class="eval">
                            <label for="reason" class="label">What's bothering you?</label>
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_recommendation" class="fa-solid"></i>
                            <div class="input" id="input_fst_name">
                                <textarea class="input-field evalInput" placeholder="Reason for taking Appointment" name="reason" id="reason"></textarea>
                            </div>
                        </div>
                        <div class="input_container">
                            <label class="label" for="counselor_id">Counselor:</label>
                            <select class="input" required name="counselor_id" id="counselor_id">
                                <option disabled value="" selected="selected">Select a Counselor</option>
                                <?php 
                                    $query = "SELECT adminAcc.AdminAccountID, adminAcc.AdminLastName,
                                             adminAcc.AdminFirstName, adminAcc.AdminMiddleName
                                            FROM adminaccountinfo AS adminAcc
                                            INNER JOIN counsellingzoomlink AS cZlink 
                                            ON adminAcc.AdminAccountID = cZlink.AdminAccountID
                                            WHERE cZlink.CounseZLink IS NOT NULL";
                                    $result1 = mysqli_query($conn, $query);
                                    while($row2 = mysqli_fetch_assoc($result1)) {
                                ?>
                                <option value="<?php echo $row2["AdminAccountID"]; ?>">
                                    <?php echo $row2['AdminLastName'] . ', ' . $row2['AdminFirstName'] . ' ' . $row2['AdminMiddleName']; ?>
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

    <div class="alert" id="alert_bottomappointment">
        <div class="alert_content">
            <div class="alert_content_text" id="alert_contentappointment">
            </div>
            <button class="alert_close" id="alert_Close_bottappointment"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
