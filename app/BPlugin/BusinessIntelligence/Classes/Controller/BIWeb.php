<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/13/15
 * Time: 10:59 AM
 */

class BIWeb extends WebService{

    function dashboard(){
        ?>
        <h1>
            App Dashboard
            <small>Preview page</small>
        </h1>
        <div class="appsummary">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>150</h3>

                            <p>App Installs</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>

                            <p>User Registration</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>44</h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

        </div>


        <div class="row">
            <div class="col-md-6">
                <!-- AREA CHART -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Area Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="revenue-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- DONUT CHART -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Donut Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Line Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="line-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- BAR CHART -->
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bar Chart</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="chart" id="bar-chart" style="height: 300px;"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <button id="areadd">click</button>
        <script>
            $(function () {
                "use strict";

                $("#revenue-chart").waitUntilExists(function() {
                    // AREA CHART
                    var area = new Morris.Area({
                        element: 'revenue-chart',
                        resize: true,
                        data: [
                            {y: '2011 Q1', item1: 2666, item2: 2666},
                            {y: '2011 Q2', item1: 2778, item2: 2294},
                            {y: '2011 Q3', item1: 4912, item2: 1969},
                            {y: '2011 Q4', item1: 3767, item2: 3597},
                            {y: '2012 Q1', item1: 6810, item2: 1914},
                            {y: '2012 Q2', item1: 5670, item2: 4293},
                            {y: '2012 Q3', item1: 4820, item2: 3795},
                            {y: '2012 Q4', item1: 15073, item2: 5967},
                            {y: '2013 Q1', item1: 10687, item2: 4460},
                            {y: '2013 Q2', item1: 8432, item2: 5713}
                        ],
                        xkey: 'y',
                        ykeys: ['item1', 'item2'],
                        labels: ['Item 1', 'Item 2'],
                        lineColors: ['#a0d0e0', '#3c8dbc'],
                        hideHover: 'auto'
                    });

                    setTimeout(function(){ area.redraw(); }, 100);

                    $("#areadd").click(function(){
                       area.redraw();
                    });
                });

                // LINE CHART
                var line = new Morris.Line({
                    element: 'line-chart',
                    resize: true,
                    data: [
                        {y: '2011 Q1', item1: 2666},
                        {y: '2011 Q2', item1: 2778},
                        {y: '2011 Q3', item1: 4912},
                        {y: '2011 Q4', item1: 3767},
                        {y: '2012 Q1', item1: 6810},
                        {y: '2012 Q2', item1: 5670},
                        {y: '2012 Q3', item1: 4820},
                        {y: '2012 Q4', item1: 15073},
                        {y: '2013 Q1', item1: 10687},
                        {y: '2013 Q2', item1: 8432}
                    ],
                    xkey: 'y',
                    ykeys: ['item1'],
                    labels: ['Item 1'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });

                setTimeout(function(){ line.redraw(); }, 100);
                //DONUT CHART
                var donut = new Morris.Donut({
                    element: 'sales-chart',
                    resize: true,
                    colors: ["#3c8dbc", "#f56954", "#00a65a"],
                    data: [
                        {label: "Download Sales", value: 12},
                        {label: "In-Store Sales", value: 30},
                        {label: "Mail-Order Sales", value: 20}
                    ],
                    hideHover: 'auto'
                });
                setTimeout(function(){ donut.redraw(); }, 100);


                setTimeout(function(){
                    //BAR CHART
                    var bar = new Morris.Bar({
                        element: 'bar-chart',
                        resize: true,
                        data: [
                            {y: '2006', a: 100, b: 90},
                            {y: '2007', a: 75, b: 65},
                            {y: '2008', a: 50, b: 40},
                            {y: '2009', a: 75, b: 65},
                            {y: '2010', a: 50, b: 40},
                            {y: '2011', a: 75, b: 65},
                            {y: '2012', a: 100, b: 90}
                        ],
                        barColors: ['#00a65a', '#f56954'],
                        xkey: 'y',
                        ykeys: ['a', 'b'],
                        labels: ['CPU', 'DISK'],
                        hideHover : false,
                        stacked : true,
                        hoverCallback: function (index, options, content, row) {
                            return "sin(" + row.x + ") = " + row.y;
                        }
                    });
                }, 100);

            });
                </script>
        <?
    }

    function demographic(){


       ?>
        <h1>
            Member Dashboard
            <small>Preview page</small>
        </h1>
<div class="row">
    <div class="col-md-6">
        <!-- USERS LIST -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Latest Members</h3>

                <div class="box-tools pull-right">
                    <span class="label label-danger">8 New Members</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <ul class="users-list clearfix">
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user1-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander Pierce</a>
                        <span class="users-list-date">Today</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user8-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Norman</a>
                        <span class="users-list-date">Yesterday</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user7-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Jane</a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user6-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user2-160x160.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander</a>
                        <span class="users-list-date">13 Jan</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user5-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Sarah</a>
                        <span class="users-list-date">14 Jan</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user4-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nora</a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                    <li>
                        <img src="<?=_SPPATH;?>themes/adminlte2/dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                    </li>
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <a href="javascript::" class="uppercase">View All Users</a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!--/.box -->
    </div>

</div>

        <?
    }

    function campaign(){

        $c = new Charting();
        $c->color = "#dceade";
        $c->label = "enak";
        $c->value = 15;
        $arrData[] = $c;

        $c = new Charting();
        $c->color = "#ff0011";
        $c->label = "ga enak";
        $c->value = 35;
        $arrData[] = $c;

        $c = new Charting();
        $c->color = "#6688aa";
        $c->label = "biasa";
        $c->value = 75;
        $arrData[] = $c;

        ?><div class="col-md-6"><?
        Charting::morrisDonut("300px",$arrData,1,"Ini morris","default");
        ?></div>
        <div class="col-md-6"><?
        Charting::chartJSPie("300px",$arrData,50,1,1,"Bagan keren");
?></div><?
        //for line and area

        $xLabels = array("Jan","Feb","Mar","April","May");

        $c = new Charting();
        $c->label = "Shoes";
        $c->data = array(10,15,30,12,21);
        $c->color = "rgba(255,132,123,0.8)";

        $c->strokeColor = "red";
        $c->fillColor = "pink";
        $c->pointColor = "orange";
        $c->pointHighlightStroke = "blue";
        $c->pointStrokeColor = "black";
        $arrData2[] = $c;

        $c = new Charting();
        $c->label = "Apparel";
        $c->data = array(13,25,10,12,23);
        $c->color = "rgba(255,243,123,0.8)";

        $c->strokeColor = "green";
        $arrData2[] = $c;

        $c = new Charting();
        $c->label = "Books";
        $c->data = array(11,15,16,13,33);
        $c->color =  "rgba(145,255,255,0.8)";
        $arrData2[] = $c;

?><div class="col-md-6"><?
        Charting::chartJSLine("300px",$xLabels,$arrData2,"false",1,1,"data kedua","info");

        ?>
        </div>
    <style>
        ul.legend li{
           list-style: none;
            line-height: 30px;
        }
        ul.legend li div{
            float: left;
            margin-top: 10px;
            margin-right: 15px;
        }
        .legend-item{
            float: left;
            margin: 10px;
            line-height: 30px;
            margin-right: 20px;
        }
        .legend-item div{
            float: left;
            margin-top: 10px;
            margin-right: 5px;
        }
    </style>
        <div class="col-md-6">
        <?

        Charting::chartJSBar("300px",$xLabels,$arrData2,"false",1,1,"data terakhir","danger");
        ?></div><?
    }

    function transaction(){
        ?>
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Donut Chart</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <canvas id="pieChart" style="height:250px"></canvas>

                <canvas id="pieChart2" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
        </div>
<script>



    window.chartOptions = {
        segmentShowStroke: false,
        percentageInnerCutout: 75,
        animation: false
    };

    var chartUpdate = function(value) {
        console.log("Updating Chart: ", value);

        // Replace the chart canvas element
        $('#pieChart2').replaceWith('<canvas id="pieChart2" width="300" height="300"></canvas>');

        // Draw the chart
        var ctx = $('#pieChart2').get(0).getContext("2d");
        new Chart(ctx).Doughnut([
                { value: value,
                    color: '#4FD134' },
                { value: 100-value,
                    color: '#DDDDDD' }],
            window.chartOptions);

        // Schedule next chart update tick
        setTimeout (function() { chartUpdate(value - 1); }, 1000);
    }
    $(document).ready(function() {
        setTimeout (function() { chartUpdate(99); }, 1000);
    });


    setTimeout (function() {
        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [
            {
                value: 700,
                color: "#f56954",
                highlight: "#f56954",
                label: "Chrome"
            },
            {
                value: 500,
                color: "#00a65a",
                highlight: "#00a65a",
                label: "IE"
            },
            {
                value: 400,
                color: "#f39c12",
                highlight: "#f39c12",
                label: "FireFox"
            },
            {
                value: 600,
                color: "#00c0ef",
                highlight: "#00c0ef",
                label: "Safari"
            },
            {
                value: 300,
                color: "#3c8dbc",
                highlight: "#3c8dbc",
                label: "Opera"
            },
            {
                value: 100,
                color: "#d2d6de",
                highlight: "#d2d6de",
                label: "Navigator"
            }
        ];
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

    }, 1000);
</script>
    <?
    }
} 