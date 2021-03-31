<?php include('server.php');





$query = "SELECT * FROM User WHERE Username='".$_SESSION["username"]."' ";
$results = mysqli_query($db, $query) or die(mystringsqli_error($db));
while($row = $results->fetch_assoc()) {
    $Full_name = $row["Full_name"];
    $Position = $row["Position"];
    $Main_task = $row["Main_task"];
    $Contact_email = $row["Contact_email"];
    $Contact_phone = $row["Contact_phone"];
    $Institute = $row["Institute"];
    $Find_me = $row["Find_me"];
}
$_SESSION['fullname'] = $Full_name;


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
            <div class="profile-basic">
                <h1 class=" text-center"><?php echo $_SESSION["userdata"]["Full_name"]; ?></h1>
                <h4 class="text-center"> <?php echo $_SESSION["userdata"]["Position"]; ?></h4>
            </div>
        </div>
        <div class="profile-info">
            <p class="key"> Main task: </p>
            <p class="value"><?php echo $_SESSION["userdata"]["Main_task"]; ?></p>
        </div>
        <div class="profile-info">
            <p class="key">Contact phone : </p>
            <p class="value"><?php echo $_SESSION["userdata"]["Contact_phone"]; ?></p>
        </div>

        <div class="profile-info">
            <p class="key" >Contact email : </p>
            <p class="value" ><?php echo $_SESSION["userdata"]["Contact_email"]; ?></p>
        </div>

        <div class="profile-info">
            <p class="key" >Usually you can find me... </p>
            <p class="text-left"><?php echo wordwrap( $_SESSION["userdata"]["Find_me"], 35, "<br>"); ?>
            </p>
        </div>

        <div class="profile-info">
            <p class="key" >Institution / Research group: <br> </p>
            <p class="value" > <?php echo $_SESSION["userdata"]["Institute"]; ?><br/>
            </p>
        </div>
        <div class="profile-info">
            <p class="key" >Edit contact information: </p>
            <div class="text-center">
                <a href="profile_edit.php"> <button class="btn btn-warning" type="submit" name="submit"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                  <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                </svg></button></a>
            </div>
        </form>
    </div>

    </div>

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
            <div class="info">
                <p class="sub-heading">My tubes</p>
                <form class="form-inline" method="post" action="search_res.php">
                    <div class="input-group">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-success" name="my_entries">Show all my Tubes</button>
                          </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<td> <form name='delete_entry' action='delete.php' method='post'>
                                <input type='submit' name='delete_entry' value='Delete' />
                                <input type='hidden' name='idSample' value="; echo $row["idSample"]; "/>
            </form>

<form class="other_user" action="profile_others.php" method="post">
    <input type="text" name="" value="">   <a style="color:blue" name="" href="profile_others.php"> <?php echo $idOwner; ?></a>
</form>


<style media="screen">

    .profile-basic{
        background-color: rgba(46, 49, 49, 0.5);
        width: 100%;
        margin-left: -50px;
    }

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
