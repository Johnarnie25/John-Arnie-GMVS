<?php
    // for Connection.php
    $connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');
    if ($connection->connect_error) {
        die('Error : (' . $connection->connect_errno . ') ' . $connection->connect_error);
    }

    $fst_name = $_POST['fst_name'];
    $mid_name = $_POST['mid_name'];
    $last_name = $_POST['last_name'];
    $suf_name = $_POST['suf_name'];
    $stud_num = $_POST['stud_num'];
    $client_email = $_POST['client_email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $bday = $_POST['bday'];
    $add = $_POST['add'];
    $gender = $_POST['gender'];
    $client_contact = $_POST['client_contact'];
    $guar_name = $_POST['guar_name'];
    $guardian_contact = $_POST['guardian_contact'];

    //insert sa database
    $insert = "INSERT INTO clientaccountinfo (ClientFirstName, ClientMiddleName, ClientLastName,
    ClientSuffix, ClientStudentNo, RoleID, ClientBDay, ClientAddress, ClientContactNo, ClientGuardian, ClientGuardianNo,
    ClientEmailAdd, ClientPassword, ClientGenderID) VALUES ('$fst_name','$mid_name','$last_name',
    '$suf_name','$stud_num','1','$bday', '$add', '$client_contact', '$guar_name', '$guardian_contact',
    '$client_email', '$password', '$gender')";
    $query_run = mysqli_query($connection, $insert);

    if ($query_run) {
        $directoryFolder = '../../assets/user_profile_pic/client/' . $stud_num;
        mkdir($directoryFolder);

        $sourceIMG = '../../assets/user_profile_pic/default_user.jpg';
        $insertIMG = '../../assets/user_profile_pic/client/' . $stud_num . '/default_user.jpg';
        copy($sourceIMG, $insertIMG);

        $imgFileName = 'default_user.jpg';
        $now = date("Y-m-d H:i:s");

        $sql_fetch = mysqli_query($connection, "SELECT ClientAccountID FROM clientaccountinfo WHERE ClientFirstName = '$fst_name' AND ClientMiddleName = '$mid_name' 
        AND ClientLastName = '$last_name' AND ClientSuffix = '$suf_name' AND ClientStudentNo = '$stud_num' AND ClientBDay = '$bday' 
        AND ClientAddress = '$add' AND ClientContactNo = '$client_contact' AND ClientGuardian = '$guar_name' AND ClientGuardianNo = '$guardian_contact' 
        AND ClientEmailAdd = '$client_email' AND ClientPassword = '$password'");
        while ($details = mysqli_fetch_assoc($sql_fetch)) {
            $id = $details['ClientAccountID'];
        }

        $insert = "INSERT INTO clientprofilepictureinfo (ClientAccountID, PictureFilename, UploadDate, UsedStatus) VALUES ('$id','$imgFileName', '$now', TRUE)";
        mysqli_query($connection, $insert);

        echo "mgs002";
        header("Location: ../../Client Login/");
    } else {
        echo "something is wrong" . $insert . $connection->error;
    }

    // Close the database connection
    $connection->close();
?>

