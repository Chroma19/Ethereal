<?php

require_once ("../includes/functions.php");

$con = spajanje();

if(isset($_POST['odabrani_tecaj'])){

    $id = $_POST['odabrani_tecaj'];

    if($id == 'NULL'){

        echo '<option selected disabled>Odaberite smjer</option>';

    }

    else{

        $sql = "SELECT id, naziv FROM grupa WHERE id_tecaj_fk = $id AND datum_zavrsetka > NOW();";

        $rez = mysqli_query($con, $sql);

        if(mysqli_num_rows($rez) == 0){

            echo '<option value="NULL" disabled selected>Nema grupa za odabrani tecaj</option>';

        }

        else{

            $tmp = "";

            while($id_grupa_fk = mysqli_fetch_assoc($rez)){

                $tmp .= "<option value='".$id_grupa_fk['id']."'>".$id_grupa_fk['naziv']."</option>";
                
            }

            echo $tmp;
            
        }
    }
}

?>