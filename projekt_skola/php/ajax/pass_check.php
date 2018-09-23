<?php

require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['data'])){

$id = $_GET['id'];

$pass = $_POST['data'];

$sql = "SELECT exam_code FROM ispit WHERE id = $id";

$rez = mysqli_query($con, $sql);


if(mysqli_num_rows($rez) == 0){
        $testpass = mysqli_fetch_assoc($rez);

        if($pass != $testpass['exam_code']){
            echo '<script>
                    alert("Unesena je netočna šifra ispita!");
                    return false;
                </script>';
            header("refresh:5;url=exam_list.php");
        }
        else{
            return false;
        }
    }   
}

?>