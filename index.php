<?php 
$current_page="dashboard";
include("inc/header.php"); 

if(isset($_GET['no-walkthrough'])){
        $no_walkthrough  = "UPDATE users SET walkthrough_complete=3 WHERE id={$_SESSION['user_id']} ";  
        $walkthrough_skipped = mysqli_query($connection, $no_walkthrough);
}

if(isset($_GET['walkthrough'])){ 
     echo "<div class=\"message\"><h4>Walkthrough Complete!</h4><br/>You can take the walkthrough again by going to your Settings!<br/></div>";
     $update_walkthrough  = "UPDATE users SET walkthrough_complete=4 WHERE id={$_SESSION['user_id']} ";  
    $walkthrough_updated = mysqli_query($connection, $update_walkthrough);
       
      
 }


 
if($_SESSION['is_employee']==0){
    //CLIENT
 
        echo "<h1>Welcome Back, ".$_SESSION['username']."</h1>";
        //INCLUDE ALERTS
        include_once('alerts.php');
        //INCLUDE STATS
        include_once('client_dashboard.php'); 
    //INCLUDE CHARTS
    echo "<div class=\"clear\"></div>";
        include_once('dashboard_charts.php'); 
    
    
    //MARK ALERTS AS READ
    if(isset($_GET['read'])){
        $mark_read  = "UPDATE claims SET hidden=1 WHERE id={$_GET['read']} LIMIT 1";  
        $readresult = mysqli_query($connection, $mark_read);
        if($readresult){
            $_SESSION['message']="Marked as read!"; 
            $link="<a href='index.php?undo={$_GET['read']}'>Undo</a>"; 
            $_SESSION['errors']=$link; 
            redirect_to('index.php');
        }
    }
        
        if(isset($_GET['undo'])){
            
                echo "You Undid this item!";
                $mark_read  = "UPDATE claims SET hidden=0 WHERE id={$_GET['undo']} LIMIT 1";  
                $readresult = mysqli_query($connection, $mark_read);
                if($readresult){ 
                    $_SESSION['message']="Marked as Unread!"; 
//                    echo "Marked as Unread!"; 
                redirect_to('index.php');
            }else{
                $_SESSION['message']="Could not revive alert"; 
//                    echo "Marked as Unread!"; 
                redirect_to('index.php');
            }

        }
   

    
}else{  
    
    //IS EMPLOYEE

?>
    <div class="stats">
    <h1>Statistics</h1>
    
    <div id="refine">
        <?php
        // TO DO:
        // Refine Results FOR EMPLOYEES ONLY:
        if($_SESSION['is_employee']==1){
        ?>
        
        
<!--        //REFINE FORM-->
<!--
        <form action="#" method="POST">
            <input type="checkbox" name="results[]" value="claims">Claims
            <input type="checkbox" name="results[]" value="items">Items 
            <input type="checkbox" name="results[]" value="users">Users 
        <input type="submit" name="refine" value="Refine">
        </form>
-->
        
        
        

        <?php } ?>
    </div> 
    
     <!-- <img class="temp" src="img/graph.PNG" alt="sample stats" /> -->
    <ul>
       <?php
            $client_query  = "SELECT * from users WHERE is_employee=0";   
            $client_result = mysqli_query($connection, $client_query);
            $total_clients=0; 
            foreach($client_result as $client){
                $total_clients++;
            }
            echo "<li>Total number of clients: ".$total_clients."</li>";
            // json client query
            $client_query1  = "SELECT * from users WHERE is_employee=0";   
            $client_result1 = mysqli_query($connection, $client_query);
            $client_rows1 = array();
            while ($row = mysqli_fetch_assoc($client_result1)) {
                $client_rows1[] = $row;
            }
            $client_json = json_encode($client_rows1);
                ?>
                
                
                       <?php
            $employee_query  = "SELECT * from users WHERE is_employee=1";   
            $employee_result = mysqli_query($connection, $employee_query);
            $total_employees=0; 
            foreach($employee_result as $employee){
                $total_employees++;
            }
            echo "<li>Total number of employees: ".$total_employees."</li>";
            // json employee query
            $employee_query1  = "SELECT * from users WHERE is_employee=1";   
            $employee_result1 = mysqli_query($connection, $employee_query1);
            $employee_rows1 = array();
            while ($row = mysqli_fetch_assoc($employee_result1)) {
                $employee_rows1[] = $row;
            }
            $employee_json = json_encode($employee_rows1);
                ?>
              
    </ul>
    </div>


    <div class="half_dashboard"> 
    <h1>Claims</h1>
    
    <?php
     
            //GET COUNTS
    
            //count total # claims that are NOT DRAFTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id!=1";   
            $all_result = mysqli_query($connection, $all_query);
            $datax=mysqli_fetch_assoc($all_result);

            // json all_query
            $all_query1  = "SELECT * FROM claims WHERE status_id !=1";   
            $all_result1 = mysqli_query($connection, $all_query1);
            $all_rows1 = array();
            while($data=mysqli_fetch_assoc($all_result1)){
                $all_rows1[] = $data;
            }
             $all_json = json_encode($all_rows1);


            // total submitted but unprocessed
            $processing_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=0";   
            $processing_result = mysqli_query($connection, $processing_query);
            $pdatax=mysqli_fetch_assoc($processing_result); 

            // json processing query
             $processing_query1  = "SELECT * FROM claims WHERE status_id = 0";   
            $processing_result1 = mysqli_query($connection, $processing_query1);
            $processing_rows1 = array();
            while($pdata=mysqli_fetch_assoc($processing_result1)) {
                $processing_rows1[] = $pdata;
            }
            $processing_json = json_encode($processing_rows1);


    
            // total awaiting client changes
            $pending_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id = 4";   
            $pending_result = mysqli_query($connection, $pending_query);
            $cdatax=mysqli_fetch_assoc($pending_result);

            // json pending query
            $pending_query1  = "SELECT * FROM claims WHERE status_id=4";   
            $pending_result1 = mysqli_query($connection, $pending_query1);
            $pending_rows1 = array();
            while($cdata=mysqli_fetch_assoc($pending_result1)) {
                $pending_rows1[] = $cdata;
            }
            $pending_json = json_encode($pending_rows1); 

    
            // total approved claims
            $approved_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=2";   
            $approved_result = mysqli_query($connection, $approved_query);
            $adatax=mysqli_fetch_assoc($approved_result); 

            // json approved query
            $approved_query1  = "SELECT * FROM claims WHERE status_id=2";   
            $approved_result1 = mysqli_query($connection, $approved_query1);
            $approved_rows1 = array();
            while($adata=mysqli_fetch_assoc($approved_result1)) {
                $approved_rows1[] = $adata;
            }
            $approved_json = json_encode($pending_rows1); 

    
            // total Denied claims
            $denied_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id=3";   
            $denied_result = mysqli_query($connection, $denied_query);
            $ddatax=mysqli_fetch_assoc($denied_result); 

            // json denied query
            $denied_query1  = "SELECT * FROM claims WHERE status_id=3";   
            $denied_result1 = mysqli_query($connection, $denied_query1);
            $denied_rows1 = array();
            while($ddata=mysqli_fetch_assoc($denied_result1)) {
                $denied_rows1[] = $ddata;
            }
            $denied_json = json_encode($denied_rows1); 
        ?>
        <ul>
            <li><a href="claim_history.php"><i class="fa fa-folder-open"></i> All Claims</a> (<?php echo $datax['total']; ?>)</li>
            <li><a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adatax['total']; ?>)</li>
            <li><a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddatax['total']; ?>)</li>
            <li><a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdatax['total']; ?>)</li>
            <li><a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdatax['total']; ?>)</li>
        </ul>

        <?php     

 

//TOTAL VALUE OF ALL CLAIMS
            $claim_value_query  = "SELECT * from claim_items";   
            $claim_value_result = mysqli_query($connection, $claim_value_query);
            $total_claim_value=0;
            $total_claimed_items=0;
            foreach($claim_value_result as $item){
                    $total_claimed_items++;
                    $item_val_query  = "SELECT * from items WHERE id={$item['item_id']}";   
                    $item_val_result = mysqli_query($connection, $item_val_query);
                    $item_val_data=mysqli_fetch_assoc($item_val_result);
                    $total_claim_value=$total_claim_value+$item_val_data['declared_value'];
            }
            echo "<p>Total number of items in claims: ".$total_claimed_items."</p>";
            echo "<p>Total Value of all combined claims: $".$total_claim_value."</p>";
            echo "<p>Average Value of all combined claims: $".$total_claim_value/$total_claimed_items."</p>";
    
            echo "</div>";
//TOTAL CLAIMS PER CLAIM TYPE
    
    
    echo "<div class=\"half_dashboard\">"; 
    echo "<h1>Items</h1>";

//TOTAL ITEMS  
            $total_item_query  = "SELECT * from items";   
            $total_item_result = mysqli_query($connection, $total_item_query);
            $total_items=0; 
            $categories = '';
            foreach($total_item_result as $item){
                    $total_items++;
                
                //TOTAL ITEMS IN EACH CATEGORY
                $category_query  = "SELECT * from item_category WHERE id={$item['category']}";   
                $category_result = mysqli_query($connection, $category_query);
                foreach($category_result as $cat){
//                    array_push($categories,$cat['name']);
                    $categories=$categories.",".$cat['name'];
                }
                
                
            }
    
            //    echo "category:".$categories."<br/>";
            $words = explode(",", $categories);
            $result = array_combine($words, array_fill(0, count($words), 0));
            
            echo "<p><strong>Total number of items: ".$total_items."</strong></p><br>";

            foreach($words as $word) {
            $result[$word]++;
            }

            foreach($result as $word => $count) {
                if($word!==""){
                    echo "<p><strong> $count</strong> items in $word</p>";
                }
            }

           
            // echo "Total number of items: ".$total_items."<br/>";    

        }
         echo "</div>";
            // echo "<p>";
            // echo  'CLIENT:', $client_json, '<br />', 'EMPLOYEE:',$employee_json, '<br />', 'ALL:', $all_json, '<br />', 'PROCESSING:',$processing_json, '<br />', 'PENDING:', $pending_json, '<br />', 'APPROVED:',$approved_json, '<br />', 'DENIED:',$denied_json, '<br />';
            // echo "</p>";

            

 ?>
      <script>
        $(function () {
            $('#chart_container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Types of Items Being Claimed'
                },
                xAxis: {
                    categories: ['Living Room', 'Kitchen', 'Bathroom', 'Bed Room', 'Other']
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total Items Claimed'
                    },
                    stackLabels: {
                        enabled: true,
                        style: {
                            fontWeight: 'bold',
                            color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                        }
                    }
                },
                legend: {
                    align: 'right',
                    x: -30,
                    verticalAlign: 'top',
                    y: 25,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                    borderColor: '#CCC',
                    borderWidth: 1,
                    shadow: false
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {
                                textShadow: '0 0 3px black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Jewelry',
                    data: [5, 3, 4, 7, 2]
                }, {
                    name: 'Electronics',
                    data: [2, 2, 3, 2, 1]
                }, {
                    name: 'Furniture',
                    data: [3, 4, 4, 2, 5]
                }, {
                    name: 'Musical Instruments',
                    data: [3, 4, 4, 2, 5]
                }, {
                    name: 'Other',
                    data: [3, 4, 4, 2, 5]
                }]
            });
        });
    </script>

    <div id="chart_container"></div>
<?php include("inc/footer.php"); ?>
