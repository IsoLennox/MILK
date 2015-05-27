<?php  
//DB
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
 
     
            $search_query = "SELECT * FROM rooms";
            $rs = mysqli_query($connection, $search_query); 
 
            $arr = array();
  
 
            while($obj = mysqli_fetch_object($rs)) {
                $arr[] = $obj;
            }

            echo '{"classifieds":'.json_encode($arr).'}';
 
//URL FOR VIEW POST: http://columbian.com/Classifieds/classifieds/view/{id}
//POSTED DATE : {updated}