<?php include("inc/header.php");
$sub_page = 'profile'; 

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
        
        
        //GET ROLE
                $role_query  = "SELECT * FROM roles WHERE id={$profile_array['role']}";  
                $roleresult = mysqli_query($connection, $role_query);
                if($roleresult){
                    $role=mysqli_fetch_assoc($roleresult);
                    if(!$role['name']){
                        $role['name']="";
                    }
                }
        
           

       
        
        $content=$profile_array['profile_content'];
        $avatar=$profile_array['avatar'];
        if(empty($avatar)){
        $avatar="images/no_img.PNG";
        }
?>

    <h2 > <?php echo $username; ?>'s Profile <?php echo $role['name']; ?></h2> 
        
    <!-- <div class="clearfix"></div> -->
    <div class="profile">

        <section class="avatar"> <img class="resize-image" src="<?php echo $avatar; ?>" onerror="this.src='images/no_img.PNG'" alt="profile image">

         </section>
        <section class="profile_content">
         <?php if($user_id!==$_SESSION['user_id']){ ?>
            <p><a href="messages.php?new&name=<?php echo $username; ?>&route=<?php echo $profile_array['id']; ?>"> <i class="fa fa-envelope"></i> Send Message</a></p> 
        <?php }else{
            echo "  <p><a href=\"edit_profile.php\"><i class=\"fa fa-pencil\"></i> Edit Profile</a></p>  ";
        } ?>  
         <?php echo $content; ?>         
        <!-- ACCOUNT DETAILS  -->
       <?php
        echo "<p><strong>Name</strong>: ".$username."</p>";
        echo "<p><strong>Phone</strong>: ".$profile_array['phone']."</p>";
        echo "<p><strong>Email</strong>: ".$profile_array['email']."</p>";
        echo "<p><strong>Address</strong>: ".$profile_array['address'];
        echo "<br> ".$profile_array['city'].", ";
        echo " ".$profile_array['state']." ";
        echo " ".$profile_array['zip']."</p>";
        if($_SESSION['is_employee']!=="1") {
            echo "<p><strong>Policy Number</strong>: ".$profile_array['policy_number']."</p>"; 
        }
        
        
        ?>
 
 
        </section>
        <div class="clearfix"></div>
    </div>

  <?php
        }else{
            echo "<p>This user does not exist</p>";
        }

    }else{
        echo "<p>You do not have permission to view this profile.</p>";
    }?>

<?php include("inc/footer.php"); ?>