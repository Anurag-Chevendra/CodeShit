<?php

session_start();
include("dbcon.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
</head>
<body>
<?php


if(isset($_POST['submit'])){
    $email= $_POST['email'];
    $password= $_POST['password'];

    $email_search= "select * from registration where email='$email';";
    $query= mysqli_query($con,$email_search);

    

    $email_count= mysqli_num_rows($query);

    if($email_count>0){
        $email_pass = mysqli_fetch_assoc($query);
        $db_pass= $email_pass['password'];
        $pass_decode= password_verify($password,$db_pass);

        if($pass_decode){
            echo "login Succesful";
            $_SESSION["email"]=$email;
            header("location: home.php");
        }else{
            echo "password incorrect";
        }
    }else{
        echo "password Incorrect";
    }
}

?>
<body>

<header>
  <nav class="navbar">
      <div class="logo"><a href="#">CodeShit</a></div>
      <a class="togglebtn" href="#"><span class="line"></span>
          <span class="line"></span>
          <span class="line"></span></a>
      <div class="navbar-links">
          <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Lend</a></li>
              <li><a href="#">Borrow</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">My Profile</a></li>
          </ul>
      </div>
  </nav>
</header>
<main>
<figure>
  <picture>
  <img src="https://image.freepik.com/free-vector/group-people-reading-borrowing-books_53876-43122.jpg" />
  </picture>
</figure>

<div class="form">
  
  <form  method="POST">
<h3> Log In to our page</h3>       
<h6>Email Id:</h6>
<input name="email" class="form-control" placeholder="Email" type="email" required><br>
<h6>Password:</h6>
<input name="password" class="form-control" placeholder="Password" type="password" required><br>
<button class="log" type="submit" name="submit"> Log In</button>
<p>Don't Have an account?<a href="signup.php">Sign In</a></p>
<p> Forgot Password?<a href="forgotPassword.php">Click here</a></p>
</form>
</main>
<script src="main.js"></script>

</body>
</html>
</body>
</html>