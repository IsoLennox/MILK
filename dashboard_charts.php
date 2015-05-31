  
  
<!--  CHARTS -->
  
  
  
<section class="circle_charts">
    <div class="pie-chart" id="circle1"></div>

    <div class="pie-chart" id="circle2"></div>
    <div class="pie-chart" id="circle3"></div>

</section>
   <br>
   <br>
   <br>
   <br><div class="clearfix"></div>
   
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
                    categories: ['Living Room', 'Kitchen', 'Bathroom', 'Bed Room', 'Attic']
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
            //#4571CD,#9F2EC3,
            // $loop_count=0;
            // foreach($rooms as $room_array){
            //     $loop_count++;
            //             if($loop_count < $room_count){
            //             echo $room_array.", ";
            //             }else{ echo $room_array; }
                    ?>
                    {
                    // colors: ['#157AA3','#575611','#E3E22C'],
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
                    text: 'Claim Types'
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
                    name: 'Claim Types',
                    data: [
                        ['Natural Disaster (515)', 515],
                        ['Floods (600)', 600],
                        ['Fire/Arson (300)', 300],
                        ['Theft (200)', 200],
                        ['Vandalism (80)', 80],
                        ['Other (151)', 151]
                    ]
                }]
            });
        });
    //---------- begin half-circle chart ----------------//
        $(function () {
            $('#circle2').highcharts({
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: 'Claim<br>status',
                    align: 'center',
                    verticalAlign: 'middle',
                    y: 50
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        dataLabels: {
                            enabled: true,
                            distance: -50,
                            style: {
                                fontWeight: 'bold',
                                color: 'white',
                                textShadow: '0px 1px 2px black'
                            }
                        },
                        startAngle: -90,
                        endAngle: 90,
                        center: ['50%', '75%']
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'Claims Status',
                    innerSize: '50%',
                    data: [
                        ['Approved', 45],
                        ['Denied',  27],
                        ['Pending', 15],
                        ['Processing', 10],
                        {
                            name: 'Others',
                            y: 0.7,
                            dataLabels: {
                                enabled: false
                            }
                        }
                    ]
                }]
            });
        });
            
   //--------> End Circle Charts for Views <----------------
 
    </script>
    