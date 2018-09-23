<?php
session_start();
require_once "includes/functions.php";
$title = "Unos novog ispita";
$con = spajanje();
if($_SESSION['role'] !== "1" and $_SESSION['role'] !=="2"){
    die('<div class="alert" style="background:yellow;"> 
        <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
        &times;
        </a>
        <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
        
        </div>');
}
else{
if(!empty($_POST['posalji'])){
    if(!empty($_POST['pitanja']) and !empty($_POST['vrijeme_ispita']) and !empty($_POST['trajanje_ispita'])){
    
    $naziv = ocisti_tekst($_POST['naziv']);
    $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
    $id_lesson_fk = ocisti_tekst($_POST['id_lesson_fk']);
    $pitanja_string = implode(",",$_POST['pitanja']);
    $pitanja_string = ocisti_tekst($pitanja_string);
    $exam_code = ocisti_tekst(md5($_POST['sifra']));
    $datum_ispita = ocisti_tekst($_POST['datum_ispita']);
    $vrijeme_ispita = ocisti_tekst($_POST['vrijeme_ispita']);
    $trajanje_ispita = ocisti_tekst($_POST['trajanje_ispita']);
    $autor  = ocisti_tekst($_SESSION['username']);
    


    $sql = "INSERT INTO
    ispit 
    (naziv,id_tecaj_fk,id_lesson_fk,pitanja_string,exam_code,datum_ispita, vrijeme_ispita, trajanje_ispita, autor)
    VALUES (
        '$naziv',
        $id_tecaj_fk,
        $id_lesson_fk,
        '$pitanja_string',
        '$exam_code',
        '$datum_ispita',
        '$vrijeme_ispita',
        '$trajanje_ispita',
        '$autor'
    );";

    $qlen = explode(",",$pitanja_string);
    $qlen = implode("",$qlen);
    if(strlen($qlen)>=10){
        $res = mysqli_query($con,$sql);
        global $res;
    }
    else{
       echo 
        '<script>
            alert("Ispit mora sadržavati najmanje 10 pitanja!");
            return false;
        </script>';
    }
    if($res){
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
else{
    echo mysqli_error($con);
}
}
else{
    die("Popunite sva područja! Za povratak na stranicu kliknite <a href='exam_add.php'><b>ovdje</b></a>");
}
}
}
require_once ("includes/header.php");

?>



<form class = "form-horizontal" action="" method = 'post'>


    <div class="form-group">
        <label class = "control-label col-sm-2" for="naziv">Unesite naziv ispita:</label>
            <div class="col-sm-7">
                <input class = "form-control" type="text" name='naziv' id='naziv' value = "" required>
            </div>
    </div>   

    <!-- select -->
    <div class="form-group">
        <label for="id_tecaj_fk" class="col-sm-2 control-label">Odaberite tečaj</label>
        <div class="col-sm-7">
            <select class ="form-control" name='id_tecaj_fk' id='id_tecaj_fk' value = "" required onchange = "traziLekcija(this.options[this.selectedIndex].value);"> 
            <option value="NULL" disabled selected>--</option>
        
                    <?php
                // Catching course 
                $sql = "SELECT id, smjer FROM tecaj";
                $res_tecaj = mysqli_query($con, $sql); 
                
                if(mysqli_num_rows($res_tecaj)>0){
                    while($tecaj = mysqli_fetch_assoc($res_tecaj)){
                        
                        echo '<option value="'.$tecaj['id'].'">';
                        echo $tecaj['smjer'];
                        echo '</option>';
                    }
                }
                
                ?>
            </select>
        </div>   
    </div>


        <div class="form-group">
        <label class = "control-label col-sm-2" for="id_lesson_fk">Odaberite lekciju:</label>
            <div class="col-sm-7">
                <select class ="form-control" name='id_lesson_fk' id='id_lesson_fk' required onchange = "traziPitanja(this.options[this.selectedIndex].value);">
                </select>
            </div>
        </div>

        
        <div class="form-group">
        <label class = "control-label col-sm-2" for="pitanja[]">Odaberite pitanja:</label>
        <div id="pitanje" class = "col-sm-7"></div>
        </div>
        
        
        
        
        <div class="form-group">
        <label class = "control-label col-sm-2" for="sifra">Unesite šifru ispita:</label>
            <div class="col-sm-7">
                <input class = "form-control" type="password" name='sifra' id='sifra' value = "" required>
            </div>
        </div>   
                
                
                
                
        <div class="form-group">
            <label class = "control-label col-sm-2" for="datum_ispita">Unesite datum pisanja ispita:</label>
            <div class="col-sm-7">
                <input name='datum_ispita' id='datum_ispita' class = "form-control" type = "date" value = "" required> 
            </div>  
        </div> 

        <div class="form-group">
            <label class = "control-label col-sm-2" for="vrijeme_ispita">Unesite vrijeme pisanja ispita:</label>
            <div class="col-sm-7">
                <input name='vrijeme_ispita' id='vrijeme_ispita' class = "form-control timepicker" value = "" required> 
            </div>  
        </div> 


        <div class="form-group">
            <label class = "control-label col-sm-2" for="trajanje_ispita">Odaberite trajanje ispita u minutama</label>
            <div class="col-sm-7">
                <input type = "number" class = "form-control" name="trajanje_ispita" id="trajanje_ispita" min = "15" max = "300">
            </div>  
        </div> 
        
        <div class="form-group">
        <div class="col-sm-2 col-sm-offset-5">
            <button onclick = "checkAll();" class = "form-control btn btn-ghost" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj ispit</button>
        </div>
        </div>


</form>   

    <?php require_once("includes/footer.php");?>
        