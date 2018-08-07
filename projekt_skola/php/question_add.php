<?php
session_start();
require_once "includes/functions.php";

    $title = "Unos novog pitanja";

    
    $con = spajanje();

    if(isset($_POST['posalji'])){
        
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
    

        require_once ("includes/header.php"); 
?>

    <form action="" method = 'post'>


        <!-- select -->
        <p>
            <label for="id_tecaj_fk">Odaberite tecaj:
                <select name='id_tecaj_fk' id='id_tecaj_fk' onchange = "traziLekcija(this.options[this.selectedIndex].value);" required>
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
            </label>
        </p>

        <article>
        <!-- select -->
        <p>
            <label for="id_lesson_fk">Odaberite lekciju:
                <select  name='id_lesson_fk' id='id_lesson_fk' required>
                <option value="NULL" disabled selected>--</option>

                
                <?php
                    // Catching lesson
                    $sql = "SELECT 
                            *
                            FROM lessons";
                    $res_lesson = mysqli_query($con, $sql); 

                    if(mysqli_num_rows($res_lesson)>0){
                        while($lesson = mysqli_fetch_assoc($res_lesson)){
                            
                            echo '<option value="'.$lesson['id'].'">';
                            echo $lesson['lesson_name'];
                            echo '</option>';
                        }
                    }
                
                ?>
                </select>
            </label>
        </p>


        <!-- select -->
        <p>
            <label for="id_tip_pitanja">Tip pitanja: 
                <select  id = "id_tip_pitanja" name = "id_tip_pitanja" onchange = "createInputs();" required>
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
            </label>
        </p>
       

        <p>
            <label for="pitanje">Unesite pitanje:
                <input required type="text" name='pitanje' id='pitanje'  value = "" required>
            </label>
        </p>
        

        <p>
            <div id = "solution">
            <label for="rjesenje[]">Unesite rješenje (ukoliko imate vise ponudenih odgovora oznacite onaj koji je tocan):
            </label>
            </div>
        </p>


        <p>
            <button id="posalji" value = "posalji" name="posalji" type="submit">Dodaj pitanje</button>
        </p>

    </form>
</article>    
<?php ispisi_polje($_POST); require_once("includes/footer.php");?>