<?php require_once("inc/session.php"); 
require_once("inc/functions.php"); 
require_once("inc/db_connection.php"); 
require_once("inc/validation_functions.php"); 
confirm_logged_in(); ?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>MILK apps</title>
        <meta name="description" content="An interactive PDF library">
<!--        Main stylesheet-->
       <?php if(isset($_SESSION['theme'])){
            if($_SESSION['theme']==1){
                // Add dark theme ?>
                <link rel="stylesheet" href="css/style.css">
                <link rel="stylesheet" href="css/dark-theme.css">
          <?php  }else{ 
//                light theme
           ?> <link rel="stylesheet" href="css/style.css">
         <?php   }

        }else{ ?>
        <link rel="stylesheet" href="css/style.css">
        <?php } ?>
        
<!--        link to font awesome-->
         <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--         STYLE GUIDE FONT  -->
     <link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
  
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
    <header>
<!-- <a href="index.php"><img src="img/greenwell_logo_sm.png" alt="Greenwell Bank Logo"></a>-->
 <a href="index.php"><img src="img/under_my_roof_sm.png" alt="Greenwell Bank Logo"></a>
       
        <span id="page_name"><?php if(isset($page)){echo $page;} ?></span>
        
        
<!--        USER ICONS -->
    <div id="user_header" class="right">
      <i class="fa fa-user"> </i> <a title="Your Profile" href="profile.php?user=<?php echo $_SESSION['user_id'] ?>"><?php echo $_SESSION['username']; ?></a> | 
       <a title="Manage Account Settings" href="settings.php?user=<?php echo $_SESSION['user_id'] ?>"><i class="fa fa-cog"></i></a> | 
       <a title="Log Out" href="logout.php"><i class="fa fa-sign-out"></i></a> 
        </div>
        

        
<!--   HEADER SEARCH BAR       -->
            
<!--
 <form class="center search" id="search_all" action="search.php?all" method="post">

    <input name="query" value="" placeholder="Search Policyholders, claims, etc..." autocomplete="off" name="header_search" id="header_search" value="" type="text">
    <input type="submit" name="submit" value="&#xf002;" />
 </form> 
-->
          </header> 
          
          <nav>
 <?php 
 
if($_SESSION['is_employee']==0){
//     IS CLIENT
    echo "<h4>Client</h4>"; 
    ?>
                  <ul>
                  <li><a href="index.php">Dashboard</a></li>
                  <li>Inventory </li>
                  <ul>
                      
                      <li><a href="inventory.php">View Items</a></li>
                      <ul>
                          <li><a href="add_item.php">Add Item</a></li>
                      </ul> 
                      <li><a href="rooms.php">View Rooms</a></li> 
                  </ul> 
                  
                  <li>Claims</li>
                  <ul> 
                      <li><a href="file_new_claim.php">File New Claim</a></li>
                      <li><a href="claim_history.php">Claim History</a></li>
                  </ul> 
                  
                    <li><a href="help.php">Help</a></li> 
              </ul>
              
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
              <?php
}else{
    //IS EMPLOYEE
    echo "<h4>Employee Role</h4>";  
        ?>
            <ul>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="claims.php">Claims</a></li> 
<!--                <li><a href="claims.php">Tickets</a></li> -->

                <li><a href="employees.php">Employees</a></li>
                <li><a href="roles.php">Roles</a></li>
                <li><a href="company_details.php">Company Details</a></li>
                <li><a href="index.php">Statistics</a></li>

            </ul>
             
             
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
              <?php }       ?>
              

          </nav>
          
        <div class="clearfix" id="page"> 
              <?php echo message(); ?>
              <?php echo form_errors($errors); ?>