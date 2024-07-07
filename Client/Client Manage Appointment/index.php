<?php
    $title = 'Client Manage Appointment';
    $page = 'client_manage_appointment';
    include_once('../includes/header.php');

    // Include the database connection file
  $conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }

    // Assuming session_start() is called before this code
    $id = $_SESSION['StudID'];

    // Check if $id is set
    if (isset($id)) {
        // Use the database connection from $connection
        $sql_fetch = mysqli_query($connection, "SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
        $name = "";

        while ($row = mysqli_fetch_assoc($sql_fetch)) {
            $name = $row['ClientAccountID'];
        }

        // Use the database connection from $connection
        $sched = mysqli_query($connection, "SELECT * FROM schedules WHERE client_id = '$name' AND (stat ='Pending' OR stat='Confirmed')");
    } else {
        // Handle the case when $id is not set, redirect or show an error message
        header("Location: login.php");
        exit();
    }
?>

    
    <div class="content">
        <div class="profile">
            <div class="title_content">
                <h3>Appointment Schedule</h3>
            </div>

            <div class="list_client">
                <h3 class="list_title">Your Appointments</h3>
                <table class="display_client">
                    <tr> 
                    <th class="client_title">Appointment ID</th>
                        <th class="client_title">Date</th>
                        <th class="client_title">Status</th>
                        <th class="client_title"> </th>
                            
                    </tr>
                    <?php 
                        while ($row = mysqli_fetch_array($sched)){

                    ?>
                    <tr>
                    <td class="client_data"><?= $row['id']?></td>
                        <td class="client_data"><?= $row['start_app'] .' - '. $row['end_app']?></td>
                        <td class="client_data"><?= $row['stat']?></td>
                        <td class="client_data"><a href="../Client Cancel Appointment/?a_id=<?php echo $row['id']; ?>" class="bttn_table">
                            <i class="fa-solid fa-calendar-xmark"></i> Cancel</a></td>
                    </tr>
                    <?php }
                    ?>
                </table>
            </div>

        </div>
    </div>
    <script src="assets/js/main.js"></script>
    
</body>

</html>