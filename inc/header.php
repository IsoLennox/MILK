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
        <link rel="stylesheet" href="css/style.css">
<!--        link to font awesome-->
         <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  
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
 <a href="index.php"><img src="img/Greenwell_sm.jpg" alt="Greenwell Bank Logo"></a>
        
<!--        USER ICONS -->
    
      <i class="fa fa-user"> </i> <a title="Your Profile" href="profile.php?user=<?php echo $_SESSION['user_id'] ?>"><?php echo $_SESSION['username']; ?></a> | 
       <a title="Manage Account Settings" href="settings.php?user=<?php echo $_SESSION['user_id'] ?>"><i class="fa fa-cog"></i></a> | 
       <a title="Log Out" href="logout.php"><i class="fa fa-sign-out"></i></a> 
        
<!--   HEADER SEARCH BAR       -->
            
 <form class="center search" id="search_all" action="search.php?all" method="post">

    <input name="query" value="" placeholder="Search Policyholders, claims, etc..." autocomplete="off" name="header_search" id="header_search" value="" type="text">
    <input type="submit" name="submit" value="&#xf002;" />
 </form> 
          </header> 
          
        <div class="clearfix" id="page"> 
              <?php echo message(); ?>
              <?php echo form_errors($errors); ?>
         

