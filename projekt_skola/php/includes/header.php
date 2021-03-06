<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="all,follow">
    <title><?=$title?></title>


    <!-- Bootstrap core CSS --> 
    <link rel="stylesheet" href="../css/bootstrap.min.css"/>
    <!-- Font Awesome & Pixeden Icon Stroke icon font-->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/pe-icon-7-stroke.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="../css/style.default.css" id="theme-stylesheet">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <!-- Custom user css -->
    <link rel="stylesheet" href="../css/custom.min.css">
</head>

<body id="site">

<noscript>
  <div id = "noJS">
    You must have Javascript enabled in your browser in order to open this website.
    It seems that you currently have it turned off.
    <br/><br/> Please consult
    <a style = "font-weight:bold;" href="http://www.google.com/support/bin/answer.py?answer=23852" target="_top">this
      article</a>
    for instructions on how to enable Javascript in your browser.
    <br/><br/>
    Also make sure that you are not using any browser plugins (like
    <i>NoScript</i> for Firefox) that could be blocking Javascript.
  </div>
</noscript>



<?php  
error_reporting(0);
$id = $_SESSION['userid'];

  if(isset($_SESSION['login']) and $_SESSION['login'] == true){

// If logged in as an administrator:
    if($_SESSION['role'] == "1"){
      
  echo '<!-- navbar-->
  <header class="header">
    <div role="navigation" class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header"><a href="index.php" class="navbar-brand">Ethereal</a>
          <div class="navbar-buttons">
            <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Izbornik<i class="fa fa-align-justify"></i></button>
          </div>
        </div>
        <div id="navigation" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="active"><a href="profile.php?id='.$id.'">Moj profil</a></li>
            <!-- Admin access  -->
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Osnovni podaci<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="user_add.php">Unos korisnika u bazu</a></li>
                <li><a href="users.php">Popis svih korisnika</a></li>
              </ul>
            </li>        


            <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Upisi i tečajevi<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="course_add.php">Unos tečaja u bazu</a></li>
                <li><a href="courses.php">Popis svih tečaja</a></li>
                <li><a href="enrol.php">Upis korisnika na tečaj</a></li>
                <li><a href="groups.php">Popis svih grupa</a></li>
                <li><a href="group_add.php">Upis grupe</a></li>
              </ul>
            </li>   


            <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">Ispiti<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="exam_list.php">Popis svih ispita</a></li>
                <li><a href="exam_add.php">Unos ispita</a></li>
                <li><a href="lesson_add.php">Unos lekcije</a></li>
                <li><a href="question_add.php">Unos pitanja u bazu</a></li>
              </ul>
            </li>   

            

            </ul><a id = "btn-adjust"  href="odjava.php" class="btn navbar-btn btn-ghost  pull-left"><i class="fa fa-sign-in"></i>Odjava</a>
        </div>
      </div>
    </div>
  </header>';
}
// If logged in as a professor:
else if($_SESSION['role'] == "2"){
	echo '<!-- navbar-->
  <header class="header">
    <div role="navigation" class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header"><a href="index.php" class="navbar-brand">Ethereal</a>
          <div class="navbar-buttons">
            <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Izbornik<i class="fa fa-align-justify"></i></button>
          </div>
        </div>
        <div id="navigation" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="active"><a href="profile.php?id='.$id.'">Moj profil</a></li>
                 
          
          <!-- professor access -->
            
                <li><a href="exam_list.php">Popis ispita</a></li>
                <li><a href="exam_add.php">Unos ispita</a></li>
                <li><a href="lesson_add.php">Unos lekcije</a></li>
                <li><a href="question_add.php">Unos pitanja</a></li>
                <li><a href="groups.php">Popis grupa</a></li>
                

          </ul><a id = "btn-adjust"  href="odjava.php" class="btn navbar-btn btn-ghost  pull-left"><i class="fa fa-sign-in"></i>Odjava</a>
        </div>
      </div>
    </div>
  </header>';
}

// If logged in as a student:
else if($_SESSION['role'] == "3"){
	echo '<!-- navbar-->
  <header class="header">
    <div role="navigation" class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header"><a href="index.php" class="navbar-brand">Ethereal</a>
          <div class="navbar-buttons">
            <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Izbornik<i class="fa fa-align-justify"></i></button>
          </div>
        </div>
        <div id="navigation" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <!-- student access -->
                <li><a href="exam_list.php">Popis nadolazećih ispita</a></li>
                <li><a href="profile.php?id='.$id.'">Moj profil</a></li> 
          </ul><a id = "btn-adjust"  href="odjava.php" class="btn navbar-btn btn-ghost  pull-left"><i class="fa fa-sign-in"></i>Odjava</a>
        </div>
      </div>
    </div>
  </header>';
}
  }

// If not logged in:
  else{
    echo '<!-- navbar-->
    <header class="header">
      <div role="navigation" class="navbar navbar-default">
        <div class="container">
          <div class="navbar-header"><a href="index.php" class="navbar-brand">Ethereal</a>
            <div class="navbar-buttons">
              <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle navbar-btn">Izbornik<i class="fa fa-align-justify"></i></button>
            </div>
          </div>
          <div id="navigation" class="collapse navbar-collapse navbar-right">
            <a id = "btn-adjust" href="#" data-toggle="modal" data-target="#login-modal" class="btn navbar-btn btn-ghost pull-left"><i class="fa fa-sign-in"></i>Log in</a>
          </div>
        </div>
      </div>
    </header>
    <!-- *** LOGIN MODAL ***_________________________________________________________
    -->
    <div id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true" class="modal fade">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
            <h4 style = "text-align:center; color:#bbb;" id="Login" class="modal-title">Prijava</h4>
          </div>
          <div class="modal-body">
            <form action="index.php" method="post">
              <div class="form-group">
                <input id="username_modal" type="text" name = "username" placeholder="Korisničko ime" class="form-control">
              </div>
              <div class="form-group">
                <input id="password_modal" type="password" name = "password" placeholder="Lozinka" class="form-control">
              </div>
              <div class="form-group checkbox">
                <label for="cookie_modal">
                  <input id="cookie_modal" type="checkbox" class = "checkbox" name = "zapamti" value = "zapamti" >Zapamti me
                </label>
              </div>
              <p class="text-center">
                <button type="submit" id = "prijava" value = "prijava" name = "prijava" class="btn btn-primary"><i class="fa fa-sign-in"></i>Prijavi se</button>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- *** LOGIN MODAL END ***-->';
  }
?>
  
      <div class="container" id = "top-container">

