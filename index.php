<?php 
$current_page="dashboard";
include("inc/header.php"); ?>

           <?php

//TO DO:

// make each result/graph/chart in it's own file -> include it where it belongs (see example below)




 
if($_SESSION['is_employee']==0){
    //CLIENT
    ?>
<!--    <h2>Your Dashboard</h2> -->
    
    <?php
        //INCLUDE ALERTS
        include_once('alerts.php');
        echo "<h1>Dashboard</h1>";
     // echo "<img class=\"temp\" src=\"img/graph.PNG\" alt=\"sample stats\" />";
        //INCLUDE STATS
        include_once('client_dashboard.php'); ?>
        
<!--
    <div>Quick add item</div>
    <div>Quick add room</div>
-->
   
<!--   //TASK SUGGESTIONS-->
   
<!--   If no items, suggest adding one-->
<!--    else, if item with no files suggest adding some-->
   
   
    <?php
    
}else{  
    
    //IS EMPLOYEE

?>
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
                ?>
                
                
                       <?php
            $employee_query  = "SELECT * from users WHERE is_employee=1";   
            $employee_result = mysqli_query($connection, $employee_query);
            $total_employees=0; 
            foreach($employee_result as $employee){
                $total_employees++;
            }
            echo "<li>Total number of employees: ".$total_employees."</li>";
                ?>
    </ul>
    
    <h1>Claims</h1>
    
    <?php
            //GET COUNTS
    
            //count total # claims that are NOT DRAFTS
            $all_query  = "SELECT COUNT(*) as total FROM claims WHERE status_id!=1";   
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
        <ul>
            <li><a href="claim_history.php"><i class="fa fa-folder-open"></i> All Claims</a> (<?php echo $data['total']; ?>)</li>
            <li><a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adata['total']; ?>)</li>
            <li><a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddata['total']; ?>)</li>
            <li><a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdata['total']; ?>)</li>
            <li><a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>)</li>
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
            echo "Total number of items in claims: ".$total_claimed_items."<br/>";
            echo "Total Value of all combined claims: $".$total_claim_value."<br/>";
            echo "Average Value of all combined claims: $".$total_claim_value/$total_claimed_items."<br/>";
    
    
//TOTAL CLAIMS PER CLAIM TYPE
    
    
    
    echo "<h1>Items</h1>";

//TOTAL ITEMS  
            $total_item_query  = "SELECT * from items";   
            $total_item_result = mysqli_query($connection, $total_item_query);
            $total_items=0; 
            $categories;
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

            foreach($words as $word) {
            $result[$word]++;
            }

            foreach($result as $word => $count) {
                if($word!==""){
                    echo "There are $count instances of $word.<br/>";
                }
            }

            echo "Total number of items: ".$total_items."<br/>";
    
    



           } 
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
