<?php

require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['sifra'])){

$id = $_GET['id'];

$pass = $_POST['sifra'];

$sql = "SELECT exam_code FROM ispit WHERE id = $id";

$rez = mysqli_query($con, $sql);


if(mysqli_num_rows($rez) == 0){
        $testpass = mysqli_fetch_assoc($rez);

        if($pass != $testpass['exam_code']){
            header("refresh:2;url=exam_list.php");
            exit("Netočna lozinka! Preusmjeravam na popis ispita.");
        }
        else{
            return true;
        }
    }   
}
// else{
//     // return true
//     echo $pass."<br>";
//     echo $testpass;
// }
?>