<?php
session_start();
require_once "includes/functions.php";

    $title = "Upis nove grupe";

    require_once ("includes/header.php");
    $con = spajanje();

    if(!empty($_POST['posalji'])){
        
        $naziv = ocisti_tekst($_POST['naziv']);
        $datum_pocetka = ocisti_tekst($_POST['datum_pocetka']);
        $datum_zavrsetka = ocisti_tekst($_POST['datum_zavrsetka']);
        $id_predavac_fk = ocisti_tekst($_POST['id_predavac_fk']); 
        $max_polaznika = ocisti_tekst($_POST['max_polaznika']);
        $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj']);

        $sql = "INSERT INTO
                grupa 
                (naziv,datum_pocetka,datum_zavrsetka,id_predavac_fk,max_polaznika,id_tecaj_fk)
                VALUES (
                    '$naziv',
                    '$datum_pocetka',
                    '$datum_zavrsetka',
                    '$id_predavac_fk',
                    '$max_polaznika',
                    '$id_tecaj_fk'
                 );";
        $res = mysqli_query($con,$sql);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

    
?>



    <form action="" method = 'post'>

         <p>
            <label for="naziv">Unesite naziv grupe:
                <input type="text" name='naziv' id='naziv' value="" required>
            </label>
        </p>

         <p>
            <label for="datum_pocetka">Unesite datum početka:
                <input type="date" name='datum_pocetka' id='datum_pocetka' value="" required>
            </label>
        </p>

         <p>
            <label for="datum_zavrsetka">Unesite datum završetka:
                <input type="date" name='datum_zavrsetka' id='datum_zavrsetka' value="" required>
            </label>
        </p>

        <!-- select -->
        <p>
            <label for="id_predavac_fk">Odaberite predavača:
                <select name='id_predavac_fk' id='id_predavac_fk' required>
                <option value="NULL" disabled selected>--</option>

                <!-- Catching tutors -->
                <?php

                    $sql = "SELECT id, ime, prezime FROM osobe WHERE id_status_fk = '2'";
                    $res_tutor = mysqli_query($con, $sql); 

                    if(mysqli_num_rows($res_tutor)>0){
                        while($tutor = mysqli_fetch_assoc($res_tutor)){
                            
                            echo '<option value="'.$tutor['id'].'">';
                            echo $tutor['ime'].' '.$tutor['prezime'];
                            echo '</option>';
                        }
                    }
                
                ?>
                </select>
            </label>
        </p>



         <p>
            <label for="max_polaznika">Unesite maksimalni broj polaznika:
                <input type="number" name='max_polaznika' id='max_polaznika' value="" max = "15" min = "1" required>
            </label>
        </p>
                

        <!-- select -->
        <p>
            <label for="id_tecaj">Odaberite tecaj:
                <select name="id_tecaj" id="id_tecaj" required>
                <option value="NULL" selected disabled>--</option>

                
                <?php
                
                $sql = "SELECT * FROM tecaj";
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
       

       
        

        <p>
            <button id="posalji" value = "posalji" name="posalji" type="submit">Dodaj grupu</button>
        </p>

    </form>  

        
    
<?php require_once("includes/footer.php");?>