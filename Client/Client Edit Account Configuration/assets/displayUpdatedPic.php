<?php
    session_start();
    $id = $_SESSION['StudID'];
  $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }
    $sql_fetch = mysqli_query($conn, "SELECT ClientStudentNo from clientaccountinfo WHERE ClientAccountID = '$id'");
    while($details = mysqli_fetch_assoc($sql_fetch))
    {
        $stud_ID = $details['ClientStudentNo']; 
    }
    $sql_fetchpic = mysqli_query($conn, "SELECT PictureFilename from clientprofilepictureinfo WHERE ClientAccountID = '$id' AND UsedStatus = TRUE ");
    while($detailpic = mysqli_fetch_assoc($sql_fetchpic))
    {
        $prof_pic = $detailpic['PictureFilename'];
        $directory = "../../assets/user_profile_pic/client/";
        ?>
        <img class="prof_pic" id="prof_pic" src="<?php echo $directory, $stud_ID,'/', $prof_pic?>" alt="Profile Pic">
        <?php
    }
    

?>