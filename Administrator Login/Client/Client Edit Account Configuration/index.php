<?php
    $title = 'Profile Edit';
    $page = 'client_edit_profile';
    include_once('../includes/header.php');
    $sql_fetch = mysqli_query($conn, "SELECT ClientStudentNo from clientaccountinfo WHERE ClientAccountID = '$id'");
    while($details = mysqli_fetch_assoc($sql_fetch))
    {
        $stud_ID = $details['ClientStudentNo'];
    }
    $sql_fetchpic = mysqli_query($conn, "SELECT PictureFilename from clientprofilepictureinfo WHERE ClientAccountID = '$id' AND UsedStatus = TRUE ");
    while($detailpic = mysqli_fetch_assoc($sql_fetchpic))
    {
        $prof_pic = $detailpic['PictureFilename'];
    }
    $directory = "../../assets/user_profile_pic/client/";
?>
    <div class="content">
        <div class="profile">
            <a href="../Client Profile/" class="acc_bttn"><i class="fas fa-arrow-left"></i></a>
            <p>Edit Profile Info</p>
            <div class="profile_info">
                <div class="pic_container">
                    <div class="profile_pic" >      
                        <div id="prof_pic_div">
                            <img class="prof_pic" id="prof_pic" src="<?php echo $directory, $stud_ID,'/', $prof_pic?>" alt="Profile Pic">
                        </div>            
                        <div class="upload_pic">
                            <input class="upload_pic_hidden" id="pic_filename" type="file" name="pic_filename" accept="image/*" visbility="hidden">
                            <label class="pic_bttn" for="pic_filename"><i class="fas fa-camera"></i> Edit Profile Picture</label>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <?php
                    $sub_page = 'client_e_acc_config';
                    include('../includes/prof_sub_nav.php');
                ?>
            </div>
            <form id="editInfo" action="assets/updateInfo.php" method="POST">
                <div class="sub_content">
                    <h4>Account Configuration:</h4>
                    
                    <div class="input_group">
                        <div class="input_container prePass">
                            <label for="#" class="label">Previous Password: </label>
                            <div class="input " id="input_fname">
                                <input type="password" class="input-field" name="prepass" id="prepass" >
                                 <i class="fas fa-eye" id="viewPass"></i>
                                <i id="i_prepass" class="fas"></i>
                            </div>
                        </div>
                        <div class="input_container">
                            <label for="#" class="label">New Password: </label>
                            <div class="input " id="input_mname">
                                <input  type="password" class="input-field" name="npass" id="npass">
                                <i class="fas fa-eye" id="viewPass1"></i>
                                <i id="i_npass" class="fas"></i>
                            </div>
                        </div>
                        <div class="input_container">
                            <label for="#" class="label">Confirm Password: </label>
                            <div class="input " id="input_lname">
                                <input type="password" class="input-field" name="conpass" id="conpass" >
                                <i class="fas fa-eye" id="viewPass2"></i>
                                <i id="i_conpass" class="fas"></i>
                            </div>
                        </div>
                        
                    </div>                 
                 </div>
                <div class="config_bttn_group">
                    <button type="sumbit" class="config_bttn" id="saveInfo" ><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>

    </div>

    <?php
        include('assets/modal_edit_picture.php')
    ?>
    <script src="assets/js/main.js"></script>
</body>

</html>