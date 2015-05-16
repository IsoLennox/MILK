<?php include("inc/header.php"); ?>


<h1>Company Details</h1>


<?php



    $query  = "SELECT * FROM company_details";  
    $result = mysqli_query($connection, $query);
    $rows = mysqli_num_rows($result);
    if($rows >=1){
        
        
            //GET PERMISSIONS FOR THIS PAGE
            foreach($_SESSION['permissions'] as $key => $val){  
                //EDIT COMPANY DETAILS
                if($key===1){ 
                    echo "<a href=\"edit.php?company_details=1\">Edit Company Details</a>";
                } 
            }  
 
            //show each result value
            foreach($result as $show){
                echo $show['name']; 
                echo $show['logo']; 
                echo $show['address']; 
                echo $show['city']; 
                echo $show['state']; 
                echo $show['zip']; 
                echo $show['phone']; 
                echo $show['content']; 
            }
        }else{
           
            //GET PERMISSIONS FOR THIS PAGE
             foreach($_SESSION['permissions'] as $key => $val){  
                 //EDIT COMPANY DETAILS
                if($key===1){ 
                     echo "This company profile has not been set up<br/><a href=\"company_details.php?create\">Create Company Profile</a>";
                } 
            }  
        
        
        }

if(isset($_GET['create'])){
    echo "INSERT COMPANY DETAILS";
}

if(isset($_GET['edit'])){
    echo "UPDATE COMPANY DETAILS";
}

?>




<!--
 
          <h4>About Greenwell Bank using UnderMyRoof</h4>
        
        <img src="img/greenwell_logo_med.png" alt="Greenwell Logo">
         <img src="img/under_my_roof.png" alt="UnderMyRoof Logo">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum aliquam assumenda odio consectetur impedit tempora quas dolores pariatur, in eius. Eius aspernatur suscipit quam. Delectus similique, temporibus nulla numquam iure.</p>
 
     
-->
        
      
        
<?php include("inc/footer.php"); ?>