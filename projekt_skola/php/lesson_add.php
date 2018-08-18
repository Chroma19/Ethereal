<?php
session_start();
require_once "includes/functions.php";

    $title = "Unos nove lekcije";

    $con = spajanje();
    if($_SESSION['role'] !== "1" or $_SESSION['role' !== "2"]){
        die('<div class="alert" style="background:yellow;"> 
            <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
            &times;
            </a>
            <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
            
            </div>');
    }
    else{
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
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
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

        
        
        <!-- select -->
        <div class = "form-group">
            <label for="id_tecaj_fk" class = "col-sm-2 control-label">Odaberite tecaj:</label>
            <div class="col-sm-7">
                <select name="id_tecaj_fk" id="id_tecaj_fk" required class = "form-control">
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
            <button class = "form-control btn btn-ghost" id="posalji" value = "posalji" name="posalji" type="submit">Dodaj lekciju</button>
        </div>
        </div>

    </form>   

<?php require_once("includes/footer.php");?>