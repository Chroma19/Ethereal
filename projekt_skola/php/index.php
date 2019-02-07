<?php
session_start();

$title = "Ethereal - Vježbaonica";

require_once "includes/functions.php";

// Start DB Connection
$con = spajanje();

// If the user has clicked the login button -> Check sent form
if(isset($_POST['prijava'])){
  
  // If all required fields contain information 
	if(isset($_POST['username']) and isset($_POST['password'])){
    
    // Hash the password (MD5) and remove ability for potential XSS and SQL Injections
    // via the "ocisti_tekst" ("filter_text") function

		$username = ocisti_tekst($_POST['username']);
		$password = md5(ocisti_tekst($_POST['password']));
		
		$sql = "SELECT *
			FROM users
			WHERE username='$username';";
    
    
		$rezultat = mysqli_query($con,$sql);
    
    // If there is one and only one user with the entered username in the DB:
		if(mysqli_num_rows($rezultat) == 1){
			
			$user = mysqli_fetch_assoc($rezultat);
    
      // Check if entered credentials are correct
			if($password == $user['password'] and $username = $user['username'] and $userid = $user['id']){
        
        // Keep the user logged in throughout all scripts via the $_SESSION array ->
        // Store the user's necessary information in these $_SESSION keys:

				$_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['role'] = $user['id_status_fk'];
        
        // If the user has checked the "Remember me/Zapamti me" checkbox
        // Create a cookie with the obligatory information
				if(isset($_POST['zapamti'])){
          setcookiealive('username',$username, time()+7*24*60*60);
          setcookiealive('userid',$userid, time()+7*24*60*60);
          setcookiealive('role', $user['id_status_fk'], time()+7*24*60*60);
        }
        
        // If the user has not checked the checkbox 
        // Delete any previously created cookies for safety purposes
				else{
          setcookiealive('username',$username, time()-7*24*60*60);
          setcookiealive('userid',$userid, time()-7*24*60*60);
          setcookiealive('role', $user['id_status_fk'], time()-7*24*60*60);
				}
        
        // Send the user back to the homepage after successfully checking the form 
        // Log the user in
        // Clear the post array to stop form resending
        // And terminate script
        header("Location: index.php");
        $_POST = array();
        exit();
      }

    }
      // If the user has entered invalid credentials
      // Reload the page with an alert <div> element 
      // Notifying the user of possible mistakes
      // Clear the $_POST variable to stop form resending
      else{
        echo '<div class="alert" style="background:yellow;"> 
              <a href="#" class="close" data-dismiss="alert" aria-label="close">
              &times;
              </a>
              <strong>Upozorenje! </strong>Netočno korisničko ime ili lozinka!        
              </div>';

        $_POST = array();
        }
			    
  }
}

// Check for cookies
cookieCheck();

require_once "includes/header.php";


?>
<style>
  body{
    background-color:#f7f7f7;
  }
</style>
<!-- Carousel -->
    <div id="carousel-home" data-ride="carousel" class="carousel slide carousel-fullscreen carousel-fade">
      <!-- Indicators-->
      <ol class="carousel-indicators">
        <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-home" data-slide-to="1"></li>
        <li data-target="#carousel-home" data-slide-to="2"></li>
      </ol>
      <!-- Wrapper for slides-->
      <div role="listbox" class="carousel-inner">
        <div style="background-image: url('../img/carousel_1.jpg');" class="item active">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1 class="super-heading">Ethereal</h1>
            <p class="super-paragraph">Vaše središte za ispitne zadatke</p>
          </div>
        </div>
        <div style="background-image: url('../img/carousel_2.jpg');" class="item">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1 class="super-heading">Ethereal</h1>
            <p class="super-paragraph">Brzo i jednostavno rješenje za obrazovne ustanove</p>
          </div>
        </div>
        <div style="background-image: url('../img/carousel_3.jpg');" class="item">
          <div class="overlay"></div>
          <div class="carousel-caption">
            <h1 class="super-heading">Ethereal</h1>
            <p class = "super-paragraph">Template by <a style = "color:white; text-decoration:none;" href="bootstrapious.com">Bootstrapious templates</a></p>
          </div>
        </div>
      </div>
	</div>
	

    <!--   *** SERVICES ***-->
    <section class="background-gray-lightest">
      <div class="container clearfix">
        <div class="row services">
          <div class="col-md-12">
            <h2>Usluge</h2>
            <p class="lead margin-bottom--medium">Ethereal Vam pruža niz mogućnosti, dajući Vam priliku da brzo i jednostavno pripremite svoje polaznike za ispite ili kreirate alate za ponavljanje.</p>
            <div class="row">
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-alarm"></i></div>
                  <h4 class="services-heading">Vremenski neograničeno</h4>
                  <p>Sami birajte kada ćete rješavati ispite, bez stresa i žurbe.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-cloud"></i></div>
                  <h4 class="services-heading">Dostupnost</h4>
                  <p>Vaši rezultati i alati uvijek su Vam dostupni na našim stranicama, gdje god se nalazili.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-coffee"></i></div>
                  <h4 class="services-heading">Sloboda</h4>
                  <p>Naši ispiti ne iziskuju strogi nadzor, radite po svojim uvjetima i volji.</p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-monitor"></i></div>
                  <h4 class="services-heading">Digitalizirano</h4>
                  <p>Naši alati su prilagođeni gotovo svim modernim računalima, pametnim telefonima i tabletima.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-id"></i></div>
                  <h4 class="services-heading">Individualizacija</h4>
                  <p>Pogledajte informacije o sebi, svojim grupama i nadolazećim ispitima bez ugrožavanja osobnih podataka.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-signal"></i></div>
                  <h4 class="services-heading">Tehnička podrška</h4>
                  <p>Za sve dodatne upite, prijedloge i informacije molim da nam se javite na <a href="mailto:zdravko.petricusic@gmail.com"> e-mail</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--   *** SERVICES END ***-->
    

    <script>let site = document.getElementById("site");site.className = "home";let btn = document.getElementById("btn-adjust");btn.removeAttribute("class");btn.classList.add("btn");btn.classList.add("navbar-btn");btn.classList.add("btn-white");btn.classList.add("pull-left");let container = document.getElementById("top-container");container.removeAttribute("id");container.removeAttribute("class");</script>
<?php
//--------------------------------
require_once "includes/footer.php";
//-------------------------------- 
?>