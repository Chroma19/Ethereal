<?php
session_start();
    $title = "Upis polaznika na tečaj";

    require_once ("includes/functions.php");
    $con = spajanje();
    if($_SESSION['role'] !== "1"){
        die('<div class="alert" style="background:yellow;"> 
            <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
            &times;
            </a>
            <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
            
            </div>');
    }
    else{
    if(!empty($_POST['posalji'])){
        
        $id_users_fk = ocisti_tekst($_POST['id_users_fk']);
        $id_smjer_fk = ocisti_tekst($_POST['id_smjer_fk']);
        $id_grupa_fk = ocisti_tekst($_POST['id_grupa_fk']);

        $sql = "INSERT INTO
                upisi 
                (id_users_fk,id_smjer_fk,id_grupa_fk)
                VALUES (
                    '$id_users_fk',
                    '$id_smjer_fk',
                    '$id_grupa_fk'
                 );";
        $res = mysqli_query($con,$sql);
       
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
    }
    require_once "includes/header.php";
?>


<form class = "form-horizontal" action="" method = "post">
        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_users_fk">Odaberite korisnika:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_users_fk' id='id_users_fk' required>
                <option value="NULL" disabled selected>--</option>

                <?php
                // Catching users

                    $sql = "SELECT id, ime, prezime FROM users WHERE id_status_fk = '3' ORDER BY prezime ASC";
                    $res_osobe = mysqli_query($con, $sql); 

                    if(mysqli_num_rows($res_osobe)>0){
                        while($user = mysqli_fetch_assoc($res_osobe)){
                            
                            echo '<option value="'.$user['id'].'">';
                            echo $user['ime'].' '.$user['prezime'];
                            echo '</option>';
                        }
                    }
                
                ?>
                </select>
            </div>
            </div>


        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_smjer_fk">Odaberite smjer:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_smjer_fk' id='id_smjer_fk' required onchange = "traziGrupe(this.options[this.selectedIndex].value)">
                <option value="NULL" disabled selected>--</option>

                <?php
                // Catching courses

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



        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_grupa_fk">Odaberite grupu:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_grupa_fk' id='id_grupa_fk' required>
                <option value="NULL" disabled selected>--</option>

                </select>
            </div>
            </div>
 

        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input class ="form-control btn btn-ghost" id="posalji" value = "Upiši korisnika" name="posalji" type="submit">
          </div>
        </div>

    </form>   
    
<?php
require_once("includes/footer.php");
?>