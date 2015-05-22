<?php $current_page="company";
include("inc/header.php"); ?>


 


<?php
 
if(isset($_GET['create'])){
   
    ?>
 
   <form action="new_company_profile.php" method="post" enctype="multipart/form-data">
   
    Company Name: <input type="text" name="name" placeholder="Company Name (i.e. Under My Roof)">
    <br>
    Address: <input type="text" name="address" placeholder="1234 Main Street">
   <br> City: <input type="text" name="city" placeholder="Vancouver">
   <br> State: <input type="text" name="state" placeholder="Washington">
   <br> Zip: <input type="text" name="zip" placeholder="98664">
   <br> Phone: <input type="text" name="phone" placeholder="(360) 992-9999">
   <br> Company Deatils: <input type="text" name="content" placeholder="Mission Statement/Hours/etc...">
       
   <br>    
    Company Logo:<br/>
    <input type="file" name="image" id="fileToUpload"><br/>
 <br>
    <input type="submit" value="Save Profile" name="submit">
</form>
    
    <?php
}elseif(isset($_GET['edit'])){
    
        $query  = "SELECT * FROM company_details";  
    $result = mysqli_query($connection, $query);
    $rows = mysqli_num_rows($result);
    if($rows >=1){
        
     
 
            //show each result value
            foreach($result as $show){
                
                $logo="<img src=\"".$show['logo']."\" alt=\"Company Logo\"><br/>"; 
                $name=$show['name']; 
                $address=$show['address'];
                $city=$show['city']; 
                $state=$show['state']; 
                $zip=$show['zip']; 
                $phone=$show['phone']; 
                $content= $show['content'];
            }
        
        echo $logo;
        echo "<a href=\"company_details.php?edit_logo\">Edit Logo</a>";
                ?>
 
   <form action="new_company_profile.php" method="post" enctype="multipart/form-data">
   
    Company Name: <input type="text" name="name" value="<?php echo $name; ?>" >
    <br>
    Address: <input type="text" name="address" value="<?php echo $address; ?>" >
   <br> City: <input type="text" name="city" value="<?php echo $city; ?>" >
   <br> State: <input type="text" name="state" value="<?php echo $state; ?>" >
   <br> Zip: <input type="text" name="zip" value="<?php echo $zip; ?>" >
   <br> Phone: <input type="text" name="phone" value="<?php echo $phone; ?>" >
   <br> Company Deatils: <input type="text" name="content" value="<?php echo $content; ?>" >
   
    <input type="submit" value="Save Profile" name="submit">
</form>
    
    <?php
        
        
        }

}else{

    
    //SHOW COMPANY DETAILS OR ADD/EDIT OPTIONS
    $query  = "SELECT * FROM company_details";  
    $result = mysqli_query($connection, $query);
    $rows = mysqli_num_rows($result);
    if($rows >=1){
        
        
            //GET PERMISSIONS FOR THIS PAGE
            foreach($_SESSION['permissions'] as $key => $val){  
                //EDIT COMPANY DETAILS
                if($key===1){ 
                    echo "<a href=\"company_details.php?edit\"><i class=\"fa fa-pencil\"></i> Edit Company Details</a>";
                } 
            }  
 
            //show each result value
            foreach($result as $show){
                echo "<h1>".$show['name']."</h1>"; 
                echo "<img src=\"".$show['logo']."\" alt=\"Company Logo\"><br/>"; 
                
                if(isset($_GET['edit_logo'])){ ?>
                
                <form action="new_company_profile.php?update_logo" method="post" enctype="multipart/form-data">
                    Select New Image:<br/>
                    <input type="file" name="image" id="fileToUpload"><br/>
                    <input type="hidden" name="logo" value="<?php echo $show['logo']; ?>">
                    <input type="submit" value="Upload File" name="submit">
                </form>
                <br>
                <hr/>
                <br>
              <?php  
                }
                
                echo $show['address']."<br/>"; 
                echo $show['city']."<br/>"; 
                echo $show['state']."<br/>"; 
                echo $show['zip']."<br/>"; 
                echo $show['phone']."<br/>"; 
                echo $show['content']."<br/>"; 
            }
        }else{
           
            //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){  
                 //EDIT COMPANY DETAILS
                if($key===1){ 
                    if(!isset($_GET['create'])){
                     echo "This company profile has not been set up<br/><a href=\"company_details.php?create\">Create Company Profile</a>";
                    }
                } 
            }  
        
        
        }

}

?>




<!--
 
          <h4>About Greenwell Bank using UnderMyRoof</h4>
        
        <img src="img/greenwell_logo_med.png" alt="Greenwell Logo">
         <img src="img/under_my_roof.png" alt="UnderMyRoof Logo">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum aliquam assumenda odio consectetur impedit tempora quas dolores pariatur, in eius. Eius aspernatur suscipit quam. Delectus similique, temporibus nulla numquam iure.</p>
 
     
-->
        
      
        
<?php include("inc/footer.php"); ?>