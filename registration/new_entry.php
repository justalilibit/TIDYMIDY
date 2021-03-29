<?php

include('server.php');

print("<br><br><br><br>");

# GET STORAGEIDs CONNECTED TO CURRENT USER ------------------------------------#
$ls_idStorages = array(); // array holding the storageIDs of our current user
$query_storageids = "SELECT * FROM User_has_Storage
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";
$resStorIDs = mysqli_query($db,$query_storageids) or die(mysqli_error($db));

while ($foundID = $resStorIDs->fetch_assoc()) {
  $idnumber = $foundID['Storage_idStorage'];
  array_push($ls_idStorages, $idnumber);
}


# CREATE A NEW STORAGE ENTRY --------------------------------------------------#
if (isset($_POST['reg_storage'])) {
  #printf("INSIDE STORAGE");
  $storagename = mysqli_real_escape_string($db, $_POST['Storagename']);
  if (empty($storagename)) { array_push($errors, "ID storage is required"); }

  if (count($errors) == 0) {
    $queryStoExis = "SELECT * FROM Storage
                      WHERE Storagename = '$storagename'"; // Check see if Storage already exists
    $resStorExis = mysqli_query($db,$queryStoExis) or die(mysqli_error($db));

    if(!empty($resStorExis)) { // Storagename already exists
      array_push($errors, "Cannot create new Storage! A storage with this name already exists. Click 'Add existing storage' or choose different name");

    } else { // storagename does not exist yet. Create entry and connect with User
    // CREATE NEW STORAGE
    $storagename = mysqli_real_escape_string($db, $_POST['Storagename']);
    $location = mysqli_real_escape_string($db, $_POST['Location']);
    print($storagename); print($location);
  #  $query_newstorage = "INSERT INTO Storage ()";
    }
    // $queryConnectU_S = "INSERT INTO User_has_Storage (User_idUser, Storage_idStorage)
    //            VALUES ('".$_SESSION["userdata"]["idUser"]."', '$idStorage')";
    //  mysqli_query($db, $queryConnectU_S) or die(mysqli_error($db));

  }
}

$t = array();

# ADD AN EXISTING STORAGE ENTRY -----------------------------------------------#
if (isset($_POST['add_storage'])) {
  print("ADDED STORAGE PRESSED<br>");
  $storagename = mysqli_real_escape_string($db, $_POST['Storagename']);
  if (empty($storagename)) {
    array_push($errors, "ID storage is required"); }

  if (count($errors) == 0) {
    // Query to see if Storage already exists
    $queryStoExis = "SELECT * FROM Storage
                      WHERE Storagename = '$storagename'";
    $resStorExis = mysqli_query($db,$queryStoExis) or die(mysqli_error($db));

    if(!empty($resStorExis)); // if Storage already exists link its id to Userid
      connectUserStorage($db, $resStorExis);
  } else{
   array_push($errors, "This Storage is not yet registered in the System. Make a new entry using 'Create New Storage'");;
 }
}

# FUNCTION connecting current User to Storage that fits the prerun query ------#
 function connectUserStorage($db, $res_foundStor) {
   $idStorage ="";
   while($storage = $res_foundStor->fetch_assoc()){
     $idStorage = $storage["idStorage"];
   }
   // create query for connecting User and Freeezer and run it
   $queryConnectU_S = "INSERT INTO User_has_Storage (User_idUser, Storage_idStorage)
             VALUES ('".$_SESSION["userdata"]["idUser"]."', '$idStorage')";
   mysqli_query($db, $queryConnectU_S) or die(mysqli_error($db));
 }

 # CREATE A NEW ENTRY #--------------------------------------------------------#
 if (isset($_POST['reg_entry'])) {
   // receive all input values from the entry form
   $samplename = mysqli_real_escape_string($db, $_POST['samplename']);
   $celltype = mysqli_real_escape_string($db, $_POST['celltype']);
   $idStorage = mysqli_real_escape_string($db, $_POST['idStorage']);
   $position = mysqli_real_escape_string($db, $_POST['position']);
   $amount = mysqli_real_escape_string($db, $_POST['amount']);
   $frozendate = mysqli_real_escape_string($db, $_POST['frozendate']);
   $availability = mysqli_real_escape_string($db, $_POST['availability']);
   $comment = mysqli_real_escape_string($db, $_POST['comment']);

   // entry validation: ensure that the form is correctly filled ...
   // by adding (array_push()) corresponding error unto $errors array
   if (empty($samplename)) { array_push($errors, "Sample name is required"); }
   if (empty($celltype)) { array_push($errors, "Cell type is required"); }
   if (empty($position)) { array_push($errors, "Position is required"); }
   // if (empty($amount)) { array_push($errors, "Amount is required"); }
   if (empty($frozendate)) { array_push($errors, "Frozen date is required"); }


   // Finally, add the new entry in the sample table
   if (count($errors) == 0) {
   	$query = "INSERT INTO Sample (Name, Cell_type, idStorage,  Position, Frozendate, Amount, Availability, Comment, idUser)
   			  VALUES('$samplename', '$celltype', '$idStorage', '$position', '$frozendate', '$amount', '$availability', '$comment','".$_SESSION["userdata"]["idUser"]."')";
     # print("<br><br><br>");
     # print($query);
     mysqli_query($db, $query) or die(mysqli_error($db));


   }
 }
 # END: CREATE A NEW ENTRY #----------------------------------------------------#


?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
<?php include('header.html') ?>



        <div class="hero">
					<div class="jumbotron text-center" style="margin-bottom: 0px;">
		          <h1>New Entry <img style="width:75px;"  src="img/eppp.png" alt=""> </h1>
		          <p>Add your tubes to the system, before you forget where you put them!</p>
		      </div>

					<div class="container">
						<form method="post" action="new_entry.php">
							<?php include('error.php'); ?>
							<h2>Enter the details of your sample</h2>


                                    <div class="row">
                                      <div class="col-sm-3 d-sm-flex align-items-center">
                                        <label class="m-sm-0">Tube name</label>
                                        <input
                                          type="text"
                                          name="samplename"
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
                                        class="form-control ml-sm-2"
                                        placeholder="1"
                                        value="<?php echo $amount; ?>"
                                        >
                                    </div>
                                    <div class="col-sm-3 d-sm-flex align-items-center">
                                        <label class="m-sm-0">For who are these tubes?</label>
                                        <select name="availability" class="custom-select"
                                            <option selected>Private</option>
                                            <option value="1">Private</option>
                                            <option value="2">Ask me first</option>
                                            <option value="3">Public</option>
                                          </select>
                                    </div>
                                </div>

                                <div class="row">
                                <div class="col-sm-3 d-sm-flex align-items-center">
                                  <label class="m-sm-0">Position</label>
                                  <input
                                    type="text"
                                    name="position"
                                    class="form-control ml-sm-2"
                                    placeholder="rack 9, 7A // left side // first drawer"
                                    value="<?php echo $position; ?>"
                                    >
                                </div>

                                <div class="col-sm-3 d-sm-flex align-items-center">
                                  <label class="m-sm-0">Date</label>
                                  <input
                                    type="text"
                                    name="frozendate"
                                    class="form-control ml-sm-2"
                                    placeholder="dd/mm/yyyy"
                                    value="<?php echo $frozendate;?>"
                                    >
                                </div>

                                <div class="input-group">
                                    <br>

                                   <label for="Storage">Select Storage / Freezer</label>
                                   <?php
                                       $sql = "Select * from Storage";
                                       $result = mysqli_query($db, $sql);
                                       echo "<select name='unitid'>";
                                       echo "<option value='empty'></option>";
                                       while ($row = mysqli_fetch_array($result)) {
                                            echo "<option value='" .$row['idStorage']."'> ".$row['Storagename']. "</option>"; #   We could add this here to print not just Storagename but also location: $row['Location'] .
                                       }
                                       echo "</select>";
                                           ?>
                               </div>

                                <div class="px-sm-2 col-sm-7 d-sm-flex align-items-center mt-2 mt-sm-0">
                                  <label for="exampleFormControlTextarea1">Comments</label>
                                  <textarea class="form-control"
                                  rows="10"
                                  name="comment"
                                  value="<?php echo $comment; ?>"
                                  placeholder="Use that one protocol that works better, place it in the fridge at the end of the corridor, position right, IMPORTANT I NEED THIS TO BE DONE BY 15:30"
                                  ></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                            <button type="submit" class="btn btn-success " name="reg_entry">Add entry
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                              <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                              <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                            </svg></button>
                            <br>
                            <br>
                            <button style="position: relative;"type="button" class="btn btn-warning " data-toggle="modal" data-target="#myModal">Add Storage
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg></button>
					      <div id="myModal" class="modal fade" role="dialog">
					            <div class="modal-dialog">


					              <!-- Modal content-->
					              <div class="modal-content">
					                <div class="modal-header">
					                  <button type="button" class="close" data-dismiss="modal">&times;</button>
					                  <h5 class="modal-title">Add storage</h5>
					                </div>
					                <div class="modal-body">
					                  <input type="text" name="Location" value="<?php echo $Location; ?>">
					                  <button type="submit" class="btn" name="reg_storage">Add</button>
					                </div>
					              </div>
					            </div>
					          </div>
                          </div>

					                  <h5 class="modal-title">Add new Storage</h5>
					                </div>
					                <div class="modal-body">
					                  <input type="text" name="Storagename" value="<?php echo $storagename; ?>">
					                  <button type="submit" class="btn btn-success" name="reg_storage">Add</button>
					                </div>

					              </div>
					            </div>
					          </div>
					        </div>





  		</form>
  	</div>
		<div class="container">
			<h3>How it works:</h3>
				<p>Use this form to add the tubes you froze. You can choose, how others see your entries in the search field. <br>
				<strong>Private:</strong> Just you can access the entry<br>
				<strong>Ask me first:</strong> Others have to ask permission<br>
				<strong>Public:</strong> Everyone may access the entry</p>
                <p><button type="submit" class="btn btn-success " name="reg_entry" disabled>Add entry
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                  <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                  <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                </svg></button> : adds a new tube to an existing freezer
                <p><button type="button" class="btn btn-warning " data-toggle="modal" data-target="#myModal" disabled>Add Storage</button> : Creates a new space to hold tubes or whatever you like</p>

		</div>

        <?php include('footer.html') ?>

  </div>

</body>
</html>


# LILILS BUTTONS AND OPTION STORAGE SELECT THINGY

              <!-- DISPLAY CONNECTED STORAGES -->
              <div class="input-group">
                <label for="idStorage">Storage:</label>
                <select name='idStorage'>
                  <option>Select Storage</option>
                  <?php
                  foreach($ls_idStorages as $idStorage) {
                    $storage_sql = "SELECT * FROM Storage WHERE idStorage = '$idStorage'";
                    $res_storage =mysqli_query($db, $storage_sql) or die(mysqli_error($db));
                      while ($storageEntry = $res_storage->fetch_assoc()){
                        ?><option value='<?php echo $storageEntry['idStorage']; ?>'><?php echo $storageEntry['Storagename']; ?></option><?php
                      }
                  }?>
                </select>
              </div>


              <!-- CREATE NEW STORAGE ENTRY -->
							  <button type="button" class="btn" data-toggle="modal" data-target="#myModal">Create new storage</button>
					      <div id="myModal" class="modal fade" role="dialog">
					        <div class="modal-dialog">
					            <!-- Modal content-->
					            <div class="modal-content">
					              <div class="modal-header">
					                <button type="button" class="close" data-dismiss="modal">&times;</button>
					                <h5 class="modal-title">Create new storage</h5>
					              </div>
					              <div class="modal-body">
                          <label>Storage name: </label>
                          <input type="text" name="Storagename" value="<?php echo $storagename; ?>">
                          <label>Storage location: </label>
                          <input type="text" name="Location" value="<?php echo $location; ?>">
					                <button type="submit" class="btn btn-success" name="reg_storage">Create new storage</button>



                 <!-- ADD EXISTING STORAGE-->
                  <button type="button" class="btn" data-toggle="modal" data-target="#myM">Add existing storage</button>
      					    <div id="myM" class="modal fade" role="dialog">
      					        <div class="modal-dialog">
      					             <!-- Modal content-->
      					          <div class="modal-content">
      					            <div class="modal-header">
      					                 <button type="button" class="close" data-dismiss="modal">&times;</button>
      					                 <h5 class="modal-title">Add new storage</h5>
      					            </div>
      					            <div class="modal-body">
      					                 <input type="text" name="Addstorage" value="<?php echo $storagename; ?>">
      					                 <button type="submit" class="btn btn-success" name="add_storage">Add existing storage</button>
      					            </div>
      					          </div>
      					        </div>
      					      </div>
