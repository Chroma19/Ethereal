<?php
session_start();
require_once "includes/functions.php";
$title = "Unos novog ispita";

        $con = spajanje();
if(!empty($_POST['posalji'])){
    if(!empty($_POST['pitanja']) or !empty($_POST['vrijeme_ispita']) or !empty($_POST['trajanje_ispita'])){
    
    $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
    $id_lesson_fk = ocisti_tekst($_POST['id_lesson_fk']);
    $pitanja_string = implode(",",$_POST['pitanja']);
    $pitanja_string = ocisti_tekst($pitanja_string);
    $exam_code = ocisti_tekst(md5($_POST['sifra']));
    $datum_ispita = ocisti_tekst($_POST['datum_ispita']);
    $vrijeme_ispita = ocisti_tekst($_POST['vrijeme_ispita']);
    $trajanje_ispita = ocisti_tekst($_POST['trajanje_ispita']);
    
    
    $sql = "INSERT INTO
    ispit 
    (id_tecaj_fk,id_lesson_fk,pitanja_string,exam_code,datum_ispita, vrijeme_ispita, trajanje_ispita)
    VALUES (
        $id_tecaj_fk,
        $id_lesson_fk,
        '$pitanja_string',
        '$exam_code',
        '$datum_ispita',
        '$vrijeme_ispita',
        '$trajanje_ispita'
    );";
    $res = mysqli_query($con,$sql);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}
else{
    die("Popunite sva područja! Za povratak na stranicu kliknite <a href='exam_add.php'><b>ovdje</b></a>");
}
}

require_once ("includes/header.php");

?>



<form class = "form-horizontal" action="" method = 'post'>


    <!-- select -->
    <div class="form-group">
        <label for="id_tecaj_fk" class="col-sm-2 control-label">Odaberite tečaj</label>
        <div class="col-sm-7">
            <select class ="form-control" name='id_tecaj_fk' id='id_tecaj_fk' value = "" required onchange = "traziLekcija(this.options[this.selectedIndex].value);"> 
            <option value="NULL" disabled selected>--</option>
        
                    <?php
                // Catching course 
                $sql = "SELECT id, naziv FROM tecaj";
                $res_tecaj = mysqli_query($con, $sql); 
                
                if(mysqli_num_rows($res_tecaj)>0){
                    while($tecaj = mysqli_fetch_assoc($res_tecaj)){
                        
                        echo '<option value="'.$tecaj['id'].'">';
                        echo $tecaj['naziv'];
                        echo '</option>';
                    }
                }
                
                ?>
            </select>
        </div>   
    </div>


        
        
    <article>
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
                <input name='datum_ispita' id='datum_ispita' type = "date" value = "" required> 
            </div>  
        </div> 

        <div class="form-group">
            <label class = "control-label col-sm-2" for="vrijeme_ispita">Unesite vrijeme pisanja ispita:</label>
            <div class="col-sm-7">
                <input name='vrijeme_ispita' id='vrijeme_ispita' class = "timepicker" value = "" required> 
            </div>  
        </div> 


        <div class="form-group">
            <label class = "control-label col-sm-2" for="trajanje_ispita">Odaberite trajanje ispita u minutama</label>
            <div class="col-sm-7">
                <input type = "number" name="trajanje_ispita" id="trajanje_ispita" min = "15" max = "300">
            </div>  
        </div> 
        
        <div class="form-group">
        <div class="col-sm-2 col-sm-offset-5">
            <button onclick = "checkAll();" class = "form-control btn btn-ghost" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj ispit</button>
        </div>
        </div>

    </article>   
</form>   


<script>

function checkAll(){
                
            let password = document.getElementById("sifra")

            if (password.value.length<8){
                password.style = "border-color:red";
                password.setCustomValidity("Lozinka je prekratka!")
            }
            else {
                password.removeAttribute("style");
                password.setCustomValidity("");

                var q = new Date();
                var m = q.getMonth();
                var d = q.getDay();
                var y = q.getFullYear();
                var h = q.getHours();

                var date = q;

                var date_exam = document.getElementById("datum_ispita").value;
                var date_exam = Date.parse(date_exam);
                var date = Date.parse(date);
                var input = document.getElementById("datum_ispita");

                if(date>date_exam){
                        input.style = "border-color:red";
                        input.setCustomValidity("Unesite važeći datum i vrijeme!"); 
                    }
                else{    
                        input.removeAttribute("style");
                        input.setCustomValidity(""); 

                        let dur = document.getElementById("trajanje_ispita");
                        if(isNaN(dur.value)){
                            dur.style = "border-color:red";
                            dur.setCustomValidity("Unesite važeće trajanje!");
                        }
                        else if(dur.value>300 || dur.value<15){
                            dur.style = "border-color:red";
                            dur.setCustomValidity("Unesite važeće trajanje!");
                        }
                        else{
                            dur.removeAttribute("style");
                            dur.setCustomValidity("");
                        }

                        }
                
            }

} 
</script>
    <?php require_once("includes/footer.php");?>
        