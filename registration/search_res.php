<?php
include('server.php');
print("<br><br>");
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


} // ADVANCED SEARCH -------------------------------------------------------------
elseif (isset($_POST['reg_search'])) {
	//receive all input variables from the serach form
	$samplename = mysqli_real_escape_string($db, $_POST['samplename']);
	$celltype = mysqli_real_escape_string($db, $_POST['celltype']);
	$idStorage = mysqli_real_escape_string($db, $_POST['idStorage']);
	$position = mysqli_real_escape_string($db, $_POST['position']);
	$frozendate = mysqli_real_escape_string($db, $_POST['frozendate']);

	// create the search query using the fields from above (empty if not provided by user)
	$query = "SELECT *
						FROM Sample
						WHERE ( IF(LENGTH('$samplename') > 0, Name LIKE '%$samplename%' , 0)
				    OR IF(LENGTH('$celltype') 	> 0, Cell_type LIKE '%$celltype%', 0)
						OR IF(LENGTH('$idStorage') 	> 0, idStorage = '$idStorage' , 0)
				    OR IF(LENGTH('$frozendate') > 0, Frozendate LIKE '%$frozendate%' , 0)
						OR IF(LENGTH('$position') 	> 0, Position LIKE '%$position%' , 0)
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
						<tr class='text-center'>

							<th class='text-center' onclick='sortTable(0)'>Name <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(1)'>Cell Type</th>
							<th class='text-center' onclick='sortTable(2)'>Freezer name</th>
							<th class='text-center' class='text-center' onclick='sortTable(3)'>Freezer Location</th>
							<th class='text-center' onclick='sortTable(10)'>Position</th>
							<th class='text-center' onclick='sortTable(5)'>Date</th>
							<th class='text-center' onclick='sortTable(6)'>Amount</th>
							<th class='text-center' onclick='sortTable(7)'>Availability</th>
							<th class='text-center' onclick='sortTable(8)'>Owner</th>
							<th class='text-center' onclick='sortTable(9)'>Comment</th>
							<th>DELETE
								</th>
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
		$table .= "<td class='text-center'>" . $row["Name"] . "</td>";
		$table .= "<td class='text-center'>" . $row["Cell_type"] . "</td>";
		$table .= "<td class='text-center'>" . $storagename . "</td>";
		$table .= "<td class='text-center'>" . $location . "</td>";
		$table .= "<td class='text-center'>" . $row["Position"] .	"</td>";
		$table .= "<td class='text-center'>" . $row["Frozendate"] . "</td>";
		$table .= "<td class='text-center'>" . $row["Amount"] . "</td>";
		$table .= "<td class='text-center'>" . $row["Availability"] . "</td>";
		// <a style="color:blue" href="profile_others.php"> $idOwner </a>
		$table .= "<td class='text-center'> <a href='profile_others.php'>" . $idOwner . "</a> </td>";
		$table .= "<td class='text-center'>" . $row["Comment"] . 	"</td>";
		$table .=	"<td class='text-center'> <form action='delete.php' method='post'>
										<button name=delete_entry class='btn btn-danger'> <img src='img/trash.svg'> </button>
										<input type='hidden' name='idSample' value="; echo $row["idSample"]; "/>
		            </form>
		          </td>";
		$table .= "</tr>";
	}
	$table .= "</tbody> </table>";

}
$table .= "</ol>";

// // DELETE AN ENTRY
// if (isset($_POST['delete_entry'])) {
// 	$queryDelete = "DELETE FROM Sample WHERE idSample = $idSample"
// 	$
// }
//
// 	//Define the query
// 	$query = "DELETE FROM Sample WHERE idSample={$_POST['idSample']}";


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
			<br>
			<br>
			<!-- BUTTONS -->
			<form action="/search.php" method="post">
				<div class="input-group">
					<div class="container">
				  		<div class="row">
							<div class="col-12 col-md-2">
								<button type="submit" class="btn btn-success" name"newsearch" id="newsearch" href="search.php">New Search <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
							   	   <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
							   	 </svg></button>
							</div>
							<div class="col-12 col-md-1">
								<button type="submit" class="btn btn-info" name"home" id="home" formacion="/index.php">Go Home <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
						          <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
						        </svg></button>
							</div>
						</div>
					</div>

			</form>
	</div>


<br>
<br>
<br>
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
