    <?php



    //see if any alerts about claims
    
    $alerts_query  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']} AND status_id != 0 AND status_id != 1 AND hidden=0";  
    $alertresult = mysqli_query($connection, $alerts_query);
if($alertresult){
    $rows = mysqli_num_rows($alertresult);
    if($rows>=1){
        echo "<div id=\"alerts\">";
        echo "<h1>ALERTS</h1>";
        //show each result value
        foreach($alertresult as $show_alert){
                                     //GET CLAIM STATUS NAME
            $status_query  = "SELECT * FROM status_types WHERE id={$show_alert['status_id']}";  
            $status_result = mysqli_query($connection, $status_query);
            if($status_result){
                $status_array=mysqli_fetch_assoc($status_result);
                $status=$status_array['name'];
            } 
            if($status=="Approved"){ $class="class=\"green\"";}else{ $class="";}
            
             echo "<span class=\"alert_node\" $class ><a href=\"claim_details.php?id=".$show_alert['id']."\">Claim #".$show_alert['id'].": '".$show_alert['title']."'</a> is ".$status." <a title=\"Mark as read\" href=\"index.php?read=".$show_alert['id']."\"><i class=\"fa fa-times right\"></i></s></span><br/>";
                      
            }
        
        echo "</div>   <hr>";
        }
}

    ?>
    
