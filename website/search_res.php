<?php
include('server.php');
# print("<br><br><br>");


$query = "UPDATE User
          SET Full_name='$Full_name',
          Position='$Position',
          Main_task='$Main_task',
          Institute='$Institute',
          Contact_email='$Contact_email',
          Contact_phone'$Contact_phone',
          Find_me='$Find_me' WHERE Username='".$_SESSION["username"]."'";

// COMMENT LILI: 	there are 2 ways to end up here:
// 											a. over simple keyword search from Index
//											b. over Advanced Search
// 								The following if statement will process the $_POST variables accordingly
// 								The query search and the result presentation is the same for both cases.

# LOAD STORAGEIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idStorages = array(); // array holding the storageIDs of our current user
$query_storageids = "SELECT * FROM User_has_Storage
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                      ";
$resStorIDs = mysqli_query($db,$query_storageids) or die(mysqli_error($db));

while ($foundID = $resStorIDs->fetch_assoc()) {
  $idStorage = $foundID['Storage_idStorage'];
  array_push($ls_idStorages, $idStorage);
}
# CREATE ARRAY FOR SEARCH QUERY
$where_in = implode(',', $ls_idStorages);

// SIMPLE SEARCH with KEYWORD from INDEX PAGE ----------------------------------
if (isset($_POST['simple_search'])) {
	$searchword = mysqli_real_escape_string($db, $_POST['keyword']); //keyword by user
	// create search query with keyword
  if(!empty($where_in)){
    $query = "SELECT *
              FROM Sample
              WHERE idStorage IN ($where_in)
              AND ( IF(LENGTH('$searchword') > 0, Name LIKE '%$searchword%', 0)
              OR IF (LENGTH ('$searchword') > 0, Cell_type LIKE '%$searchword%',0)
            )";
  }

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
						WHERE idStorage IN ($where_in)
						AND ( IF(LENGTH('$samplename') > 0, Name LIKE '%$samplename%' , 0)
				    OR IF(LENGTH('$celltype') 	> 0, Cell_type LIKE '%$celltype%', 0)
						OR IF(LENGTH('$idStorage') 	> 0, idStorage = '$idStorage' , 0)
				    OR IF(LENGTH('$frozendate') > 0, Frozendate LIKE '%$frozendate%' , 0)
						OR IF(LENGTH('$position') 	> 0, Position LIKE '%$position%' , 0)
					)";


} // USER ENTRIES -------------------------------------------------------------#
elseif (isset($_POST['my_entries'])) {
	$idUser = $_SESSION["userdata"]["idUser"];

	$query = "SELECT *
						FROM Sample
						WHERE idUser = '$idUser' ";


}  else {
	echo "Something went wrong! Please try again";
};

//search in db
$results = mysqli_query($db, $query) or die(mysqli_error($db));

// GENERATE RESULT TABLE AND STORE IN '$table'
# When a header is clicked, run the sortTable function, with a parameter, 0 for sorting by names, 1 for sorting by Storage
if ($results->num_rows > 0) {
	echo "<table border='1' cellspacing='5' cellpadding='4' id='resultTable' style='width:100%' class=''>
					<thead>
						<tr class='text-center'>

							<th class='text-center' onclick='sortTable(0)'>Name <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(1)'>Cell Type <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg> </th>
							<th class='text-center' onclick='sortTable(2)'>Freezer name <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' class='text-center' onclick='sortTable(3)'>Storage Location <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(10)'>Position <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(5)'>Date <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-numeric-down' viewBox='0 0 16 16'>
                              <path d='M12.438 1.668V7H11.39V2.684h-.051l-1.211.859v-.969l1.262-.906h1.046z'/>
                              <path fill-rule='evenodd' d='M11.36 14.098c-1.137 0-1.708-.657-1.762-1.278h1.004c.058.223.343.45.773.45.824 0 1.164-.829 1.133-1.856h-.059c-.148.39-.57.742-1.261.742-.91 0-1.72-.613-1.72-1.758 0-1.148.848-1.835 1.973-1.835 1.09 0 2.063.636 2.063 2.687 0 1.867-.723 2.848-2.145 2.848zm.062-2.735c.504 0 .933-.336.933-.972 0-.633-.398-1.008-.94-1.008-.52 0-.927.375-.927 1 0 .64.418.98.934.98z'/>
                              <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                            </svg></th>
							<th class='text-center' onclick='sortTable(6)'>Amount <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-numeric-down' viewBox='0 0 16 16'>
                              <path d='M12.438 1.668V7H11.39V2.684h-.051l-1.211.859v-.969l1.262-.906h1.046z'/>
                              <path fill-rule='evenodd' d='M11.36 14.098c-1.137 0-1.708-.657-1.762-1.278h1.004c.058.223.343.45.773.45.824 0 1.164-.829 1.133-1.856h-.059c-.148.39-.57.742-1.261.742-.91 0-1.72-.613-1.72-1.758 0-1.148.848-1.835 1.973-1.835 1.09 0 2.063.636 2.063 2.687 0 1.867-.723 2.848-2.145 2.848zm.062-2.735c.504 0 .933-.336.933-.972 0-.633-.398-1.008-.94-1.008-.52 0-.927.375-.927 1 0 .64.418.98.934.98z'/>
                              <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                            </svg></th>
							<th class='text-center' onclick='sortTable(7)'>Availability <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(8)'>Owner <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center' onclick='sortTable(9)'>Comment <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
							</svg></th>
							<th class='text-center'>DELETE
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
			$OwnerName = $Owner["Username"];   # LILI: changed idOwner here to OwnerName
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
		// <a style="color:blue" href="profile_others.php"> $OwnerName </a>
		# $table .= "<td class='text-center'> <a href='profile_others.php?id= " .  $idOwner . "'>" . $OwnerName ."</a> </td>";
    		$table .=	"<td class='text-center'> <form action='profile_others.php' method='post'>
                    <button input='submit' name='profile_others' class='btn btn-link'> $OwnerName </button>
                    <input type='hidden' name='idOwner' value=". $idOwner. " />
                </form>
              </td>";
    // $table .= "<td class='text-center>
    //             <a href='profile_others.php?id= "; echo $idOwner; "' > "; echo $OwnerName ; " </a>
    //           </td>";
		$table .= "<td class='text-center'>" . $row["Comment"] . 	"</td>";

    $table .=	"<td class='text-center'> <form action='delete.php' method='post'>

                    <button input='submit' name='delete_entry' class='btn btn-danger'> <img src='img/trash.svg'> </button>
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
    <link rel="icon" href="img/tube.ico">


</head>
<body>
	<?php include('header.html') ?>

	<div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
         <h1>Search Results <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
  <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
</svg></h1>
         <p>Look what we found for you!</p>
		</div>
	</div>

	<div class="container">
			<div class="content">
				<h4>Entries matching your Search: <?= mysqli_num_rows($results) ?></h4>

				<p>Sort entries by clicking Header</p>
			</div>
			<!-- RESULT TABLE -->
			<div>
				<?php echo $table ?>
			</div>
			<br>
			<br>
      <!-- BUTTONS -->
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
      								<button type="submit" class="btn btn-info" name="home" id="home">Go Home <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
      						          <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
      						        </svg></button>
      							</div>
                      </form>
      						</div>
      					</div>
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
