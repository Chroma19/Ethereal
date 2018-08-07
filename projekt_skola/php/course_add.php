<?php

session_start();
    $title = "Upis novog tečaja";

    require_once ("includes/functions.php");
    $con = spajanje();
    if($_SESSION['role'] !== "1"){
        die("Nemate ovlasti za pristupanje ovoj stranici! Za povratak na početnu kliknite <a href='index.php'><b>ovdje</b></a>");
    }
    else{
    if(!empty($_POST['posalji'])){
        
        $naziv = ocisti_tekst($_POST['naziv']);
        $broj_sati = ocisti_tekst($_POST['broj_sati']);
        $cijena = ocisti_tekst($_POST['cijena']);
       

        $sql = "INSERT INTO
                tecaj 
                (naziv,broj_sati,cijena)
                VALUES (
                    '$naziv',
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
            <label for ="naziv" class="col-sm-2 control-label">Naziv</label>
                <div class = "col-sm-7">
                    <input type="text" id="naziv" name="naziv" class ="form-control" value="" required/>
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