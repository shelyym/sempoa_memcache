<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/24/15
 * Time: 9:18 AM
 */

class BIWebTransaction extends WebService{

    function transaction(){
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
        $t = time();


        //get average transaction value

        //latest transaction

        //max transaction
        //min transaction

        //most buyed products
        //most viewed products

        $tt = new LL_AccStatement();
        $arrTt = $tt->getWhere("Cash_Value > 0 AND (TransactionDateTime BETWEEN '$days_ago' AND '$days_now') ORDER BY TransactionDateTime DESC");

        $value = 0;
        foreach($arrTt as $tts){
            $value += $tts->Cash_Value;
        }
        $atv = $value/count($arrTt);


        $arrStats['Transactions Nr.'] = $arrTt;
//        pr($arrTt);

//        echo $atv;
        ?><div class="row">
        <div class="col-md-12">
            <h1>
                Transaction Dashboard
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
                            openLw("Transaction","<?=_SPPATH;?>BIWebTransaction/transaction?m="+slc,"fade");
                        });
                    </script>
                </li>
            </ol>
        </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><small style="color: white;font-weight: bold;"><?=idr($atv);?></small></h3>
                        <p>Average Transaction Value</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-green">
                    <div class="inner">

                        <h3><small style="color: white;font-weight: bold;"><?=idr($value);?></small></h3>

                        <p>Total Transactions</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-4">
                <div class="small-box bg-yellow">
                    <div class="inner">


                        <h3><?=count($arrTt);?></h3>

                        <p>Number of Transactions</p>
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
                        <h3 class="box-title">Transaction Stats</h3>

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

        <?

        //latest transactions
        $tt = new LL_AccStatement();
        $arrTtNew = $tt->getWhere("(TransactionDateTime BETWEEN '$days_ago' AND '$days_now') ORDER BY TransactionDateTime DESC LIMIT 0,10");


        ?>
        <div class="row">
            <div class="col-md-7">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Transactions</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Store</th>
                                    <th>Value</th>
                                    <th>Points</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                foreach($arrTtNew as $tt){
                                ?>
                                <tr>
                                    <td><?=$tt->TransactionID;?></td>
                                    <td><?=date("d-m-Y",strtotime($tt->TransactionDateTime));?></td>
                                    <td><?=$tt->Description;?></td>
                                    <td><?=$tt->StoreName;?></td>
                                    <td><?=idr($tt->Cash_Value);?></td>
                                    <td><?=$tt->Point_Value;?></td>
                                </tr>
                                <? } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">

                        <a href="javascript:openLw('Transaction_Detail', '<?=_SPPATH;?>LLAccWeb/LL_TransactionDetail', 'fade');
                                activkanMenuKiri('Transaction_Detail');" class="btn btn-sm btn-default btn-flat pull-right">View All Transactions</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
            </div>
            <?

            $arrSales = array();
            $prods = array();
            //calculate top products based on sales
            $lltt = new LL_TransactionDetail();
            foreach($arrTt as $tt){
                $arrProd = $lltt->getWhereFromMultipleTable("detail_trans_id = ".$tt->TransactionID." AND VariantID = detail_varian_id ",array("LL_Article_WImage"));

//                pr($arrProd);
                foreach($arrProd as $prod){
                    $arrSales[$prod->VariantID] += $prod->detail_price_total;
                    $prods[$prod->VariantID] = $prod;
                }
            }

            arsort($arrSales);
//            $arrSales = array_reverse($arrSales);
//            pr($arrSales);
            ?>
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Top Products</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                <tr>
                                    <th>ID</th>
<!--                                    <th>Picture</th>-->
                                    <th>Name</th>

                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? foreach($arrSales as $varid=>$saledata){
                                    if($varid == '2887')continue;
                                    ?>
                                <tr>
                                    <td><?=$varid;?></td>

<!--                                    <td>--><?//=$prods[$varid]->BaseArticleImageFile;?><!--</td>-->
                                    <td><?=$prods[$varid]->VariantNameENG;?></td>
                                    <td>
                                        <?=idr($saledata);?>
                                    </td>
                                </tr>
                                <? } ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
<!--                     /.box-body-->
                    <div class="box-footer clearfix">
<!--                        <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>-->
                        <a href="javascript:openLw('LL_Article', '<?=_SPPATH;?>LLProdWeb/LL_Article_WImage', 'fade');
                                activkanMenuKiri('LL_Article');" class="btn btn-sm btn-default btn-flat pull-right">View All Articles</a>
                    </div>
                    <!-- /.box-footer -->
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
            .users-list-name{
                white-space: nowrap;
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
                $data["Transactions Value"][$label] =  0;
            }

        }
//        pr($xLabels);

        //manage data
        $arrData2 = array();

        $colors = array("#00c0ef","#00a65a","#f39c12","#dd4b39");

//        pr($arrStats);
        foreach($arrStats as $ll=>$arrw) {

            foreach ($arrw as $w) {
                if($ll == "Transactions Nr.") {
                    $curdate = date("d", strtotime($w->TransactionDateTime));
                    $data[$ll][$curdate]++;
                    $data["Transactions Value"][$curdate] += $w->Cash_Value/1000;
                }


            }

//        pr($data);

            $arr = array_values($data[$ll]);
//        pr($arr);

            $c = new Charting();
            $c->label = "Nr";
            $c->data = $arr;
            $c->color = array_pop($colors);


            $arrData2[] = $c;

            $arr = array_values($data["Transactions Value"]);
//        pr($arr);

            $c = new Charting();
            $c->label = "Value";
            $c->data = $arr;
            $c->color = array_pop($colors);


            $arrData2[] = $c;



        }

        Charting::chartJSLine("300px",$xLabels,$arrData2,"false",1,0,"User Statistic","info",1);

//        pr($data);
        return $data;
    }
} 