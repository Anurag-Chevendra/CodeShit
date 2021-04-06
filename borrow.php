<?php
session_start();
include("dbcon.php");

if(isset($_POST['ATC'])){
    unset($_SESSION["cart_array"]);
    
    if(isset($_POST['lang'])){
    $_SESSION["cart_array"]=$_POST['lang'];
    header("Location: AddToCart.php");
}
    

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

<form action="" method="POST">
<input name="booksearch" class="form-control" placeholder="Subject name" type="text" >
<input name="branchsearch" class="form-control" placeholder="Branch" type="text" >
<input name="yearsearch" class="form-control" placeholder="Year(1,2,3,4)" type="number" >
<button> Search</button>
</form>
<div>
<table>
    <thead>
        <tr>
            <th>box</th>
            
            <th>Subject</th>
            <th>year</th>
            <th>branch</th>
            <th>name</th>
        </tr>
    </thead>

</div> 

<?php

$searchkeybook= $searchkeybranch= $searchkeyyear="";
$qry_final="SELECT * FROM books WHERE ";
if (isset($_POST['booksearch'])?$_POST['booksearch']:""){
    $searchkeybook="book_name LIKE '%".$_POST['booksearch']."%'";  
}

if(isset($_POST['branchsearch'])?$_POST['branchsearch']:""){  
    $searchkeybranch="branch LIKE '%".$_POST['branchsearch']."%'";
}

if(isset($_POST['yearsearch'])?$_POST['yearsearch']:""){
    $searchkeyyear="year LIKE '%".$_POST['yearsearch']."%'";
}

$strng_array=array($searchkeybook,$searchkeybranch,$searchkeyyear);
for ($i=0; $i < 3; $i++) { 
    if($strng_array[$i]!="" ){
        $qry_final=$qry_final.$strng_array[$i]." AND " ;
    }  
}

$qry_final= substr($qry_final,0,-5);
$result = mysqli_query($con,$qry_final);
$result1 = mysqli_query($con,$qry_final);
$resultCheck= mysqli_num_rows($result);
?>

<?php
$book_id_array=array();
while($row1= mysqli_fetch_assoc($result1)){
    array_push($book_id_array,$row1["book_id"]);
}
?>
<form method="POST">
<?php
foreach( $book_id_array as $indivisualId){
    $row=mysqli_fetch_assoc($result);
    

    ?>
    <tr>
    <td><input type=checkbox name="lang[]" value="<?php echo $indivisualId ?>" /></br></td>
    
    <td><?php echo $row['book_name'];?></td>
    <td><?php echo $row['year']; ?></td>
    <td><?php echo $row['branch']; ?></td>
    <td><?php echo $row['name']; ?></td>
    </tr>
    <?php
    
}
?>
</table>
<input type="submit" name="ATC" value="AddToCart" />
</form>

</body>
</html>