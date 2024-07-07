<?php
$title = 'Appointment Scheduling';
$page = 'client_app_sched';
include_once('../includes/header.php');

// Database connection
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
}

$id = $_SESSION['StudID'];
$sql_fetch = mysqli_query($conn, "SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
$name = "";
while($row = mysqli_fetch_assoc($sql_fetch))
{
    $name = $row['ClientAccountID'];
}

if(isset($_POST['submit'])){
    $input_name = $_POST['name'];
    $email = $_POST['email_add'];
    $c_id = $_POST['counselor_id'];
    $reason = $_POST['reason'];
    // Check if 'anonymous' field exists in $_POST array
    // If not, set a default value of 'No'
    $anonymous = isset($_POST['anonymous']) ? $_POST['anonymous'] : 'No';
}
?>
<div class="content">
    <div class="appoint_form">
        <div class="title_content">
            <h3>Appointment Schedule</h3>
        </div>
        <div class="content_appoint">
            <form action="scheduleCheck.php" method="POST">
                <div class="form_content">
                    <a class="back_bttn" href="index.php"><i class="fas fa-arrow-left"></i></a>
                    <p>Fill up the following to appoint a Sched</p>
                    <input class="input" type="hidden" id="id" name="id" value="<?= $name ?>">
                    <input class="input" type="hidden" id="email_add" name="email_add" value="<?= $email ?>">
                    <input class="input" type="hidden" id="name" name="name" value="<?= $input_name ?>">
                    <input class="input" type="hidden" id="counselor_id" name="counselor_id" value="<?= $c_id ?>">
                    <!-- Use the default value of 'No' for the 'anonymous' field -->
                    <input class="input" type="hidden" id="anonymous" name="anonymous" value="<?= $anonymous ?>">
                    <input class="input" type="hidden" id="reason" name="reason" value="<?= $reason ?>">
                    <div class="input_container">
                        <?php 
                        $SQL = $conn->query("SELECT meta_field,
                        start_date,
                        end_date FROM avail_sched WHERE meta_field = '$c_id'");

                        while ($row = $SQL->fetch_assoc()) {
                        ?>
                        <label class="label" for="#">Date of Appointment: </label>
                        <br>
                        <input class="input" type="date" required id="start_app_date" name="start_app_date" min="<?php echo $row['start_date']; ?>" max="<?php echo $row['end_date']; ?>">
                        <?php
                        }
                        ?>
                    </div>
                    
                    <div class="input_container">
                        <?php 
                        $SQL = $conn->query("SELECT meta_field,
                        start_time,
                        end_time FROM avail_sched WHERE meta_field = '$c_id'");

                        while ($row = $SQL->fetch_assoc()) {
                            $start_time = strtotime($row['start_time']);
                            $end_time = strtotime($row['end_time']);
                            $current_time = $start_time;
                            ?>
                            <label class="label" for="#">Time of Appointment: </label>
                            <br>
                            <select class="input" required id="start_app_time" name="start_app_time">
                                <?php while ($current_time < $end_time): ?>
                                    <?php if (date('H:i', $current_time) !== '12:00'): ?>
                                        <option value="<?php echo date('H:i', $current_time); ?>"><?php echo date('h:i A', $current_time); ?></option>
                                    <?php endif; ?>
                                    <?php $current_time += 3600; ?>
                                <?php endwhile; ?>
                            </select>
                        <?php } ?>
                    </div>
                </div>
                <div class="form_action">
                    <button type="submit" name="submit" class="form_bttn">Appoint</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
