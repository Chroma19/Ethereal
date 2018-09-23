<?php

require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['sifra'])){

$id = $_GET['id'];

$pass = $_POST['sifra'];

$sql = "SELECT exam_code FROM ispit WHERE id = $id";

$rez = mysqli_query($con, $sql);


if(mysqli_num_rows($rez) == 1){
        $testpass = mysqli_fetch_assoc($rez);

        if($pass != $testpass['exam_code']){
            echo "false";
        }
        else {
            echo "true";
        }
    }   
    else{
        echo $id."<br>".$pass;   
    }
}
?>