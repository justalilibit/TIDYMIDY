<?php
include('server.php');

// DELETE AN ENTRY
print("<br><br><br><br>");

if(isset($_POST['delete_request'])){
  if  (isset($_POST['idRequest'])) {
    mysqli_query($db, "DELETE FROM Request WHERE idRequest='".$_POST['idRequest']."'");
}}

?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.html') ?>
</head>
<body>

  <div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
        <h1>Deletion successful</h1>
        <p>Your request has been removed from the Request table!</p>
    </div>
  </div>

  <div class="container">
			<h2>Request Results</h2>
			<div class="content">
				<h4>The following Request has been successfully removed:</h4>
			</div>
    </div>

			<!-- RESULT TABLE -->

			</div>

			<form method="post" action="request.php">
				<div class="input-group">
					<button class="btn btn-success">New Request Search</button>
				</div>
			</form>
      <form method="post" action="index.php">
				<div class="input-group">
					<button class="btn btn-success">Back to Home</button>
				</div>
			</form>
	</div>
	<?php include('footer.html') ?>

</body>
</html>
