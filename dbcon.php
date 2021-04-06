<?php

$server="localhost";
$user="root";
$password="";
$db="Codeshit";

$con= mysqli_connect($server,$user,$password,$db);

if($con){
    
      }else{
          ?><script>
          alert("No Connection ");
          </script>
          <?php

      }

?>