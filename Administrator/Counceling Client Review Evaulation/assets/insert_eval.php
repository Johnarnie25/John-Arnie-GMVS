<?php 
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }


    $id = $_POST['id'];
    $a_id = $_POST['a_id'];
    $eval = $_POST['evaluation'];
    $reco = $_POST['recommendation'];

    $insert = $conn->query("INSERT INTO forevaluation(evaluator_id, appointment_id, evaluation, recommendation) VALUES
    ('$id', '$a_id', '$eval', '$reco')");
    if($insert){
        $update = $conn->query("UPDATE schedules SET stat = 'Evaluated' WHERE id = '$a_id'");
    echo "success";
        exit();
    }else{
        echo "somethingWrong";
        exit();
    }



?>