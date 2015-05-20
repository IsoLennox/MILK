<?php 
$current_page="dashboard";
include("inc/header.php"); ?>

           <?php

//TO DO:

// make each result/graph/chart in it's own file -> include it where it belongs (see example below)




 
if($_SESSION['is_employee']==0){
    //CLIENT
    ?>
    <h2>Your Dashboard</h2> 
    
    <?php
        //INCLUDE ALERTS
        include_once('alerts.php');
    ?>
    
<!--    SAMPLE STYLE GUIDE IMAGE : CAN REMOVE-->
    <img src="img/stats.PNG" alt="sample stats" />
    
    <?php
        //INCLUDE ALERTS
        include_once('client_dashboard.php');

    ?>
    <div>Quick add item</div>
    <?php
    
}else{  
    

    
    //IS EMPLOYEE
 
//    foreach($_SESSION['permissions'] as $key => $val){ 
//        if($val==3){
//            echo "permission granted!";
//        }
//    }
?>
    <h2>Statistics</h2>
    
    <div id="refine">
        <?php
        // TO DO:
        // Refine Results FOR EMPLOYEES ONLY:
        if($_SESSION['is_employee']==1){
        ?>
        <form action="#" method="POST">

            <input type="checkbox" name="results[]" value="claims">Claims
        <!--    inside would involve total number of claims, number of items in each claims type, number involved in each claim status -->
            <input type="checkbox" name="results[]" value="items">Items
        <!--    inside would involve number of items total, as well as number of items in each category-->
            <input type="checkbox" name="results[]" value="users">Users
        <!--    inside would involve total num of users, total num of clients vs. employees, and statistics based on location and how many number of items, and claims clients have each, and on average --> 

        <input type="submit" name="refine" value="Refine">
        </form>

        <?php } ?>
    </div>
    
    
    
    
    
     <img src="img/stats.PNG" alt="sample stats" />
    <ul>
        <li>Total number of clients</li>
        <li>number of claims made &amp; Percent of resolved/denied/pending claims</li>
    </ul>
    
    
    
    
    
    
    <?php
        
    
    
            //GET COUNTS
    
            //count total # claims
            $all_query  = "SELECT COUNT(*) as total FROM claims";   
            $all_result = mysqli_query($connection, $all_query);
            $data=mysqli_fetch_assoc($all_result);

            // total submitted but unprocessed
            $processing_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=0";   
            $processing_result = mysqli_query($connection, $processing_query);
            $pdata=mysqli_fetch_assoc($processing_result); 

    
            // total awaiting client changes
            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=4";   
            $pending_result = mysqli_query($connection, $pending_query);
            $cdata=mysqli_fetch_assoc($pending_result); 

    
            // total approved claims
            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adata=mysqli_fetch_assoc($approved_result); 

    
            // total Denied claims
            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddata=mysqli_fetch_assoc($denied_result); 
        ?>
           <li><a href="claims.php">All Claims</a> (<?php echo $data['total']; ?>)</li>
           <li><a href="claims.php?processing">Processing</a> (<?php echo $pdata['total']; ?>)</li>
           <li><a href="claims.php?pending">Pending Client Changes</a> (<?php echo $cdata['total']; ?>)</li>
           <li><a href="claims.php?approved">Approved</a> (<?php echo $adata['total']; ?>)</li>
           <li><a href="claims.php?denied">Denied</a> (<?php echo $ddata['total']; ?>)</li>
           
           
           

<?php }     

           


//example query

//    $query  = "SELECT * FROM TABLE";  
//    $result = mysqli_query($connection, $query);
//    if($result){
//        //show each result value
//        foreach($result as $show){
//            
//            $this_value=$show['col_name'];
//            echo $this_value;
//                      
//            }
//        }
 ?>
     
<?php include("inc/footer.php"); ?>
