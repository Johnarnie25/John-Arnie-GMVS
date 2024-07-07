<?php
    // Include header file
    $title = 'Violation Records';
    $page = 'v_rec';
    
     include_once('../includes/header.php');
    // Include database connection file
//connect to the database
    
$location = "localhost";
    $name = "u872502285_gmvs";
    $password = "Gmvs_123";
    $database = "u872502285_gmvs";

    $conn2 = new mysqli($location, $name, $password, $database);

    if($conn2->connect_error){
        echo "Connection Error";
    }
    
    // Fetch client information based on session's student ID
    $id = $_SESSION['StudID'];

    $sql_fetch = mysqli_query($conn2, "SELECT * FROM clientaccountinfo WHERE ClientAccountID = '$id'");
    $name = "";
    while($row = mysqli_fetch_assoc($sql_fetch)) {
        $name = $row['ClientAccountID'];
        $student = $row['ClientStudentNo'];
    }

    // Fetch schedules for the client (if needed)
    $sched = $conn2->query("SELECT * FROM schedules WHERE client_id = '$name' AND (stat ='Pending' OR stat='Confirmed')");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
    :root{
        --nav-width: 92px;
        --button-color-font-icon: rgb(136, 136, 136);
        --button-hover-color-font-icon: rgb(84, 83, 87);
        --button-hover-bg: rgb(160, 160, 160);
        --color-content0-bg: white;
        --maroong-content-bg: #008000;
        --maroong-content-hover: #630000;
        --body-color: rgb(209, 209, 209);
        --normal-font-size: 1rem;
        --small-font-size: .875rem;
        --medium-font-size: 15px;
    }
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    .body_container{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .content_rec{
        background-color: var(--color-content0-bg);
        margin-top: 10px;
        padding: 30px 5% 30px;
        width: 70%;
        height: auto;
    }
    .content_rec .title{
        width: 219px;
    }
    .title h1{
        font-size: 1.5rem;
        color: var(--button-color-font-icon);
        display: inline-block;
    }
    .title hr{
        border-bottom: 2px solid var(--maroong-content-bg);
    }
    .records_action_prop{
        margin-top: 1.20rem;
        margin-bottom: 10px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .records_action_prop .records_filter{
        font-size: var(--normal-font-size);
        color: var(--button-color-font-icon);
    }
    .records_action_prop .records_filter select{
        width: 180px;
        padding: 3px 7px 3px;
        border: 1px solid #ddd;
    }
    .records_action_prop .records_print_bttn a{
        background-color: var(--maroong-content-bg);
        color: var(--color-content0-bg);
        height: 40px;
        padding: 6px 8px 6px;
        border-radius: .5rem;
        text-decoration: none;
    }
    .records_action_prop .records_print_bttn a:hover{
        background-color: var(--maroong-content-hover);
    }
    .list_student_violation{
        padding-top: 25px;
        width: 100%;
        display: inline-block;
        justify-content: center;
    }
    .list_student_violation .display_violation_record{
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }
    .display_violation_record .violation_title{
        color: var(--color-content0-bg);
        background-color: var(--maroong-content-bg);
        font-size: 13px;
    }
    .display_violation_record .violation_data{
        border: 1px solid #ddd;
        padding: 2px 5px 2px;
        font-size: 11px;
    }
    @media print {
        body * {
            visibility: hidden; 
        }
        .print-container, .print-container * {
            visibility: visible; 
            overflow: hidden;
        }
        .print-container {
            position: absolute;
            left: 0px;
            top: 0px; 
        }
    }
    @media (max-width: 1200px) {
        .content_rec{
            width: 75%;
        }
    }
    @media (max-width: 1024px) {
        .content_rec{
            width: 85%;
        }
    }
    @media (max-width: 768px) {
        .content_rec{
            width: 95%;
        }
    }
    @media (max-width: 480px) {
        .content_rec{
            width: 100%;
        }
    }
    body {
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333; /* Change this to your header's background color */
            color: #fff; /* Change this to your header's text color */
            padding: 20px;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .content_rec {
            background-color: var(--color-content0-bg);
            margin-top: 20px; /* Adjust this margin as needed */
            padding: 30px 5%;
            width: 100%; /* Make the content full width */
            max-width: 1200px; /* Adjust this value as needed */
            height: auto;
            box-sizing: border-box;
        }


    </style>
</head>
<body>

    <?php
        include_once('assets/dbconnection.php');

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
    ?>

<br>
<br>
    <div class="body_container">
        <div class="content_rec">
            <div class="title">
                <h1>Violation Records</h1>
                <hr>
            </div>
            <div class="violation_records_content">
                <!-- Violation Records Table -->
                <?php if (mysqli_num_rows($sql) > 0): ?>
                    <div class="list_student_violation">
                        <table class="display_violation_record">
                            <thead>
                                <tr>
                                    <th class="violation_title">Student Number</th>
                                    <th class="violation_title">Name</th>
                                    <th class="violation_title">Program</th>
                                    <th class="violation_title" style="width: 8%;">Section</th>
                                    <th class="violation_title">Violations</th>
                                    <th class="violation_title">Sanctions</th>
                                    <th class="violation_title">A.Y. Code</th>
                                    <th class="violation_title">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row2 = mysqli_fetch_assoc($sql)) {
                                        echo "<tr>";
                                        echo "<td class='violation_data'>" . $row2['studnum'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['fullName'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['p_description'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['Section'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['Violations'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['Sanctions'] . "</td>";
                                        echo "<td class='violation_data'>" . $row2['a_code'] . "</td>";
                                        echo "<td class='violation_data'>" . date("d/m/Y", strtotime($row2['Date'])) . "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No violation records found for this user.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Add your JavaScript and other scripts here -->
</body>
</html>
