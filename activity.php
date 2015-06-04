<?php 
$current_page="activity";
include("inc/header.php"); ?> 
    <span class="activity">
    
         <?php  if(isset($_GET['all'])){ ?>
                <h1>All Activity</h1>
                  <span class="left"><a href="activity.php"><i class="fa fa-eye"></i> View your history</a></span> <br><br>
                  <?php
         //GET ALL HISTPORY 
                $query  = "SELECT * FROM history WHERE is_employee=1 ORDER BY id DESC"; 
                $result = mysqli_query($connection, $query);
                if($result){
                    echo "<ul>";
                    //show each result value
                    foreach($result as $show){
                        $user=find_user_by_id($show['user_id']);
                        echo "<li><a href=\"profile.php?user=".$user['id']."\">".$user['first_name']." ".$user['last_name']."</a> ".$show['content']." ".$show['datetime']."</li>";

                        }
                    echo "</ul>";
                }
    

  }else{ ?>
                 
                  <h1>Your Activity</h1>
                  <?php  if($_SESSION['is_employee']==1){ ?>
                  <span class="left"><a href="activity.php?all"><i class="fa fa-eye"></i> All employee history</a></span> 
                  <?php  } ?>
                  <br>
                  <br>
<!--
                  
                <form action="activity.php" method="GET">
                        <select onChange="this.form.submit()" name="filter" id="filter">
                           <option value="">---</option>
                           <option value="all">All Activity</option>
                           
                            <?php if($_SESSION['is_employee']==0){ ?> 
                            <option value="added">Added Items</option>
                            <option value="removed">Removed Items</option>
                            <option value="edited">Edited Items</option>
                            <option value="filed claim">Submitted Claims</option>
                            <option value="updated claim">Updated Claims</option>
                            <?php }else{ ?>
                            <option value="updated claim">Updated Claim</option> 
                            <option value="removed">Added Employee</option>
                            <option value="edited">Updated Roles</option>
                            <option value="claim">etc.</option>
                            <?php } ?>
                       </select> 
                       </form>   
-->
<?php
            
            if(isset($_GET['filter'])){
                echo "<h3>".strtoupper($_GET['filter'])."</h3>";
                
                if($_GET['filter']=="" || $_GET['filter']=="all"){
                 //GET ALL HISTPORY FROM USER LOGGED IN
                $query  = "SELECT * FROM history WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC"; 
                }else{
//                $like= "AND content LIKE '%".$_POST['filter']."&' ";
                 $query  = "SELECT * FROM history WHERE user_id={$_SESSION['user_id']} AND content LIKE '%{$_GET['filter']}%' ORDER BY id DESC"; 
                }
            }else{
                
                //GET ALL HISTPORY FROM USER LOGGED IN
                $query  = "SELECT * FROM history WHERE user_id={$_SESSION['user_id']} ORDER BY id DESC"; 
            
            }

 
    $result = mysqli_query($connection, $query);
    if($result){
        echo "<ul>";
        //show each result value
        foreach($result as $show){
            echo "<li>".$show['content']." ".$show['datetime']."</li>";
                      
            }
        echo "</ul>";
        }
 
    } ?>
</span>
     
<?php include("inc/footer.php"); ?>