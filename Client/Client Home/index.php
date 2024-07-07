<?php
// Include header file
$title = 'Home';
$page = 'client_home';
include_once('../includes/header.php');

// Include database connection file
$location = "localhost";
$name = "u872502285_gmvs";
$password = "Gmvs_123";
$database = "u872502285_gmvs";

$conn2 = new mysqli($location, $name, $password, $database);

if($conn2->connect_error){
    echo "Connection Error";
}

// Check if $conn2 is properly initialized
if (!$conn2) {
    echo "Failed to connect to the database.";
    // You might want to handle this error gracefully, such as displaying a message to the user
    exit; // Exit the script to prevent further execution
}
$id = $_SESSION['StudID'];

// Fetch client information
$sql_fetch = mysqli_query($conn2, "SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
$name = "";
while($row = mysqli_fetch_assoc($sql_fetch)) {
    $name = $row['ClientAccountID'];
    $student = $row['ClientStudentNo'];
}

// Fetch violation records for the current user
$sql = $conn2->query("SELECT
    forviolationentries.entry_id,
    forviolationentries.studNum as studnum,
    forviolationentries.Date,
    forstudents.fullName as fullName,
    forstudents.Section as Section,
    fortheviolations.Violations as Violations,
    forthesanctions.Sanctions as Sanctions,
    forprogram.pDescription AS p_description,
    foracademicyear.code AS a_code 
    FROM forviolationentries
    INNER JOIN forprogram ON forviolationentries.pCode = forprogram.pID
    INNER JOIN foracademicyear ON forviolationentries.code = foracademicyear.code
    INNER JOIN fortheviolations ON forviolationentries.Violations = fortheviolations.v_code
    INNER JOIN forstudents ON forviolationentries.studNum = forstudents.studNum
    INNER JOIN forthesanctions ON forviolationentries.Sanctions = forthesanctions.s_id
    WHERE forviolationentries.studNum = '$student' AND forviolationentries.date >= '2020-01-01'");

// Count the number of violations
$violation_count = mysqli_num_rows($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Add your CSS and other head elements here -->
    <link rel="stylesheet" href="modal.css"> <!-- Link to your modal CSS file -->
</head>
<Style>
    /* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%; /* Could be more or less, depending on screen size */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    border-radius: 10px; /* Rounded corners */
}

/* Close button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

</Style>
<body>

    <div class="content">
        <div class="home_content">
            <div class="title_content">
                <h3>Home</h3>
            </div>
            <div class="bttn_appoint_list">
                <a href="../Client Appointment Scheduling/" class="appointment_bttn">
                    <i class="fas fa-calendar-check"></i>
                    <span>
                        Book Appointment
                    </span>
                </a>
                <a href="../Client Manage Appointment/" class="appointment_bttn">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>
                        Manage Schedule
                    </span>
                </a>
                <a href="../Client Records/" class="appointment_bttn">
                    <i class="fa-solid fa-clipboard-list"></i>
                    <span>
                        Records
                    </span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="violation-message"></p>
        </div>
    </div>

    <!-- Add your JavaScript and other scripts here -->
    <script>
        // Check if violation records exist
        var violationCount = <?php echo $violation_count; ?>;
        var modalMessage = "";
        
        if (violationCount > 0) {
            if (violationCount == 1) {
                modalMessage = "This is your first violation. Please be cautious.";
            } else if (violationCount == 2) {
                modalMessage = "This is your second violation! Please write a letter.";
            } else if (violationCount == 3) {
                modalMessage = "This is your third violation. Please Report To CSLD Office!.";
            } else {
                modalMessage = "You have violation records. Please review your records in the Violation Records section.";
            }

            // Display the message in the modal
            document.getElementById("violation-message").innerText = modalMessage;
            
            // Display the modal
            var modal = document.getElementById("myModal");
            modal.style.display = "block";
            
            // Get the close button
            var span = document.getElementsByClassName("close")[0];

            // Close the modal when the user clicks on the close button
            span.onclick = function() {
                modal.style.display = "none";
            }

            // Close the modal when the user clicks anywhere outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
