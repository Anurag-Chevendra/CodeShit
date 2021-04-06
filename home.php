<?php
session_start();
include("dbcon.php");
$session_email=$_SESSION["email"];
$query_get_id="select * from registration where email='$session_email'";
$result_session = mysqli_query($con,$query_get_id);
$user_data = mysqli_fetch_assoc($result_session);
$_SESSION["user_ID"]=$user_data["ID"];


if(isset($_POST['borrow_page'])){
    header("location: borrow.php");

}
if(isset($_POST['lend_page'])){
    header("location: lend.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a>home page, front end developer do your magic.</a> 
    <a>include: details about this page</a>
<form method="POST">
    <button name="borrow_page">borrow</button>
    <button name="lend_page">lend</button>
</form>
</body>
</html>