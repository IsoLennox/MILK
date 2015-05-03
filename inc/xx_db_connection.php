<?php
 

define("DB_SERVER","localhost");
define("DB_USER","*********");
define("DB_PASS","************");
define("DB_NAME","*************");

$connection= mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//test iff connection occured
if(mysqli_connect_error()){
    die("Database connection failed: ".mysqli_connect_error()." (".mysqli_errno() .")"
       );
}else{ //echo "connected!";
     } //end test connection

//END CREATE CONNECTION
?>