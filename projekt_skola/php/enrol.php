<?php
session_start();
    $title = "Upis polaznika na tečaj";

    require_once ("includes/functions.php");
    $con = spajanje();
    if($_SESSION['role'] !== "1"){
        die("Nemate ovlasti za pristupanje ovoj stranici! Za povratak na početnu kliknite <a href='index.php'><b>ovdje</b></a>");
    }
    else{
    if(!empty($_POST['posalji'])){
        
        $id_users_fk = ocisti_tekst($_POST['id_users_fk']);
        $id_grupa_fk = ocisti_tekst($_POST['id_grupa_fk']);

        $sql = "INSERT INTO
                upisi 
                (id_users_fk,id_grupa_fk)
                VALUES (
                    '$id_users_fk',
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

                    $sql = "SELECT id, ime, prezime FROM users ORDER BY prezime ASC";
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
          <label class="col-sm-2 control-label" for="id_grupa_fk">Odaberite grupu:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_grupa_fk' id='id_grupa_fk' required>
                <option value="NULL" disabled selected>--</option>

                <?php
                // Catching groups

                    $sql = "SELECT * FROM grupa WHERE datum_zavrsetka > NOW();";
                    $res_grupe = mysqli_query($con, $sql); 
                    if(mysqli_num_rows($res_grupe)>0){
                        while($grupa = mysqli_fetch_assoc($res_grupe)){
                            
                            echo '<option value="'.$grupa['id'].'">';
                            echo $grupa['naziv'];
                            echo '</option>';
                        }
                    }
                    
                ?>
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