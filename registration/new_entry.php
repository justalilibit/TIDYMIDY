<?php

include('server.php');
# print("<br><br><br><br>");

# LOAD STORAGEIDs CONNECTED TO CURRENT USER -----------------------------------#
$ls_idStorages = array(); // array holding the storageIDs of our current user
$query_storageids = "SELECT * FROM User_has_Storage
                      WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
                        ";
$resStorIDs = mysqli_query($db,$query_storageids) or die(mysqli_error($db));

while ($foundID = $resStorIDs->fetch_assoc()) {
  $idStorage = $foundID['Storage_idStorage'];
  array_push($ls_idStorages, $idStorage);
#  print("Your User is connected to Freezers with ID: "); print($idStorage);
}

# CREATE A NEW STORAGE ENTRY --------------------------------------------------#
if (isset($_POST['reg_storage'])) {
  $create_storagename = mysqli_real_escape_string($db, $_POST['createStoragename']);

  if (empty($create_storagename)) {
    array_push($errors, "Unable to add existing Storage. Name is required");}

  if (count($errors) == 0) {
    // CHECK  IF STORAGE ENTRY ALREADY EXISTS
    $res_findStorage = storageexists($db, $create_storagename);

    if ($res_findStorage) {
      if ($res_findStorage->num_rows === 0){ // no freezer with this name exists yet
        // CREATE NEW STORAGE
        $create_location = mysqli_real_escape_string($db, $_POST['createLocation']);
        $queryNewStorage = "INSERT INTO Storage (Storagename, Location)
                  VALUES ('$create_storagename', '$create_location')";
        mysqli_query($db, $queryNewStorage) or die(mysqli_error($db));

        // CHECK THAT ENTRY WAS MADE
        $res_storageMade = storageexists($db, $create_storagename);
        if ($res_storageMade) {
          if ($res_storageMade->num_rows === 0){ // Storagename is not in db ;
            array_push($errors, "No Storage was created. An unexpected Error occured. Please try again.");;
          } else { // Storagename is in db ;
            // CONNECT U and S
            connectUserStorage($db, $res_storageMade);
          }
        }
      } else {
        array_push($errors, "A storage with this name already exists. Click 'Add existing storage' or choose different name");
      }
    }
  }
} # end reg_storage
# END: NEW STORAGE ENTRY ------------------------------------------------------#



# ADD AN EXISTING STORAGE ENTRY -----------------------------------------------#
if (isset($_POST['add_storage'])) {
  $add_storagename = mysqli_real_escape_string($db, $_POST['addStoragename']);

  if (empty($add_storagename)) {
    array_push($errors, "Unable to add existing Storage. Name is required");}

  if (count($errors) == 0) {
      // MAKE SURE THAT ENTRY EXISTS
      $resStorExis = storageexists($db, $add_storagename);

      if ($resStorExis) {
        if ($resStorExis->num_rows === 0){ // Storagename is not in db yet;
          array_push($errors, "This Storage is not yet registered in the System. Make a new entry using 'Create New Storage'");;
        } else {
          connectUserStorage($db, $resStorExis);
        }
      }
  }
}
# END ADD AN EXISTING STORAGE ENTRY -------------------------------------------#

# FUNCTION to check if Storagename already exists -----------------------------#
function storageexists($db, $storagename) {
  // function to see if Storagename already exists. returns result object or
  $query = "SELECT * FROM Storage
                    WHERE Storagename = '$storagename'";
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
  return $result;
}

# FUNCTION to check if User already connected to Storage ----------------------#
function alreadyconnected($db, $idStorage) {
  $query = "SELECT * FROM User_has_Storage
            WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
            AND Storage_idStorage = '$idStorage'
            ";
            // print($query);
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
  return $result;
}

# FUNCTION connecting current User to Storage that fits the prerun query ------#
 function connectUserStorage($db, $res_foundStor) {
   $idStorage ="";
   while($storage = $res_foundStor->fetch_assoc()){
     $idStorage = $storage["idStorage"];
   }
   $alreadyexists = alreadyconnected($db, $idStorage);

   if ($alreadyexists) {
     if ($alreadyexists->num_rows === 0){ // User and Storage not yet connected
       // connecting User and Storage
       $queryConnectU_S = "INSERT INTO User_has_Storage (User_idUser, Storage_idStorage)
                 VALUES ('".$_SESSION["userdata"]["idUser"]."', '$idStorage')";
       mysqli_query($db, $queryConnectU_S) or die(mysqli_error($db));
    }
  }
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
   if (empty($samplename)) { array_push($errors, "Sample name is required"); }
   if (empty($celltype)) { array_push($errors, "Cell type is required"); }
   if (empty($position)) { array_push($errors, "Position is required"); }
   if (empty($amount)) { array_push($errors, "Amount is required"); }
   if (empty($frozendate)) { array_push($errors, "Frozen date is required"); }
   if (empty($idStorage)) { array_push($errors, "Please select a valid Storage"); }
   #if (!is_int($idStorage)) { array_push($errors, "Please select a valid Storage"); print($idStorage); }


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

      <script language="JavaScript" type="text/javascript">

      function checkDelete(){
          return confirm('Are you sure?');
      }
      </script>

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
                                            <option selected>Privat</option>
                                            <option value="1">Privat</option>
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
                                    <!-- DISPLAY CONNECTED STORAGES -->
                                    <div class="input-group">
                                      <label for="idStorage">Storage:</label>
                                      <select name='idStorage'>
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

<!--- THIS IS ADDING THE ENTRY --------------------------------------------------------------------------------------------------------------------->
                            <div class="input-group">
                            <button type="submit" onclick="return checkDelete()" class="btn btn-success " name="reg_entry">Add entry
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-plus" viewBox="0 0 16 16">
                              <path fill-rule="evenodd" d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
                              <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                              <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                            </svg></button>
                            <br>
                            <br>
<!--- ADD_BUTTON: THIS IS ADDING AN EXISTING ALREADY THERE STORAGE --------------------------------------------------------------------------------------------------------------------->

                            <button style="position: relative;"type="button" class="btn btn-warning " data-toggle="modal" data-target="#myModal">Add EXISTING Storage
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                              <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                            </svg></button>
					      <div id="myModal" class="modal fade" role="dialog">
					            <div class="modal-dialog">

					              <!-- Modal content-->
					              <div class="modal-content">
					                <div class="modal-header">
					                  <button type="button" class="close" data-dismiss="modal">&times;</button>
					                  <h5 class="modal-title">Add existing storage</h5>
					                </div>
					                <div class="modal-body">
					                  <input type="text" placeholder='Name of existing Storage' name="addStorage" value="<?php echo $add_storagename; ?>">
					                  <button type="submit" class="btn" name="add_storage">Add EXISTING storage</button>
					                </div>
					              </div>
					            </div>
					          </div>
                          </div>

                          <br>
<!--- CREATE_BUTTON: THIS IS CREATING A NEW STORAGE ---------------------------------------------------------------------------------------------------------------------------->

                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_create">Create NEW storage <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                        <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                      </svg></button>
                                <div id="myModal_create" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                          <h5 class="modal-title">Create new storage
                                        </div>
                                        <div class="modal-body">
                                          <label>Storage name: </label>
                                          <input type="text" placeholder='New Storage Name' name="createStoragename" value="<?php echo $create_storagename; ?>">
                                          <label>Storage location: </label>
                                          <input type="text" placeholder='New Storage Location' name="createLocation" value="<?php echo $create_location; ?>">
                                          <button type="submit" class="btn btn-success" name="reg_storage">Create new storage</button>

					              </div>
					            </div>
					          </div>
					        </div>

  		</form>
  	</div>

<!-- EXPLAINING THE BUTTONS  -->

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
              </svg></button> : Adds a new tube to an existing freezer</p>

              <button style="position: relative;"type="button" class="btn btn-warning " data-toggle="modal" data-target="#myModal" disabled>Add EXISTING Storage
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
              </svg></button> : Creates a new space to hold tubes or whatever you like</p>

                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" disabled>Create NEW storage <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                </svg></button> : Creates a new space where you will be able to place new tubes

		</div>
        <br>
        <br>
        <?php include('footer.html') ?>

  </div>

</body>
</html>
