<?php include('server.php'); ?>

<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>

        <?php include('header.html') ?>

            <!-- contacto -->
            <br>
            <div id="top" class="hero">
                        <div class="jumbotron text-center" style="margin-bottom: 0px;"> <h1>CONTACT US! <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                          <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                      </svg></h1>	<p>If you detect any bug or you have any demand that we could fulfill, please contact us!</p>
                  </div>
            <div class="container">
                <form method="" action="">
                    <h2 class="text-center">Report any problem or bug. We highly appreciate your feedback!</h2>
                    <br>
                    <br>
                    <div class="row">

            <div class="row">
            <div class="col-sm-3">
                <br>
                <br>
              <p><span class="glyphicon glyphicon-map-marker"></span> Barcelona, Spain</p>
              <p><span class="glyphicon glyphicon-envelope"></span> Lili M.: lilianmarie.boll01@estudiant.upf.edu</p>
              <p><span class="glyphicon glyphicon-envelope"></span> Albert: albert.garcia11@estudiant.upf.edu</p>
              <p><span class="glyphicon glyphicon-envelope"></span> Joana: joana.llaurado01@estudiant.upf.edu</p>

            </div>
            <div class="col-sm-7">
              <div class="row">
                <div class="col-sm-6 form-group">
                    <label class="m-sm-0">Your name</label>
                  <input class="form-control"  name="name" placeholder="<?php echo $_SESSION["userdata"]["Full_name"]?>" type="text" required>
                </div>
                <div class="col-sm-6 form-group">
                    <label class="m-sm-0">Your email</label>
                  <input class="form-control"  name="email" placeholder="<?php echo $_SESSION["userdata"]["Email"] ?>" type="email" required>
              </div>
            </div>
            <label class="m-sm-0">Your Message</label>
            <textarea class="form-control" id="comments" name="comments" placeholder="NOTICE THIS CONTACT FORM IS TEMPORARY DISABLED DUE TO SECURITY ISSUES, PLEASE GO TO OUR HOME PAGE (by clicking on the tidytubes logo) AND CONTACT US THROUGH THE NETWORKS IN OUR CARDS OR USING THE LEFT PLACED E-MAILS :)" rows="5"></textarea><br>
            <div class="row">
                <div class="col-sm-12 form-group ">
                  <button class="btn btn-success pull-center" type="submit" disabled>Send</button>
              </div>
            </div>
          </div>
        </div>
    </div>


            <!-- Image of location -->
      <div class="jumbotron text-center" style="margin-bottom: 0px;">
          <h2>Find us in our second home </h2>
          <h4>(Campus del Mar, UPF)</h4>

      </div>
      <img src="img/upf.jpg" style="width:100%">
    </body>
    <?php include('footer.html') ?>

</html>
