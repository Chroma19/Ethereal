<?php
error_reporting(0);

session_start();

$title = "Upis polaznika na tečaj";

require_once ("includes/functions.php");

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check user's status
$status = checkStatus();

// If status is not admin or professor deny access and redirect to home page
if($status !== 2 && $status !== 1){

    header("refresh:2;url=index.php");
    
    die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
    
}

// If user is either a professor or admin allow enrollment
else{
    // If button 'posalji' is clicked prepare and send SQL query
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
        
        // If mysqli_query returns true
        if($res){

            header("Location:enrol.php");

            // Empty $_POST array to prevent form resending
            $_POST = array();

            // Terminate script
            exit();
            
        }

        // If mysqli_query returns false throw error
        else{
            echo "Korisnik nije upisan " .mysqli_error($con);
        }
    }
}
require_once "includes/header.php";
?>


<form class = "form-horizontal" action="" method = "post">
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_users_fk">Odaberite korisnika:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_users_fk' id='id_users_fk' required>
                <option value="NULL" disabled selected>--</option>

                <?php
                // Fetching students

                    $sql = "SELECT id, ime, prezime FROM users WHERE id_status_fk = '3' ORDER BY prezime ASC";

                    $res_osobe = mysqli_query($con, $sql); 

                    // If query returns at least one student fill in the select menu
                    if(mysqli_num_rows($res_osobe) > 0){
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


        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_smjer_fk">Odaberite smjer:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_smjer_fk' id='id_smjer_fk' required onchange = "traziGrupe(this.options[this.selectedIndex].value)">
                <option value="NULL" disabled selected>--</option>

                <?php
                // Fetching courses

                    $sql = "SELECT * FROM tecaj";

                    $res_tecaj = mysqli_query($con, $sql); 

                    // If query returns at least one course fill in the select menu
                    if(mysqli_num_rows($res_tecaj) > 0){
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
          <label class="col-sm-2 control-label" for="id_grupa_fk">Odaberite grupu:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_grupa_fk' id='id_grupa_fk' required>
                <option value="NULL" disabled selected>--</option>
                    <?php
                        // Expecting AJAX input from previous <select> element
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