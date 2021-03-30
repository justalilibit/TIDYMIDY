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
$create_storagename = $create_location = $add_storagename = "";
$errors_registration = array('username' => '', 'email' => '', 'password_1' => '', 'password_2' => '', 'fullname' => '', 'cemail' => '', 'cphone' => '');
// connect to the database
 $db = mysqli_connect('localhost', 'albert', '/Puiyuaru1616', 'mydb');   # albert pw
// $db = mysqli_connect('localhost', 'tidytubes', 'Welcome123%', 'mydb');    # jo & lili pw




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
