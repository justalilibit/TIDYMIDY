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

			<form method="post" action="search.php">
				<div class="input-group">
					<button class="btn btn-success">New advanced Search</button>
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
