
<?php

include('server.php');
print($_SESSION["userdata"]["idUser"]);

# LOAD LABGROUPIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idLabgroup = array(); // array holding the requestIDs of our current user
$query_labgroupids = "SELECT * FROM User_has_Labgroup
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";

$resResIDs = mysqli_query($db,$query_labgroupids) or die(mysqli_error($db));

while ($foundID = $resResIDs->fetch_assoc()) {
 $idLabgroup= $foundID['Labgroup_idLabgroup'];
  array_push($ls_idLabgroup, $idLabgroup);



}
# CREATE A NEW STORAGE ENTRY --------------------------------------------------#
if (isset($_POST['reg_labgroup'])) {
  $create_labgroupname = mysqli_real_escape_string($db, $_POST['createLabgroupname']);


  if (empty($create_labgroupname)) {
    array_push($errors, "Unable to add Labgroup. Name is required");}

  if (count($errors) == 0) {
    // CHECK  IF STORAGE ENTRY ALREADY EXISTS
    $res_findLabgroup = labgroupexists($db, $create_labgroupname);

    if ($res_findLabgroup) {
      if ($res_findLabgroup->num_rows === 0){ // no freezer with this name exists yet
        // CREATE NEW labgroup
        $queryNewLabgroup = "INSERT INTO Labgroup (Labgroupname)
                  VALUES ('$create_labgroupname')";
        mysqli_query($db, $queryNewLabgroup) or die(mysqli_error($db));


        // CHECK THAT ENTRY WAS MADE
        $res_LabgroupMade = labgroupexists($db, $create_labgroupname);
        if ($res_LabgroupMade) {
          if ($res_LabgroupMade->num_rows === 0){ // labgroupname is not in db ;
            array_push($errors, "No Lab group was created. An unexpected Error occured. Please try again.");;
          } else { // labgroupname is in db ;
            // CONNECT U and S
            connectUserLabgroup($db, $res_LabgroupMade, $add_labgroupname);
          }
        }
      } else {
        array_push($errors, "A Lab Group with this name already exists. Click 'Add existing Lab Group' or choose different name");
      }
    }
  }
} # end reg_labgroup
# END: NEW labgroup ENTRY ------------------------------------------------------#


# ADD AN EXISTING labgroup ENTRY -----------------------------------------------#
if (isset($_POST['add_labgroup'])) {
  $add_labgroupname = mysqli_real_escape_string($db, $_POST['addLabgroupname']);

  if (empty($add_labgroupname)) {
    array_push($errors, "Unable to add existing Lab group. Name is required");}

  if (count($errors) == 0) {
      // MAKE SURE THAT ENTRY EXISTS
      $resLabExis = labgroupexists($db, $add_labgroupname);

      if ($resLabExis) {
        if ($resLabExis->num_rows === 0){ // labgroupname is not in db yet;
          array_push($errors, "This Lab Group is not yet registered in the System. Make a new entry using 'Create New Lab Group'");;
        } else {
          connectUserLabgroup($db, $resLabExis, $add_labgroupname);
        }
      }
  }
}
# END ADD AN EXISTING labgroup ENTRY -------------------------------------------#

# END: NEW STORAGE ENTRY ------------------------------------------------------#


# ADD AN EXISTING STORAGE ENTRY -----------------------------------------------#
if (isset($_POST['add_labgroup'])) {
  $add_labgroupname = mysqli_real_escape_string($db, $_POST['addLabgroupname']);

  if (empty($add_labgroupname)) {
    array_push($errors, "Unable to add existing Lab group. Name is required");}

  if (count($errors) == 0) {
      // MAKE SURE THAT ENTRY EXISTS
      $resLabExis = labgroupexists($db, $add_labgroupname);

      if ($resLabExis) {
        if ($resLabExis->num_rows === 0){ // Storagename is not in db yet;
          array_push($errors, "This Lab Group is not yet registered in the System. Make a new entry using 'Create New Lab Group'");;
        } else {
          connectUserLabgroup($db, $resLabExis, $add_labgroupname);
        }
      }
  }
}
# END ADD AN EXISTING STORAGE ENTRY -------------------------------------------#


// NEW REQUEST
if (isset($_POST['reg_request'])) {

  // receive all input values from the entry form
  $samplename = mysqli_real_escape_string($db, $_POST['samplename']);
  $celltype = mysqli_real_escape_string($db, $_POST['celltype']);
  $amount = mysqli_real_escape_string($db, $_POST['amount']);
  $comment = mysqli_real_escape_string($db, $_POST['comment']);
  $position = mysqli_real_escape_string($db, $_POST['position']);
  $requestdate = mysqli_real_escape_string($db, $_POST['requestdate']);
  $availability = mysqli_real_escape_string($db, $_POST['availability']);
  $idLabgroup = mysqli_real_escape_string($db, $_POST['idLabgroup']);


// entry validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($samplename)) { array_push($errors, "Sample name is required"); }
  if (empty($celltype)) { array_push($errors, "Cell type is required"); }
  if (empty($position)) { array_push($errors, "Position is required"); }
  if (empty($amount)) { array_push($errors, "Amount is required"); }
  if (empty($requestdate)) { array_push($errors, "Request date is required"); }
  if (empty($idLabgroup)) { array_push($errors, "Please select a valid Labgroup"); }

  // Finally, add the new entry in the sample table
  if (count($errors) == 0) {
  	$query = "INSERT INTO Request (Name, Cell_type, Amount, Comment, Position, Requestdate, Availability, idUser, idLabgroup)
  			  VALUES('$samplename', '$celltype', '$amount', '$comment', '$position', '$requestdate', '$availability', '".$_SESSION["userdata"]["idUser"]."', '$idLabgroup')";
    print($query);
    mysqli_query($db, $query) or die(mysqli_error($db));

  }
}


?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<?php include('header.html') ?>

        <div class="hero">
					<div class="jumbotron text-center" style="margin-bottom: 0px;">
		          <h1>New Request <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                  <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
                </svg></h1>
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
                            <br>
                            <div class="col-sm-3 d-sm-flex align-items-center">
                                <label class="m-sm-0">For who are these tubes?</label>
                                <select name="availability" class="custom-select"
                                    <option selected>Private</option>
                                    <option value="Private">Private</option>
                                    <option value="Ask me first">Ask me first</option>
                                    <option value="Public">Public</option>
                                  </select>
                            </div>
                        </div>

                        <div class="row">
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

                          <div class="col-sm-3 d-sm-flex align-items-center">
                            <label class="m-sm-0">Position</label>
                            <input
                              type="text"
                              name="position"
                              class="form-control ml-sm-2"
                              placeholder="it must go on rack 9-7A"
                              value="<?php echo $position; ?>"
                            >
                        </div>

                              <br>

                              <!-- DISPLAY CONNECTED labgroupS -->

                              <div class="input-group">
                                <label for="idLabgroup">Labgroup:</label>
                                <select name='idLabgroup'>
                                  <?php
                                  foreach($ls_idLabgroup as $idLabgroup) {
                                    $labgroup_sql = "SELECT * FROM Labgroup WHERE idLabgroup = '$idLabgroup'";
                                    $res_labgroup =mysqli_query($db, $labgroup_sql) or die(mysqli_error($db));
                                      while ($labgroupEntry = $res_labgroup->fetch_assoc()){
                                        ?><option value='<?php echo $labgroupEntry['idLabgroup']; ?>'><?php echo $labgroupEntry['Labgroupname']; ?></option><?php
                                      }
                                  }?>
                                  <option selected >nothing selected</option>;
                                </select>
                              </div>
                          </div>
                    <div class="row">
                        <div class="px-sm-2 col-sm-7 d-sm-flex align-items-center mt-2 mt-sm-0">
                          <label for="exampleFormControlTextarea1">Comments</label>
                          <textarea class="form-control"
                          id="description"
                          rows="10"
                          name="comment"
                          placeholder=" (Recomended) Use that one protocol that works better, place it in the fridge at the end of the corridor, position right, IMPORTANT I NEED THIS TO BE DONE BY 15:30"
                          ><?php echo $comment; ?></textarea>
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-3 col-md-12">
                    <button type="submit" class="btn btn-success" name="reg_request">Add Request <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus" viewBox="0 0 16 16">
                  <path d="M8 6.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 .5-.5z"/>
                  <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                </svg></button>
                </form>


                <div class="col-3 col-md-3">
              <form method="post" action="request_res.php">
              <button type="submit" class="btn btn-primary" name="see_request">SEE Request <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg></button>
            </form>
        </div>
    </div>

    </div>
    <br>




            <!--- CREATE_BUTTON: THIS IS CREATING A NEW LAB GROUP---------------------------------------------------------------------------------------------------------------------------->
            <div class="col-2 col-md-3">

            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_create">Create NEW Lab Group <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
              <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
              <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg></button>
        <div id="myModal_create" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h5 class="modal-title">Create new labgroup
                </div>
                <div class="modal-body">
                  <label>Labgroup name: </label>
                  <input type="text" placeholder='New Labgroup Name' name="createLabgroupname" value="<?php echo $create_labgroupname; ?>">

                  <button type="submit" class="btn btn-success" name="reg_labgroup">Create new Labgroup</button>

          </div>
      </div>

        </div>
      </div>
    </div>


                    <!--- ADD_BUTTON: THIS IS ADDING AN EXISTING ALREADY THERE LABGROUP --------------------------------------------------------------------------------------------------------------------->
                    <div class="col-3 col-md-2">

                                                <button style="position: relative;"type="button" class="btn btn-warning " data-toggle="modal" data-target="#myModal">Add EXISTING Labgroup


                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                                </svg></button>
                    					      <div id="myModal" class="modal fade" role="dialog">
                    					            <div class="modal-dialog">

                    					              <!-- Modal content-->
                    					              <div class="modal-content">
                    					                <div class="modal-header">
                    					                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                    					                  <h5 class="modal-title">Add existing labgroup</h5>
                    					                </div>
                    					                <div class="modal-body">
                    					                  <input type="text" placeholder='Name of existing Storage' name="addLabgroupname" value="<?php echo $add_labgroupname; ?>">
                    					                  <button type="submit" class="btn" name="add_labgroup">Add EXISTING Lab Group</button>
                    					                </div>
                    					              </div>
                    					            </div>
                    					          </div>
                                              </div>
                                          </div>


                                              <br>


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
