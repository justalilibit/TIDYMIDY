<?php
include('server.php');

// REGISTER USER
if (isset($_POST['edit_info'])) {
  // receive all input values from the form
  $Full_name = mysqli_real_escape_string($db, $_POST['fullname']);
  $Position = mysqli_real_escape_string($db, $_POST['position']);
  $Main_task = mysqli_real_escape_string($db, $_POST['maintask']);
  $Contact_email = mysqli_real_escape_string($db, $_POST['cemail']);
  $Contact_phone = mysqli_real_escape_string($db, $_POST['cphone']);
  $Institute = mysqli_real_escape_string($db, $_POST['institute']);
  $Find_me = mysqli_real_escape_string($db, $_POST['findme']);


  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($Full_name)) {
      $errors_registration['fullname'] = "Your full name is required";
  } else {
      if (!preg_match('/^[a-zA-Z\s]+$/', $Full_name)){ $errors_registration['fullname'] = "Your name cannot contain special characters"; }}

  if (empty($Contact_email)) {$errors_registration['cemail'] = "Email is required";}

  if (empty($Contact_phone)) {

  } else {
      if (!preg_match('/^\s*\+?\s*([0-9][\s-]*){9,}$/', $Contact_phone)){ $errors_registration['cphone'] = "Your contact phone must have only numbers, and at least 9 of them";
      }
  }


  if (empty($Contact_phone)) {

  } else {
      if (!preg_match('/^\s*\+?\s*([0-9][\s-]*){9,}$/', $Contact_phone)){ $errors_registration['cphone'] = "Your contact phone must have only numbers, and at least 9 of them"; }}


  if (empty($Contact_phone)) {

  } else {
      if (!preg_match('/^\s*\+?\s*([0-9][\s-]*){9,}$/', $Contact_phone)){ $errors_registration['cphone'] = "Your contact phone must have only numbers, and at least 9 of them"; }}

  if(array_filter($errors_registration)){

  } else {
  	$query = "UPDATE User
              SET Full_name='$Full_name',
              Position='$Position',
              Main_task='$Main_task',
              Institute='$Institute',
              Contact_email='$Contact_email',
              Contact_phone='$Contact_phone',
              Find_me='$Find_me'
              WHERE idUser='".$_SESSION["userdata"]["idUser"]."'";

    print("<br><br><br>THIS IS THE QUERY:<br>"); print($query);


  	mysqli_query($db, $query) or die(mysqli_error($db));
    $query = "SELECT * FROM User WHERE Username='".$_SESSION["userdata"]["idUser"]."'";
    $results = mysqli_query($db, $query) or die(mysqli_error($db));
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['userdata'] = mysqli_fetch_assoc($results);
  	  header('location: profile.php');
  }
}
}  if (empty($Contact_phone)) {

  } else {
      if (!preg_match('/^\s*\+?\s*([0-9][\s-]*){9,}$/', $Contact_phone)){ $errors_registration['cphone'] = "Your contact phone must have only numbers, and at least 9 of them"; }}

  if(array_filter($errors_registration)){

  } else {
  	$query = "UPDATE User SET Full_name='$Full_name', Position='$Position', Main_task='$Main_task', Institute='$Institute', Contact_email='$Contact_email', Contact_phone='$Contact_phone', Find_me='$Find_me' WHERE Username='
".$_SESSION["userdata"]["idUser"]."'";
  	mysqli_query($db, $query) or die(mysqli_error($db));
    $query = "SELECT * FROM User WHERE Username='".$_SESSION["userdata"]["idUser"]."'";
    $results = mysqli_query($db, $query) or die(mysqli_error($db));
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['userdata'] = mysqli_fetch_assoc($results);
  	  header('location: profile.php');
  }
}
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
                <form method="post" action="profile.php" >
                <label class="m-sm-0">Full name </label>
                <input
                  type="text"
                  name="fullname"
                  class="form-control ml-sm-2"
                  value="<?php echo $_SESSION["userdata"]["Full_name"]; ?>"
                  >
                  <div style="color:red" ><?php echo $errors_registration['fullname']; ?></div>

                <label class="m-sm-0">Position: </label>
                <input
                  type="text"
                  name="position"
                  class="form-control ml-sm-2"
                  value="<?php echo $_SESSION["userdata"]["Position"]; ?>"
                  >
            </div>
        </div>
        <div class="profile-info">
            <label class="m-sm-0">Main task: </label>
            <input
              type="text"
              name="maintask"
              class="form-control ml-sm-2"
              value="<?php echo $_SESSION["userdata"]["Main_task"]; ?>"
              >

        </div>
        <div class="profile-info">
            <label class="m-sm-0">Contact phone : </label>
            <input
              type="text"
              name="cphone"
              class="form-control ml-sm-2"
              value="<?php echo $_SESSION["userdata"]["Contact_phone"]; ?>"
              >
              <div style="color:red" ><?php echo $errors_registration['cphone']; ?></div>
        </div>

        <div class="profile-info">
            <label class="m-sm-0">Contact email :</label>
            <input
              type="text"
              name="cemail"
              class="form-control ml-sm-2"
              value="<?php echo $_SESSION["userdata"]["Contact_email"]; ?>"
              >
              <div style="color:red" ><?php echo $errors_registration['cemail']; ?></div>
        </div>

        <div class="profile-info">

            <label class="m-sm-0">Usually you can find me...</label>
            <textarea
              type="text"
              rows="10"
              name="findme"
              class="form-control ml-sm-2"
              value=""><?php echo $_SESSION["userdata"]["Find_me"]; ?>
              </textarea>
            </p>
        </div>

        <div class="profile-info">
                  <label class="m-sm-0">Institution / Research group:</label>
                  <input
                    type="text"
                    name="institute"
                    class="form-control ml-sm-2"
                    value="<?php echo $_SESSION["userdata"]["Institute"]; ?>"
                    >
        </div>
        <div class="profile-info">
            <p class="key" >Edit contact information: </p>
            <div class="text-center">
                <button class="btn btn-success" name="edit_info" type="submit"> APPLY </button>
            </div>
        </form>
    </div>
</form>

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
