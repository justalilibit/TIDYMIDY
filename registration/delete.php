<?php
include('server.php');

// DELETE AN ENTRY
print("<br><br><br><br>");
echo "DIGGA WO IST DIE SCHEISS SAMPLE ID ICH KRIEG NEN ANFALL.";

if(isset($_POST['delete_entry'])){

  print("<br><br>DELETE PUSHED");

  if (isset($_POST['idSample']) && !empty($_POST['idSample'])) {
    print( $_POST['idSample']);
    print("<br><br>GET HERE");
  } else {
    print("<br><br>GET HERE");
  }

}else {
  echo "Did you push the delete button to get here? Don't think so. Go Back";
}

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
			<!-- RESULT TABLE -->
			<div>
				<?php echo $table ?>

			</div>

			<form method="post" action="search.php">
				<div class="input-group">
					<button class="btn btn-success" href="search.php">New advanced Search</button>
					<button class="btn btn-success" href="index.html">Back to Home</button>
				</div>
			</form>
	</div>
	<?php include('footer.html') ?>

</body>
</html>










<?php
foreach($ls_idStorages as $idStorage) {
  $storage_sql = "SELECT * FROM Storage WHERE idStorage = '$idStorage'";
  $res_storage =mysqli_query($db, $storage_sql) or die(mysqli_error($db));
    while ($storageEntry = $res_storage->fetch_assoc()){
      "<h4 value=' "; echo $storageEntry['idStorage']; "'>"; echo $storageEntry['Storagename']; echo "<br>"; "</h4>";
    }
}

?>

<div class="input-group">
  <label for="Storage">Type</label>
  <?php
    $sql = "Select * from Storage";
    $result = mysqli_query($db, $sql);
    echo "<select name='unitid'>";
    while ($row = mysqli_fetch_array($result)) {
       echo "<option value='" .$row['idStorage']."'> ".$row['Storagename'] . "</option>";
    }
    echo "</select>";
