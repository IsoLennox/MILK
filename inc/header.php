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
        <!-- For High Charts: Vertical Bar Charts -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <!-- For High Charts: Circular View Charts -->
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/highcharts-3d.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
    </head>
       
<body>
     
    <script>
        //FADE OUT SESSION MESSAGES
      setTimeout(function() {
          $(".message").fadeOut(800);
      }, 5000);
     </script>
    
    
    
<!--    FULL SITE  -->

<!-- <div class="wrapper">         -->
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
                    echo "<li class=\"current_page\"><a href=\"index.php\"><i class=\"fa fa-tachometer\"></i> Dashboard</a></li>";
                }else{
                   echo " <li><a href=\"index.php\"><i class=\"fa fa-tachometer\"></i> Dashboard</a></li>";
                }
    
    // END PAGE INDICATORS
            ?>
             
                <?php
                if(isset($current_page) && $current_page=="inventory"){
                    echo "<li class=\"current_page\"><a href='inventory.php'><i class=\"fa fa-cubes\"></i> Inventory</a>";
                    echo "<ul>";
                    if(isset($sub_page)&&($sub_page == "add_item")) {
                      echo "<li class=\"sub_page\"><a href='add_item.php'><i class=\"fa fa-plus\"></i> Add Item</a></li>";
                    } else {
                      echo "<li><a href=\"add_item.php\"><i class=\"fa fa-plus\"></i> Add Item</a></li>";
                    }
                    if(isset($sub_page)&&($sub_page == "view_rooms")) {
                      echo "<li class=\"sub_page\"><a href='rooms.php'><i class=\"fa fa-eye\"></i> View Rooms</a></li>";
                    } else {
                      echo "<li><a href='rooms.php'><i class=\"fa fa-eye\"></i> View Rooms</a></li>";
                    }
                    echo "</ul></li>";
                ?>

            <?php
                }else{
                   echo " <li><a href='inventory.php'><i class=\"fa fa-cubes\"></i> Inventory</a> ";
                     ?>
              <ul>
                <li><a href="add_item.php"><i class="fa fa-plus"></i> Add Item</a></li>
                <!-- <li><a href="inventory.php">View Items</a></li> -->
                <li><a href="rooms.php"><i class="fa fa-eye"></i> View Rooms</a></li> 

              </ul> </li>
               <?php
                }
    
    if(isset($current_page) && $current_page=="claims"){  ?>
            <li class="current_page"><a href="claim_history.php"><i class="fa fa-folder-open"></i> Claims</a> 
            <ul>  
          <?php 
              if(isset($sub_page)&&($sub_page == "file_claim")) {
                echo "<li class=\"sub_page\"><a href=\"file_new_claim.php\"><i class=\"fa fa-file-text\"></i> File Claim</a></li> ";
              } else {
                echo "<li><a href=\"file_new_claim.php\"><i class=\"fa fa-file-text\"></i> File Claim</a></li>";
              }?> 
            </ul>
            </li> 
           
<?php }else{ 
        //SHOW ALERT IF ANY CLAIMS ARE PENDING CHANGES
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id=4";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);
        
        if($data['total']==0){ $claim_alert=""; $total_alerts=""; }else{ $claim_alert="claim_alert_client"; $total_alerts=$data['total']; }
          ?>
           
            <li class='alert_container'><a href="claim_history.php"><i class="fa fa-folder-open"></i> Claims</a> <div class="<?php echo $claim_alert; ?>"><?php echo $total_alerts; ?></div>
                <ul> 
                 <li><a href="file_new_claim.php"><i class="fa fa-file-text"></i> File Claim</a></li>  
                </ul>
            </li> 
          
   <?php } 
            
             if(isset($current_page) && $current_page=="activity"){ ?>
   
            <li class="current_page"><a href="activity.php"><i class="fa fa-history"></i> Activity</a></li> 
            <?php }else{ ?>
             <li><a href="activity.php"><i class="fa fa-history"></i> Activity</a></li>
           <?php  } 
            
            if(isset($current_page) && $current_page=="help"){?>
            <li class="current_page"><a href="help.php"><i class="fa fa-question"></i> Help</a></li> 
             <?php }else{ ?>
              <li><a href="help.php"><i class="fa fa-question"></i> Help</a></li> 
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
                
                
                <?php  if(isset($current_page) &&  $current_page=="messages"){ ?>   
                        <li class="current_page"><a href="messages.php"><i class="fa fa-envelope"></i> Messages </a>(<?php echo $num_messg; ?>)</li>
              <?php  }else{ ?>   
                      <li><a href="messages.php"><i class="fa fa-envelope"></i> Messages </a>(<?php echo $num_messg; ?>)</li>
             <?php   } ?>
                
                
                
                <?php  
                      //?pending removed from link, not sure if we want it to go to all or just the new claims first
                      if(isset($current_page) && $current_page=="claims"){ ?>  
                <li class="current_page"><a href="claims.php?pending"><i class="fa fa-file-text"></i> Claims </a><div class="claim_alert"><?php echo $total; ?></div></li> 
              <?php  }else{ ?>  
                <li><a href="claims.php?pending"><i class="fa fa-file-text"></i> Claims </a><div class="claim_alert"><?php echo $total; ?></div></li> 
             <?php   } ?>
               
               
               
                <?php  if(isset($current_page) && $current_page=="employees"){ ?>   
                        <li class="current_page"><a href="employees.php"><i class="fa fa-users"></i> Employees</a></li>
              <?php  }else{ ?>   
                     <li><a href="employees.php"><i class="fa fa-users"></i> Employees</a></li>
             <?php   } ?>
                
                
                
                
                
                <?php  if(isset($current_page) && $current_page=="roles"){ 
                        if($role == 1){ ?>
                            <li class="current_page"><a href="roles.php"><i class="fa fa-user-secret"></i> Roles</a></li>
                        <?php }?>
                
                
              <?php  }else{ 
                        if($role == 1){ ?>
                <li><a href="roles.php"><i class="fa fa-user-secret"></i> Roles</a></li>
                
                <?php }?>
             <?php   } ?>
                

                 
                
            <?php  if(isset($current_page) && $current_page=="company"){ ?> 
                        <li class="current_page"><a href="company_details.php"><i class="fa fa-building"></i> Company Details</a></li>
              <?php  }else{ ?> 
                      <li><a href="company_details.php"><i class="fa fa-building"></i> Company Details</a></li>
             <?php   } ?>
                
                
               <?php  if(!isset($current_page) || $current_page=="dashboard"){ ?>
                        <li class="current_page"><a href="index.php"><i class="fa fa-pie-chart"></i> Statistics</a></li>
              <?php  }else{ ?>
                  <li><a href="index.php"><i class="fa fa-pie-chart"></i> Statistics</a></li>
             <?php   } ?>
                 
                <?php if(isset($current_page) && $current_page=="activity"){ ?>
                <li class="current_page"><a href="activity.php"><i class="fa fa-history"></i> Activity</a></li> 
                    <?php }else{ ?>
                     <li><a href="activity.php" ><i class="fa fa-history"></i> Activity</a></li>
                   <?php  } ?> 
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
          <a title="Manage Account Settings" href="settings.php?user=<?php echo $_SESSION['user_id'] ?>"><i id="spinCog" class="fa fa-cog fa-2x"></i></a>
        </div>
        <div>
          <a title="Log Out" href="logout.php"><i class="fa fa-sign-out fa-2x"></i></a>
        </div> 
    </div>
</header> 




        <div class="clearfix" id="page"> 
              <?php echo message(); ?>
              <?php echo errors(); ?>
              <?php echo form_errors($errors); ?>
              <div class="content_wrapper">
