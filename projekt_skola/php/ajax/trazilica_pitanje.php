<?php
error_reporting(0);
require_once ("../includes/functions.php");
$con = spajanje();

if(isset($_POST['odabrana_lekcija'])){
    
    $id = $_POST['odabrana_lekcija'];
    
    if($id == 'NULL'){
        echo 'Odaberite lekciju';
    }
    else{
        
        
        $sql = "SELECT id, pitanje FROM baza_pitanja WHERE id_lesson_fk = $id";
        
        $rez = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($rez) == 0){
            
            echo 'Nema pitanja za odabranu lekciju!';
        }
        else{
            $tmp = "";
            
            while($pitanja = mysqli_fetch_assoc($rez)){
                $tmp .= '<div class="col-sm-7"><input type = "checkbox" name = "pitanja['.$pitanja["id"].']"  id = "pitanja['.$pitanja["id"].']" value = "'.$pitanja["id"].'"></input>';
                $tmp .= '<label for="pitanja['.$pitanja["id"].']">'.ucfirst($pitanja["pitanje"]).'</label></div>';
            }
            echo $tmp;
        }
    }
}

?>