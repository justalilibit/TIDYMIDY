<?php
include('server.php');

# LOAD LABGROUPIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idLabgroup = array(); // array holding the requestIDs of our current user
$query_labgroupids = "SELECT * FROM User_has_Labgroup
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";

$resResIDs = mysqli_query($db,$query_labgroupids) or die(mysqli_error($db));

while ($foundID = $resResIDs->fetch_assoc()) {
#  print("INSIDE WHILE");
 $idLabgroup= $foundID['Labgroup_idLabgroup'];
  array_push($ls_idLabgroup, $idLabgroup);
  #print("Your User is connected to Request with ID: "); print($idLabgroup);
}
// CREATE ARRAY FOR SEARCH QUERY
$where_in = implode(',', $ls_idLabgroup);

if (isset($_POST['see_request'])) {
  if (!empty($where_in)){
    $query = "SELECT * FROM Request WHERE idLabgroup IN ($where_in)";
  #  print($query);
  #  print("<br><br><br>");
    $results = mysqli_query($db,$query) or die(mysqli_error($db));

    if ($results->num_rows > 0) {
    	echo "<table border='1' cellspacing='5' cellpadding='4' id='resultTable' style='width:100%'>
    					<thead>
    						<tr>

    							<th class='text-center' onclick='sortTable(0)'>Name <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
    							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
    							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
    							</svg></th>
    							<th class='text-center' onclick='sortTable(1)'>Cell Type< <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
    							  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
    							  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
    							</svg></th>
    							<th class='text-center' onclick='sortTable(2)'>Date <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-numeric-down' viewBox='0 0 16 16'>
                                  <path d='M12.438 1.668V7H11.39V2.684h-.051l-1.211.859v-.969l1.262-.906h1.046z'/>
                                  <path fill-rule='evenodd' d='M11.36 14.098c-1.137 0-1.708-.657-1.762-1.278h1.004c.058.223.343.45.773.45.824 0 1.164-.829 1.133-1.856h-.059c-.148.39-.57.742-1.261.742-.91 0-1.72-.613-1.72-1.758 0-1.148.848-1.835 1.973-1.835 1.09 0 2.063.636 2.063 2.687 0 1.867-.723 2.848-2.145 2.848zm.062-2.735c.504 0 .933-.336.933-.972 0-.633-.398-1.008-.94-1.008-.52 0-.927.375-.927 1 0 .64.418.98.934.98z'/>
                                  <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                                </svg></th>
                  <th class='text-center' onclick='sortTable(3)'>Availability <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
                    <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                  </svg></th>
                  <th class='text-center' onclick='sortTable(4)'>Comment <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
                    <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                  </svg></th>
                  <th class='text-center' onclick='sortTable(5)'>Position <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
                    <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                  </svg></th>
				<th class='text-center' onclick='sortTable(6)'>Amount <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-numeric-down' viewBox='0 0 16 16'>
                  <path d='M12.438 1.668V7H11.39V2.684h-.051l-1.211.859v-.969l1.262-.906h1.046z'/>
                  <path fill-rule='evenodd' d='M11.36 14.098c-1.137 0-1.708-.657-1.762-1.278h1.004c.058.223.343.45.773.45.824 0 1.164-.829 1.133-1.856h-.059c-.148.39-.57.742-1.261.742-.91 0-1.72-.613-1.72-1.758 0-1.148.848-1.835 1.973-1.835 1.09 0 2.063.636 2.063 2.687 0 1.867-.723 2.848-2.145 2.848zm.062-2.735c.504 0 .933-.336.933-.972 0-.633-.398-1.008-.94-1.008-.52 0-.927.375-.927 1 0 .64.418.98.934.98z'/>
                  <path d='M4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                </svg></th>
				<th class='text-center' onclick='sortTable(7)'>Owner <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
				  <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
				  <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
				</svg></th>
                  <th class='text-center' onclick='sortTable(8)'>Lab Group name <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-sort-alpha-down' viewBox='0 0 16 16'>
                    <path fill-rule='evenodd' d='M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z'/>
                    <path d='M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z'/>
                  </svg></th>
    							<th class='text-center' >Delete</th>
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
      $OwnerName = $Owner["Username"];
  }

  $table .= "<tr class='item'>";
  $table .= "<td class='text-center'>" . $row["Name"] . "</td>";
  $table .= "<td class='text-center'>" . $row["Cell_type"] . "</td>";
  $table .= "<td class='text-center'>" . $row["Requestdate"] . "</td>";
  $table .= "<td class='text-center'>" . $row["Availability"] . "</td>";
  $table .= "<td class='text-center'>" . $row["Comment"] . 	"</td>";
  $table .= "<td class='text-center'>" . $row["Position"] .	"</td>";
  $table .= "<td class='text-center'>" . $row["Amount"] . "</td>";
  $table .=	"<td class='text-center'> <form action='profile_others.php' method='post'>
          <button input='submit' name='profile_others' class='btn btn-link'> $OwnerName </button>
          <input type='hidden' name='idOwner' value=". $idOwner. " />
      </form>
    </td>";  $table .= "<td class='text-center'>" . $labgroupname . "</td>";
  // <a style="color:blue" href="profile_others.php"> $idOwner </a>
  $table .=	"<td class='text-center'> <form action='delete_request.php' method='post'>
                  <button input='submit' onclick='return deleteEntry()' name='delete_request' class='btn btn-danger'> <img src='img/trash.svg'> </button>
                  <input type='hidden' name='idRequest' value=".$row['idRequest']." />
              </form>
            </td>";
  $table .= "</tr>";
  }
  $table .= "</tbody> </table>";

  }}
  $table .= "</ol>";

}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="img/tube.ico">

  <script language="JavaScript" type="text/javascript">

  function deleteEntry(){
      return confirm('Are you sure you want to delete this entry?');
  }
  </script>

</head>
<body>
	<?php include('header.html') ?>

	<div class="hero">
    <div class="jumbotron text-center" style="margin-bottom: 0px;">
         <h1>Pending Requests <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
           <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
           <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
         </svg></h1>
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
								<button type="submit" class="btn btn-info" name="home" id="home"> Home <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
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
