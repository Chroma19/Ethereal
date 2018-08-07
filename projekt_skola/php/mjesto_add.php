<?php
session_start();
    $title = "Unos novog mjesta";

    require_once ("includes/functions.php");
    $con = spajanje();
    if($_SESSION['role'] !== "1"){
        die("Nemate ovlasti za pristupanje ovoj stranici! Za povratak na početnu kliknite <a href='index.php'><b>ovdje</b></a>");
    }
    else{
    if(!empty($_POST['posalji'])){
        
        $naziv = ocisti_tekst($_POST['naziv']);
        $pbr = ocisti_tekst($_POST['pbr']);
        
        $sql = "INSERT INTO
               `mjesto` 
                (`naziv`,`pbr`)
                VALUES (
                    '$naziv',
                    $pbr
                 );";
        $res = mysqli_query($con,$sql);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
        }
    }
    require_once "includes/header.php";
?>


    <form class = "form-horizontal" action="" method = "post">

        <div class="form-group">
            <label for ="naziv" class="col-sm-2 control-label">Naziv mjesta</label>
                <div class = "col-sm-7">
                    <input type="text" id="naziv" name="naziv" class ="form-control" value="" required/>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="pbr">Unesite poštanski broj:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="number" name='pbr' id='pbr'  value = "" required> 
                </div>
        </div>
        
        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input class ="form-control btn btn-ghost" id="posalji" value = "Dodaj mjesto" name="posalji" type="submit">
          </div>
        </div>

    </form>   



<?php require_once("includes/footer.php");?>