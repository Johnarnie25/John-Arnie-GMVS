<?php
    $title = 'Maintenance';
    $page = 'maintenance';
    include_once('../includes/header.php');

   $connection = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($connection->connect_error) {
    die('Error : (' . $connection->connect_errno . ') ' . $connection->connect_error);
}


    $idFecth = $_SESSION['AdminID'];
    $sql_fetchid = mysqli_query($connection, 
    "SELECT adminAccount.AdminFirstName, adminAccount.AdminUserRoleID, userRole.AdminPageStudentCounceling, 
    userRole.AdminPageViolation, userRole.AdminMaintenance, userRole.StatusID
    FROM adminaccountinfo AS adminAccount 
    INNER JOIN adminuserrole AS userRole 
    ON adminAccount.AdminUserRoleID = userRole.AdminUserRoleID WHERE adminAccount.AdminAccountID = '$idFecth' ");
    
    while($row = mysqli_fetch_assoc($sql_fetchid))
    {
        $userRoleID = $row['AdminUserRoleID']; 
        $studCounceling = $row['AdminPageStudentCounceling']; $studViol = $row['AdminPageViolation']; 
        $systemMaintenance = $row['AdminMaintenance']; $roleStatus = $row['StatusID']; 
    }
    if ($studViol != '1'){
        echo "<script> window.location.href = '../Page 404/';</script>";
    }
?>

<?php
    $sub_page = 'vmain_stud_main';
    include('../includes/sub_nav.php');
?>

<?php 
    include 'assets/dbconnection.php';
    $enrolled = 'Enrolled';
    $disabled = 'Disabled';
    $sched = $conn->query("SELECT 
    id,
    studNum,
    lastName,
    firstName,
    middleName,
    Section,
    Address,
    Gender,
    progCode,
    t2.pCode AS p_description,
    t3.code AS a_code,
    status FROM forstudents t1
    INNER JOIN forprogram t2 ON t1.progCode = t2.pID
    INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code
    
    WHERE status = '$enrolled' OR status = '$disabled'");

    //search button and drop down button
    if(isset($_POST['submit'])){

        if(isset($_POST['search_box'])){
            $searched = $_POST['search_box'];
            $sched = $conn->query("SELECT 
            id,
            studNum,
            lastName,
            firstName,
            middleName,
            Section,
            Address,
            progCode,
            Gender,
            t2.pCode AS p_description,
            t3.code AS a_code,
            status FROM forstudents t1
            INNER JOIN forprogram t2 ON t1.progCode = t2.pID
            INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code
            

            WHERE studNum LIKE '{$searched}' OR lastName LIKE '{$searched}'
            OR firstName LIKE '{$searched}'");

        }


    }
    
    //update student button
    if (isset($_POST['but_update'])){
        if(isset($_POST['update'])){
            foreach ($_POST['update'] as $updateid){
                
                $ln = $_POST['lastName_'.$updateid];
                $fn = $_POST['firstName_'.$updateid];
                $mn = $_POST['middleName_'.$updateid];
                $curriculum = $_POST['curri_'.$updateid];
                $curriculum2 = $_POST['curri2_'.$updateid];
                $sec = $_POST['section_'.$updateid];
                $add = $_POST['address_'.$updateid];
                $gend = $_POST['gender_'.$updateid];
                $fullName = $ln . ", " . $fn . " " . $mn;

                
                

                if($curriculum !=''){

                    $updateUser = "UPDATE forstudents SET fullName = '$fullName', 
                    lastName = '$ln', 
                    firstName = '$fn',
                    middleName = '$mn',
                    progCode = '$curriculum',
                    Section = '$sec',
                    Address = '$add',
                    Gender = '$gend'
                    WHERE id = $updateid";
                    mysqli_query($conn, $updateUser);
                    $sched = $conn->query("SELECT 
                    id,
                    studNum,
                    lastName,
                    firstName,
                    middleName,
                    Section,
                    Address,
                    progCode,
                    Gender,
                    t2.pCode AS p_description,
                    t3.code AS a_code,
                    status FROM forstudents t1
                    INNER JOIN forprogram t2 ON t1.progCode = t2.pID
                    INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code WHERE status = '$enrolled' OR status = '$disabled'");
                }else{
                    $updateUser = "UPDATE forstudents SET fullName = '$fullName', 
                    lastName = '$ln', 
                    firstName = '$fn',
                    middleName = '$mn',
                    progCode = '$curriculum2',
                    Section = '$sec',
                    Address = '$add',
                    Gender = '$gend'
                    WHERE id =$updateid";
                    mysqli_query($conn, $updateUser);
                    $sched = $conn->query("SELECT 
                    id,
                    studNum,
                    lastName,
                    firstName,
                    middleName,
                    Section,
                    progCode,
                    Address,
                    Gender,
                    t2.pCode AS p_description,
                    t3.code AS a_code,
                    status FROM forstudents t1
                    INNER JOIN forprogram t2 ON t1.progCode = t2.pID
                    INNER JOIN foracademicyear t3 ON t1.ayCode = t3.code WHERE status = '$enrolled' OR status = '$disabled'");
                }

            }
            
        }
    }

?>

            <div class="subcontent">
                <div class="sub_nav">
                    <a href="../Violation Maintenance Student Maintenance/" class="sub_nav_bttn_active">
                        Update Student
                    </a>
                    <a href="../Violation Maintenance Student Maintenance Section Year/" class="sub_nav_bttn">
                        Update Section/Year
                    </a>
                    <a href="../Violation Maintenance Student Maintenance Status/" class="sub_nav_bttn">
                        Update Status
                    </a>
                </div>


                <div class="sub_top_content">
                    <div class="student_input_group">
                   <form action = "" method = "POST">
                        <div class="student_input">
                            <label for="#" class="label">Search:</label>
                            <input type="text" class="input_field" id="search_box" name="search_box" class="">
                            <button type="submit" name="submit" value=">>" class="srch_bttn"><i class="fas fa-search"></i></button>
                        </div>
                        
                        
                        
                    </div>

                    <div class="student_main_bttn_group">
                    <button type ="submit" id="but_update" name = "but_update" class="stud_bttn">
                            <i class="fas fa-save"></i>
                            Save
                            </button>
                    </div>
                    
                </div>
                    


                <div class="stud_table_content">
                    <table class="stud_table">
                        <tr> 
                            <th class="stud_title" style="width: 50px" ><input type='checkbox' class="all" id='checkAll'>All</th>
                            <th class="stud_title">Student Num</th>
                            <th class="stud_title">Last Name</th>
                            <th class="stud_title">First Name</th>
                            <th class="stud_title">Middle Name</th>
                            <th class="stud_title">Curriculum</th>
                            <th class="stud_title">Section</th>
                            <th class="stud_title" style="width: 28%;">Address</th>
                            <th class="stud_title" style="width: 10%;">Gender</th>
                            
                        </tr>
                        <?php
                            
                            while($row = $sched->fetch_array()){
                                $id = $row['id'];
                            $lastName = $row['lastName'];
                            $firstName = $row['firstName'];
                            $middleName = $row['middleName'];
                            $curri = $row['progCode'];
                            $curri2 = $row['p_description'];
                            $section = $row['Section'];
                            $address = $row['Address'];
                            $gender = $row['Gender'];
				        ?>
                        <tr>
                            <td class="stud_data"> <input class="cbox" type ='checkbox' name ='update[]' value='<?= $id ?>'></td>
                            <td class="stud_data"> <?php echo $row['studNum']?> </td>
                            <td class="stud_data"> <input class="inputTable" type ='text' maxlength="12" name ='lastName_<?= $id ?>' value='<?= $lastName ?>'></td>
                            <td class="stud_data"> <input class="inputTable" type ='text' maxlength="14" name ='firstName_<?= $id ?>' value='<?= $firstName ?>'> </td>
                            <td class="stud_data"> <input class="inputTable" type ='text' maxlength="10" name ='middleName_<?= $id ?>' value='<?= $middleName ?>'>  </td>
                            <td class="stud_data">  <input class="inputTable" type="hidden" name =  "curri2_<?= $id ?>" value='<?= $curri ?>'>
                                <select class="inputTable" name = "curri_<?= $id ?>">
                            
                                <?php 
                                
                                $query = "SELECT * from forprogram";
                                $result1 = mysqli_query($conn, $query);
                                while($row2 = mysqli_fetch_assoc($result1))
                                {?>
                                <option value="<?php echo $row2["pID"];?>" <?php if($row2['pID'] == $curri) echo "selected" ?>
                                ><?php echo $row2['pCode']; ?></option>
                                <?php } ?>
                                
                            </select> </td>
                            
                            <td class="stud_data"> <input class="inputTable" type ='text' maxlength="12" name ='section_<?= $id ?>' value='<?= $section ?>'> </td>
                            <td class="stud_data" style="width: 33%;"> <input class="inputTable" type ='text' maxlength="50" name ='address_<?= $id ?>' value='<?= $address ?>'> </td>
                            <td class="stud_data"> <input class="inputTable" type ='text' maxlength="10" name ='gender_<?= $id ?>' value='<?= $gender ?>'>  </td>
                            
                        </tr>
                        <?php
							}
				        ?>
                    </table>
                    </form>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        // Check/Uncheck ALl
                        $('#checkAll').change(function(){
                            if($(this).is(':checked')){
                                $('input[name="update[]"]').prop('checked',true);
                            }else{
                                $('input[name="update[]"]').each(function(){
                                    $(this).prop('checked',false);
                                }); 
                            }
                        });
                        // Checkbox click
                        $('input[name="update[]"]').click(function(){
                            var total_checkboxes = $('input[name="update[]"]').length;
                            var total_checkboxes_checked = $('input[name="update[]"]:checked').length;
        
                            if(total_checkboxes_checked == total_checkboxes){
                                $('#checkAll').prop('checked',true);
                            }else{
                                $('#checkAll').prop('checked',false);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        
    </div>


</body>

</html>