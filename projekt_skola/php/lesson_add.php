<?php
session_start();
require_once "includes/functions.php";

    $title = "Unos nove lekcije";

    require_once ("includes/header.php");
        $con = spajanje();
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

    
?>


    <form action="" method = 'post'>

       
        <p>
            <label for="lesson_name">Upišite lekciju:
               <input type="text" id='lesson_name' name="lesson_name" value = "" required>
            </label>
        </p>

        
        
        <!-- select -->
        <p>
            <label for="id_tecaj_fk">Odaberite tecaj:
                <select name="id_tecaj_fk" id="id_tecaj_fk" required>
                <option value="NULL" selected disabled>--</option>
                
                <?php
                
                $sql = "SELECT * FROM tecaj";
                $res_tecaj = mysqli_query($con, $sql);

                if(mysqli_num_rows($res_tecaj)>0){
                    while($tecaj = mysqli_fetch_assoc($res_tecaj)){
                            echo '<option value="'.$tecaj['id'].'">';
                            echo $tecaj['naziv'];
                            echo '</option>';
                    }
                }

                ?>

                </select>
            </label>
        </p>


        <p>
            <button id="posalji" value = "posalji" name="posalji" type="submit">Dodaj lekciju</button>
        </p>

    </form>   

<?php require_once("includes/footer.php");?>