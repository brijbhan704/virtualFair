@extends('layouts.master')
@section('main-content')

        <div class="breadcrumb">
                <h1>&nbsp;</h1>
                <ul>
                    <li><a href="">Dashboard</a></li>
                    <li>Visitor Tracker </li>
                </ul>
            </div>
                
            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <div class="content">
                                  
                                <p class="text-muted mt-2 mb-0">TODAY LEADS</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$todays_total}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <i class="i-Add-User"></i>
                            <div class="content">
                                  
                                <p class="text-muted mt-2 mb-0">TOTAL LEADS</p>
                                <p class="text-primary text-24 line-height-1 mb-2">{{$total}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
               
                    
            <div class="row">

                <div class="col-lg-6 col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body" style="position: relative;">
                                <div class="card-title"> City Wise Student </div>
                                <!-- <div id="simpleDonut1" style="min-height: 359px;"> -->
                                <div class="panel-body" align="center">
                                 <div id="pie_chart_today" style="min-height: 359px;" >

                                 </div>
                                </div>
                               <!-- </div> --> 
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-sm-6">
                        <div class="card mb-4">
                            <div class="card-body" style="position: relative;">
                                <div class="card-title"> City Wise Student </div>
                                <!-- <div id="simpleDonut1" style="min-height: 359px;"> -->
                                <div class="panel-body" align="center">
                                 <div id="pie_chart" style="min-height: 359px;" >

                                 </div>
                                </div>
                               <!-- </div> --> 
                        </div>
                    </div>
                  </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Course Interested by student</div>
                           <!--  <div id="simpleDonut2" style="min-height: 359px;"></div> -->
                            <div class="panel-body" align="center">
                                 <div id="pie_chart_today1" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Course Interested by student</div>
                           <!--  <div id="simpleDonut2" style="min-height: 359px;"></div> -->
                            <div class="panel-body" align="center">
                                 <div id="pie_chart1" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">University Interested by student </div>
                            <!-- <div id="simpleDonut3" style="min-height: 359px;"></div> -->
                             <div class="panel-body" align="center">
                                 <div id="pie_chart_today2" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">University Interested by student </div>
                            <!-- <div id="simpleDonut3" style="min-height: 359px;"></div> -->
                             <div class="panel-body" align="center">
                                 <div id="pie_chart2" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Student Activity </div>
                            <!-- <div id="simpleDonut3" style="min-height: 359px;"></div> -->
                             <div class="panel-body" align="center">
                                 <div id="pie_chart_today3" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
                 <div class="col-lg-6 col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="card-title">Student Activity </div>
                            <!-- <div id="simpleDonut3" style="min-height: 359px;"></div> -->
                             <div class="panel-body" align="center">
                                 <div id="pie_chart3" style="min-height: 359px;">

                                 </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            
           


@endsection

@section('page-js')

     <!-- <script src="{{asset('assets/js/vendor/apexcharts.min.js')}}"></script>
     <script src="{{asset('assets/js/vendor/apexcharts.dataseries.js')}}"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- piechart today -->
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Name', 'TotalCount'],

                  <?php                
                    foreach ($info as $key => $value) {
                        echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                    }          
                    ?>  
                ]);
                var options = {                
                };
                var chart = new google.visualization.PieChart(document.getElementById('pie_chart_today'));
                chart.draw(data, options);
              }  
            </script>
            <script type="text/javascript">   
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() 
                    {
                    var data = google.visualization.arrayToDataTable([
                    ['Name', 'TotalCount'],

                    <?php          
                    foreach ($infoTodaycourse as $key => $value) {
                        if(isset($value->pm_id)){
                        $checked=[];
                        $checked =  explode(',',$value->pm_id);
                        if(in_array($value->pm_id, $checked))
                        {
                      // dump($checked);
                      echo "['".$value->Name.' (Total = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                        } 
                      }
                        
                     
                    }          
                    ?>  
                    ]);
                    var options = {};
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_today1'));
                    chart.draw(data, options);
                    }
                </script>
           
                <script type="text/javascript">   
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() 
                    {
                        var data = google.visualization.arrayToDataTable([
                        ['Name', 'TotalCount'],

                        <?php     
                        foreach ($infoTodayuniversity as $key => $value) {
                        echo "['".$value->Name.' (TotalCount = '.$value->TotalCount.')'."',".$value->TotalCount."],";  
                        }          
                        ?>  
                        ]);
                        var options = {};
                        var chart = new google.visualization.PieChart(document.getElementById('pie_chart_today2'));
                        chart.draw(data, options);
                  }
                </script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Name', 'TotalCount'],

                      <?php                
                        foreach ($info as $key => $value) {
                            echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                        }          
                    ?>  
                    ]);
                    var options = {                
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart_today3'));
                    chart.draw(data, options);
                  }  
            </script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['Name', 'TotalCount'],

                  <?php                
                    foreach ($infoTodayactivity as $key => $value) {
                        echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                    }          
                ?>  
                ]);
                var options = {                
                };
                var chart = new google.visualization.PieChart(document.getElementById('pie_chart_today3'));
                chart.draw(data, options);
              }  
            </script>
<!--End  piechart today -->
<!-- Start piechart Total -->
            <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['cm_name', 'TotalCount'],

                      <?php              
                        foreach ($infoTotalcity as $key => $value) {
                            echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                        }          
                    ?>  
                    ]);
                    var options = {
                     
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
                    chart.draw(data, options);
                  }  
            </script>
            <script type="text/javascript">   
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() 
                    {
                    var data = google.visualization.arrayToDataTable([
                    ['Name', 'TotalCount'],

                    <?php 
                    
                    foreach ($infoTotalcourse as $key => $value) {
//dump($value->pm_id);
                    if(isset($value->pm_id)){
                        $checked=[];
                        $checked =  explode(',',$value->pm_id);
                        if(in_array($value->pm_id, $checked))
                        {
                      // dump($checked);
                        echo "['".$value->Name.' (Total = '.$value->TotalCount.')'."',".$value->TotalCount."],";  
                        } 
                      }
                   }
         
                    ?>  
                    ]);
                    var options = {};
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart1'));
                    chart.draw(data, options);
                    }
                </script>
           
                <script type="text/javascript">   
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() 
                    {
                        var data = google.visualization.arrayToDataTable([
                        ['Name', 'TotalCount'],

                        <?php 
                        foreach ($infoTotaluniversity as $key => $value) {
                        echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                        }          
                        ?>  
                        ]);
                        var options = {};
                        var chart = new google.visualization.PieChart(document.getElementById('pie_chart2'));
                        chart.draw(data, options);
                  }
                </script>
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                    ['cm_name', 'TotalCount'],

                  <?php
                                
                    foreach ($infoTotalactivity as $key => $value) {
                        echo "['".$value->Name.' (TotlCount = '.$value->TotalCount.')'."',".$value->TotalCount."],"; 
                    }          
                ?>  
                ]);
                var options = {
                 
                };
                var chart = new google.visualization.PieChart(document.getElementById('pie_chart3'));
                chart.draw(data, options);
              }  
            </script>
                
<!-- End piechart Total -->
@endsection
