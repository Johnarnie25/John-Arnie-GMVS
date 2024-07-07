<?php
$title = 'Counseling Appointment Dashboard';
$page = 'ca_appoint_sched';
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
}

$id = 'ap_dash';
$online_script = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>';
include_once('../includes/header.php');

$s_id = $_SESSION['AdminID'];
$sql_fetch = mysqli_query($conn, "SELECT * FROM adminaccountinfo WHERE AdminAccountID = '$s_id'");

while($row = mysqli_fetch_assoc($sql_fetch))
{
    $name = $row['AdminAccountID'];
}

$sql_fetchid = mysqli_query($conn, 
"SELECT adminAccount.AdminFirstName, adminAccount.AdminUserRoleID, userRole.AdminPageStudentCounceling, 
userRole.AdminPageViolation, userRole.AdminMaintenance, userRole.StatusID
FROM adminaccountinfo AS adminAccount 
INNER JOIN adminuserrole AS userRole 
ON adminAccount.AdminUserRoleID = userRole.AdminUserRoleID WHERE adminAccount.AdminAccountID = '$name' ");

while($row = mysqli_fetch_assoc($sql_fetchid))
{
    $userRoleID = $row['AdminUserRoleID']; 
    $studCounceling = $row['AdminPageStudentCounceling']; $studViol = $row['AdminPageViolation']; 
    $systemMaintenance = $row['AdminMaintenance']; $roleStatus = $row['StatusID']; 
}

if ($studCounceling != '1'){
    echo "<script> window.location.href = '../Page 404/';</script>";
}

$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

if ($conn->connect_error){
    die('Error : ('. $conn->connect_errno.') '.$conn->connect_error);
}

date_default_timezone_set("Asia/Manila");

// Count the number of appointments for each day
$query_count = $conn->query("
    SELECT DATE(start_app) AS appointment_date, COUNT(*) AS appointment_count
    FROM schedules 
    WHERE remarks = '$name' 
    AND stat IN ('Confirmed', 'Pending') 
    GROUP BY DATE(start_app)
");

// Fetch all appointments for the logged-in user that are relevant for the current day or future dates
$query_appointments = $conn->query("
    SELECT id, start_app, end_app
    FROM schedules 
    WHERE remarks = '$name' 
    AND stat IN ('Confirmed', 'Pending') 
    AND DATE(start_app) >= CURDATE()  -- Only fetch appointments for the current day or future dates
    ORDER BY id
");

// Generate an array to hold time slots from 8 am to 5 pm
$timeSlots = array();
for ($hour = 8; $hour < 17; $hour++) {
    $nextHour = $hour + 1; // Increment hour for the end time
    $timeSlots[] = array(
        'title' => $hour . ':00 - ' . $nextHour . ':00', // Displaying appointments in one-hour intervals
        'start' => date('Y-m-d H:00:00', mktime($hour, 0, 0)),
        'end' => date('Y-m-d H:00:00', mktime($nextHour, 0, 0))
    );
}

// Convert fetched appointments to a format compatible with FullCalendar
$events = [];
while ($row = $query_appointments->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'], // Add appointment ID for identification
        'start' => $row['start_app'],
        'end' => $row['end_app'],
    ];
}
?>

<script>
    $(document).ready(function(){
        var today = moment().startOf('day');
        
        var calendar = $('#calendar').fullCalendar({
            editable: true,
            header:{
                left: 'prev, next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay'
            },
            events: <?php echo json_encode($events); ?>,
            selectable: true,
            selectHelper: true,
            minDate: today, // Set the minimum date to today
            select: function(start, end, allDay) {
                var eventExists = calendar.fullCalendar('clientEvents', function(event) {
                    return start.isBetween(event.start, event.end, 'minutes', '[)');
                }).length > 0;

                if (start.isBefore(today)) {
                    alert("You can't select past dates.");
                    calendar.fullCalendar('unselect');
                } else if (eventExists) {
                    alert("This time slot is already taken.");
                    calendar.fullCalendar('unselect');
                } else {
                    // Proceed with selecting the date
                    // You can add your code here to handle the selected date
                    // For example, open a modal to add an event
                }
            }
        });
    });
</script>

<div class="body_container">
    <div class="content">
        <div class="title">
            <h1>Appointment</h1>
            <hr>
        </div>
        <div class="subcontent">
            <?php
                $sub_page = 'dash_app';
                include '../includes/appoitment_sub_nav.php';
            ?>
            <h3 class="subtitle">Scheduling Calendar</h3>
            <div class="calen_holder">
                <div class="calendar" id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/main.js"></script>
</body>
</html>