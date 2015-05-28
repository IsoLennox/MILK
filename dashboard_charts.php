  
  
<!--  CHARTS -->
  
  
  
   <section class="circle_charts">
    <div class="pie-chart" id="circle1"></div>
<!--
    <div class="pie-chart" id="circle2"></div>
    <div class="pie-chart" id="circle3"></div>
-->
</section>
   
   
<!--  BAR GRAPH-->
   <div id="chart_container" height="400px" width="100%"></div>
 

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
                    colors: ['#157AA3','#575611','#E3E22C'],
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
    