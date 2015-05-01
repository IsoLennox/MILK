<?php

//define("DB_SERVER","108.167.189.11");
//define("DB_USER","ilennox");
//define("DB_PASS","z107*2013");
//define("DB_NAME","ilennox_milk");

define("DB_SERVER","localhost");
define("DB_USER","ilennox");
define("DB_PASS","z107*2013");
define("DB_NAME","ilennox_milk");

$connection= mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

//test iff connection occured
if(mysqli_connect_error()){
    die("Database connection failed: ".mysqli_connect_error()." (".mysqli_errno() .")"
       );
}else{ //echo "connected!";
     } //end test connection

//END CREATE CONNECTION
?>