<section class="circle_charts">
    <div class="pie-chart" id="circle1"></div>
<!--
    <div class="pie-chart" id="circle2"></div>
    <div class="pie-chart" id="circle3"></div>
-->
</section>
   
   
<!--  BAR GRAPH-->
   <div id="chart_container" height="400px" width="100%"></div>

    
       
      
      
<?php 

                    //*****************
                    //    ROOMS
                    //*****************



//GET NUMBER OF ROOMS
    $rooms=0;
    $room_count  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']}";  
    $room_result = mysqli_query($connection, $room_count);
    $num_rooms=mysqli_num_rows($room_result);
    
    //get items for each room

function item_array($array, $key, $value){
                    $array[$key] = $value;
                    return $array;
                }

 echo "<div class=\"stats\"> <ul>";
//echo "<h3>You have ".$num_rooms." rooms <h3>";
echo "<h3>".$num_rooms." rooms <h3>";
if($num_rooms==0){
?>
        
    
        <!--      ADD A ROOM  -->
<form  method="POST" action="rooms.php">
    <h2>Add A Room</h2>
    <label for="room_name">Room Name: </label><input id='room_name' type="text" name="name" placeholder="e.x. Bedroom.."><br/>
    <label for="room_notes">Room Notes:</label><textarea id='room_notes' cols="20" rows="8"  name="notes" placeholder="e.x. This room is in the guest house..."></textarea><br/> 
    <input name="submit" type="submit" value="Save Room">
</form> 
            
            <?php }
  
    $roomquery  = "SELECT * FROM rooms WHERE user_id={$_SESSION['user_id']} LIMIT 3";  
    $roomresult = mysqli_query($connection, $roomquery);
    if($roomresult){ 
        $rooms=array();
        //show each result value
        foreach($roomresult as $show){
                $item_count=0;
                $item_array=array();

            
                $item_query  = "SELECT * FROM items WHERE room_id={$show['id']} AND in_trash=0";  
                $item_result = mysqli_query($connection, $item_query);
            if($item_result){
                foreach($item_result as $item){  
                    $item_count++; 
                    $item_array = item_array($item_array, $item['id'], $item['name']);
                 }
            }
            echo "<h4><a href=\"room_details.php?id=".$show['id']."\">".$show['name']."</a><br/> (".$item_count." items)</h4>";
            
            //PUT ALL ROOMS INTO ARRAY TO USSE IN HIGHCHARTS
            array_push($rooms , "{name: '".$show['name']."', data: [5, 3, 4, 7, 2] }");
           
                if(!empty($item_array)){
                     echo "<ul>";
                    foreach($item_array as $id=>$name){
                        echo "<li><a href=\"item_details.php?id=".$id."\" >".$name."</a></li>";
                    }
                    echo "</ul>";
                }
 
            }
        
        echo "<a href=\"rooms.php\">View all rooms</a>";
        }
        

        //COUNT ROOMS FOR FOR LOOP TO ECHO EACH OUT IN HIGH CHARTS
        $count_rooms=0;
        foreach($rooms as $room_array){
            $count_rooms++;
        //    echo $room_array; 
        }
                   
            echo "</div>";




                    //*****************
                    //    ITEMS
                    //*****************





          echo "<div class=\"stats\">";

//TOTAL ITEMS  
            $total_item_query  =  "SELECT * FROM items WHERE user_id={$_SESSION['user_id']} AND in_trash=0";   
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
            echo "<h3>You have ".$total_items." items</h3><br/>";
            
            if($total_items==0){
                echo "<a href=\"add_item.php\">Add your first item!</a>";
               
            }
            if(!empty($categories)){
            $words = explode(",", $categories);
            $result = array_combine($words, array_fill(0, count($words), 0));

            foreach($words as $word) {
            $result[$word]++;
            }

            foreach($result as $word => $count) {
                if($word!==""){
                    echo "$count items in $word.<br/>";
                }
            }
            }
            
    
    
       
       echo "</div>";



                    //*****************
                    //    CLAIMS
                    //*****************




        echo "<div class=\"stats\">";
   
    $claims=0;
    $claim_count  = "SELECT * FROM claims WHERE user_id={$_SESSION['user_id']}";  
    $claim_result = mysqli_query($connection, $claim_count);
    $num_claims=0;
    if($claim_result){
        foreach($claim_result as $claim){
        $num_claims++;
    }
    }
//    echo "<li>You have made ".$num_claims." claims</li>";



 
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
          
          <li><a href="claim_history.php">
              
            <a href="claim_history.php"><i class="fa fa-folder-open"></i> All Claims</a> (<?php echo $data['total']; ?>)<br/>
            <a href="claim_history.php?approved"><i class="fa fa-check green"></i> Approved </a> (<?php echo $adata['total']; ?>)<br/>
            <a href="claim_history.php?denied"><i class="fa fa-times red"></i> Denied </a> (<?php echo $ddata['total']; ?>)<br/>             
            <a href="claim_history.php?pending"><i class="fa fa-clock-o "></i> Processing </a> (<?php echo $pdata['total']; ?>)<br/>            
            <a href="claim_history.php?changes"><i class="fa fa-pencil"></i> Pending Changes </a> (<?php echo $cdata['total']; ?>) <br/>
            <a href="claim_history.php?draft"><i class="fa fa-file-o "></i> Drafts </a> (<?php echo $drdata['total']; ?>) <br/>

    </ul>
    </div>
    </div>


   
 

        <script>
    // -------> Begin Vertical Bar chart <--------------
        $(function () {
            $('#chart_container').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Stacked column chart'
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
                series: [
                  
                    <?php
            // $loop_count=0;
            // foreach($rooms as $room_array){
            //     $loop_count++;
            //             if($loop_count < $room_count){
            //             echo $room_array.", ";
            //             }else{ echo $room_array; }
                    ?>
                    {
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
                }
                     <?php //} ?>
                        ]
            });
        });
   // -------> End of Vertical Bar chart <--------------


   // -------> Begin Circle Charts for Views <--------------
        
    // begin chart 1
        $(function () {
            $('#circle1').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: false,
                    }
                },
                title: {
                    text: 'Claim Status'
                },
                subtitle: {
                    text: ''
                },
                plotOptions: {
                    pie: {
                        innerSize: 175,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Total Views',
                    data: [
                        ['Applicants (3154)', 3154],
                        ['Forwards (912)', 912],
                        ['Interviews (1546)', 1546]
                    ]
                }]
            });
        });

    // begin circle 2
        $(function () {
            $('#circle2').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: false,
                    }
                },
                title: {
                    text: 'Current Week\'s Claims'
                },
                subtitle: {
                    text: 'Current Claims Status'
                },
                plotOptions: {
                    pie: {
                        innerSize: 175,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Claims',
                    data: [
                        ['Pending (200)', 200],
                        ['Finalized (400)', 400],
                        ['In Process (100)', 100]
                    ]
                }]
            });
        });
            
                // begin circle 3
        $(function () {
            $('#circle3').highcharts({
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: false,
                    }
                },
                title: {
                    text: 'Current Week\'s Claims'
                },
                subtitle: {
                    text: 'Current Claims Status'
                },
                plotOptions: {
                    pie: {
                        innerSize: 175,
                        depth: 45
                    }
                },
                series: [{
                    name: 'Claims',
                    data: [
                        ['Pending (200)', 200],
                        ['Finalized (400)', 400],
                        ['In Process (100)', 100]
                    ]
                }]
            });
        });




   //--------> End Circle Charts for Views <----------------
 
    </script>
    
   
    
    <br>
    <br>
    <br>
 