<?php
error_reporting(0);

session_start();

require_once "includes/functions.php";

$title = "Unos nove lekcije";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check user's status
$status = checkStatus();

// If user is not an admin nor a professor redirect to homepage
if($status !== 2 && $status !== 1){

    header("refresh:2;url=index.php");
    
    die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
    
}

// If the user is an admin or professor allow DB input
else{
    // If button 'posalji' is clicked prepare and send off an SQL query
    if(!empty($_POST['posalji'])){
        
        $lesson_name = ocisti_tekst($_POST['lesson_name']);
        $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
        
        $sql = "INSERT INTO
                lessons 
                (lesson_name,id_tecaj_fk)
                VALUES (
                    '$lesson_name',
                    '$id_tecaj_fk'
                    );";

        $res = mysqli_query($con,$sql);
        
        // If mysqli_query returns true
        if($res){

            // Empty $_POST array to prevent form resending
            $_POST=array();

            // Reload the page
            header("Location:lesson_add.php");

            // Terminate script
            exit();
            
        }

        // If mysqli_query returns false throw error
        else{
            echo "Lekcija nije dodana " .mysqli_error($con);
        }
    }
}

require_once ("includes/header.php");
?>


<form class = "form-horizontal" action="" method = 'post'>

    
    <div class = "form-group">
        <label for="lesson_name" class = "col-sm-2 control-label">Upišite lekciju:</label>
        <div class="col-sm-7">
            <input type="text" class = "form-control" id='lesson_name' name="lesson_name" value = "" required>
        </div>
    </div>

    
    
    <div class = "form-group">
        <label for="id_tecaj_fk" class = "col-sm-2 control-label">Odaberite tečaj:</label>
        <div class="col-sm-7">
            <select name="id_tecaj_fk" id="id_tecaj_fk" required class = "form-control">
            <option value="NULL" selected disabled>--</option>
            
        <?php
            
            $sql = "SELECT id, smjer FROM tecaj";

            $res_tecaj = mysqli_query($con, $sql);

            // If mysqli_query returns more than one result
            // Echo them into <select> menu
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


    <div class = "form-group">
    <div class="col-sm-2 col-sm-offset-5">
        <button class = "form-control btn btn-ghost submit" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj lekciju</button>
    </div>
    </div>

</form>   

<?php require_once("includes/footer.php");?>