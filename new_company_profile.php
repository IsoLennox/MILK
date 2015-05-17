<?php include("inc/header.php"); ?>
<?php
 

        //GET CURRENT IMG AND DELETE IT So that img name doesnt exist if user should try to upload it again in future
        //No Gallery in this website, just one user image.

 
 
    if(isset($_GET['update_logo'])){
               
               $logo=$_POST['logo'];
        //UNLINK IMAGE FROM DIR
        unlink($logo);


              //CHECK IMAGE
            $target_dir = "img/";
            if (!file_exists($target_dir)) {

                //CREATE DIR and FILE 
                mkdir($target_dir, 0777, true);
                require_once("inc/company_img.php"); 

            }else{

                //DIRECTORY EXISTS. UPLOAD IMAGE
                require_once("inc/company_img.php"); 
            }//end check for directory

     
               
               }else{  

        //REMOVE FROM DB
        $reset  = "INSERT INTO company_details ( name, address, city, state, zip, phone, content ) VALUES ( '{$_POST['name']}', '{$_POST['address']}', '{$_POST['city']}', '{$_POST['state']}', '{$_POST['zip']}', '{$_POST['phone']}', '{$_POST['content']}') "; 
        $result = mysqli_query($connection, $reset);

        if ($result && mysqli_affected_rows($connection) == 1) {

              //CHECK IMAGE
            $target_dir = "img/";
            if (!file_exists($target_dir)) {

                //CREATE DIR and FILE 
                mkdir($target_dir, 0777, true);
                require_once("inc/company_img.php"); 

            }else{

                //DIRECTORY EXISTS. UPLOAD IMAGE
                require_once("inc/company_img.php"); 
            }//end check for directory

        } else{
            // Failure
            $_SESSION["message"] = "Could not create profile";
            redirect_to("company_details.php");
        }
               }//end check if new or update 
?>
 