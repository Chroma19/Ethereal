<?php
session_start();
require_once "includes/functions.php";
$title = "Unos novog ispita";

        $con = spajanje();
if(!empty($_POST['posalji'])){
    
    $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
    $id_lesson_fk = ocisti_tekst($_POST['id_lesson_fk']);
    $pitanja_string = implode(",",$_POST['pitanja']);
    $pitanja_string = ocisti_tekst($pitanja_string);
    $exam_code = ocisti_tekst(md5($_POST['sifra']));
    $datum_ispita = ocisti_tekst($_POST['datum_ispita']);
    $trajanje_ispita = ocisti_tekst($_POST['trajanje_ispita']);
    
    
    
    
    
    
    $sql = "INSERT INTO
    ispit 
    (id_tecaj_fk,id_lesson_fk,pitanja_string,exam_code,datum_ispita, trajanje_ispita)
    VALUES (
        $id_tecaj_fk,
        $id_lesson_fk,
        '$pitanja_string',
        '$exam_code',
        '$datum_ispita',
        '$trajanje_ispita'
    );";
    $res = mysqli_query($con,$sql);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
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
            <div id = "pitanje" class="col-sm-7">
                
            </div>
        </div>
        
        
        
        
        <div class="form-group">
        <label class = "control-label col-sm-2" for="sifra">Unesite šifru ispita:</label>
            <div class="col-sm-7">
                <input class = "form-control" type="password" name='sifra' id='sifra' value = "" required>
            </div>
        </div>   
                
                
                
                
        <div class="form-group">
            <label class = "control-label col-sm-2" for="datum_ispita">Unesite datum i vrijeme pisanja ispita:</label>
            <div class="col-sm-7">
                <input  name='datum_ispita' id='datum_ispita' type = "datetime-local" value = "" required> 
            </div>  
        </div> 

        <div class="form-group">
            <label class = "control-label col-sm-2" for="trajanje_ispita">Odaberite trajanje ispita u minutama</label>
            <div class="col-sm-7">
                <input type="range" min = "15" max = "300" id="trajanje_ispita" value = "" required onchange="updateTextInput(this.value);">
                <input type="number" name="trajanje_ispita" id="display" >
            </div>  
        </div> 

        <script>
        function updateTextInput(val) {
        document.getElementById('display').value=val; 
        }
        </script>
                
        <div class="form-group">
        <div class="col-sm-2 col-sm-offset-5">
            <button onclick = "dateChecker();" class = "form-control btn btn-ghost" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj ispit</button>
        </div>
        </div>

    </article>   
</form>   


<script>
function dateChecker(){
var q = new Date();
var m = q.getMonth();
var d = q.getDay();
var y = q.getFullYear();
var h = q.getHours();

var date = q;

date_exam = document.getElementById("datum_ispita").value;
console.log(date);
console.log(date_exam);

if(date>date_exam)
{
    alert("Current is bigger");
}
else
{
    alert("Current is smaller");
}
}
</script>
    <?php require_once("includes/footer.php");?>
        