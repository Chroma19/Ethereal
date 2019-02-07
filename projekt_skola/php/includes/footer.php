    </div>
    <div id="bottom"></div>
<footer class = "footer"> 
      <div class="footer__copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-offset-5 col-md-3">
              <p>&copy;2018 Ethereal. Sva prava pridržana.</p>
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

    <!-- skripte-->
    <script src="../js/jquery_331.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src = "../js/datatables.min.js"></script>
    <script src = "../js/bundle.js"></script>
    <script src = "../js/jquery.cookie.js"></script>
    <script src = "../js/front.js"></script>
  </body>
</html>
<?php mysqli_close($con);?>
