<?php include("inc/header.php"); 

//determine whose profile we are looking at 
if(isset($_GET['user'])){
    $user_id=$_GET['user'];
    
    //GET USERNAME
    $find_user = find_user_by_id($user_id);
    $username= $find_user['username'];
    
    
}elseif(isset($_GET['user_id'])){
    $user_id=$_GET['user_id'];
    
    //GET USERNAME
    $find_user = find_user_by_id($user_id);
    $username= $find_user['username'];
    
    
}else{
    $user_id=$_SESSION['user_id'];
    $username = $_SESSION['username'];
   
}





//GET PROFILE IMAGE AND CONTENT
    $query  = "SELECT * FROM customers WHERE id={$user_id} LIMIT 1";  
    $result = mysqli_query($connection, $query);
     $num_rows=mysqli_num_rows($result);
//    if($result){
    if($num_rows ==1){
        $profile_array=mysqli_fetch_assoc($result);
        
        $content=$profile_array['profile_content'];
        $avatar="http://lorempixel.com/150/150/cats";

?>
 
    <h2> <?php echo $username; ?>'s Profile </h2>
    
    <div id="profile">
        <section id="avatar" class="left"> <img src="<?php echo $avatar; ?>" alt="profile image">
         </section>
        <section id="profile-content"> <?php echo $content; ?> </section>
    </div>

<?php

if($user_id==$_SESSION['user_id']){
    echo "<br/><span class=\"right\"><a href=\"edit_profile.php\"><i class=\"fa fa-pencil\"></i> Edit Profile</a></span><br/>";
}
?>
 
  <?php
    }else{
        echo "This user does not exist";
    } ?>
 
        
<?php include("inc/footer.php"); ?>