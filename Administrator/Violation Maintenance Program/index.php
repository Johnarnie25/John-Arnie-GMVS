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
    $sub_page = 'vmain_program';
    include('../includes/sub_nav.php');
?>
            <?php if (isset($_GET['msg'])) { ?>
                <input class="input" type="hidden" id="msg" name="msg" value="<?php echo $_GET['msg']; ?>">
            <?php } ?>
            <div class="subcontent">
                <div class="title">
                    <h1>Program</h1>
                    <hr>
                </div>

                <div class="c_bttn_group">
                    <a href="#" class="c_bttn" id="openModal_add_curriculum">
                        <i class="fas fa-plus-square"></i>
                        Create
                    </a>
                </div>

                <div class="c_table_content">
                    <table class="c_table" id="table">
                        <tr>
                            <th class="curriculum_title" style="width: 12%;">PCODE</th>
                            <th class="curriculum_title">Description</th>

                            <th class="curriculum_title" style="width: 12%;"> </th>
                        </tr>
                        <!-- DISPLAYING THE DATA TO WEB PAGE FROM DATA BASE -->
                        <?php
                        include_once 'assets/dbconnection.php';
                        $SQL = $conn->query("SELECT * FROM forprogram");

                        if ($SQL->num_rows > 0) {
                            while ($row = $SQL->fetch_assoc()) {
                        ?>
                            <tr id="editRows">
                                <td class="curriculum_data pCode<?php echo $row['pID']; ?>" id="<?php echo $row['pCode']; ?>" ><?php echo $row['pCode'] . "<br>"; ?></td>
                                <td class="curriculum_data pDescription<?php echo $row['pID']; ?>" id="<?php echo $row['pDescription']; ?>"> <?php echo $row['pDescription'] . "<br>"; ?> </td>
                                <td class="curriculum_data"> <a class="c_data_bttn editBttn" id="<?php echo $row['pID']; ?>"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>

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

    <?php
        include('assets/modal_add_curriculum.php');
        // include('assets/modal_upload_curri.php'); // Removed upload modal from inclusion
        include('assets/modal_edit_curriculum.php');

    ?>
    <script src="assets/js/main.js"></script>
    
</body>

</html>
