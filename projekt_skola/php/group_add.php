<?php
session_start();
require_once "includes/functions.php";

$title = "Upis nove grupe";

$con = spajanje();

$status = checkStatus();

if($status !== 2 && $status !== 1){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}

else{

    if(!empty($_POST['posalji'])){
        
        $naziv = ocisti_tekst($_POST['naziv']);
        $id_predavac_fk = ocisti_tekst($_POST['id_predavac_fk']); 
        $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj']);
        
        $sql = "INSERT INTO
                grupa 
                (naziv,id_predavac_fk,id_tecaj_fk)
                VALUES (
                    '$naziv',
                    '$id_predavac_fk',
                    '$id_tecaj_fk'
                );";

        $res = mysqli_query($con,$sql);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}  
    
    require_once ("includes/header.php");
    
?>



    <form action="" class = "form-horizontal" method = 'post'>

         <div class = "form-group">
            <label class = "col-sm-2 control-label" for="naziv">Unesite naziv grupe:</label>
            <div class="col-sm-7">
                <input class = "form-control" type="text" name='naziv' id='naziv' value="" required>
            </div>
        </div>

        <div class = "form-group">
            <label for="id_predavac_fk" class = "col-sm-2 control-label">Odaberite predavača:</label>
            <div class="col-sm-7">
                <select class  = "form-control" name='id_predavac_fk' id='id_predavac_fk' required>
                <option value="NULL" disabled selected>--</option>

                <?php
                    //  Catching tutors 

                    $sql = "SELECT id, ime, prezime FROM users WHERE id_status_fk = '2'";
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
                </div>
            
        </div>


       
        <div class = "form-group">
            <label for="id_tecaj" class = "col-sm-2 control-label">Odaberite tečaj:</label>
            <div class="col-sm-7">
                <select name="id_tecaj" id="id_tecaj" required class = "form-control">
                <option value="NULL" selected disabled>--</option>

                
                <?php
                
                $sql = "SELECT * FROM tecaj";
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
            

        <div class = "form-group">
        <div class="col-sm-2 col-sm-offset-5">
            <button onclick = "startcheck();" class = "btn-ghost btn form-control submit" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj grupu</button>
        </div>
        </div>

    </form>  

<?php require_once("includes/footer.php");?>