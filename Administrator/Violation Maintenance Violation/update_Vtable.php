<tr> 
    <th class="violation_title">Violation</th>
    <th class="violation_title"> </th>                            
</tr>
                            
    <!-- DISPLAYING THE VIOLATION INSERTED FROM DATABASE -->
<?php
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }

    $SQL = "SELECT * FROM fortheviolations;";
    $RESULT = mysqli_query($conn, $SQL);
    $resultchecker = mysqli_num_rows($RESULT);

    if ($resultchecker > 0) {

        while ($row = mysqli_fetch_assoc($RESULT)) {
?>
<tr>
    <td class="violation_data" id="Violations" name="Violations"><?php echo $row['Violations'] . "<br>"; ?> </td>

    <td class="violation_data">
        <!--<a href="assets/delete.php?Violations=<"?php echo $row['Violations']; ?>" class="v_data_bttn"><i class="fas fa-trash-alt"></i></a>-->
        <a id="<?php echo $row['v_code']; ?>" class="v_data_bttn"><i class="fas fa-trash-alt"></i></a>
    </td>
</tr>
<?php
    }
}
?>