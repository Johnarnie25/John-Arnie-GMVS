<?php
$title = 'Maintenance Counseling Link';
$page = 'maintenance';
include_once('../includes/header.php');

$id = $_SESSION['AdminID'];
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error) {
    die('Error: (' . $conn->connect_errno . ') ' . $conn->connect_error);
}

// Fetch user role and permissions
$sql_fetchid = mysqli_query($conn, "SELECT adminAccount.AdminFirstName, adminAccount.AdminUserRoleID, userRole.AdminPageStudentCounceling, 
        userRole.AdminPageViolation, userRole.AdminMaintenance, userRole.StatusID
        FROM adminaccountinfo AS adminAccount 
        INNER JOIN adminuserrole AS userRole 
        ON adminAccount.AdminUserRoleID = userRole.AdminUserRoleID WHERE adminAccount.AdminAccountID = '$id' ");

if (!$sql_fetchid) {
    die('Error executing the query: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($sql_fetchid)) {
    $userRoleID = $row['AdminUserRoleID'];
    $studCounceling = $row['AdminPageStudentCounceling'];
    $studViol = $row['AdminPageViolation'];
    $systemMaintenance = $row['AdminMaintenance'];
    $roleStatus = $row['StatusID'];
}

// Check if user has access to counseling page
if ($studCounceling != '1') {
    echo "<script> window.location.href = '../Page 404/';</script>";
}

// Fetch user details
$sql_fetch = mysqli_query($conn, "SELECT * from adminaccountinfo WHERE AdminAccountID = '$id'");
$name = "";
while ($row = mysqli_fetch_assoc($sql_fetch)) {
    $name = $row['AdminAccountID'];
}

// Fetch Zoom link
$query = "SELECT * from counsellingzoomlink where AdminAccountID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die('Error executing the query: ' . $stmt->error);
}

$row = $result->fetch_assoc();
$zoomLink = ($row !== null) ? $row['CounseZLink'] : '';

?>
<div class="body_container">
    <div class="content">
        <div class="title">
            <h1>Counseling Maintenance</h1>
            <hr>
        </div>
        <div class="subcontent">
            <?php
            $sub_page = 'cmain_link';
            include '../includes/cmain_sub_nav.php';
            ?>
            <div class="title">
                <h1>Evaluator's Zoom Link:</h1>
                <hr>
            </div>
            <form id="zlinkForm" action="assets/insertAvail_sched.php" method="POST">
                <div class="input_group">
                    <div class="input_container">
                        <input class="input" type="hidden" id="id" name="id" value="<?= $name ?>">
                        <label for="#" class="label">Zoom Link: </label>
                        <div class="input " id="input_roleName">
                            <input class="input-field" type="text" placeholder="Insert Zoom Link" name="zlink"
                                id="zlink" value="<?= htmlspecialchars($zoomLink); ?>">
                            <i class="fa-solid fa-asterisk"></i>
                            <i id="i_zlink" class="fa-solid "></i>
                        </div>
                    </div>
                </div>
                <div class="action_content">
                    <button class="bttn" type="submit" name="submit" id="submit"><i
                            class="fa-solid fa-floppy-disk"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/main.js"></script>
</body>
</html>
