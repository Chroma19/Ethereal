<?php

require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['odabrani_tecaj'])){

    $id = $_POST['odabrani_tecaj'];

    if($id == 'NULL'){
        echo '<option selected disabled>Odaberite grupu</option>';
    }
    else{


$sql = "SELECT id, lesson_name FROM lessons WHERE id_tecaj_fk = $id";

$rez = mysqli_query($con, $sql);


if(mysqli_num_rows($rez) == 0){
    echo '<option value="NULL" disabled selected>Nema lekcija za odabrani tecaj</option>';
}
else{
    $tmp = "";

    while($id_lesson_fk = mysqli_fetch_assoc($rez)){
        $tmp .= "<option value='".$id_lesson_fk['id']."'>".$id_lesson_fk['lesson_name']."</option>";
        
    }
    echo $tmp;
}
    }
}

?>