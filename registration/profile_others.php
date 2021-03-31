<?php include('server.php');
print("<br><br><br>");
print("THIS WAS PASSED:");
print($idOwner);

$query = "SELECT * FROM User WHERE Username='$idOwner'";
$results = mysqli_query($db, $query) or die(mystringsqli_error($db));
while($row = $results->fetch_assoc()) {
    $idOwner = $row["idUser"];
    $Full_name = $row["Full_name"];
    $Position = $row["Position"];
    $Main_task = $row["Main_task"];
    $Contact_email = $row["Contact_email"];
    $Contact_phone = $row["Contact_phone"];
    $Institute = $row["Institute"];
    $Find_me = $row["Find_me"];
}

# LOAD STORAGEIDs CONNECTED TO THIS PROFILE -----------------------------------#
$ls_idStorages = array(); // array holding the storageIDs of our current user
$query_storageids = "SELECT * FROM User_has_Storage
                      WHERE User_idUser = '$idOwner'
                      ";
$resStorIDs = mysqli_query($db,$query_storageids) or die(mysqli_error($db));

while ($foundID = $resStorIDs->fetch_assoc()) {
  $idStorage = $foundID['Storage_idStorage'];
  array_push($ls_idStorages, $idStorage);
#  print("Your User is connected to Freezers with ID: "); print($idStorage);
}

# LOAD LABGROUPIDs CONNECTED TO THIS PROFILE  ---------------------------------#
$ls_idLabgroup = array(); // array holding the requestIDs of our current user
$query_labgroupids = "SELECT * FROM User_has_Labgroup
                      WHERE User_idUser = '$idOwner'
                        ";

$resResIDs = mysqli_query($db,$query_labgroupids) or die(mysqli_error($db));

while ($foundID = $resResIDs->fetch_assoc()) {
 $idLabgroup= $foundID['Labgroup_idLabgroup'];
  array_push($ls_idLabgroup, $idLabgroup);
}


// if(isset($_POST['submit'])){
//         $ptofile_pic= $_FILES['file'];
//
//         $file_name = $_FILES['file']['name'];
//         $file_tmp_name = $_FILES['file']['tmp_name'];
//         $file_size= $_FILES['file']['size'];
//         $file_type = $_FILES['file']['error'];
//         $file_error = $_FILES['file']['type'];
//
//         $fileEXT = explode('.', $filename);
//         $file_actual_EXT = strtolower(end($fileEXT));
//
//         $allowed = array('jpg', 'jpeg', 'png' );
//
//         if(in_array($file_actual_EXT, $allowed)){
//             if ($file_error === 0) {
//                 if ($file_size < 100000){
//                     $file_new_name = uniqid( '', true).".".$file_actual_EXT;
//                     $file_destination = '';
//                 } else {
//                     echo "The file file is WAY TOO BIG OMG";
//                 }string
//             } else {
//             echo "The file coudnt been uploaded";
//             }
//         } else
//
//         echo "This type of file is not allowed";
// }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <title></title>
    <body>
        <?php include('header.html') ?>
        <br>
<br>
<br>
<div class="container">
    <div class="sidebar">
        <div class="sidebar-top">
            <img class="profile-image" src="img/default_profile_pic.jpg" />
            <div style=" background-color: rgba(46, 49, 49, 0.5);" class="profile-basic">
                <h1 class="name"><?php echo $Full_name; ?></h1>
                <h4 class="designation"> <?php echo $Position; ?></h4>
            </div>
        </div>
        <div class="profile-info">
            <p class="key"> Main task: </p>
            <p class="value"><?php echo $Main_task; ?></p>
        </div>
        <div class="profile-info">
            <p class="key">Contact phone : </p>
            <p class="value"><?php echo $Contact_phone; ?></p>
        </div>

        <div class="profile-info">
            <p class="key" >Contact email : </p>
            <p class="value" ><?php echo $Contact_email; ?></p>
        </div>

        <div class="profile-info">
            <p class="key" >Usually you can find me... </p>
            <p class="text-left"><?php echo wordwrap($Find_me, 35, "<br>"); ?>
            </p>
        </div>

        <div class="profile-info">
            <p class="key" >Institution / Research group: <br> </p>
            <p class="value" > <?php echo $Institute; ?><br/>
            </p>
        </div>
        <div class="profile-info">
            <p class="key" >Change profile picture: </p>
        <form class="text-left" action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file" value="Post">
            <button class="btn btn-success text-center" type="submit" name="submit">UPLOAD</button>
        </form>
    </div>

    </div>

    <div class="content">


            <div class="content">
                <div class="work-experience">
                    <h1 class="heading"> MY STUFF</h1>
                    <div class="info">
                        <p class="sub-heading">My Lab Groups</p>
                        <ul name='idLabgroup'>
                          <?php
                          foreach($ls_idLabgroup as $idLabgroup) {
                            $labgroup_sql = "SELECT * FROM Labgroup WHERE idLabgroup = '$idLabgroup'";
                            $res_labgroup =mysqli_query($db, $labgroup_sql) or die(mysqli_error($db));
                              while ($labgroupEntry = $res_labgroup->fetch_assoc()){
                                ?><li value='<?php echo $labgroupEntry['idLabgroup']; ?>'><?php echo $labgroupEntry['Labgroupname']; ?></li><?php
                              }
                          }?>
                        </ul>
                    </div>
                    <div class="info">
                        <p class="sub-heading">My Storages</p>
                          <ul id="idStorage">
                          <?php
                          foreach($ls_idStorages as $idStorage) {
                            $storage_sql = "SELECT * FROM Storage WHERE idStorage = '$idStorage'";
                            $res_storage =mysqli_query($db, $storage_sql) or die(mysqli_error($db));
                              while ($storageEntry = $res_storage->fetch_assoc()){
                                ?><li value='<?php echo $storageEntry['idStorage']; ?>'><?php echo $storageEntry['Storagename']; ?></li><?php
                              }
                          }?>
                          </ul>
                    </div>
        <div class="work-experience">
            <h1 class="heading"> MY STUFF</h1>
            <div class="info">
                <p class="sub-heading">My Lab Groups</p>
                <ul name='idLabgroup'>
                  <?php
                  foreach($ls_idLabgroup as $idLabgroup) {
                    $labgroup_sql = "SELECT * FROM Labgroup WHERE idLabgroup = '$idLabgroup'";
                    $res_labgroup =mysqli_query($db, $labgroup_sql) or die(mysqli_error($db));
                      while ($labgroupEntry = $res_labgroup->fetch_assoc()){
                        ?><li value='<?php echo $labgroupEntry['idLabgroup']; ?>'><?php echo $labgroupEntry['Labgroupname']; ?></li><?php
                      }
                  }?>
                </ul>
            </div>
            <div class="info">
                <p class="sub-heading">My Storages</p>
                  <ul id="idStorage">
                  <?php
                  foreach($ls_idStorages as $idStorage) {
                    $storage_sql = "SELECT * FROM Storage WHERE idStorage = '$idStorage'";
                    $res_storage =mysqli_query($db, $storage_sql) or die(mysqli_error($db));
                      while ($storageEntry = $res_storage->fetch_assoc()){
                        ?><li value='<?php echo $storageEntry['idStorage']; ?>'><?php echo $storageEntry['Storagename']; ?></li><?php
                      }
                  }?>
                  </ul>
            </div>
            <div class="info">
                <p class="sub-heading">My tubes</p>
                <form class="form-inline" method="post" action="search_res.php">
                    <div class="input-group">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-success" name="my_entries" disabled>Show all my Tubes</button>
                          </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style media="screen">

    .sidebar {
        width:30%;
        display: inline-block;
        margin-left: 0;
        background: #5da4d9;
        color: white;
    }

    img {
        width: 100%;
    }

    .sidebar-top { position: relative; }

    .profile-basic {
        position: absolute;
        bottom: 0px;
        left: 50px;
    }

    .profile-info {
        padding: 20px 10px;
        border-bottom: 1px solid #4783c2;
    }

     .profile-info p{
        margin-left: 10px;
        display: inline-block;
        vertical-align: top;
    }

    .profile-info .key{
        font-weight: bold;
    }

    .profile-info .value{
    }

    .social-media:hover{
        cursor: pointer;
        color: white;
    }

    .content {
        width: 65%;
        margin-left: 2%;
        display: inline-block;
        vertical-align: top;
    }

    .work-experience, .education {
        margin-bottom: 30px;
        padding: 5% 2% 5% 10%;
        background: white;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    }

    .info {
        padding: 2% 1%;
        border-bottom: 1px solid #bdbdbd;
    }


    .sub-heading {
  font-weight: bold;
}

    .duration {
        color: #5da4d9;
        font-size:12px;
    }

</style>

        <?php include('footer.html') ?>


    </body>
</html>
