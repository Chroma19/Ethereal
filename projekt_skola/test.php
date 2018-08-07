<?php 


                    // //funkcija time() - vraća timestamp trenutnog vremena
                    // echo 'time(): '.time().'<br>';
                    
                    // //funkcija date() - formatira timestamp (trenutni) u drugačiji oblik
                    // echo 'date(): '.date("d.F.Y. h:i a").'<br>';
                    
                    // echo date('Y-m-d', time()); //formatira dobiveni timestamp
                    
                    // echo '<br>';
                    
                    // $datum='1995/2/23';
                    // $datum_timestamp = strtotime($datum); //pretvara bilo koji oblik datuma u timestamp
                    // echo $datum_timestamp;
                    // echo '<br>'.date("d.F.Y.", $datum_timestamp).'<br>';
                    
                    // echo '<br>'.date("d.F.Y.", strtotime("25.5.2000.")).'<br>';

                    // $datum_ispita = getdate();
                    // $datum_ispita = $datum_ispita['year']."-".$datum_ispita['mon']."-".$datum_ispita['mday'];
                    // $datum_ispita = strtotime($datum_ispita);
                    // $datum_ispita = date("Y-m-d",$datum_ispita);
                    // echo $datum_ispita;

                    session_start();
                    if(!empty($_POST['posalji'])){
                    $datum_ispita_raw =$_POST['datum_ispita'];
                    // $datum_ispita = date("Y-m-d", strtotime($datum_ispita_raw));
                    $_SESSION['var'] = $datum_ispita_raw;
                    header("Location:test2.php");
                    }
                    ?>
                    <form action="" method = "post">
                    
                    <input type="date" name = "datum_ispita">

                    <button id = "posalji" value ="posalji" type = "submit" name = "posalji">Submit</button>
                    </form>
                

