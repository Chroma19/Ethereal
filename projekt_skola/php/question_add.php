<?php
session_start();

require_once "includes/functions.php";

$title = "Unos novog pitanja";


$con = spajanje();

$status = checkStatus();

if($status !== 2 && $status !== 1){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}
else{
    if(isset($_POST['posalji'])){
        if(!empty($_POST['rjesenje'])){
        
        $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
        $id_lesson_fk = ocisti_tekst($_POST['id_lesson_fk']);
        $id_tip_pitanja_fk = ocisti_tekst($_POST['id_tip_pitanja']);
        $pitanje = ocisti_tekst($_POST['pitanje']);
        $ponudeni_odgovori = implode(",", $_POST['ponudeni_odgovori']);
        $ponudeni_odgovori = ocisti_tekst($ponudeni_odgovori); 
        $rjesenje = implode(",", $_POST['rjesenje']);
        $rjesenje = ocisti_tekst($rjesenje); 



        $sql = "INSERT INTO
                baza_pitanja 
                (id_tecaj_fk,id_lesson_fk,id_tip_pitanja_fk,pitanje,ponudeni_odgovori,rjesenje)
                VALUES (
                    '$id_tecaj_fk',
                    '$id_lesson_fk',
                    '$id_tip_pitanja_fk',
                    '$pitanje',
                    '$ponudeni_odgovori',
                    '$rjesenje'
                    );";
        $res = mysqli_query($con,$sql);
        header("Location: question_add.php");
        }
        else{
            header("Location: question_add.php");
            exit("Popunite sva polja!");
        }
    }
}
    require_once ("includes/header.php"); 
?>

    <form action="" class = "form-horizontal" method = 'post'>


        <div class = "form-group">
            <label for="id_tecaj_fk" class = "col-sm-2 control-label">Odaberite tecaj:</label>
            <div class="col-sm-7">
                <select name='id_tecaj_fk' id='id_tecaj_fk' class = "form-control" onchange = "traziLekcija(this.options[this.selectedIndex].value);" required>
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

        <article>
        <div class = "form-group">
            <label class = "col-sm-2 control-label" for="id_lesson_fk">Odaberite lekciju:</label>
            <div class="col-sm-7">
                <select  name='id_lesson_fk' class = "form-control" id='id_lesson_fk' required>
                <option value="NULL" disabled selected>--</option>
                <?php 
                    // Expecting AJAX response from previous <select> element
                ?>
                </select>
                </div>
        </div>



        <!-- select -->
        <div class = "form-group">
            <label for="id_tip_pitanja" class = "col-sm-2 control-label">Tip pitanja:</label> 
            <div class="col-sm-7">
                <select  id = "id_tip_pitanja" name = "id_tip_pitanja" class = "form-control" onchange = "createInputs();" required>
                <option value="NULL" disabled selected>--</option>
                <?php

                    // Catching question type


                    $sql = "SELECT * FROM tip_pitanja";
                    $res_tip_pitanja = mysqli_query($con, $sql);

                    if(mysqli_num_rows($res_tip_pitanja)>0){
                        while($tip_pitanja = mysqli_fetch_assoc($res_tip_pitanja)){
                            echo '<option id= "'.$tip_pitanja['type'].'" value="'.$tip_pitanja['id'].'">';
                            echo $tip_pitanja['opis'];
                            echo '</option>';
                            
                        }
                    }
                ?>
               
                </select>
        </div>
        </div>
       

        <div class = "form-group">
            <label for="pitanje" class = "col-sm-2 control-label">Unesite pitanje: </label>
            <div class="col-sm-7">
                <input required class = "form-control" type="text" name='pitanje' id='pitanje'  value = "" required>
            </div>    
        </div>
        
        <div class = "form-group">
            <label class = "col-sm-2 control-label" for="rjesenje[]">Unesite rješenje:</label>
            <div class = "col-sm-7" id = "solution">
            </div>
        </div>


        <div class = "form-group">
        <div class="col-sm-2 col-sm-offset-5">
            <button id="posalji" value = "posalji" class = "btn btn-ghost form-control submit" name="posalji" type="submit">Dodaj pitanje</button>
        </div>
        </div>

    </form>
</article>    
<?php require_once("includes/footer.php");?>