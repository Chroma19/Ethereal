    </div>
    <div id="bottom"></div>
<footer class = "footer"> 
      <div class="footer__copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <p>&copy;2018 Ethereal. Sva prava pridržana.</p>
            </div>
            <div class="col-md-4">
              <p style = "text-align:center"><a href="#site" class = "js-scroll-trigger">Povratak na vrh</p>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <p class="credit"><a style = "color:#222;" href="https://bootstrapious.com/free-templates" class="external">Template by Bootstrapious templates</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
   
    <button type="button" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-primary btn-sm"><span class="fa fa-cog fa-2x"></span></button>
    <div id="style-switch" class="collapse collapse-div">
      <h4 class="text-uppercase">Odaberi temu</h4>
      <form class="margin-bottom">
        <select name="colour" id="colour" class="form-control">
          <option selected disabled value="">Odaberite temu</option>
          <option value="default">Ružičasta</option>
          <option value="blue">Plava</option>
          <option value="green">Zelena</option>
          <option value="red">Crvena</option>
          <option value="sea">Morsko plava</option>
          <option value="violet">Ljubičasta</option>
        </select>
      </form>
      <p class="text-muted text-small">Mijenjanje teme ne utječe na rad stranice.</p>
    </div>

    <a href="#bottom" class = "js-scroll-trigger">
        <button id = "scroll-to-bottom" type = "button" class = "btn-primary btn btn-sm">
            <i class="fa fa-chevron-circle-down fa-2x"></i>
        </button>
    </a> 

    <!-- skripte-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src = "//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-agency/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/jquery.cookie.js"> </script>
    <script src="../js/lightbox.js"></script>
    <script src="../js/front.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script src = "../js/bundle.js"></script>
    

  </body>
</html>
<?php mysqli_close($con);?>
