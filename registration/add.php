<?php

// Php script for errors in sign-in process

$email = $user = $password = $pswr = '';
$errors = array('email' => '' , 'user' => '' , 'password' => '', 'pswr' => '' );

if(isset($_POST['submit'])){

    if(empty($_POST['email'])){
        $errors['email'] = 'An e-mail adress is required';
    } else {
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'The e-mail must be a valid address';
        }
    }
    if(empty($_POST['user'])){
        $errors['user'] = 'A user name is required';
    } else {
        $user = $_POST['user'];
        if(!preg_match('/^[a-zA-Z\s]+$/', $user)){
            $errors['user'] = 'Your user name cannot contain special characters';
        }
    }
    if(empty($_POST['password'])){
    $errors['password'] = 'You want to let anyone inside really?';
    } else {
        $password = $_POST['password'];
        if(strlen($password) <= 7 ){
            $errors['password'] = 'Your password must have at least 8 characters';
            }
    }

    if(empty($_POST['pswr'])){
        $errors['pswr'] = 'You must repeat your password';
    } else {
        $pswr = $_POST['pswr'];
        if($password !== $pswr) {
            $errors['pswr'] = 'Your passwords should match';
        }
    }
    if(array_filter($errors)){
    } else {
        // $email = mysqli_real_escape_string($connetion, $_POST['email']);
        // $user = mysqli_real_escape_string($connetion, $_POST['user']);
        // $email = mysqli_real_escape_string($connetion, $_POST['password']);
        header('Location: prueba.php');

    // $saving_in_db = "INSTERT INTO user(email, user_name, password) VALUES('$email', '$user', '$password')";
    }
}
?>
<?php include('header.html') ?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <head>
         <meta charset="utf-8">
         <title>mira loco</title>
         <link rel="stylesheet" type="text/css" href="estilo.css">
     </head>
     <body>
         <section class="container grey-text">
             <form class="white" action="add.php" method="POST">
                 <label for="">E-mail:</label>
                 <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
                 <div class=""> <?php echo $errors['email']; ?> </div>

                 <label for="">User name:</label>
                 <input type="text" name="user" value="<?php echo htmlspecialchars($user) ?>">
                 <div class=""> <?php echo $errors['user']; ?> </div>

                 <label for="">password</label>
                 <input type="password" name="password">
                 <div class=""> <?php echo $errors['password']; ?> </div>

                 <label for="">Repeat your password:</label>
                 <input type="password" name="pswr">
                 <div class=""> <?php echo $errors['pswr']; ?> </div>

                 <input type="submit" name="submit" value="Create account!">
             </form>

         </section>
     </body>
 </html>
