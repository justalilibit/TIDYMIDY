<?php
include('server.php');

// REGISTER USER
if (isset($_POST['reg_info'])) {
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

  if(array_filter($errors_registration)){

  } else {
  	$query = "INSERT INTO User (Username, Email, Password, Full_name, Position, Main_task, Institute, Contact_email, Contact_phone, Find_me)
  			  VALUES('".$_SESSION["username"]."', '".$_SESSION["email"]."', '".$_SESSION["password"]."', '$Full_name', '$Position', '$Main_task', '$Institute', '$Contact_email', '$Contact_phone', '$Find_me')";
  	mysqli_query($db, $query) or die(mysqli_error($db));
    $query = "SELECT * FROM User WHERE Username='$username' ";
    $results = mysqli_query($db, $query) or die(mysqli_error($db));
  	header('location: login.php');
  }
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link href="https://fonts.googleapis.com/css?family=Muli:400,600&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css'>
  <link rel="stylesheet" type="text/css" href="style.css">
  <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</head>
<body>


	<?php include('error.php'); ?>

    <nav style="background-color: rgba(0,0,0,.2);" class="navbar navbar-light sticky-top" style="background-color: #45B8AC;">
    <div class="navbar-header">
      <a style="color: white;"class="navbar-brand" href="index.html"><img style="width:150px;" src="img/tidytubes.png" alt="Logo"></a></div>
    </div>
    </nav>

    <!-- resgistration -->
    <br>
    <br>
    <br>
    <br>
    </nav>
<div class="content__outer">
   <div class="content__inner">
       <div class="row">
         <div class="col-lg-6 m-auto">
           <form method="post" action="register2.php" class="password-strength form p-4">
             <h3 class="form__title text-center mb-4">INTRODUCE YOUR DATA</h3>
             <h4 class="form__title text-center mb-4"> If someone has a question about what you have done, they will see this info</h4>
             <div class="form-group">

             <div class="input-group">
                 <label for="password-input">Full name</label>
               <input type="text" name="fullname" value="<?php echo $Full_name; ?>" placeholder="Clean Cleanest Tidy"/>
               <div style="color:red" ></div>
               <div style="color:red" ><?php echo $errors_registration['fullname']; ?></div>

               <div class="input-group">
                <label for="password-input">Main Task</label>
                 <input type="text" name="maintask" value="<?php echo $Main_task; ?>" placeholder="(Optional) Tell us a bit about your function"/>
             </div>

               <div class="input-group">
                <label for="password-input">Position</label>
                 <input type="text" name="position" value="<?php echo $Position; ?>" placeholder="Student / PI / Lab technician..."/>
             </div>

               <div class="input-group">
                <label for="password-input">Contact Email</label>
                 <input type="email" name="cemail" value="<?php echo $Contact_email; ?>" placeholder="Put an email that you'd like to got contacted to"/>
             </div>
             <div style="color:red" ><?php echo $errors_registration['cemail']; ?></div>

             <div class="input-group">
              <label for="password-input">Contact Phone number</label>
               <input type="text" name="cphone" value="<?php echo $Contact_phone; ?>" placeholder="(Optional) Put a phone number that you'd like to got contacted to"/>
           </div>
           <div style="color:red" ><?php echo $errors_registration['cphone']; ?></div>

           <div class="input-group">
            <label for="password-input">Institution / Lab group</label>
             <input type="text" name="institute" value="<?php echo $Institute; ?>" placeholder="(Optional) TIDYTUBES S.L."/>
         </div>

         <label for="exampleFormControlTextarea1">Where can I usually find you arround?</label>

         <div class="input-group">
           <textarea textarea="form-control"
           class="form-control"
           name="findme"
           value="<?php echo $Find_me; ?>"
           placeholder="(Optional)  A short paragraf about where your colleages could find you physiscally e.g: Office 9 second floor"
           rows="8"
           cols="80"
           ></textarea>
         </div>

         <button type="submit" class="btn btn-success" href="index.php" name="reg_info" >Start my account!
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg></button>
             </p>
           </form>
           </div>
       </div>
     </div>
   </div>
 </div>


 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js'></script>
 <script  src="java.js"></script>


<!-- Style for the login -->
<style media="screen">

body, html {
    background: #00C9FF;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #92FE9D, #00C9FF);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #92FE9D, #00C9FF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    margin: 0;
    width: 100%;
    height: 100%;
    padding: 0;
    background-color: #E8A87C;
    margin: 0;
    padding: 0;
}

body {
  font-family: 'Muli', sans-serif;
  font-size: 16px;
  color: #2c2c2c;
}
body a {
  color: inherit;
  text-decoration: none;
}
.content{
  width: 100%;
  margin: 0;
  margin-top: 15%;
}
.col-lg-6 {
    /* width: 100%; */
    height: auto;
    width: auto;
}
.password-strength {
  box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
}
.js-hidden {
  display: none;
}
.btn-outline-secondary {
  color: #28a745;
  border-color: #28a745;
}
.btn-outline-secondary:hover {
  background: #28a745;
}
</style>

  </form>
  </div>
  </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
