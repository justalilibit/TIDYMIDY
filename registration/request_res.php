<?php
include('server.php');

# LOAD LABGROUPIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idLabgroup = array(); // array holding the requestIDs of our current user
$query_labgroupids = "SELECT * FROM User_has_Labgroup
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";

$resResIDs = mysqli_query($db,$query_labgroupids) or die(mysqli_error($db));

while ($foundID = $resResIDs->fetch_assoc()) {
  print("INSIDE WHILE");
 $idLabgroup= $foundID['Labgroup_idLabgroup'];
  array_push($ls_idLabgroup, $idLabgroup);
  #print("Your User is connected to Request with ID: "); print($idLabgroup);
}
// CREATE ARRAY FOR SEARCH QUERY
$where_in = implode(',', $ls_idLabgroup);

if (isset($_POST['see_request'])) {

  $query = "SELECT * FROM Request WHERE idLabgroup IN ($where_in)";
  print($query);
  print("<br><br><br>");
  $results = mysqli_query($db,$query) or die(mysqli_error($db));

  if ($results->num_rows > 0) {
  	echo "<table border='1' cellspacing='5' cellpadding='4' id='resultTable' style='width:80%'>
  					<thead>
  						<tr>

  							<th onclick='sortTable(0)'>Name</th>
  							<th onclick='sortTable(1)'>Cell Type</th>
  							<th onclick='sortTable(2)'>Date</th>
                <th onclick='sortTable(3)'>Availability</th>
                <th onclick='sortTable(4)'>Comment</th>
                <th onclick='sortTable(5)'>Position</th>
  							<th onclick='sortTable(6)'>Amount</th>
  							<th onclick='sortTable(7)'>Owner</th>
                <th onclick='sortTable(8)'>Lab Group name</th>
  							<th>Delete</th>
  						</tr>
  					</thead>
  					<tbody>";

  while ($row = mysqli_fetch_array($results)){
    $idRequest = $row["idRequest"];
		// GET STORAGE INFO
		$idLabgroup = $row["idLabgroup"]; // get Owner Id for current Sample
		$queryLabgroup = "SELECT * FROM Labgroup WHERE idLabgroup = $idLabgroup";
		$resultsLabgroup = mysqli_query($db, $queryLabgroup) or die(mysqli_error($db));
		while($labgroup = $resultsLabgroup->fetch_assoc()){
			$labgroupname = $labgroup["Labgroupname"];

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
$table .= "<td>" . $row["Requestdate"] . "</td>";
$table .= "<td>" . $row["Availability"] . "</td>";
$table .= "<td>" . $row["Comment"] . 	"</td>";
$table .= "<td>" . $row["Position"] .	"</td>";
$table .= "<td>" . $row["Amount"] . "</td>";
$table .= "<td>" . $idOwner . "</td>";
$table .= "<td>" . $labgroupname . "</td>";
// <a style="color:blue" href="profile_others.php"> $idOwner </a>
$table .=	"<td> <form action='delete_request.php' method='post'>
                  <div>
                  <button name = delete_request type='submit'>Delete</button>
                </div>
                <input type='hidden' name='idRequest' value=".$row['idRequest']." />
            </form>
          </td>";
$table .= "</tr>";
}
$table .= "</tbody> </table>";

}}
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
         <h1>Request Results</h1>
		</div>
	</div>

	<div class="container">
			<h2>Request Results</h2>
			<div class="content">
				<p>Sort Entries by clicking Header</p>
			</div>
			<!-- RESULT TABLE -->
			<div>
				<?php echo $table ?>
			</div>
			<br>
			<br>
			<!-- BUTTONS -->
			<form action="request.php" method="post">
				<div class="input-group">
					<div class="container">
				  		<div class="row">
							<div class="col-12 col-md-2">
								<button type="submit" class="btn btn-success" name="newsearch" id="newrequest">New Request <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
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
