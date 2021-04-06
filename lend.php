<?php

session_start();
include("dbcon.php");



 ?>
 <html>
 <head><title>Lend</title></head>
 <body>
   <?php


   
   if(isset($_POST['submit'])){
   $bookname=mysqli_real_escape_string($con,$_POST["Book_Name"]);
   $year=mysqli_real_escape_string($con,$_POST["year"]);
   $branch=mysqli_real_escape_string($con,$_POST["Branch"]);
   $author=mysqli_real_escape_string($con,$_POST["Author"]);
   $id_for_page=$_SESSION["user_ID"];
   $book_id="";
   while(true){
   for ($i=0; $i <9 ; $i++) { 

     $book_id=$book_id.(random_int(0,9));
   }
   $check_book_id="Select * from books where book_id='$book_id'";
   $check_book_id_request=mysqli_query($con,$check_book_id);
   if(mysqli_num_rows($check_book_id_request)>0){

   }
   else{
     break;
   }
  }
   $insertquery="INSERT into books(ID, book_name,year,branch,name,book_id) values($id_for_page,'$bookname','$year','$branch','$author',$book_id)";
   $iquery=mysqli_query($con,$insertquery);
   
   if($iquery){
       ?>
         <script>
         alert("Inserted Successful");
         
         </script>
         <?php
         header("Location: home.php");
         }
   else{
             ?><script>
             alert("Not Inserted");
             </script>
             <?php
         }
      }
   ?>

   <form class="form-input"action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">
     <input name="Book_Name" placeholder="Enter Subject name" type="text" required>
     <input name="year" placeholder="Enter current studying year" type="number" min="1" max="4" required>
     <input name="Branch" placeholder="Enter Branch" type="text" required>
     <input name="Author" placeholder="Enter Author name" type="text" required>
     <button class="but" type="submit" name="submit">  LEND! </button>

   </body>
   </html>