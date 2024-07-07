<?php 
$conn = new mysqli('localhost', 'u872502285_gmvs', 'Gmvs_123', 'u872502285_gmvs');

    if ($conn->connect_error){
        die(
            'Error : ('. $conn->connect_errno.') '.$conn->connect_error
        );
    }


    $id = $_POST['id'];
    $a_id = $_POST['a_id'];
    $eval_id = $_POST['eval_id'];
    $eval = $_POST['evaluation'];
    $reco = $_POST['recommendation'];

    $insert = $conn->query("UPDATE forevaluation SET evaluation = '$eval', recommendation = '$reco' WHERE eval_id = '$eval_id'");
    if($insert){
        echo "success";
        exit();
    }else{
        echo "somethingWrong";
        exit();
    }



?>