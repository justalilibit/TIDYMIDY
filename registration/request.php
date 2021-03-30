<?php

include('server.php');
print($_SESSION["userdata"]["idUser"]);

# LOAD STORAGEIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idRequests = array(); // array holding the requestIDs of our current user
$query_requestids = "SELECT * FROM User_has_Request
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";

$resResIDs = mysqli_query($db,$query_requestids) or die(mysqli_error($db));

while ($foundID = $resResIDs->fetch_assoc()) {
  $idRequest = $foundID['Request_idRequests'];
  $idUser = $foundID['User_idUser'];
  array_push($ls_idRequests, $idRequest);
  print("<br><br><br>");
  print("<br><br><br>");
  print("<br><br><br>");

   print("Your User is connected to Request with ID: "); print($idUser);
}



// NEW ENTRY
if (isset($_POST['reg_request'])) {
  print("INSIDE REEEQUEEEST");
  print("INSIDE REEEQUEEEST");
  print("INSIDE REEEQUEEEST");
  print("<br><br><br>");

  // receive all input values from the entry form
  $samplename = mysqli_real_escape_string($db, $_POST['samplename']);
  $celltype = mysqli_real_escape_string($db, $_POST['celltype']);
  $amount = mysqli_real_escape_string($db, $_POST['amount']);
  $comment = mysqli_real_escape_string($db, $_POST['comment']);
  $position = mysqli_real_escape_string($db, $_POST['position']);
  $requestdate = mysqli_real_escape_string($db, $_POST['requestdate']);
// entry validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($samplename)) { array_push($errors, "Sample name is required"); }
  if (empty($celltype)) { array_push($errors, "Cell type is required"); }
  #if (empty($position)) { array_push($errors, "Position is required"); }
  if (empty($amount)) { array_push($errors, "Amount is required"); }

  // Finally, add the new entry in the sample table
  if (count($errors) == 0) {
  	$query = "INSERT INTO Request (Name, Cell_type, Amount, Comment, Position, Date)
  			  VALUES('$samplename', '$celltype', '$amount', '$comment', '$position', '$requestdate')";
    print($query);
    mysqli_query($db, $query) or die(mysqli_error($db));

  }
}

if (isset($_POST['see_request'])) {
  print("<br><br><br>");
  print("<br><br><br>");
  print("<br><br><br>");

  $query = "SELECT * FROM Request";

  print($query);
  print("<br><br><br>");
  $result = mysqli_query($db,$query);
  #echo "<table>";
  connectUserRequest($db,$result);

foreach($ls_idRequests as $idRequest) {
  print("INISDE FOREACH");
  $request_sql = "SELECT * FROM Request WHERE idRequests = '$idRequest'";
  $res_request =mysqli_query($db, $request_sql) or die(mysqli_error($db));
  while ($row = mysqli_fetch_array($res_request)){
    print("HHHHH");
    print("<br><br><br>");
    print("<br><br><br>");
    $table = $row['idRequests']."</td><td>".$row['Name']. "</td></tr>";
  }
}}
#  while ($row = mysqli_fetch_array($result)){
  #  echo $row['idRequests'];
  #  echo"<tr>>td>".$row['idRequests']."</td><td>".$row['Date']. "</td></tr>";
# }
function alreadyconnected($db,$idRequest){
  $query = "SELECT * FROM User_has_Request
            WHERE User_idUser = '".$_SESSION["userdata"]["idUser"] ."'
            AND Request_idRequests = '$idRequest'
            ";
  $result = mysqli_query($db,$query) or die (mysqli_error($db));
  return $result;
}
#FUNCTION connecting current User to Storage that fits the prerun query ------#
function connectUserRequest($db, $res_query) {
  $idRequest ="";
  while($request = $res_query->fetch_assoc()){
    $idRequest = $request["idRequests"];
  }
  $alreadyexists = alreadyconnected($db,$idRequest);
  if($alreadyexists){
    if($alreadyexists->num_rows === 0){
        // create query for connecting User and Freeezer and run it
        $queryConnectU_R = "INSERT INTO User_has_Request (User_idUser, Request_idRequests)
                  VALUES ('".$_SESSION["userdata"]["idUser"]."', '$idRequest')";
        mysqli_query($db, $queryConnectU_R) or die(mysqli_error($db));
}}}


?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<?php include('header.html') ?>

        <div class="hero">
					<div class="jumbotron text-center" style="margin-bottom: 0px;">
		          <h1>New Request</h1>
		          <p>Add a new request and the technicians will fulfill it!</p>
		      </div>
					<div class="container">
						<form method="post" action="request.php">
							<?php include('error.php'); ?>
							<h2>Enter the details of your sample</h2>
                            <div class="row">
                              <div class="col-sm-3 d-sm-flex align-items-center">
                                <label class="m-sm-0">Tube name</label>
                                <input
                                  type="text"
                                  name="samplename"
                                  id="title"
                                  class="form-control ml-sm-2"
                                  placeholder="E.coli-LB-AMX50"
                                  value="<?php echo $samplename; ?>"
                                >
                            </div>
                            <div class="col-sm-3 d-sm-flex align-items-center">
                              <label class="m-sm-0">Cell type</label>
                              <input
                                type="text"
                                name="celltype"
                                id="cell_type"
                                class="form-control ml-sm-2"
                                placeholder="(Optional)"
                                value="<?php echo $celltype; ?>"
                                >
                            </div>
                            <div class="col-sm-1 d-sm-flex align-items-center">
                              <label class="m-sm-0">Amount</label>
                              <input
                                type="number"
                                name="amount"
                                id="amount"
                                class="form-control ml-sm-2"
                                placeholder="1"
                                value="<?php echo $amount; ?>"
                                >
                            </div>
                            <div class="col-sm-3 d-sm-flex align-items-center">
                                <label class="m-sm-0">For who are these tubes?</label>
                                <select class="custom-select" id="owner">
                                    <option selected>Private</option>
                                    <option value="1">Private</option>
                                    <option value="2">Ask me first</option>
                                    <option value="3">Public</option>
                                  </select>
                            </div>
                            <div class="col-sm-3 d-sm-flex align-items-center">
                              <label class="m-sm-0">Position</label>
                              <input
                                type="text"
                                name="position"
                                id="position"
                                class="form-control ml-sm-2"
                                placeholder="hrhrhrhr"
                                value="<?php echo $position; ?>"
                              >
                          </div>
                          <div class="col-sm-3 d-sm-flex align-items-center">
                            <label class="m-sm-0">Date</label>
                            <input
                              type="text"
                              name="requestdate"
                              class="form-control ml-sm-2"
                              placeholder="dd/mm/yyyy"
                              value="<?php echo $requestdate;?>"
                              >
                          </div>
                        </div>
                    <div class="row">
                        <div class="px-sm-2 col-sm-7 d-sm-flex align-items-center mt-2 mt-sm-0">
                          <label for="exampleFormControlTextarea1">Comments</label>
                          <textarea class="form-control"
                          id="description"
                          rows="10"
                          name="comment"
                          value="<?php echo $comment; ?>"
                          placeholder="Use that one protocol that works better, place it in the fridge at the end of the corridor, position right, IMPORTANT I NEED THIS TO BE DONE BY 15:30"
                          ></textarea>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn" name="reg_request">Add Request</button>
                    <button type="submit" class="btn" name="see_request">SEE Request</button>
                    <label>table</label>
                    <?php echo $table ?>
                    </div>
          		</form>
          	</div>
        		  <div class="container">
        			<h3>How it works:</h3>
        				<p>Use this form to add the tubes you froze. You can choose, how others see your entries in the search field. <br>
        				<strong>Private:</strong> Just you can access the entry<br>
        				<strong>Semi-privat:</strong> Others have to ask permission<br>
        				<strong>Public:</strong> Everyone may access the entry</p>
        		</div>
                <div class="mt-5">
                  <table class="table table-striped" id="table">
                    <thead>
                      <tr>
                        <th scope="col">Tube name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Amount</th>
                        <th scope="col">This tube will be</th>
                        <th scope="col">
                          <div class="d-flex justify-content-center">
                            Completed
                          </div>
                        </th>
                        <th scope="col"></th>
                      </tr>
                    </thead>
                    <tbody>
¡                    </tbody>
                  </table>
                </div>

        <?php include('footer.html') ?>
        <script src="index.js" type="module"></script>
  </div>

</body>
</html>
