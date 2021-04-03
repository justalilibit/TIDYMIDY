<?php include('server.php');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { $errors_registration['username'] = "Username is required"; }
  else { if (!preg_match('/^[a-zA-Z\s]+$/', $username)){ $errors_registration['username'] = "Your user name cannot contain special characters"; }}
  if (empty($email)) { $errors_registration['email'] = "Email is required"; }
  // if (empty($password_1)) { array_push($errors, "Password is required"); }
  else { if (strlen($password_1) <= 8 ){ $errors_registration['password_1'] = "Your password must have at least 8 characters"; }}
  if ($password_1 != $password_2) {
    $errors_registration['password_2'] = "The two passwords do not match";
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM User WHERE Username='$username' OR Email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['Username'] === $username) {
      $errors_registration['username'] = "Username already exists";
    }

    if ($user['Email'] === $email) {
      $errors_registration['email'] = "email already exists";
    }
  }


  // Finally, REGISTER user if there are no errors in the form
  if(array_filter($errors_registration)){

  } else {
      $password = md5($password_1);//encrypt the password before saving in the database

      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['password'] = $password;
      $_SESSION['userdata'] = mysqli_fetch_assoc($result);
  	  header('location: register2.php');
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

    <nav style="background-color: rgba(0,0,0,.2);" class="navbar navbar-light navbar-fixed-top" style="background-color: #45B8AC;">
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
           <form method="post" action="register.php" class="password-strength form p-4">
             <h3 class="form__title text-center mb-4">CREATE A NEW ACCOUNT</h3>
             <div class="form-group">

             <div class="input-group">
                 <label for="password-input">Username</label>
               <input type="text" name="username" value="<?php echo $username; ?>" placeholder="MrClean"/>
               <div style="color:red" ><?php echo $errors_registration['username']; ?></div>

               <div class="input-group">
                <label for="password-input">Email</label>
                 <input type="email" name="email" value="<?php echo $email; ?>" placeholder="tidytubes@gmail.com"/>
             </div>
             <div style="color:red"><?php echo $errors_registration['email']; ?></div>

             <div class="input-group">
                 <label for="password-input">Password</label>
             </div>
               <div class="input-group">
                 <input name="password_1" class="password-strength__input form-control" type="password" id="password-input" aria-describedby="passwordHelp" placeholder="Enter password"/>
             <div class="input-group-append">
               <button class="password-strength__visibility btn btn-outline-secondary" type="button"><span class="password-strength__visibility-icon" data-visible="hidden"><i class="fas fa-eye-slash"></i></span><span class="password-strength__visibility-icon js-hidden" data-visible="visible"><i class="fas fa-eye"></i></span></button>
             </div>             </div>

             <div style="color:red"><?php echo $errors_registration['password_1']; ?></div>

             <div class="input-group">
                 <label for="password-input">Repeat your password</label>
             </div>
                 <div class="input-group">
                   <input  name="password_2" class="password-strength__input form-control" type="password" id="password-input" aria-describedby="passwordHelp" placeholder="Repeat your password"/>
               </div>
               <div style="color:red" ><?php echo $errors_registration['password_2']; ?></div>



           </div><small class="password-strength__error text-danger js-hidden">This symbol is not allowed!</small><small class="form-text text-muted mt-2" id="passwordHelp">Add 9 charachters or more, lowercase letters, uppercase letters, numbers and symbols to make the password as strong as your research!</small>
             </div>
             <div class="password-strength__bar-block progress mb-4">
               <div class="password-strength__bar progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
             </div>
             <button name="reg_user" class="password-strength__submit btn btn-success d-flex m-auto" type="submit" disabled="disabled">Submit</button>
             <br>
             <p>
                 Already a member?
                  <a style="color:blue" href="login.php">Sign in</a>
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

</body>
</html>
