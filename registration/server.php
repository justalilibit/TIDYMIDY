<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$table ="";       //result table for search
$keyword = $searchword = "";  //for simple search on index page
$errors = array();

$idSample = $samplename = $celltype = $position = $amount = $frozendate = $availability = $comment = $idOwner = $Location = $Contact_email = $Full_name = $Contact_phone = $Position = $Main_task = $Find_me = $Institute = '';
$idStorage = $storagename = $location = "";

$idLabgroup = $requestdate = $add_labgroupname = $create_labgroupname ="";
$create_storagename = $create_location = $add_storagename = "";
$errors_registration = array('username' => '', 'email' => '', 'password_1' => '', 'password_2' => '', 'fullname' => '', 'cemail' => '', 'cphone' => '');
$errors_entry = array('samplename' => '', 'position' => '', 'amount' => '', 'frozendate' => '', 'idStorage' => '');
// connect to the database
 # $db = mysqli_connect('localhost', 'albert', '/Puiyuaru1616', 'tidytubes');   # albert pw

 $db = mysqli_connect('localhost', 'tidytubes', 'Welcome123%', 'tidytubes');    # jo & lili pw



 # DEFINE FUNCTIONS:-----------------------------------------------------------#

 #----------------------------- STORAGE ---------------------------------------#

 # FUNCTION to check if Storagename already exists -----------------------------#
 function storageexists($db, $storagename) {
   // function to see if Storagename already exists. returns result object or
   $query = "SELECT * FROM Storage
                     WHERE Storagename = '$storagename'";
   $result = mysqli_query($db, $query) or die(mysqli_error($db));
   return $result;
 }

 # FUNCTION to check if User already connected to Storage ----------------------#
 function Stor_alreadyconnected($db, $idStorage) {
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
    $alreadyexists = Stor_alreadyconnected($db, $idStorage);

    if ($alreadyexists) {
      if ($alreadyexists->num_rows === 0){ // User and Storage not yet connected
        // connecting User and Storage
        $queryConnectU_S = "INSERT INTO User_has_Storage (User_idUser, Storage_idStorage)
                  VALUES ('".$_SESSION["userdata"]["idUser"]."', '$idStorage')";
        mysqli_query($db, $queryConnectU_S) or die(mysqli_error($db));
     }
   }
 }


 #---------------------------- LABGROUP ---------------------------------------#

# FUNCTION to check if labgroupname already exists ----------------------------#
function Labgroupexists($db, $labgroupname) {
  // function to see if labgroupname already exists. returns result object or
  $query = "SELECT * FROM Labgroup
                    WHERE Labgroupname = '$labgroupname'";
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
  return $result;

}


# FUNCTION to check if User already connected to labgroup ---------------------#
function alreadyconnected($db, $idLabgroup) {
  $query = "SELECT * FROM User_has_Labgroup
            WHERE User_idUser = '".$_SESSION["userdata"]["idUser"]."'
            AND Labgroup_idLabgroup = '$idLabgroup'
            ";
            // print($query);
  $result = mysqli_query($db, $query) or die(mysqli_error($db));
  return $result;

}


# FUNCTION connecting current User to labgroup that fits the prerun query -----#
 function connectUserLabgroup($db, $res_foundLab) {
   $idLabgroup ="";
   while($labgroup = $res_foundLab->fetch_assoc()){
     $idLabgroup = $labgroup["idLabgroup"];
   }
   $alreadyexists = alreadyconnected($db, $idLabgroup);


  if (empty($create_labgroupname)) {
    array_push($errors, "Unable to add Labgroup. Name is required");}

  if (count($errors) == 0) {
    // CHECK  IF STORAGE ENTRY ALREADY EXISTS
    $res_findLabgroup = labgroupexists($db, $create_labgroupname);

    if ($res_findLabgroup) {
      if ($res_findLabgroup->num_rows === 0){ // no freezer with this name exists yet
        // CREATE NEW STORAGE
        $queryNewLabgroup = "INSERT INTO Labgroup (Labgroupname)
                  VALUES ('$create_labgroupname')";
        mysqli_query($db, $queryNewLabgroup) or die(mysqli_error($db));

        // CHECK THAT ENTRY WAS MADE
        $res_LabgroupMade = labgroupexists($db, $create_labgroupname);
        if ($res_LabgroupMade) {
          if ($res_LabgroupMade->num_rows === 0){ // Storagename is not in db ;
            array_push($errors, "No Lab group was created. An unexpected Error occured. Please try again.");;
          } else { // Storagename is in db ;
            // CONNECT U and S
            connectUserLabgroup($db, $res_LabgroupMade);
          }
        }
      } else {
        array_push($errors, "A Lab Group with this name already exists. Click 'Add existing Lab Group' or choose different name");
      }
    }
  }
}

# END DEFINE FUNCTIONS -------------------------------------------------------#

#-----------------------------------------------------------------------------#


// NEW SEARCH

//if (isset($_POST['reg_search']))
//{
//   $name = $_POST['Name'];
//
//   $query = "SELECT * FROM Sample WHERE Name = '$name' ";
//   $query_run = mysqli_query($db, $query);
//
//   while($row = mysqli_fetch_array($query_run))
//   {
//     echo $row['Name'];
//     echo $row['Cell_type'];
//     echo $row['Frozendate'];
//     echo $row['Position'];
//     echo $row['Rack'];
//     echo $row['Availability'];
//     echo $row['Comment'];
//   }
// };



  //$fields_array = array('Name','Rack');
  //$conditions = array();
  //$query = "SELECT Name FROM Sample";
  //$result = mysqli_query($db, $query);
  //print("HERE <br> HERE <br> HERE <br>HERE <br>HERE <br>HERE <br>");

    //foreach ($fields_array as $field) {
      //if (isset($_POST[$field]) && $_POST[$field] != '') { // commented:
      //  $conditions[] = "$field LIKE '%" . mysqli_real_escape_string($db, $_POST[$field]) ."%'";
      //  //print $field;
      //}
    //};

    //if(count($conditions) > 0) {
    //  $query = $query . " WHERE " . implode(' OR ', $conditions);
    //};
    //print($query);
    //mysqli_query($db, $query) or die(mysqli_error($db));

    //echo "<table border='1'>";
    //while ($row = mysqli_fetch_assoc($result)) { // Important line !!! Check summary get row on array ..
      //  echo "<tr>";
      //  foreach ($row as $field => $value) { // I you want you can right this line like this: foreach($row as $value) {
        //    echo "<td>" . $value . "</td>"; // I just did not use "htmlspecialchars()" function.
      //  }
      //  echo "</tr>";
    //}
    //echo "</table>";
  //}




// ----------------------------------------------------------------------------------------//
// ----------------------------------------------------------------------------------------//
//                            PRINT ALL ENTRIES OF A TABLE
// ----------------------------------------------------------------------------------------//
// ----------------------------------------------------------------------------------------//
// LILI : THIS IS CODE THAT WILL PRINT YOU ALL ENTRIES IN THE TABLE "SAMPLE"

  // if (isset($_POST['reg_search'])) {
  //   $sql = "SELECT Name FROM Sample";
  //   $result = mysqli_query($db, $sql);
  //
  //   if (mysqli_num_rows($result) > 0) {
  //     // output data of each row
  //     echo "<table><tr><th>Sample Name</th><th>Add other features here later</th></tr>";
  //     // output data of each row
  //     while($row = $result->fetch_assoc()) {
  //       echo "<tr><td>".$row["Name"]."</td><td>"."This is lili's dummy"."</td></tr>";
  //     }
  //     echo "</table>";
  //
  //   } else {
  //     echo "0 results";
  //   }
  //   // empty results
  //   $result = $free_result();
?>
