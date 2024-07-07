<?php
$title = 'Profile';
$page = 'client_profile';
include_once('../includes/header.php');

$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
}

// Assuming $id is defined somewhere before this point
$id = mysqli_real_escape_string($conn, $id);

$sql_fetch = $conn->query("SELECT ClientFirstName, ClientMiddleName, ClientLastName, ClientSuffix, ClientStudentNo,
 ClientBDay, ClientAddress, ClientContactNo, ClientGuardian, ClientGuardianNo, ClientEmailAdd FROM clientaccountinfo WHERE ClientAccountID = '$id'");

while($details = $sql_fetch->fetch_assoc())
{
    $fname = $details['ClientFirstName'];
    $mname = $details['ClientMiddleName'];
    $lname = $details['ClientLastName'];
    $sname = $details['ClientSuffix'];
    $stud_ID = $details['ClientStudentNo'];
    $bday = $details['ClientBDay'];
    $cAdd = $details['ClientAddress'];
    $cNo = $details['ClientContactNo'];
    $gName = $details['ClientGuardian'];
    $cGNo = $details['ClientGuardianNo'];
    $cEmail = $details['ClientEmailAdd'];
}

$newBday = date_create($bday);

$sql_fetchpic = $conn->query("SELECT PictureFilename FROM clientprofilepictureinfo WHERE ClientAccountID = '$id' AND UsedStatus = TRUE ");

while($detailpic = $sql_fetchpic->fetch_assoc())
{
    $prof_pic = $detailpic['PictureFilename'];
}

$directory = "../../assets/user_profile_pic/client/";
?>


<div class="content">
<div class="profile">
    <a href="../Client Edit Personal Information/" class="acc_bttn"><i class="fas fa-user-cog"></i></a>
    <p>Profile Info</p>
    <div class="profile_info">
        <div class="profile_pic">
            <div id="prof_pic_div">
                <img class="prof_pic" id="prof_pic" src="<?php echo $directory, $stud_ID,'/', $prof_pic?>" alt="Profile Pic">
            </div>
            

        </div>

       <div class="profile_content_info">
            <div class="input-container">
                <label class="label" for="stud_ID">Student Number: </label>
                <input class="input-field" type="text" id="stud_ID" value="<?php echo $stud_ID?>">
            </div>
            <div class="input-container">
                <label class="label" for="full_name">Full Name: </label>
                <input class="input-field" type="text" id="full_name" value="<?php echo $lname . ', ' . $fname . ' ' . $mname . ' ' . $sname?>" maxlength="20">
            </div>
            <div class="input-container">
                <label class="label" for="birthdate">BirthDate: </label>
                <input class="input-field" type="text" id="birthdate" value="<?php echo date_format($newBday,"F j, Y")?>" maxlength="20">
            </div>
            <div class="input-container">
                <label class="label" for="full_address">Full Address: </label>
                <input class="input-field" type="text" id="full_address" value="<?php echo $cAdd?>" maxlength="50">
            </div>
            <div class="input-container">
                <label class="label" for="email_address">Email Address: </label>
                <input class="input-field" type="email" id="email_address" value="<?php echo $cEmail?>" maxlength="25">
            </div>
            <div class="input-container">
                <label class="label" for="contact_name">Contact Name: </label>
                <input class="input-field" type="text" id="contact_name" value="<?php echo $cNo?>" maxlength="15">
            </div>
            <div class="input-container">
                <label class="label" for="guardian_name">Guardian's Name: </label>
                <input class="input-field" type="text" id="guardian_name" value="<?php echo $gName?>" maxlength="20">
            </div>
            <div class="input-container">
                <label class="label" for="guardian_contact">Guardian's Contact Number: </label>
                <input class="input-field" type="text" id="guardian_contact" value="<?php echo $cGNo?>" maxlength="15">
            </div>
        </div>

    </div>

    <div class="counceling_records_content">
        <h4>Counseling Records</h4>
        <table class="cr_record">
            <tr> 
                <th class="cr_title">Appointment Num.</th>
                <th class="cr_title">Date and Time</th>
                <th class="cr_title">Monitored by:</th>
            </tr>
            <?php 
            $id = $_SESSION['StudID'];

            $sql_fetch = mysqli_query($conn, 
            "SELECT DISTINCT eval.appointment_id, appointSched.app_date, appointSched.start_app, appointSched.end_app, 
            appointSched.client_id, client.ClientFirstName,
            client.ClientMiddleName, client.ClientLastName, client.ClientSuffix, appointSched.anonymity
            FROM forevaluation AS eval 
            INNER JOIN schedules AS appointSched 
            ON eval.appointment_id = appointSched.id 
            INNER JOIN clientaccountinfo AS client 
            ON appointSched.client_id = client.ClientAccountID WHERE appointSched.client_id = '$id' AND appointSched.stat = 'Evaluated'");
            $processed_ids = array();

            while($row = mysqli_fetch_assoc($sql_fetch))
            {
                $app_id = $row['appointment_id'];

                // Check if the appointment_id is already processed
                if (in_array($app_id, $processed_ids)) {
                    continue; // Skip this iteration if the id is already processed
                }

                // Add the appointment_id to the processed list
                $processed_ids[] = $app_id;

                $dateSTime = $row['start_app']; 
                $dateNTime = $row['end_app']; 
                $app_date = $row['app_date']; 
                $anonymity = isset($row['anonymity']) ? $row['anonymity'] : ''; // Check if 'anonymity' key exists, if not, set it to an empty string
                $client_id = $row['client_id'];

                if($anonymity == 'Yes'){
                    $name = 'Anonymous'.$client_id; 
                }
                else{
                    $name = $row['ClientLastName'].", ".$row['ClientFirstName']." ".$row['ClientMiddleName']." ".$row['ClientSuffix']; 
                }
            ?>
            
            <tr>
                <td class="cr_data"><?= $app_id ?></td>
                <td class="cr_data"><?php echo $app_date.' '.date('h:i A', strtotime($dateSTime)).' - '.date('h:i A', strtotime($dateNTime)); ?></td>
                <td class="cr_data">
                    <a href="../Counceling Review Evaulation/?a_id=<?php echo $app_id; ?>" class="bttn_table">
                    <i class="fa-solid fa-book-open"></i>  Review</a>
                </td> 
            </tr>
            <?php }?>
        </table>
    </div>

    <div id="memapic"></div>
</div>
</div>

<?php
include('assets/modal_edit_picture.php')
?>
<script src="assets/js/main.js"></script>
</body>
</html>
