<?php
error_reporting(0);

session_start();

require_once "includes/functions.php";

$title = "Unos novog ispita";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check status of user
$status = checkStatus();

// If user is neither a professor or admin deny access and redirect to homepage
if($status !== 2 && $status !== 1){

    header("refresh:2;url=index.php");
    
    die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
    
}

// Else allow exam form input and DB insertion
else{
    // If button 'posalji' is clicked proceed to check form
    if(!empty($_POST['posalji'])){
        // If there are questions, scheduling or duration information in POST variable proceed 
        // To prepare and send SQL query for exam creation 
        if(!empty($_POST['pitanja']) and !empty($_POST['vrijeme_ispita']) and !empty($_POST['trajanje_ispita'])){
        
            $naziv = ocisti_tekst($_POST['naziv']);
            $id_tecaj_fk = ocisti_tekst($_POST['id_tecaj_fk']);
            $id_lesson_fk = ocisti_tekst($_POST['id_lesson_fk']);
            $pitanja_string = implode(",",$_POST['pitanja']);
            $pitanja_string = ocisti_tekst($pitanja_string);
            $autor  = ocisti_tekst($_SESSION['username']);
            


            $sql = "INSERT INTO
            ispit 
            (naziv,id_tecaj_fk,id_lesson_fk,pitanja_string,autor)
            VALUES (
                '$naziv',
                $id_tecaj_fk,
                $id_lesson_fk,
                '$pitanja_string',
                '$autor'
            );";


            // Checking whether there are at least 10 questions in the exam
            $totalQuestions = explode(",",$pitanja_string);

            $totalQuestions = implode("",$totalQuestions);

            if(strlen($totalQuestions) >= 10){

                mysqli_query($con,$sql);

                header("Location: ".$_SERVER['PHP_SELF']);

                exit();

            }

            // If there are 10>questions in the exam call a JS alert function and remain on same page
            else{
                echo 
                    '<script>
                        alert("Ispit mora sadržavati najmanje 10 pitanja!");
                        return false;
                    </script>';
                }
        }
    
        // If lacking duration, scheduling or questions in form reload the page and terminate script
        else{
            die("Popunite sva područja! Za povratak na stranicu kliknite <a href='exam_add.php'><b>ovdje</b></a>");
        }
    }
}
require_once ("includes/header.php");

?>



<form class = "form-horizontal" action="" method = 'post'>


    <div class="form-group">
        <label class = "control-label col-sm-2" for="naziv">Unesite naziv ispita:</label>
            <div class="col-sm-7">
                <input class = "form-control" type="text" name='naziv' id='naziv' value = "" required>
            </div>
    </div>   

    <div class="form-group">
        <label for="id_tecaj_fk" class="col-sm-2 control-label">Odaberite tečaj</label>
        <div class="col-sm-7">
            <select class ="form-control" name='id_tecaj_fk' id='id_tecaj_fk' value = "" required onchange = "traziLekcija(this.options[this.selectedIndex].value);"> 
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


        <div class="form-group">
        <label class = "control-label col-sm-2" for="id_lesson_fk">Odaberite lekciju:</label>
            <div class="col-sm-7">
                <select class ="form-control" name='id_lesson_fk' id='id_lesson_fk' required onchange = "traziPitanja(this.options[this.selectedIndex].value);">
                <?php
                    // Expecting AJAX input from previous <select> element
                ?>
                </select>
            </div>
        </div>

        
        <div class="form-group">
        <label class = "control-label col-sm-2" for="pitanja[]">Odaberite pitanja:</label>
        <div id="pitanje" class = "col-sm-7">
            <?php
                // Expecting AJAX input from previous <select> element
            ?>
        </div>
        </div>
              
        
        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-5">
                <button onclick = "checkAll();" class = "form-control btn btn-ghost" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj ispit</button>
            </div>
        </div>


</form>   

    <?php require_once("includes/footer.php");?>
        