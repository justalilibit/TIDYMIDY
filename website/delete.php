<?php
include('server.php');

// DELETE AN ENTRY
# print("<br><br><br><br>");

if(isset($_POST['delete_entry'])){
  if  (isset($_POST['idSample'])) {
    mysqli_query($db, "DELETE FROM Sample WHERE idSample='".$_POST['idSample']."'");
}}

?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.html') ?>
  <link rel="icon" href="img/tube.ico">

</head>
<body>

  <div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
        <h1>Deletion successful</h1>
        <p>Your entry has been removed from the Storage!</p>
    </div>
  </div>

  <div class="container">
			<h2>Search Results</h2>
			<div class="content">
				<h4>The following Entry has been successfully removed:</h4>
			</div>
    </div>

			<!-- RESULT TABLE -->

			</div>
            <form action="search.php" method="post">
				<div class="input-group">
					<div class="container">
				  		<div class="row">
							<div class="col-12 col-md-2">
								<button type="submit" class="btn btn-success" name="newsearch" id="newrequest">New Search <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
							   	   <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							   	 </svg></button>
							</div>
            </form>
            <form action="index.php" method="post">
							<div class="col-12 col-md-1">
								<button type="submit" class="btn btn-info" name="home" id="home"> Home <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
						          <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
						        </svg></button>
							</div>
                </form>
						</div>
					</div>
	</div>

	<?php include('footer.html') ?>

</body>
</html>
