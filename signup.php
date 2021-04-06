<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
    <title>Signup</title>
</head>
<body>


<?php
include 'dbcon.php';
session_start();

if(isset($_POST['submit'])){
    $username=mysqli_real_escape_string($con,$_POST['username']);
    $email=mysqli_real_escape_string($con,$_POST['email']);
    $mobile=mysqli_real_escape_string($con,$_POST['mobile']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    $cpassword=mysqli_real_escape_string($con,$_POST['cpassword']);


    $token=random_int(100000,6999999);
    $pass = password_hash($password,PASSWORD_BCRYPT);
    $cpass= password_hash($cpassword,PASSWORD_BCRYPT);

    $emailquery = " select * from registration where email='$email'";
    $query = mysqli_query($con,$emailquery);

    $emailcount = mysqli_num_rows($query);

    if($emailcount>0){
        echo "email already exists";
    }else{
        if($password === $cpassword){
            //unique id 
            while(true){//id generation
                $id_generator="";
                $len=random_int(5,21);
                for ($i=0; $i < $len; $i++) { 
                    $id_generator=$id_generator.(random_int(0,9));
                }
                //id not to be repeated:
                if(mysqli_num_rows(mysqli_query($con,"select * from registration where ID='$id_generator'"))>0){
                    //if id repeated then loop will continue
                }
                else{
                    break;
                }
            }
            $flag=0;
            
            //mobile validity:

            if(6999999999 < $mobile && $mobile <10000000000){
                //phone not repeated
                if(mysqli_num_rows(mysqli_query($con,"select * from registration where mobile='$mobile'"))>0){
                    echo "number already registered";
                    $flag=1;
                }
            }
            else{
                echo "invalid mobile";
                $flag=1;
            }

            

            //password strength
            if($flag==0){
               
                if(!ctype_alpha($password)){
                    if(strlen($password)>6){

                    }
                }
                else{
                    echo "invalid password" ;
                    echo "<br>";
                    echo "password must have a special char";
                    echo "<br>";
                    echo "length must be greater than 5";
                    $flag=1;
                }
            }


            
            //inserting values
            if($flag==0){
                $insertquery = "insert into registration(ID, username, email, mobile, password, cpassword , token , status) 
                values ('$id_generator','$username','$email','$mobile','$pass','$cpass',$token,'inactive');";
                $iquery = mysqli_query($con,$insertquery);

                if($iquery){
                    $subject = "Email Activation";
                    $body = "Hi, $username. Click here to activate your account
                         http://localhost/Clg_Website/codeshit/activation.php?token=$token";
                    $sender_email = "From: //emailid";
                
                    if (mail($email, $subject, $body, $sender_email)) {
                      $_SESSION['msg']= "check $email to activate your account";
                     header('location:login.php');
                    } else {
                     echo "Email sending failed...";
                    }
               
                    ?>
                    <script>
                    alert("Sign Up Successful");
                    </script>

                 <?php
                }else{
                    ?>
                    <script>
                    alert("No insert");
                    </script>
                    <?php
                }
            }
            
             
        }else{
            echo "password are not matching";
        }
    }
}
   ?> 

<header>
        <nav class="navbar">
            <div class="logo"><a href="#">CodeSh*t</a></div>
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


<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
    <h3> Create Account</h3>
    <p> Get started with your free account:</p>
  <h6>Name:</h6>
<input name="username" class="form-control" placeholder="Full name" type="text" required><br>
  <h6>Email Id:<h6>
<input name="email" class="form-control" placeholder="Email address" type="email" required><br>
    <h6>Phone No.</h6>
<input name="mobile" class="form-control" placeholder="Phone number" type="number" required><br>
    <h6>Password:</h6>
<input name="password" class="form-control" placeholder="Create password" type="password" required><br>
    <h6>Confirm Password</h6>
<input name="cpassword" class="form-control" placeholder="Confirm password" type="password" required> <br>
<button type="submit" name="submit"> Create Account</button><br>
<p> Have an account?<a href="login.php">Log In</a></p>

</form>
</div>
</main>
<script src="main.js"></script>

</body>
</html>