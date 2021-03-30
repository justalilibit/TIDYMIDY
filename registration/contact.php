<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>

        <?php include('header.html') ?>

            <!-- contacto -->
            <br>
            <div class="hero">
                        <div class="jumbotron text-center" style="margin-bottom: 0px;"> <h1>CONTACT US! <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                          <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                      </svg></h1>	<p>If you detect any bug or you have any demand that we could fulfill, please contact us!</p>
                  </div>
            <div class="container">
                <form method="post" action="request.php">
                    <h2>Report any problem or bug. We highly appreciate your feedback!</h2>
                    <div class="row">
                      <div class="col-sm-3 d-sm-flex align-items-center">
                        <label class="m-sm-0">Your name</label>
                        <input
                          type="text"
                          class="form-control ml-sm-2"
                          placeholder="E.coli-LB-AMX50"
                        >
                        </div>
            <div class="row">
            <div class="col-sm-5">
              <p>Report any problem or bug. We appreciate your feedback!</p>
              <p><span class="glyphicon glyphicon-map-marker"></span> Barcelona, Spain</p>
              <p><span class="glyphicon glyphicon-phone"></span> +ring rinnnnggg</p>
              <p><span class="glyphicon glyphicon-envelope"></span> tidytubes@gmail.com</p>
            </div>
            <div class="col-sm-7">
              <div class="row">
                <div class="col-sm-6 form-group">
                  <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
                </div>
                <div class="col-sm-6 form-group">
                  <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
              </div>
            </div>
            <textarea class="form-control" id="comments" name="comments" placeholder="Comment" rows="5"></textarea><br>
            <div class="row">
                <div class="col-sm-12 form-group">
                  <button class="btn btn-default pull-right" type="submit">Send</button>
              </div>
            </div>
          </div>
        </div>
            <!-- Image of location -->
      <div class="jumbotron text-center" style="margin-bottom: 0px;">
          <h2>Find us in our second home</h2>
      </div>
      <img src="img/upf.jpg" style="width:100%">
    </body>
    <?php include('footer.html') ?>

</html>
