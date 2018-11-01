<?php

session_start();
$title = "Prijava";
require_once "includes/functions.php";
$con = spajanje();

//form check for cookies etc.
if(isset($_POST['prijava'])){
	
	if(isset($_POST['username']) and isset($_POST['password'])){
		
		$username = ocisti_tekst($_POST['username']);
		$password = md5(ocisti_tekst($_POST['password']));
		
		$sql = "SELECT *
			FROM users
			WHERE username='$username';";
		
		$rezultat = mysqli_query($con,$sql);
		
		if(mysqli_num_rows($rezultat) == 1){
			
			$user= mysqli_fetch_assoc($rezultat);
		
			if($password == $user['password'] and $username = $user['username'] and $userid = $user['id']){
				
				$_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $user['id'];
        $_SESSION['role'] = $user['id_status_fk'];
				
				if(isset($_POST['zapamti'])){
          setcookiealive('username',$username, time()+7*24*60*60);
          setcookiealive('userid',$userid, time()+7*24*60*60);
          setcookiealive('role', $user['id_status_fk'], time()+7*24*60*60);
				}
				else{
          setcookiealive('username',$username, time()-7*24*60*60);
          setcookiealive('userid',$userid, time()-7*24*60*60);
          setcookiealive('role', $user['id_status_fk'], time()-7*24*60*60);
				}
        
        header("Location: index.php");
        exit();
      }
      else{
        echo '<div class="alert" style="background:yellow;"> 
              <a href="#" class="close" data-dismiss="alert" aria-label="close">
              &times;
              </a>
              <strong>Upozorenje! </strong>Netočno korisničko ime ili lozinka!        
              </div>';
        }
			
    }
    
  }
}


if(!isset ($_SESSION['login'])){
	
	if(isset($_COOKIE['username'])){
		$_SESSION['login'] = true;
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['userid'] = $_COOKIE['userid'];
    $_SESSION['role'] = $_COOKIE['role'];
	}
	
} 

require_once "includes/header.php";


?>
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
	
<section class="background-gray-lightest negative-margin">
      <div class="container">
        <h1> Mauris placerat eleifend leo.</h1>
        <p class="lead">Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat.</p>
        <p> <a href="#" class="btn btn-ghost">Continue reading   </a></p>
      </div>
    </section>
    <section class="section--padding-bottom-small">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="post">
              <h3><a href="#">Rit eget tincidunt condimentum</a></h3>
              <p class="post__intro">ellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
              <p class="read-more"><a href="#" class="btn btn-ghost">Continue reading   </a></p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="post">
              <h3><a href="#">Tempor sit amet</a></h3>
              <p class="post__intro"> Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi.</p>
              <p class="read-more"><a href="#" class="btn btn-ghost">Continue reading   </a></p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="post">
              <h3><a href="#">Rit eget tincidunt condimentum</a></h3>
              <p class="post__intro">ellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
              <p class="read-more"><a href="#" class="btn btn-ghost">Continue reading     </a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <h3><a href="#">Tempor sit amet</a></h3>
              <p class="post__intro"> Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi.</p>
              <p class="read-more"><a href="#" class="btn btn-ghost">Continue reading     </a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="#">#</a></div>
              <h3><a href="#">Vestibulum erat wisi</a></h3>
              <p class="post__intro">ellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
              <p class="read-more"><a href="#" class="btn btn-ghost">Continue reading     </a></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--   *** SERVICES ***-->
    <section class="background-gray-lightest">
      <div class="container clearfix">
        <div class="row services">
          <div class="col-md-12">
            <h2>Services</h2>
            <p class="lead margin-bottom--medium"> Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
            <div class="row">
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-alarm"></i></div>
                  <h4 class="services-heading">Webdesign</h4>
                  <p>Fifth abundantly made Give sixth hath. Cattle creature i be don\'t them.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-cloud"></i></div>
                  <h4 class="services-heading">Print</h4>
                  <p>Advantage old had otherwise sincerity dependent additions. It in adapted natural.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-coffee"></i></div>
                  <h4 class="services-heading">SEO and SEM</h4>
                  <p>Am terminated it excellence invitation projection as. She graceful shy. </p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-monitor"></i></div>
                  <h4 class="services-heading">Consulting</h4>
                  <p>Fifth abundantly made Give sixth hath. Cattle creature i be don\'t them.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-signal"></i></div>
                  <h4 class="services-heading">Email Marketing</h4>
                  <p>Advantage old had otherwise sincerity dependent additions. It in adapted natural.</p>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="box box-services">
                  <div class="icon"><i class="pe-7s-id"></i></div>
                  <h4 class="services-heading">UX &amp; UI</h4>
                  <p>Am terminated it excellence invitation projection as. She graceful shy. </p>
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