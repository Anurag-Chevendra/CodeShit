<?php
session_start();
include("dbcon.php");
#echo implode(' ',$_SESSION["cart_array"]);
#echo $_SESSION["user_ID"];
$id=$_SESSION["user_ID"];
$query_user_name="select * from registration where ID='$id'";
$user_result = mysqli_query($con,$query_user_name);
$user_data=mysqli_fetch_assoc($user_result);
$username=$user_data["username"];
echo $user_data["email"];
echo implode(" ", $_SESSION["cart_array"]);
if(isset($_POST["submit"])){
    $subject = "Confirmation";
                    $text="";
                    foreach($_SESSION["cart_array"] as $lender){
                        $book_query="select * from books where book_id='$lender'";
                        $book_result=mysqli_query($con,$book_query);
                        $book_data=mysqli_fetch_assoc($book_result);
                        $id_contact= $book_data["ID"];
                        $lender_query="select * from registration where ID='$id_contact'";
                        $lender_result=mysqli_query($con,$lender_query);
                        $lender_data=mysqli_fetch_assoc($lender_result);
                        
                        


                        $text=$text."Book name :".$book_data["book_name"]." by ".$book_data["name"].". Contact : ".$lender_data["username"].", whatsappNo: ".$lender_data["mobile"]." , email: ".$lender_data["email"];                                                      
                        $text=$text."\n";

                        $update_book_db_query="Delete from books where book_id='$lender'";
                        $update_book_db=mysqli_query($con,$update_book_db_query);
                        
                    }
                    $body = "Hi, $username. Here is your confirmation! \n".$text;
                    
                    $sender_email = "From: //emailid";

                    if (mail($user_data["email"], $subject, $body, $sender_email)) {
                      
                     echo"done";
                     header("Location: home.php");
                     
                    } else {
                     echo "Email sending failed...";
                    }
}

if(isset($_POST["cancel"])){
    
    unset($_SESSION["cart_array"]);
    header("Location: borrow.php");
    die();
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
</head>
<body>
    <h4>Summary</h4>
    <form method="POST">
<div>
<table>
    <thead>
        <tr>
            
            
            <th>Subject</th>
            <th>year</th>
            <th>branch</th>
            <th>name</th>
        </tr>
    </thead>

</div> 

<?php

if(isset($_SESSION["cart_array"])){
foreach( $_SESSION["cart_array"] as $book){
    
    $book_query="select * from books where book_id='$book'";
    $book_result = mysqli_query($con,$book_query);
    $book_data=mysqli_fetch_assoc($book_result);
    

    ?>
    <tr>
    <td><?php echo $book_data['book_name'];?></td>
    <td><?php echo $book_data['year']; ?></td>
    <td><?php echo $book_data['branch']; ?></td>
    <td><?php echo $book_data['name']; ?></td>
    </tr>
    <?php
    
}
}
?>
</table>
<input type="submit" name="submit" value="Submit" />
<input type="submit" name="cancel" value="Cancel" />
</form>
</body>
</html>