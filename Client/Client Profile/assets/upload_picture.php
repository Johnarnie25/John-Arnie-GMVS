<?php
session_start();
$id = $_SESSION['StudID'];
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die(
        'Error : ('. $conn->connect_errno.') '.$conn->connect_error
    );
}

$sql_fetchpic = mysqli_query($conn, "SELECT ClientProfilePictureID from clientprofilepictureinfo WHERE ClientAccountID = '$id' AND UsedStatus = TRUE ");
while($detailpic = mysqli_fetch_assoc($sql_fetchpic))
{
    $prof_picID = $detailpic['ClientProfilePictureID'];
}
if(isset($_POST["image"]))
{
    $data= $_POST["image"];
    $img_array_1 = explode(";" , $data);
    $img_array_2 = explode(",", $img_array_1[1]);
    $basedecode = base64_decode($img_array_2[1]);
    $filename = $id . date("YmdHis") . '.jpg'; // Adjust filename format
    $directory = "../../../assets/user_profile_pic/client";
    // Create directory if it doesn't exist
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    file_put_contents("$directory/$filename", $basedecode);
    $now = date("Y-m-d H:i:s");
    
    $update = "UPDATE clientprofilepictureinfo SET UsedStatus = FALSE WHERE ClientProfilePictureID = '$prof_picID'";
    $conn->query($update);
    
    $insert="INSERT INTO clientprofilepictureinfo(ClientAccountID, PictureFilename, UploadDate, UsedStatus) VALUES ('$id','$filename', '$now', TRUE)";
    mysqli_query($conn, $insert);
    echo '<span class="alert_icon green">
                <i class="fa-solid fa-check"></i>
            </span>
            <span class="alert_text">
                Updated Picture Successful
            </span>';
    
}
else{
    echo '<span class="alert_icon red">
            <i class="fa-solid fa-exclamation"></i>
        </span>
        <span class="alert_text">
            Updated Picture Unsuccessfully
        </span>';
}

?>