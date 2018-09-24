<?php
session_start();
require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['prijava'])){

$id = $_POST['prijava'];

$user = $_SESSION['userid'];

$sql = "SELECT * FROM ispitni_rok WHERE id_ispit_fk = '$id'";

$res = mysqli_query($con, $sql);

if(!$res){

$sql_new = "INSERT INTO ispitni_rok 
        VALUES(
            id_ispit_fk = '$id',
            id_polaznici_fk = CONCAT(id_polaznici_fk, '$user,')) 
        ;";

global $sql_new;
}

else{
    $sql_new = "UPDATE ispitni_rok 
            SET 
            id_polaznici_fk = CONCAT(id_polaznici_fk, '$user,') WHERE id_ispit_fk = '$id';";
    
    global $sql_new;
}

$res = mysqli_query($con, $sql_new);


if($res){
        echo "Ispit uspješno prijavljen!";
}

}
?>