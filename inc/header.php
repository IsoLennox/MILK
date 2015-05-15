<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
require_once("inc/db_connection.php"); 
require_once("inc/validation_functions.php"); 
confirm_logged_in(); 
?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Under My Roof</title>
        <meta name="description" content="An interactive PDF library">
        <!--        Main stylesheet-->
        <?php if(isset($_SESSION['theme'])){
        if($_SESSION['theme']==1){
                    // Add dark theme ?>
                    <link rel="stylesheet" href="css/style.css">
                    <link rel="stylesheet" href="css/dark-theme.css">
            <?php  }else{ 
                    //   light theme  ?> 
                    <link rel="stylesheet" href="css/style.css">
            <?php   }

        }else{ ?>
            <link rel="stylesheet" href="css/style.css">
        <?php } ?>

        <!--        link to font awesome-->
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <!--         STYLE GUIDE FONT  -->
        <link href="http://fonts.googleapis.com/css?family=Nunito:300,400,700" rel="stylesheet" type="text/css">
        <!--   JS VERSIONS-->
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="https://code.jquery.com/jquery-2.1.1.js"></script>
    </head>
       
<body>
     
    <script>
        //FADE OUT SESSION MESSAGES
      setTimeout(function() {
          $(".message").fadeOut(800);
      }, 5000);
     </script>
    
    
    
<!--    FULL SITE  -->

<div class="wrapper">        
<nav>
	<div class= 'logo_user'>
    <a href="index.php"><img src="img/under_my_roof_sm.png" alt="Greenwell Bank Logo"></a><br>
    <i class="fa fa-user"> </i> <a title="Your Profile" href="profile.php"><?php echo $_SESSION['username']; ?></a>
  </div>

<?php 
    
    //CHECK IF CLIENT OR EMPLOYEE 
    
if($_SESSION['is_employee']==0){
    
    //************************//
    //     IS CLIENT
    //************************//
         ?>

        <ul>
           
         <?php 
    //PAGE INDICATORS
    if(!isset($current_page) || $current_page=="dashboard"){
                    echo "<li class=\"current_page\"><a href=\"index.php\">Dashboard</a></li>";
                }else{
                   echo " <li><a href=\"index.php\">Dashboard</a></li>";
                }
    
    // END PAGE INDICATORS
            ?>
             
                <?php
                if($current_page=="inventory"){
                    echo "<li class=\"current_page\"><a href='inventory.php'>Inventory</a>";
                    ?>
                     <ul>
                <li><a href="add_item.php">Add Item</a></li>
                <!-- <li><a href="inventory.php">View Items</a></li> -->
                <li><a href="rooms.php">View Rooms</a></li> 

            </ul> </li>
               <?php
                }else{
                   echo " <li><a href='inventory.php'>Inventory</a> ";
                     ?>
                     <ul>
                <li><a href="add_item.php">Add Item</a></li>
                <!-- <li><a href="inventory.php">View Items</a></li> -->
                <li><a href="rooms.php">View Rooms</a></li> 

            </ul> </li>
               <?php
                }
    
            if($current_page=="claims"){ ?>
            <li class="current_page"><a href="claim_history.php">Claims</a>
            <ul> 
               <li><a href="file_new_claim.php">File Claim</a></li> 
          <?php 
        //GET COUNTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']}";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claim_history.php">All Claims</a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?pending">Pending</a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved">Approved</a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?denied">Denied</a> (<?php echo $ddata['total']; ?>)</li>
        
                
<!--                <li><a href="claim_history.php">Claim History</a></li>-->
            </ul></li> 
           
<?php }else{ ?>
               <li><a href="claim_history.php">Claims</a>
            <ul> 
              <li><a href="file_new_claim.php">File Claim</a></li>  
          <?php 
        //GET COUNTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']}";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=0";   
            $pending_result = mysqli_query($connection, $pending_query);
            $pdata=mysqli_fetch_assoc($pending_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claim_history.php">All Claims</a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?pending">Pending</a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved">Approved</a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?denied">Denied</a> (<?php echo $ddata['total']; ?>)</li>
        
                
<!--                <li><a href="claim_history.php">Claim History</a></li>-->
            </ul></li> 
          
   <?php } 
            
             if($current_page=="activity"){ ?>
   
            <li class="current_page"><a href="activity.php">Activity</a></li> 
            <?php }else{ ?>
             <li><a href="activity.php">Activity</a></li>
           <?php  } 
            
            if($current_page=="help"){?>
            <li class="current_page"><a href="help.php">Help</a></li> 
             <?php }else{ ?>
              <li><a href="help.php">Help</a></li> 
              <?php  } ?>
        </ul>
    
<?php }else{
    
    //************************//
    //IS EMPLOYEE
    //************************//
    
     ?>
     <?php 
    $role_query  = "SELECT * FROM roles WHERE id={$_SESSION['role']}";  
    $role_result = mysqli_query($connection, $role_query);
    if($role_result){
        $role=mysqli_fetch_assoc($role_result);
        echo "<h4>".$role['name']."</h4>";  
    }
    
    //NOTIFICATIONS FOR CLAIMS: GET NUMBER OF CLAIMS PENDING
    $claim_notification="SELECT COUNT(*) as total FROM claims WHERE status_id=0";
    $result=mysqli_query($connection, $claim_notification);
    $data=mysqli_fetch_assoc($result);
    $total= $data['total'];
    //NOTIFICATIONS FOR MESSAGES: GET NUMBER OF MESSAGES WHERE SENT_TO==you && VIEWED==0
        ?>
            <ul>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="claims.php">Claims</a>(<?php echo $total; ?>)</li> 
                <li><a href="employees.php">Employees</a></li>
                <li><a href="roles.php">Roles</a></li>
                <li><a href="company_details.php">Company Details</a></li>
                <li><a href="index.php">Statistics</a></li>
                <li><a href="activity.php">Activity</a></li> 

            </ul>
<?php }  ?>
         
<!--         BOTH SIDE WITLL HAVE THESE OPTIONS  -->
            <ul id="themes">
                 <?php if(isset($_SESSION['theme'])){
            if($_SESSION['theme']==1){
                  echo "<li><a href=\"edit.php?theme\">Switch to Light Theme</a></li>";
                    }else{
                    echo "<li><a href=\"edit.php?theme\">Switch to Dark Theme</a></li>";
                    }
                }else{
            echo "<li><a href=\"edit.php?theme\">Switch to Dark Theme</a></li>";
            }
        ?>
             </ul>
          </nav>
  
<header>
    <!--        USER ICONS -->
    <div class="search_container">
        <form class ='search' action="#" method="#">        	
	        <input type="search" placeholder='Search Here' name="client_search" id="searchbar">
	        <input type="submit" name="submit" id="nav_search" value="">
	    </form>
	</div>

    <div class="account_links">
        <div>
        	<a title="Manage Account Settings" href="settings.php?user=<?php echo $_SESSION['user_id'] ?>"><i class="fa fa-cog fa-2x"></i></a>
        </div>
        <div>
        	<a title="Log Out" href="logout.php"><i class="fa fa-sign-out fa-2x"></i></a>
        </div> 
    </div>
</header> 




        <div class="clearfix" id="page"> 
              <?php echo message(); ?>
              <?php echo form_errors($errors); ?>