<?php

session_start();

$title = "Upis novog tečaja";

require_once ("includes/functions.php");

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check if current user has required permissions to view the page
$isAdmin = checkStatus();

// If checkStatus does not return 1 (admin) redirect to index page
if($isAdmin !== 1){

    header("refresh:2;url=index.php");
    
    die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
    
}

// If checkStatus returns 1 allow the user to input another course into the DB via a POST form
else{
    if(!empty($_POST['posalji'])){
        
        // Secure DB from breach using the inputted data via ocisti_tekst function
        $smjer = ocisti_tekst($_POST['smjer']);       

        $sql = "INSERT INTO
                tecaj 
                (smjer)
                VALUES (
                    '$smjer'
                    );";
        $res = mysqli_query($con,$sql);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}
require_once ("includes/header.php");
?>


    <form class = "form-horizontal" action="" method = "post">

        <div class="form-group">
            <label for ="smjer" class="col-sm-2 control-label">Smjer:</label>
                <div class = "col-sm-7">
                    <input type="text" id="smjer" name="smjer" class ="form-control" value="" required/>
                </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input class ="form-control btn btn-ghost submit" id="posalji" value = "Dodaj tečaj" name="posalji" type="submit">
          </div>
        </div>

    </form> 

<?php require_once("includes/footer.php");?>