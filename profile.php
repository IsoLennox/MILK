<?php include("inc/header.php"); 

//determine whose profile we are looking at 
if(isset($_GET['user'])){
    $user_id=$_GET['user'];
    
    //GET USERNAME
    $find_user = find_user_by_id($user_id);
    $username= $find_user['first_name']." ".$find_user['last_name'];
    
    
}elseif(isset($_GET['user_id'])){
    $user_id=$_GET['user_id'];
    
    //GET USERNAME
    $find_user = find_user_by_id($user_id);
    $username= $find_user['first_name']." ".$find_user['last_name'];
    
    
}else{
    $user_id=$_SESSION['user_id'];
    $username = $_SESSION['username'];
   
}



//ONLY SHOW THIS USERS PROFILE IF BELONGS TO USER, OR IS EMPLOYEE VIEWING
if($_SESSION['is_employee']==1 || $user_id == $_SESSION['user_id']){

//GET PROFILE IMAGE AND CONTENT
    $query  = "SELECT * FROM users WHERE id={$user_id} LIMIT 1";  
    $result = mysqli_query($connection, $query);
     $num_rows=mysqli_num_rows($result);
//    if($result){
    if($num_rows ==1){
        $profile_array=mysqli_fetch_assoc($result);
        
        $content=$profile_array['profile_content'];
        $avatar=$profile_array['avatar'];
        if(empty($avatar)){
        $avatar="http://lorempixel.com/250/250/abstract";
        }
?>
 
    <h2> <?php echo $username; ?>'s Profile </h2>
    
    <div id="profile">
        <section id="avatar" class="left"> <img src="<?php echo $avatar; ?>" alt="profile image">
         </section>
        <section id="profile-content"> <?php echo $content; ?> 
        
<!--        ACCOUNT DETAILS  -->
       <?php
        echo "<br/><Br/>";
        echo $profile_array['phone']."<br/>";
        echo $profile_array['email']."<br/>";
        echo $profile_array['address']."<br/>";
        echo $profile_array['city']."<br/>";
        echo $profile_array['state']."<br/>";
        echo $profile_array['zip']."<br/>";
        echo $profile_array['policy_number']."<br/>"; 
        ?>
        
        </section>
 
    </div>

        <?php

        if($user_id==$_SESSION['user_id']){
            echo "<br/> <a href=\"edit_profile.php\"><i class=\"fa fa-pencil\"></i> Edit Profile</a> <br/>";
        }
        ?>
 
  <?php
    }else{
        echo "This user does not exist";
    }

}else{
    echo "You do not have permission to view this profile.";
}?>
 
        
<?php include("inc/footer.php"); ?>