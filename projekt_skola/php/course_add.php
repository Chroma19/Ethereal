<?php

session_start();
    $title = "Upis novog tečaja";

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
        
        $smjer = ocisti_tekst($_POST['smjer']);
        $broj_sati = ocisti_tekst($_POST['broj_sati']);
        $cijena = ocisti_tekst($_POST['cijena']);
       

        $sql = "INSERT INTO
                tecaj 
                (smjer,broj_sati,cijena)
                VALUES (
                    '$smjer',
                    '$broj_sati',
                    '$cijena'
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
            <label for ="smjer" class="col-sm-2 control-label">smjer</label>
                <div class = "col-sm-7">
                    <input type="text" id="smjer" name="smjer" class ="form-control" value="" required/>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="broj_sati">Unesite broj sati:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="number" name='broj_sati' id='broj_sati'  value = "" required> 
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="cijena">Unesite cijenu tečaja:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="number" step = "0.01" name='cijena' id='cijena'  value = "" required>
                </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input class ="form-control btn btn-ghost" id="posalji" value = "Dodaj tečaj" name="posalji" type="submit">
          </div>
        </div>

    </form> 

<?php require_once("includes/footer.php");?>