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
        <div class="work-experience">
            <h1 class="heading"> MY STUFF</h1>
            <div class="info">
                <p class="sub-heading">My storages</p>
                <p>dsfcgv</p>
            </div>
            <div class="info">
                <p class="sub-heading">My lab groups</p>
                <p>asdsf</p>
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
