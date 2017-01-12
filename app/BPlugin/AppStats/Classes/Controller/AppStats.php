<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/25/15
 * Time: 3:20 PM
 */

class AppStats extends WebService{

    var $access_app = "normal_user";
    function app(){


        $app_id =  $_SESSION['app_id'];
        if($app_id == "")die("Please insert App ID");




        ?>
        <div id="clientdata">
            <? $this->loadDataApp($app_id); ?>
        </div>
        <?







    }

    var $access_loadDataApp = "normal_user";
    public function loadDataApp($app_id){


        if($app_id == "")die("Please insert App ID");


        $app = new AppAccount();
        $app->getByID($app_id);

//        pr($app);

        $acc = new Account();
        $acc->getByID($app->app_client_id);


        ?>
        <div class="row">

            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?=$acc->admin_pulsa;?></h3>
                        <p>Kuota Push Notifications</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
        </div>

        <?

        $bulan = addslashes($_GET['m']);
        if($bulan == ""){
            $bulan = date("F Y");
            $days_ago = date('Y-m-01'); // hard-coded '01' for first day
            $days_now  = date('Y-m-t');
        }
        else{
            $bulan = urldecode($bulan);
            $days_ago = date('Y-m-01',strtotime($bulan)); // hard-coded '01' for first day
            $days_now  = date('Y-m-t',strtotime($bulan));
        }

        $numberDays = cal_days_in_month(CAL_GREGORIAN, date('n',strtotime($bulan)), date('Y',strtotime($bulan)));

        $days_ago = date('Y-m-01',strtotime($bulan)); // hard-coded '01' for first day
        $days_now  = date('Y-m-01',strtotime('+1 month', strtotime($bulan)));




        //user acquisitions
        $ll = new LL_Account();
        $arrUserNew = $ll->getWhere("(macc_acquire_date BETWEEN '$days_ago' AND '$days_now')","macc_acquire_date");

        //new device
        $dev = new DeviceModel();
        $arrDevNew = $dev->getWhere(" (firstlogin BETWEEN '$days_ago' AND '$days_now') ");

        //device active
        $dlog = new DeviceLogger();
        $arrDevActive = $dlog->getWhere(" (log_date BETWEEN '$days_ago' AND '$days_now') ");

//        count($arrDevActive);
        //user active

        $acclog = new LL_AccountLogger();
        $arrUserActive = $acclog->getWhere("(log_date BETWEEN '$days_ago' AND '$days_now')");

//        count($arrUserActive);

        $arrStats["New Users"] = $arrUserNew;
        $arrStats["Active Users"] = $arrUserActive;
        $arrStats["New Devices"] = $arrDevNew;
        $arrStats["Active Devices"] = $arrDevActive;


        $t = time();
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1>
                    App Dashboard
                    <small><?=$bulan;?></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <?=Lang::t('Select Timeframe');?>
                    </li>
                    <li class="active">
                        <?
                        $start    = new DateTime('11 months ago');
                        // So you don't skip February if today is day the 29th, 30th, or 31st
                        $start->modify('first day of this month');
                        $end      = new DateTime();
                        $interval = new DateInterval('P1M');
                        $period   = new DatePeriod($start, $interval, $end);

                        ?>
                        <select id="apptimeselector_<?=$t;?>">
                            <?
                            foreach ($period as $dt) {?>
                                <option value="<?=urlencode($dt->format('F Y'));?>" <?if($dt->format('F Y') == $bulan)echo "selected";?>>
                                    <? echo $dt->format('F Y') . "<br>"; ?>
                                </option>
                            <? } ?>

                        </select>
                        <script>
                            $("#apptimeselector_<?=$t;?>").change(function(){
                                var slc = $("#apptimeselector_<?=$t;?>").val();
                                openLw("App","<?=_SPPATH;?>BIWebProd/app?m="+slc,"fade");
                            });
                        </script>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?=count($arrUserNew);?></h3>
                        <p>New Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-green">
                    <div class="inner">

                        <h3><?=count($arrUserActive);?></h3>

                        <p>Active Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-yellow">
                    <div class="inner">


                        <h3><?=count($arrDevNew);?></h3>

                        <p>New Devices</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-red">
                    <div class="inner">
                        <?

                        ?>

                        <h3><?=count($arrDevActive);?></h3>

                        <p>Active Devices</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">User Stats</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">

                        <?
                        //            $days_ago = date('Y-m-d', strtotime('-30 days', time()));
                        //            $days_now =  date("Y-m-d");





                        $data = self::getAppStats($arrStats,$days_ago,$days_now);
                        ?>


                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
        <div class="row">

            <?
            $arrDType = array();
            foreach($arrDevActive as $de){
                $arrDType[$de->log_dev_type][] = $de;
            }
            $arrColor = array("#00a65a","#00c0ef");
            foreach($arrDType as $type=>$arrDe) {
                $c = new Charting();
                $c->color = array_pop($arrColor);
                $c->label = $type;
                $c->value = count($arrDe);
                $totalanDevType[$type] = $c->value;
                $arrData[] = $c;
            }

            //                pr($arrData);


            ?><div class="col-md-6"><?
                Charting::morrisDonut("300px",$arrData,1,"Device Type","default");
                ?>

            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Average</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="average" style="padding: 20px;">
                            <?
                            //                                pr($data);
                            $maxUsers = max($data['New Users']);
                            $maxActiveUsers = max($data['Active Users']);
                            $maxNewDevice = max($data['New Devices']);
                            $maxActiveDevice = max($data['Active Devices']);

                            ?>
                            <p class="text-center">
                                <strong></strong>
                            </p>


                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">New Users per Day</span>
                                <span class="progress-number"><b><?=round(count($arrUserNew)/$numberDays,2);?></b>/<?=$maxUsers;?></span>

                                <div class="progress sm">
                                    <?
                                    $percent = (ceil(count($arrUserNew)/$numberDays)/$maxUsers)*100;

                                    ?>
                                    <div class="progress-bar progress-bar-red" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <?
                                $rata2 = round(count($arrUserActive)/$numberDays,2);
                                $percent = round($rata2/$maxActiveUsers*100);
                                ?>
                                <span class="progress-text">Active Users per Day</span>
                                <span class="progress-number"><b><?=$rata2;?></b>/<?=$maxActiveUsers;?></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-yellow" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <?
                                $rata2 = round(count($arrDevNew)/$numberDays,2);
                                $percent = round($rata2/$maxNewDevice*100);
                                ?>

                                <span class="progress-text">New Device per Day</span>
                                <span class="progress-number"><b><?=$rata2;?></b>/<?=$maxNewDevice;?></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-red" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <?
                                $rata2 = round(count($arrDevActive)/$numberDays,2);
                                $percent = round($rata2/$maxActiveDevice*100);
                                ?>

                                <span class="progress-text">Active Device per Day</span>
                                <span class="progress-number"><b><?=$rata2;?></b>/<?=$maxActiveDevice;?></span>

                                <div class="progress sm">
                                    <div class="progress-bar progress-bar-yellow" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">Android vs iOS</span>
                                <span class="progress-number"><b><?=$totalanDevType['android'];?></b>/<?=$totalanDevType['android']+$totalanDevType['ios'];?></span>

                                <div class="progress sm">
                                    <?
                                    $percent = round(($totalanDevType['android']/($totalanDevType['android']+$totalanDevType['ios']))*100);

                                    ?>
                                    <div class="progress-bar progress-bar-aqua" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                            <!-- /.progress-group -->
                            <div class="progress-group">
                                <span class="progress-text">iOS vs Android</span>
                                <span class="progress-number"><b><?=$totalanDevType['ios'];?></b>/<?=$totalanDevType['android']+$totalanDevType['ios'];?></span>

                                <div class="progress sm">
                                    <?
                                    $percent = round(($totalanDevType['ios']/($totalanDevType['android']+$totalanDevType['ios']))*100);

                                    ?>
                                    <div class="progress-bar progress-bar-green" style="width: <?=$percent;?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>

            </div>
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
                margin-right: 5px;
            }
            .legend-item div{
                float: left;
                margin-top: 10px;
                margin-right: 5px;
            }
            .breadcrumb {
                padding: 8px 15px;
                margin-bottom: 20px;
                list-style: none;
                background-color: #f5f5f5;
                border-radius: 4px;
            }
            .breadcrumb {
                float: right;
                background: transparent;
                margin-top: 0;
                margin-bottom: 0;
                font-size: 12px;
                padding: 7px 5px;
                position: absolute;
                top: 15px;
                right: 10px;
                border-radius: 2px;
            }
        </style>

    <?

    }

    public static function getAppStats($arrStats,$beginDate,$endDate){
        //customer acquisition per day
//        $ll = new LL_Account();

//        $arrw = $ll->getWhere("(macc_acquire_date BETWEEN '$beginDate' AND '$endDate')","macc_acquire_date");
//        pr($arrw);
//        echo count($arrw);

        $data = array();

        //for begin date sampai end date day by day
        $start = strtotime($beginDate);
        $finish = strtotime($endDate);
        while($start<$finish){
            $label = date("d",$start);
            $start = strtotime('+1 day', $start);
            $xLabels[] = $label;
            foreach($arrStats as $ll=>$arrw) {
                $data[$ll][$label] =  0;
            }

        }
//        pr($xLabels);

        //manage data
        $arrData2 = array();

        $colors = array_reverse( array("#00c0ef","#00a65a","#f39c12","#dd4b39"));

//        pr($arrStats);
        foreach($arrStats as $ll=>$arrw) {

            foreach ($arrw as $w) {
                if($ll == "New Users") {
                    $curdate = date("d", strtotime($w->macc_acquire_date));
                    $data[$ll][$curdate]++;
                }
                if($ll == "Active Users") {
                    $curdate = date("d", strtotime($w->log_date));
                    $data[$ll][$curdate]++;
                }
                if($ll == "New Devices") {
                    $curdate = date("d", strtotime($w->firstlogin));
                    $data[$ll][$curdate]++;
                }
                if($ll == "Active Devices") {
                    $curdate = date("d", strtotime($w->log_date));
                    $data[$ll][$curdate]++;
                }
            }

//        pr($data);

            $arr = array_values($data[$ll]);
//        pr($arr);

            $c = new Charting();
            $c->label = $ll;
            $c->data = $arr;
            $c->color = array_pop($colors);


            $arrData2[] = $c;


        }

        Charting::chartJSLine("300px",$xLabels,$arrData2,"false",1,0,"User Statistic","info",1);

//        pr($data);
        return $data;
    }

    public static function getAcquire($beginDate,$endDate){
        //customer acquisition per day
        $ll = new LL_Account();

        $arrw = $ll->getWhere("(macc_acquire_date BETWEEN '$beginDate' AND '$endDate')","macc_acquire_date");
//        pr($arrw);
//        echo count($arrw);

        $data = array();

        //for begin date sampai end date day by day
        $start = strtotime($beginDate);
        $finish = strtotime($endDate);
        while($start<=$finish){
            $label = date("d",$start);
            $start = strtotime('+1 day', $start);
            $xLabels[] = $label;
            $data[$label] =  0;
        }
//        pr($xLabels);

        //manage data

        foreach($arrw as $w){
            $curdate = date("d",strtotime($w->macc_acquire_date));
            $data[$curdate]++;
        }
//        pr($data);

        $arr = array_values($data);
//        pr($arr);

        $c = new Charting();
        $c->label = "User Acquisition";
        $c->data = $arr;
        $c->color = "#AAAAAA";


        $arrData2[] = $c;


        Charting::chartJSLine("300px",$xLabels,$arrData2,"false",0,0,"User Acquisition","info",0);

        return $arrw;
    }
} 