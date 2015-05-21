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
        <link rel="shortcut icon" href="http://isobellennox.com/team_milk/public/favicon.ico" type="image/x-icon">
        <link rel="icon" href="http://isobellennox.com/team_milk/public/favicon.ico" type="image/x-icon">
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
        <link href="http://fonts.googleapis.com/css?family=Nunito:300,300italic,400,700" rel="stylesheet" type="text/css">
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
    <?php 
        $logo_query="SELECT * FROM company_details";
        $logo_found=mysqli_query($connection, $logo_query);;
        if($logo_found){
            $details=mysqli_fetch_assoc($logo_found);
            $logo=$details['logo'];
        }else{
            $logo="img/under_my_roof_sm.png";
        }
        ?>
    <a href="index.php"><img src="<?php echo $logo; ?>" alt="Greenwell Bank Logo"></a><br>
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
                    echo "<ul>";
                    if(isset($sub_page)&&($sub_page == "add_item")) {
                      echo "<li class=\"sub_page\"><a href='add_item.php'>Add Item</a></li>";
                    } else {
                      echo "<li><a href=\"add_item.php\">Add Item</a></li>";
                    }

                    if(isset($sub_page)&&($sub_page == "view_rooms")) {
                      echo "<li class=\"sub_page\"><a href='rooms.php'>View Rooms</a></li>";
                    } else {
                      echo "<li><a href='rooms.php'>View Rooms</a></li>";
                    }
                    echo "</ul></li>";
                ?>

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
                
            $draft_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1";   
            $draft_result = mysqli_query($connection, $draft_query);
            $drdata=mysqli_fetch_assoc($draft_result); 

                
            $changes_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4";   
            $changes_result = mysqli_query($connection, $changes_query);
            $cdata=mysqli_fetch_assoc($changes_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claim_history.php">All Claims </a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?draft">Drafts </a> (<?php echo $drdata['total']; ?>)</li>
           <li><a href="claim_history.php?pending">Processing </a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved">Approved </a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?changes">Pending Changes </a> (<?php echo $cdata['total']; ?>)</li>
           <li><a href="claim_history.php?denied">Denied </a> (<?php echo $ddata['total']; ?>)</li>
        
                
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
                
            $draft_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=1";   
            $draft_result = mysqli_query($connection, $draft_query);
            $drdata=mysqli_fetch_assoc($draft_result); 
                
            $changes_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4";   
            $changes_result = mysqli_query($connection, $changes_query);
            $cdata=mysqli_fetch_assoc($changes_result); 


            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claim_history.php">All Claims </a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claim_history.php?draft">Drafts </a> (<?php echo $drdata['total']; ?>)</li>
           <li><a href="claim_history.php?pending">Processing </a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claim_history.php?approved">Approved </a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claim_history.php?changes">Pending Changes </a> (<?php echo $cdata['total']; ?>)</li>
           <li><a href="claim_history.php?denied">Denied </a> (<?php echo $ddata['total']; ?>)</li>
        
                
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
    
    
   $role=0;
//GET NAV ITEM PERMISSIONS
     foreach($_SESSION['permissions'] as $key => $val){ 
//         echo $val;
         
         //UPDATE ROLES
        if($val==3){ 
            //has edit roles permissions
            $role++;  
        }
    }  ?>
            <ul>
               
                   <?php 
                    $message_query="SELECT COUNT(*) as messages FROM messages WHERE sent_to={$_SESSION['user_id']} AND viewed=0";
                    $message_found=mysqli_query($connection, $message_query);
                    $mes=mysqli_fetch_assoc($message_found);
                    $num_messg= $mes['messages'];
                     
                    ?>
                <li><a href="messages.php"><i class="fa fa-envelope"></i> Messages </a>(<?php echo $num_messg; ?>)</li>
                <li><a href="claims.php?pending"><i class="fa fa-file-text"></i> Claims </a>(<?php echo $total; ?>)</li> 
                <li><a href="employees.php"><i class="fa fa-users"></i> Employees</a></li>
                <?php if($role == 1){ ?>
                <li><a href="roles.php"><i class="fa fa-user-secret"></i> Roles</a></li>
                
                <?php }?>
                
                <li><a href="company_details.php"><i class="fa fa-building"></i> Company Details</a></li>
                <li><a href="index.php"><i class="fa fa-pie-chart"></i> Statistics</a></li>
                <li><a href="activity.php"><i class="fa fa-history"></i> Activity</a></li> 

            </ul>
<?php }  ?>
         
<!--         BOTH SIDE WITLL HAVE THESE OPTIONS  -->
            <ul id="themes">
                 <?php if(isset($_SESSION['theme'])){
            if($_SESSION['theme']==1){
                  echo "<li><a href=\"edit.php?theme\"><i class=\"fa fa-sun-o\"></i> Light Theme</a></li>";
                    }else{
                    echo "<li><a href=\"edit.php?theme\"><i class=\"fa fa-moon-o\"></i> Dark Theme</a></li>";
                    }
                }else{
            echo "<li><a href=\"edit.php?theme\"><i class=\"fa fa-moon-o\"></i> Dark Theme</a></li>";
            }
        ?>
             </ul>
          </nav>
  
<header>
    <!-- Search Bar -->
    <div class="search_container">
        <form class='search' action="search.php" method="POST">        	
	        <input type="search" placeholder='Search Here' name="query" id="searchbar">
	        <input type="submit" name="search" id="nav_search" value="&#xf002;">
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
              <div class="content_wrapper">
