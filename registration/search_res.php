<?php
include('server.php');

// COMMENT LILI: 	there are 2 ways to end up here:
// 											a. over simple keyword search from Index
//											b. over Advanced Search
// 								The following if statement will process the $_POST variables accordingly
// 								The query search and the result presentation is the same for both cases.

// SIMPLE SEARCH with KEYWORD from INDEX PAGE ----------------------------------
if (isset($_POST['simple_search'])) {
	$searchword = mysqli_real_escape_string($db, $_POST['keyword']); //keyword by user
	// create search query with keyword

	$query = "SELECT *
						FROM Sample
						WHERE ( IF (LENGTH ('$searchword') > 0, Name LIKE '%$searchword%', 0))
						'";


}
// ADVANCED SEARCH -------------------------------------------------------------
elseif (isset($_POST['reg_search'])) {
	//receive all input variables from the serach form
	$samplename = mysqli_real_escape_string($db, $_POST['samplename']);
	$celltype = mysqli_real_escape_string($db, $_POST['celltype']);
	$idStorage = mysqli_real_escape_string($db, $_POST['idStorage']);
	$rack = mysqli_real_escape_string($db, $_POST['rack']);
	$position = mysqli_real_escape_string($db, $_POST['position']);
	$amount = mysqli_real_escape_string($db, $_POST['amount']);
	$frozendate = mysqli_real_escape_string($db, $_POST['frozendate']);
	$availability = mysqli_real_escape_string($db, $_POST['availability']);
	$comment = mysqli_real_escape_string($db, $_POST['comment']);

	// create the search query using the fields from above (empty if not provided by user)
	$query = "SELECT *
						FROM Sample
						WHERE ( IF(LENGTH('$samplename') > 0, Name LIKE '%$samplename%' , 0)
				    OR IF(LENGTH('$celltype') > 0, Cell_type LIKE '%$celltype%', 0)
						OR IF(LENGTH('$idStorage') > 0, idStorage = '$idStorage' , 0)
				    OR IF(LENGTH('$frozendate') > 0, Frozendate LIKE '%$frozendate%' , 0)
				    OR IF(LENGTH('$availability') > 0, Availability LIKE '%$availability%', 0)
						OR IF(LENGTH('$position') > 0, Position LIKE '%$position%' , 0)
						OR IF(LENGTH('$rack') > 0, Rack LIKE '%$rack%' , 0)
						OR IF(LENGTH('$amount') > 0, Amount LIKE '%$amount%' , 0)
						OR IF(LENGTH('$comment') > 0, Comment LIKE '%$comment%' , 0)
					)";


} // USER ENTRIES -------------------------------------------------------------
elseif (isset($_POST['my_entries'])) {
	$idUser = $_SESSION["userdata"]["idUser"];

	$query = "SELECT *
						FROM Sample
						WHERE idUser = '$idUser' ";
} else {
	echo "Something went wrong! Please try again";
};

//search in db
$results = mysqli_query($db, $query) or die(mysqli_error($db));

// GENERATE RESULT TABLE AND STORE IN '$table'
# When a header is clicked, run the sortTable function, with a parameter, 0 for sorting by names, 1 for sorting by Storage
if ($results->num_rows > 0) {
	echo "<table border='1' cellspacing='5' cellpadding='4' id='resultTable' style='width:80%'>
					<thead>
						<tr>
							<th echo onclick='sortTable(0)'>Name</th>
							<th onclick='sortTable(1)'>Cell Type</th>
							<th onclick='sortTable(2)'>Freezer name</th>
							<th onclick='sortTable(3)'>Freezer Location</th>
							<th onclick='sortTable(4)'>Rack</th>
							<th onclick='sortTable(10)'>Position</th>
							<th onclick='sortTable(5)'>Date</th>
							<th onclick='sortTable(6)'>Amount</th>
							<th onclick='sortTable(7)'>Availability</th>
							<th onclick='sortTable(8)'>Owner</th>
							<th onclick='sortTable(9)'>Comment</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>";


	while($row = $results->fetch_assoc()) {

		$idSample = $row["idSample"];
		// GET STORAGE INFO
		$idStorage = $row["idStorage"]; // get Owner Id for current Sample
		$queryStorage = "SELECT * FROM Storage WHERE idStorage = $idStorage";

		$resultsStorage = mysqli_query($db, $queryStorage) or die(mysqli_error($db));
		while($storage = $resultsStorage->fetch_assoc()){
			$storagename = $storage["Storagename"];
			$location = $storage["Location"];
		}

		// GET USER INFO
		$idOwner = $row["idUser"]; // get Owner Id for current Sample
		//get Info on Owner
		$queryOwner = "SELECT * FROM User WHERE idUser = $idOwner";
		$resultsOwner = mysqli_query($db, $queryOwner) or die(mysqli_error($db));
		while($Owner = $resultsOwner->fetch_assoc()){
			$idOwner = $Owner["Username"];
		}

		$table .= "<tr class='item'>";
		$table .= "<td>" . $row["Name"] . "</td>";
		$table .= "<td>" . $row["Cell_type"] . "</td>";
		$table .= "<td>" . $storagename . "</td>";
		$table .= "<td>" . $location . "</td>";
		$table .= "<td>" . $row["Rack"] . "</td>";
		$table .= "<td>" . $row["Position"] .	"</td>";
		$table .= "<td>" . $row["Frozendate"] . "</td>";
		$table .= "<td>" . $row["Amount"] . "</td>";
		$table .= "<td>" . $row["Availability"] . "</td>";

		$table .= "<td>" . $idOwner . "</td>";
		$table .= "<td>" . $row["Comment"] . 	"</td>";
		$table .=	"<td> <form action='delete.php' method='post'>
											<div>
									    <button name = delete_entry type='submit'>Delete</button>
									  </div>
										<input type='hidden' name='idSample' value=".$row['idSample']." />
		            </form>
		          </td>";
		$table .= "</tr>";
	}
	$table .= "</tbody> </table>";

}
$table .= "</ol>";


?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<?php include('header.html') ?>

	<div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
         <h1>Search Results</h1>
         <p>Look what we found for you!</p>
		</div>
	</div>

	<div class="container">
			<h2>Search Results</h2>
			<div class="content">
				<h4>Entries matching your Search: <?= mysqli_num_rows($results) ?></h4>

				<p>Sort Entries by clicking Header</p>
			</div>
			<!-- RESULT TABLE -->
			<div>
				<?php echo $table ?>

			</div>
		</div>
		<div class = "container">
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

<!-- code for sorting the table
	THIS SORTS BUT ALSO FOR UPPER AND LOWER SPACE
<script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
-->

<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("resultTable");
  switching = true; // Set the sorting direction to ascending:
  dir = "asc";
	/* Make a loop that will continue until no switching has been done: */
  while (switching) { // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) { // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare, one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place, based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) { // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) { // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc", set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

</html>
