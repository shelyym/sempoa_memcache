<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/5/16
 * Time: 11:51 AM
 */

class MyDashboard {

    public static function getMyDashboard(){
        $acc = Account::getAccountObject();

        $myid = Account::getMyID();
        $kom = new KomisiModel();

        global $db;
//        $q = "SELECT SUM(komisi_value) FROM {$kom->table_name}"
        $arrKom = $kom->getWhere("komisi_acc_id = '$myid'  ORDER BY komisi_app_date ASC");

        $paid = 0;
        $unpaid = 0;
        $total = 0;

        $free = 0;
        $android = 0;
        $androidios = 0;
        $totalpaketbayar = 0;
        $totalpaket = 0;

        foreach($arrKom as $kom){
            if($kom->komisi_status == 1){
                $paid += $kom->komisi_value;
            }else{
                $unpaid += $kom->komisi_value;
            }
            $total += $kom->komisi_value;

            if($kom->komisi_paket_id == 1){
                //free
                $free++;
            }
            if($kom->komisi_paket_id == 2){
                //free
                $android++;
                $totalpaketbayar++;
            }
            if($kom->komisi_paket_id == 3){
                //free
                $androidios++;
                $totalpaketbayar++;
            }
            $totalpaket++;
        }


        //get applied banner
        $bm = new BannerModel();
        $arrBm = $bm->getWhere("banner_interval_begin <= $totalpaketbayar AND banner_interval_end >= $totalpaketbayar AND banner_active = 1");
//        pr($arrBm);
        if(count($arrBm)>0){
            $selBanner = $arrBm[0];
        }

        //get applied level
        $lv = new LevelModel();
        $arrLvl = $lv->getWhere("level_start<=$totalpaketbayar AND level_end>=$totalpaketbayar AND level_active = 1");
        if(count($arrLvl)>0){
            $selLvl = $arrLvl[0];
        }
        ?>
        <style>


            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
                    padding-left: 0px;
                    padding-right: 0px;

                }
                .container {
                    padding-right: 0px;
                    padding-left: 0px;
                }
                .attop{
                    /*padding-top: 50px;*/
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }
                #attratas{
                    margin-top: 30px;
                }
                #agentbanner{
                    padding-right: 0px;
                }
                .stats{
                    /*min-height: 250px;*/
                }
                .stats_text{
                    /*padding-top: 30px;*/
                }
                .stats_number_big{
                    /*font-size: 40px;*/
                }
                .stats_money{
                    font-weight: bold;
                    /*font-size: 30px;*/
                }
                .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
                    padding-left: 0px;
                    padding-right: 0px;

                }
            }
        </style>
        <div class="container attop"  >
            <div class="col-md-12">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-dashboard.png" >
                    </a>
                </div>

                <div id="attratas">


                    <button onclick="document.location='<?=_SPPATH;?>invite';" class="btn btn-success btn-abu" style="margin: 0px;  ">Invite</button>
                    <button onclick="document.location='<?=_SPPATH;?>mysales';" class="btn btn-success btn-abu" style="margin: 0px;  ">Sales</button>

                    <button onclick="document.location='<?=_SPPATH;?>myapps';" class="btn btn-success btn-abu" style="margin: 0px;">Apps</button>
                </div>

                <div class="clearfix"></div>
                <div  class="col-md-12" >
                    <?
//halo
                    $sales = AppearSales::calculatePaidSalesCount(Account::getMyID(),date('n'),date('Y'));
//                                        pr($sales);

                    $lastmon = getFirstDayOfLastMonth(date('n'),date('Y'),"n");
                    $lastyear = getFirstDayOfLastMonth(date('n'),date('Y'),"Y");
                    $lastmonsales = AppearSales::calculatePaidSalesCount(Account::getMyID(),$lastmon,$lastyear);

                    //revenue
                    $rev = AppearSales::calculateRevenueCount(Account::getMyID());

                    $target = AppearSales::calculateTarget(0);
                    ?>

                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <div class="stats_text"><i class="glyphicon glyphicon-signal"></i> last month</div>
                        <div class="stats_number_big green"><?=$lastmonsales->nr;?></div>
                        <div class="stats_money">IDR <?=idr($lastmonsales->total);?></div>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <div class="stats_text"><i class="glyphicon glyphicon-stats"></i> this month</div>
                        <div class="stats_number_big green"><?=$sales->nr;?></div>
                        <div class="stats_money">IDR <?=idr($sales->total);?></div>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <div class="stats_text"><i class="glyphicon glyphicon-fire"></i> target</div>
                        <div class="stats_number_big green">+<?=$target['nr'];?></div>
                        <div class="stats_money">+IDR <?=idr($target['total']);?></div>
                    </div>

                    <?


//                    pr($rev);

                    ?>
                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <div class="stats_text"><i class="glyphicon glyphicon-scale"></i> revenue</div>
                        <div class="stats_number_big green"><?=$rev->nr;?></div>
                        <div class="stats_money">IDR <?=idr($rev->total);?></div>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <div class="stats_text"><i class="glyphicon glyphicon-tag"></i> free</div>
                        <div class="stats_number_big green">7</div>
                        <div class="stats_money">9</div>
                    </div>

                    <div class="col-md-2 col-sm-6 col-xs-6 stats">
                        <?if(count($arrLvl)>0){?>
                            <div class="level_image"><img height="91px" src="<?=_SPPATH._PHOTOURL.$selLvl->level_img;?>"></div>
                            <div class="stats_money"><?=$selLvl->level_name;?></div>
                        <? } ?>
                    </div>

                </div>
                <div class="clearfix"></div>

                <? if(count($arrBm)>0){?>
                    <div  class="col-md-4 col-sm-12 col-xs-12" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                    <div  class="col-md-4" style="padding-left: 0px; padding-right: 0px;" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                    <div  class="col-md-4" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                <?}?>

                <? if($acc->admin_isAgent <1){?>
                    <div class="total_commision">
                        <a href="<?=_SPPATH;?>become_agent">Please complete Agent registration, to start earning your share.</a>
                    </div>
                <?}?>




                <div class="clearfix" style="margin-bottom: 100px;"></div>
            </div>
        </div>

    <?
    }

    /*
    *  my sales
    */

    public static function mysales(){


        $agent_id = Account::getMyID();
        $agent = "AND komisi_acc_id = '$agent_id'";

        $komisiModel = new KomisiModel();


        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");




        $date = new DateTime();
        $date->setDate($y, $mon, 1);
        $ymd= $date->format('Y-m-d');


        $thismon = $mon;
        $prev_mon = date('n',strtotime($ymd." -3 months"));
        $prev_year = date('Y',strtotime($ymd." -3 months"));



        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        ?>
        <style>
            .heading_earning{
                font-size: 17px;
                font-style: italic;
            }
            .heading_amount{
                font-size: 40px;
            }
            .heading_amount a{
                color: inherit;
                text-decoration: none;
            }
            .heading_amount a:hover{
                text-decoration: underline;
            }

            .inside{
                padding: 20px;
            }
            .selectMonth{
                padding-left: 10px;
            }
            .target_text{
                color: #00733e;
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .selectMonth{
                    padding-bottom: 20px;
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder,.topborder,.bottomborder{
                    background-color: #ffffff;
                    min-height: 115px;
                    text-align: center;
                    padding-top: 10px;
                }
                .endingborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .heading_amount{
                    font-size: 20px;
                }
                .heading_earning{
                    font-size: 13px;
                    font-style: italic;
                }
                .mobilelb{
                    border-left: 1px solid #CCCCCC;
                }
                .detail_text{
                    font-size: 12px;
                }
                .inside{
                    padding: 10px;
                }
                .container{
                    padding-left: 0px;
                    padding-right: 0px;
                }
            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }


                .rightborder{
                    border-right: 1px solid #CCCCCC;
                }
                .topborder{
                    border-top: 1px solid #CCCCCC;
                }
                .rightborder,.topborder,.bottomborder{
                    background-color: #ffffff;
                    min-height: 141px;
                }
            }
        </style>
        <div class="container attop"  >
            <div class="col-md-12">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-dashboard.png" >
                    </a>
                </div>

                <div id="attratas">

                    <button onclick="$('#selectMonth').toggle();" class="btn btn-success btn-abu" style="margin: 0px;  ">Select Month</button>
                    <button onclick="document.location='<?=_SPPATH;?>invite';" class="btn btn-success btn-abu" style="margin: 0px;  ">Invite</button>

                    <button onclick="document.location='<?=_SPPATH;?>myapps';" class="btn btn-success btn-abu" style="margin: 0px;">Apps</button>


                </div>

                <div class="clearfix"></div>
                <div  class="col-md-12" id="comission" >

                    <div class="selectMonth" id="selectMonth" style="display: none; padding-bottom: 10px;">
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px;">Month</div>
                            <div style="float: left;">
                            <select id="mon" class="form-control">
                                <? for($x=1;$x<13;$x++){ ?>
                                    <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
                                <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px; padding-left: 10px;">Year</div>
                            <div style="float: left;">
                                <select id="year" class="form-control">
                                    <? for($x=2016;$x<2030;$x++){ ?>
                                        <option <?if($y==$x)echo "selected";?>  value="<?=$x;?>"><?=$x;?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left; padding-left: 10px;">
                            <button id="change" type="button" class="btn btn-default">Go</button>
                            </div>

                        <div class="clearfix"></div>




                        <script>
                            $('#change').click(function(){
                                document.location = '<?=_SPPATH;?>mydashboard?mon='+$('#mon').val()+'&y='+$('#year').val();
//                openLw("Comissioning",'<?//=_SPPATH;?>//FinanceBE/comissioning?mon='+$('#mon').val()+'&y='+$('#year').val(),'fade');
                            });
                        </script>
                    </div>

                    <?

                    $sales = AppearSales::calculatePaidSalesCount(Account::getMyID(),$mon,$y);
                    //                                        pr($sales);

                    $lastmon = getFirstDayOfLastMonth($mon,$y,"n");
                    $lastyear = getFirstDayOfLastMonth($mon,$y,"Y");
                    $lastmonsales = AppearSales::calculatePaidSalesCount(Account::getMyID(),$lastmon,$lastyear);

                    //revenue
                    $rev = AppearSales::calculateRevenueCount(Account::getMyID());
                    $paid_count = AppearSales::paidCount($agent_id);
                    $target = AppearSales::calculateTarget($paid_count);


                    $dateObj   = DateTime::createFromFormat('!m', $lastmon);
                    $monthNameLast = $dateObj->format('F'); // March

                    $free = AppearSales::calculateFree(Account::getMyID(),$mon,$y);
//                    pr($free);


                    ?>
                    <div class="col-md-4  col-sm-6 col-xs-6  rightborder bottomborder">
                        <div class="inside">
                            <div class="heading_earning">Target </div>
                            <div class="heading_amount target_text">+IDR <?=idr($target['total']);?></div>
                            <div class="detail_text target_text">+<?=$target['nr'];?> more sales to go</div>
                            <!--                    <div class="detail"><a href="--><?//=_SPPATH;?><!--myearning?mon=--><?//=$mon;?><!--&y=--><?//=$y;?><!--">view details</a></div>-->
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-6 rightborder bottomborder mobilelb">
                        <div class="inside">
                            <div class="heading_earning">Earning <?=$monthName;?> <?=$y;?></div>
                            <div class="heading_amount">IDR <a href="<?=_SPPATH;?>myearning?mon=<?=$mon;?>&y=<?=$y;?>"><?=idr($sales->total);?></a></div>
                            <div class="detail_text">You have made <a href="<?=_SPPATH;?>myearning?mon=<?=$mon;?>&y=<?=$y;?>"><?=$sales->nr;?></a> Sales</div>
                            <!--                    <div class="detail">view details</a></div>-->
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-6 bottomborder endingborder ">
                        <div class="inside">
                            <div class="heading_earning">Last Month </div>
                            <div class="heading_amount">IDR <a href="<?=_SPPATH;?>myearning?mon=<?=$lastmon;?>&y=<?=$lastyear;?>"><?=idr($lastmonsales->total);?></a></div>
                            <div class="detail_text">Last month you made <a href="<?=_SPPATH;?>myearning?mon=<?=$lastmon;?>&y=<?=$lastyear;?>"><?=$lastmonsales->nr;?></a> Sales</div>

                        </div>

                    </div>



                    <div class="col-md-4  col-sm-6 col-xs-6 rightborder topborder mobilelb">
                        <div class="inside">
                            <div class="heading_earning">Freebies <?=$monthName;?> <?=$y;?></div>
                            <div class="heading_amount">IDR <a href="<?=_SPPATH;?>myfreebies?mon=<?=$mon;?>&y=<?=$y;?>"><?=idr($free['total']);?></a></div>
                            <div class="detail_text">You have made <a href="<?=_SPPATH;?>myfreebies?mon=<?=$mon;?>&y=<?=$y;?>"><?=$free['total_free'];?></a> Free Deals</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-6 rightborder topborder">


                        <div class="inside">
                            <div class="heading_earning">Payout <?=$monthName;?> <?=$y;?></div>
                            <div class="heading_amount">IDR <a href="<?=_SPPATH;?>mypayout?mon=<?=$mon;?>&y=<?=$y;?>"><?=idr(AppearSales::calculatePayout($agent_id,$mon,$y)['total']);?></a></div>
                            <div class="detail"><a href="<?=_SPPATH;?>mypayout?mon=<?=$mon;?>&y=<?=$y;?>">payout details</a></div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-6 topborder mobilelb">
                        <div class="inside">
                            <div class="heading_earning">All Time Revenue</div>
                            <div class="heading_amount">IDR <?=idr(AppearSales::calculateRevenue($agent_id));?></div>
                            <div class="detail_text">from <?=$paid_count;?> Sales and <?=AppearSales::freeCount($agent_id);?> Freebies</div>

                        </div>
                    </div>






                </div>

                <div class="clearfix"></div>
                <?
                $acc = Account::getAccountObject();
                //get applied banner
                $bm = new BannerModel();
                $arrBm = $bm->getWhere("banner_interval_begin <= $paid_count AND banner_interval_end >= $paid_count AND banner_active = 1");
                //        pr($arrBm);
                if(count($arrBm)>0){
                    $selBanner = $arrBm[0];
                }

                //get applied level
                $lv = new LevelModel();
                $arrLvl = $lv->getWhere("level_start<=$paid_count AND level_end>=$paid_count AND level_active = 1");
                if(count($arrLvl)>0){
                    $selLvl = $arrLvl[0];
                }
                ?>
                <? if(count($arrBm)>0){?>
                    <div  class="col-md-4 col-sm-12 col-xs-12" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                    <div  class="col-md-4" style="padding-left: 0px; padding-right: 0px;" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                    <div  class="col-md-4" >
                        <!--                    <div style="background-color:#dedede; text-align:center; line-height: 30px; cursor: pointer; position: absolute; width: 30px; height: 30px;" onclick="$('#agentbanner').hide();">x</div>-->
                        <a href="<?=$selBanner->banner_link_url;?>">
                            <img src="<?=_SPPATH._PHOTOURL.$selBanner->banner_img;?>" width="100%">
                        </a>
                    </div>
                <?}?>

                <? if($acc->admin_isAgent<1){?>
                    <div class="total_commision">
                        <a href="<?=_SPPATH;?>become_agent">Please complete Agent registration, to start earning your share.</a>
                    </div>
                <?}?>
            </div>
        </div>
    <?
    }

    public static function mypayout(){

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        $arr = AppearSales::getPayoutArray(Account::getMyID(),$mon,$y);
        ?>
        <style>
            .heading_earning{
                font-size: 17px;
                font-style: italic;
            }
            .heading_amount{
                font-size: 40px;
            }

            .inside{
                padding: 20px;
            }
            .selectMonth{
                /*padding-left: 10px;*/
            }
            .payout{
                color: #95abc2;
            }
            .money{
                font-size: 22px;
                color: #73879C;
            }
            .big{
                font-size: 18px;
                color: #73879C;
            }
            .rev_item{
                background-color: #ffffff;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .order_id{
                font-size: 20px;
                color: #73879C;
            }
            .pdate{
                color: #73879C;
                font-style: italic;
            }
            .heading_amount{
                font-size: 30px;
                text-align: right;
                padding-bottom: 100px;
            }
            .heading_amount_Sales{
                font-size: 18px;
                text-align: right;
                /*padding-bottom: 20px;*/
            }

            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .selectMonth{
                    padding-left: 0px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .leftborder{
                    border-top: 1px solid #CCCCCC;
                }
                .inside{
                    padding: 10px;
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }

                .leftborder{
                    border-left: 1px solid #CCCCCC;
                }

                .rightborder{
                    border-right: 1px solid #CCCCCC;
                }
                hr{
                    padding-top: 20px;
                }
            }
        </style>
        <div class="container attop"  >
        <div class="col-md-12">
        <div class="appear_logo_pages">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-agent.png" >
            </a>
        </div>

        <div id="attratas">

            <button onclick="document.location='<?=_SPPATH;?>mydashboard';" class="btn btn-success btn-abu" style="margin: 0px;  ">Dashboard</button>

        </div>

        <div class="clearfix"></div>
        <div  class="col-md-12" id="comission" >

        <div class="selectMonth" id="selectMonth" style=" padding-bottom: 10px;">
            <div style="float: left;">
                <div style="float: left; line-height: 34px; padding-right: 10px;">Month</div>
                <div style="float: left;">
                    <select id="mon" class="form-control">
                        <? for($x=1;$x<13;$x++){ ?>
                            <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div style="float: left;">
                <div style="float: left; line-height: 34px; padding-right: 10px; padding-left: 10px;">Year</div>
                <div style="float: left;">
                    <select id="year" class="form-control">
                        <? for($x=2016;$x<2030;$x++){ ?>
                            <option <?if($y==$x)echo "selected";?>  value="<?=$x;?>"><?=$x;?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
            <div style="float: left; padding-left: 10px;">
                <button id="change" type="button" class="btn btn-default">Go</button>
            </div>

            <div class="clearfix"></div>




            <script>
                $('#change').click(function(){
                    document.location = '<?=_SPPATH;?>mypayout?mon='+$('#mon').val()+'&y='+$('#year').val();
//                openLw("Comissioning",'<?//=_SPPATH;?>//FinanceBE/comissioning?mon='+$('#mon').val()+'&y='+$('#year').val(),'fade');
                });
            </script>
        </div>



        <div id="rev">
        <h3><?=$monthName;?> <?=$y;?> Payouts</h3>
        <?
        if(count($arr['pertama'])>0) {
            ?>
            <hr>
            <h4>First Payouts</h4>
        <?

        }
        //                                        pr($arr);

        foreach($arr['pertama'] as $tt){
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);
            ?>
            <div class="rev_item col-md-12">
                <div class="col-md-5 ">
                    <div class="inside">
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            <div class="rev_details2">
                                <small>Order ID</small>
                                <div class="order_id"><?=$tt->komisi_order_id;?></div>
                            </div>
                        </div>
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            <div class="rev_details">
                                Date : <?=$tt->komisi_app_date;?>
                            </div>
                            <div class="rev_details">
                                App : <?=$app->app_name;?>
                            </div>
                            <div class="rev_details">
                                Client : <?=$acc->admin_nama_depan;?>
                            </div>
                            <div class="rev_details">
                                Paket  : <?=$paket->paket_name;?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-3 payout">
                    <div class="inside">
                        <div class="komisi">
                            Total Commision
                            <div class="money big">IDR <?=idr($tt->komisi_value);?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 leftborder rightborder">
                    <div class="inside">
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            First Payout
                            <div class="money">IDR <?=idr($tt->komisi_bagi_pertama_value);?></div>
                            <small>will be processed on</small>
                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_pertama_date));?></div>
                            <small>*if agent ready</small>
                        </div>
                        <!--                                        <div class="payout col-md-6 col-sm-6 col-xs-6">-->
                        <!--                                            Second Payout-->
                        <!--                                            <div class="money">IDR --><?//=idr($tt->komisi_bagi_kedua_value);?><!--</div>-->
                        <!--                                            <small>will be processed on</small>-->
                        <!--                                            <div class="pdate">--><?//=date("d-m-Y",strtotime($tt->komisi_bagi_kedua_date));?><!--</div>-->
                        <!---->
                        <!--                                            <small>*if agent ready</small>-->
                        <!--                                        </div>-->
                        <div class="clearfix"></div>
                    </div>
                </div>


                <div class="clearfix"></div>
            </div>
        <? } ?>
        <?
        if(count($arr['kedua'])>0) {
            ?>
            <div class="clearfix"></div>
            <hr>
            <h4>Second Payouts</h4>
        <?
        }
        foreach($arr['kedua'] as $tt){
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);
            ?>
            <div class="rev_item col-md-12">
                <div class="col-md-5 ">
                    <div class="inside">
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            <div class="rev_details2">
                                <small>Order ID</small>
                                <div class="order_id"><?=$tt->komisi_order_id;?></div>
                            </div>
                        </div>
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            <div class="rev_details">
                                Date : <?=$tt->komisi_app_date;?>
                            </div>
                            <div class="rev_details">
                                App : <?=$app->app_name;?>
                            </div>
                            <div class="rev_details">
                                Client : <?=$acc->admin_nama_depan;?>
                            </div>
                            <div class="rev_details">
                                Paket  : <?=$paket->paket_name;?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-3 payout">
                    <div class="inside">
                        <div class="komisi">
                            Total Commision
                            <div class="money big">IDR <?=idr($tt->komisi_value);?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 leftborder rightborder">
                    <div class="inside">
                        <!--                                        <div class="payout col-md-6 col-sm-6 col-xs-6">-->
                        <!--                                            First Payout-->
                        <!--                                            <div class="money">IDR --><?//=idr($tt->komisi_bagi_pertama_value);?><!--</div>-->
                        <!--                                            <small>will be processed on</small>-->
                        <!--                                            <div class="pdate">--><?//=date("d-m-Y",strtotime($tt->komisi_bagi_pertama_date));?><!--</div>-->
                        <!--                                            <small>*if agent ready</small>-->
                        <!--                                        </div>-->
                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                            Second Payout
                            <div class="money">IDR <?=idr($tt->komisi_bagi_kedua_value);?></div>
                            <small>will be processed on</small>
                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_kedua_date));?></div>

                            <small>*if agent ready</small>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>


                <div class="clearfix"></div>
            </div>
        <? } ?>
        <?
        if(count($arr['bonus'])>0) {
            ?>
            <div class="clearfix"></div>
            <hr>
            <h4>Bonuses</h4>
        <?
        }
        foreach($arr['bonus'] as $tt){
            $app = new BonusKomisi();
            $app->getByID($tt->bagi_bk_id);

            $acc = new Account();
            $acc->getByID($tt->bagi_acc_id);


            ?>
            <div class="rev_item col-md-12">
                <div class="col-md-4 payout ">
                    <div class="inside">
                        <div class="rev_details2">

                            <div class="order_id">Bonus <?=$tt->bagi_bk_id;?></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 payout ">
                    <div class="inside">
                        Date : <?=$tt->bagi_date_acquire;?>
                    </div>
                </div>
                <div class="col-md-4 payout leftborder">
                    <div class="inside">
                        <div class="komisi">
                            Total Bonus
                            <div class="money">IDR <?=idr($tt->bagi_value);?></div>
                        </div>
                    </div>
                </div>




                <div class="clearfix"></div>
            </div>
        <? } ?>
        <!--                        <div class="heading_amount_Sales">Number of Sales --><?//=count($arr['total']);?><!--</div>-->

        <div class="heading_amount">Total Payout IDR <?=idr(AppearSales::calculatePayout(Account::getMyID(),$mon,$y)['total']);?></div>
        </div>

        </div>
        </div>
        </div>
    <?
    }

    public static function myearning(){

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        ?>
        <style>
            .heading_earning{
                font-size: 17px;
                font-style: italic;
            }
            .heading_amount{
                font-size: 40px;
            }

            .inside{
                padding: 20px;
            }
            .selectMonth{
                /*padding-left: 10px;*/
            }
            .payout{
                color: #95abc2;
            }
            .money{
                font-size: 22px;
                color: #73879C;
            }
            .big{
                font-size: 30px;
                color: #73879C;
            }
            .rev_item{
                background-color: #ffffff;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .order_id{
                font-size: 20px;
                color: #73879C;
            }
            .pdate{
                color: #73879C;
                font-style: italic;
            }
            .heading_amount{
                font-size: 30px;
                text-align: right;
                padding-bottom: 100px;
            }
            .heading_amount_Sales{
                font-size: 18px;
                text-align: right;
                /*padding-bottom: 20px;*/
            }

            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .selectMonth{
                    padding-left: 0px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .leftborder{
                    border-top: 1px solid #CCCCCC;
                }
                .inside{
                    padding: 10px;
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }

                .leftborder{
                    border-left: 1px solid #CCCCCC;
                }

                .rightborder{
                    border-right: 1px solid #CCCCCC;
                }
            }
        </style>
        <div class="container attop"  >
            <div class="col-md-12">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-agent.png" >
                    </a>
                </div>

                <div id="attratas">

                     <button onclick="document.location='<?=_SPPATH;?>mydashboard';" class="btn btn-success btn-abu" style="margin: 0px;  ">Dashboard</button>

                </div>

                <div class="clearfix"></div>
                <div  class="col-md-12" id="comission" >
                    <div class="selectMonth" id="selectMonth" style=" padding-bottom: 10px;">
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px;">Month</div>
                            <div style="float: left;">
                                <select id="mon" class="form-control">
                                    <? for($x=1;$x<13;$x++){ ?>
                                        <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px; padding-left: 10px;">Year</div>
                            <div style="float: left;">
                                <select id="year" class="form-control">
                                    <? for($x=2016;$x<2030;$x++){ ?>
                                        <option <?if($y==$x)echo "selected";?>  value="<?=$x;?>"><?=$x;?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left; padding-left: 10px;">
                            <button id="change" type="button" class="btn btn-default">Go</button>
                        </div>

                        <div class="clearfix"></div>




                        <script>
                            $('#change').click(function(){
                                document.location = '<?=_SPPATH;?>myearning?mon='+$('#mon').val()+'&y='+$('#year').val();
//                openLw("Comissioning",'<?//=_SPPATH;?>//FinanceBE/comissioning?mon='+$('#mon').val()+'&y='+$('#year').val(),'fade');
                            });
                        </script>
                    </div>


                    <div id="rev">
                        <h3><?=$monthName;?> <?=$y;?> Earnings</h3>
                        <?
                        $arr = AppearSales::getRevenueArray(Account::getMyID(),$mon,$y);
                        //                pr($arr);
$total = 0;
                        foreach($arr as $tt){
                            $app = new AppAccount();
                            $app->getByID($tt->komisi_app_id);

                            $acc = new Account();
                            $acc->getByID($tt->komisi_app_client_id);

                            $paket = new Paket();
                            $paket->getByID($tt->komisi_paket_id);

                            $total += $tt->komisi_value;
                            ?>
                            <div class="rev_item col-md-12">
                                <div class="col-md-5 ">
                                    <div class="inside">
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            <div class="rev_details2">
                                                <small>Order ID</small>
                                                <div class="order_id"><?=$tt->komisi_order_id;?></div>
                                            </div>
                                        </div>
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            <div class="rev_details">
                                                Date : <?=$tt->komisi_app_date;?>
                                            </div>
                                            <div class="rev_details">
                                                App : <?=$app->app_name;?>
                                            </div>
                                            <div class="rev_details">
                                                Client : <?=$acc->admin_nama_depan;?>
                                            </div>
                                            <div class="rev_details">
                                                Paket  : <?=$paket->paket_name;?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-md-4 leftborder rightborder">
                                    <div class="inside">
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            First Payout
                                            <div class="money">IDR <?=idr($tt->komisi_bagi_pertama_value);?></div>
                                            <small>will be processed on</small>
                                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_pertama_date));?></div>
                                            <small>*if agent ready</small>
                                        </div>
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            Second Payout
                                            <div class="money">IDR <?=idr($tt->komisi_bagi_kedua_value);?></div>
                                            <small>will be processed on</small>
                                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_kedua_date));?></div>

                                            <small>*if agent ready</small>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-md-3 payout">
                                    <div class="inside">
                                        <div class="komisi">
                                            Total Commision
                                            <div class="money big">IDR <?=idr($tt->komisi_value);?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <? } ?>

                        <div class="heading_amount_Sales">Number of Sales <?=count($arr);?></div>

                        <div class="heading_amount">Total Earning IDR <?=idr($total);?></div>
                    </div>

                </div>
            </div>
        </div>
    <?
    }

    public static function myfreebies(){

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March
        ?>
        <style>
            .heading_earning{
                font-size: 17px;
                font-style: italic;
            }
            .heading_amount{
                font-size: 40px;
            }

            .inside{
                padding: 20px;
            }
            .selectMonth{
                /*padding-left: 10px;*/
            }
            .payout{
                color: #95abc2;
            }
            .money{
                font-size: 22px;
                color: #73879C;
            }
            .big{
                font-size: 30px;
                color: #73879C;
            }
            .rev_item{
                background-color: #ffffff;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .order_id{
                font-size: 20px;
                color: #73879C;
            }
            .pdate{
                color: #73879C;
                font-style: italic;
            }
            .heading_amount{
                font-size: 30px;
                text-align: right;
                padding-bottom: 100px;
            }
            .heading_amount_Sales{
                font-size: 18px;
                text-align: right;
                /*padding-bottom: 20px;*/
            }

            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .selectMonth{
                    padding-left: 0px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .leftborder{
                    border-top: 1px solid #CCCCCC;
                }
                .inside{
                    padding: 10px;
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }

                .leftborder{
                    border-left: 1px solid #CCCCCC;
                }

                .rightborder{
                    border-right: 1px solid #CCCCCC;
                }
            }
        </style>
        <div class="container attop"  >
            <div class="col-md-12">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-agent.png" >
                    </a>
                </div>

                <div id="attratas">

                     <button onclick="document.location='<?=_SPPATH;?>mydashboard';" class="btn btn-success btn-abu" style="margin: 0px;  ">Dashboard</button>

                </div>

                <div class="clearfix"></div>
                <div  class="col-md-12" id="comission" >
                    <div class="selectMonth" id="selectMonth" style=" padding-bottom: 10px;">
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px;">Month</div>
                            <div style="float: left;">
                                <select id="mon" class="form-control">
                                    <? for($x=1;$x<13;$x++){ ?>
                                        <option <?if($mon==$x)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left;">
                            <div style="float: left; line-height: 34px; padding-right: 10px; padding-left: 10px;">Year</div>
                            <div style="float: left;">
                                <select id="year" class="form-control">
                                    <? for($x=2016;$x<2030;$x++){ ?>
                                        <option <?if($y==$x)echo "selected";?>  value="<?=$x;?>"><?=$x;?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div style="float: left; padding-left: 10px;">
                            <button id="change" type="button" class="btn btn-default">Go</button>
                        </div>

                        <div class="clearfix"></div>




                        <script>
                            $('#change').click(function(){
                                document.location = '<?=_SPPATH;?>myfreebies?mon='+$('#mon').val()+'&y='+$('#year').val();
//                openLw("Comissioning",'<?//=_SPPATH;?>//FinanceBE/comissioning?mon='+$('#mon').val()+'&y='+$('#year').val(),'fade');
                            });
                        </script>
                    </div>


                    <div id="rev">
                        <h3><?=$monthName;?> <?=$y;?> Earnings</h3>
                        <?
                        $arr = AppearSales::getFreebiesRevenueArray(Account::getMyID(),$mon,$y);
                        //                pr($arr);
                        $total = 0;
                        foreach($arr as $tt){
                            $app = new AppAccount();
                            $app->getByID($tt->komisi_app_id);

                            $acc = new Account();
                            $acc->getByID($tt->komisi_app_client_id);

                            $paket = new Paket();
                            $paket->getByID($tt->komisi_paket_id);

                            $total += $tt->komisi_value;
                            ?>
                            <div class="rev_item col-md-12">
                                <div class="col-md-5 ">
                                    <div class="inside">
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            <div class="rev_details2">
                                                <small>Order ID</small>
                                                <div class="order_id"><?=$tt->komisi_order_id;?></div>
                                            </div>
                                        </div>
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            <div class="rev_details">
                                                Date : <?=$tt->komisi_app_date;?>
                                            </div>
                                            <div class="rev_details">
                                                App : <?=$app->app_name;?>
                                            </div>
                                            <div class="rev_details">
                                                Client : <?=$acc->admin_nama_depan;?>
                                            </div>
                                            <div class="rev_details">
                                                Paket  : <?=$paket->paket_name;?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-md-4 leftborder rightborder">
                                    <div class="inside">
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            First Payout
                                            <div class="money">IDR <?=idr($tt->komisi_bagi_pertama_value);?></div>
                                            <small>will be processed on</small>
                                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_pertama_date));?></div>
                                            <small>*if agent ready</small>
                                        </div>
                                        <div class="payout col-md-6 col-sm-6 col-xs-6">
                                            Second Payout
                                            <div class="money">IDR <?=idr($tt->komisi_bagi_kedua_value);?></div>
                                            <small>will be processed on</small>
                                            <div class="pdate"><?=date("d-m-Y",strtotime($tt->komisi_bagi_kedua_date));?></div>

                                            <small>*if agent ready</small>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div class="col-md-3 payout">
                                    <div class="inside">
                                        <div class="komisi">
                                            Total Commision
                                            <div class="money big">IDR <?=idr($tt->komisi_value);?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <? } ?>

                        <div class="heading_amount_Sales">Number of Freebies <?=count($arr);?></div>

                        <div class="heading_amount">Total Earning IDR <?=idr($total);?></div>
                    </div>

                </div>
            </div>
        </div>
    <?
    }


    public static function dashboardWebService($acc){
        $agent_id = $acc->admin_id;

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");


        $date = new DateTime();
        $date->setDate($y, $mon, 1);
        $ymd= $date->format('Y-m-d');



        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March


        $sales = AppearSales::calculatePaidSalesCount($agent_id,$mon,$y);
        //                                        pr($sales);

        $lastmon = getFirstDayOfLastMonth($mon,$y,"n");
        $lastyear = getFirstDayOfLastMonth($mon,$y,"Y");
        $lastmonsales = AppearSales::calculatePaidSalesCount($agent_id,$lastmon,$lastyear);

        //revenue
        $rev = AppearSales::calculateRevenueCount($agent_id);
        $paid_count = AppearSales::paidCount($agent_id);
        $target = AppearSales::calculateTarget($paid_count);


        $dateObj   = DateTime::createFromFormat('!m', $lastmon);
        $monthNameLast = $dateObj->format('F'); // March

        $free = AppearSales::calculateFree($agent_id,$mon,$y);

        $json['acc_id'] = $acc->admin_id;
        $json['mon'] = $mon;
        $json['y'] = $y;

        $json['cube']['target']['total'] = $target['total'];
        $json['cube']['target']['nr'] = $target['nr'];

        if($sales->total == null) $sales->total = 0;
        if($sales->nr == null) $sales->nr = 0;

        $json['cube']['paidsales']['total'] = $sales->total;
        $json['cube']['paidsales']['nr'] = $sales->nr;
        $json['cube']['paidsales']['mon'] = $mon;
        $json['cube']['paidsales']['y'] = $y;

        if($lastmonsales->total == null) $lastmonsales->total = 0;
        if($lastmonsales->nr == null) $lastmonsales->nr = 0;

        $json['cube']['lastmon_paidsales']['total'] = $lastmonsales->total;
        $json['cube']['lastmon_paidsales']['nr'] = $lastmonsales->nr;
        $json['cube']['lastmon_paidsales']['mon'] = $lastmon;
        $json['cube']['lastmon_paidsales']['y'] = $lastyear;

        $json['cube']['freebies']['total'] = $free['total'];
        $json['cube']['freebies']['nr'] = $free['total_free'];
        $json['cube']['freebies']['mon'] = $mon;
        $json['cube']['freebies']['y'] = $y;

        $json['cube']['payout']['total'] = AppearSales::calculatePayout($agent_id,$mon,$y)['total'];
        $json['cube']['payout']['mon'] = $mon;
        $json['cube']['payout']['y'] = $y;

        $json['cube']['revenue']['total'] = AppearSales::calculateRevenue($agent_id);
        $json['cube']['revenue']['paid_nr'] = $paid_count;
        $json['cube']['revenue']['free_nr'] = AppearSales::freeCount($agent_id);




        //get applied banner
        $bm = new BannerModel();
        $arrBm = $bm->getWhere("banner_interval_begin <= $paid_count AND banner_interval_end >= $paid_count AND banner_active = 1");
        //        pr($arrBm);
        if(count($arrBm)>0){
            $selBanner = $arrBm[0];

            $json['banner'][] = array(
                "url" => $selBanner->banner_link_url,
                "img" => _BPATH._PHOTOURL.$selBanner->banner_img,
            );
        }

        //get applied level
        $lv = new LevelModel();
        $arrLvl = $lv->getWhere("level_start<=$paid_count AND level_end>=$paid_count AND level_active = 1");
        if(count($arrLvl)>0){
            $selLvl = $arrLvl[0];

            $json['level'] = array(
                "name" => $selLvl->level_name,
                "img" => _BPATH._PHOTOURL.$selLvl->level_img,
            );
        }



        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        echo json_encode($json);
        die();
    }

    public static function earningWS($acc){


        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $json['acc_id'] = $acc->admin_id;
        $json['mon'] = $mon;
        $json['y'] = $y;

        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        $arr = AppearSales::getRevenueArray($acc->admin_id,$mon,$y);
        //                pr($arr);
        $total = 0;

        foreach($arr as $tt) {
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);

            $total += $tt->komisi_value;

            $earn = array();
            $earn['order_id'] = $tt->komisi_order_id;
            $earn['komisi_app_date'] = $tt->komisi_app_date;
            $earn['app_name'] = $app->app_name;
            $earn['app_id'] = $app->app_id;
            $earn['client_name'] = $acc->admin_nama_depan;
            $earn['paket_id'] = $paket->paket_id;
            $earn['paket_name'] = $paket->paket_name;
            $earn['komisi_bagi_pertama_value'] = $tt->komisi_bagi_pertama_value;
            $earn['komisi_bagi_pertama_date'] = date("F Y",strtotime($tt->komisi_bagi_pertama_date));
            $earn['komisi_bagi_kedua_value'] = $tt->komisi_bagi_kedua_value;
            $earn['komisi_bagi_kedua_date'] = date("F Y",strtotime($tt->komisi_bagi_kedua_date));

            $earn['total_komisi'] = $tt->komisi_value;



            $json['earning'][] = $earn;
        }

        $json['nr_sales'] = count($arr);
        $json['total_sales'] = $total;


        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        echo json_encode($json);
        die();
    }

    public static function freebiesWS($acc){


        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $json['acc_id'] = $acc->admin_id;
        $json['mon'] = $mon;
        $json['y'] = $y;

        $monthNum  = $mon;
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F'); // March

        $arr = AppearSales::getFreebiesRevenueArray($acc->admin_id,$mon,$y);
        //                pr($arr);
        $total = 0;

        foreach($arr as $tt) {
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);

            $total += $tt->komisi_value;

            $earn = array();
            $earn['order_id'] = $tt->komisi_order_id;
            $earn['komisi_app_date'] = $tt->komisi_app_date;
            $earn['app_name'] = $app->app_name;
            $earn['app_id'] = $app->app_id;
            $earn['client_name'] = $acc->admin_nama_depan;
            $earn['paket_id'] = $paket->paket_id;
            $earn['paket_name'] = $paket->paket_name;
            $earn['komisi_tingtong'] = $tt->komisi_ting_tong;
            $earn['komisi_tingtong_date'] = $tt->komisi_tingtong_date;
            $earn['komisi_bagi_pertama_value'] = $tt->komisi_bagi_pertama_value;
            $earn['komisi_bagi_pertama_date'] = date("F Y",strtotime($tt->komisi_bagi_pertama_date));
            $earn['komisi_bagi_kedua_value'] = $tt->komisi_bagi_kedua_value;
            $earn['komisi_bagi_kedua_date'] = date("F Y",strtotime($tt->komisi_bagi_kedua_date));

            $earn['total_komisi'] = $tt->komisi_value;



            $json['earning'][] = $earn;
        }

        $json['nr_sales'] = count($arr);
        $json['total_sales'] = $total;


        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        echo json_encode($json);
        die();
    }

    public static function payoutWS($acc){

        $agent_id = $acc->admin_id;

        $mon = (isset($_GET['mon']))?addslashes($_GET['mon']):date("n");
        $y = (isset($_GET['y']))?addslashes($_GET['y']):date("Y");

        $json['acc_id'] = $acc->admin_id;
        $json['mon'] = $mon;
        $json['y'] = $y;

        $arr = AppearSales::getPayoutArray($acc->admin_id,$mon,$y);

        foreach($arr['pertama'] as $tt) {
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);


            $earn = array();
            $earn['order_id'] = $tt->komisi_order_id;
            $earn['komisi_app_date'] = $tt->komisi_app_date;
            $earn['app_name'] = $app->app_name;
            $earn['app_id'] = $app->app_id;
            $earn['client_name'] = $acc->admin_nama_depan;
            $earn['paket_id'] = $paket->paket_id;
            $earn['paket_name'] = $paket->paket_name;
//            $earn['komisi_tingtong'] = $tt->komisi_ting_tong;
//            $earn['komisi_tingtong_date'] = $tt->komisi_tingtong_date;
            $earn['komisi_bagi_pertama_value'] = $tt->komisi_bagi_pertama_value;
            $earn['komisi_bagi_pertama_date'] = date("F Y",strtotime($tt->komisi_bagi_pertama_date));
            $earn['komisi_bagi_kedua_value'] = $tt->komisi_bagi_kedua_value;
            $earn['komisi_bagi_kedua_date'] = date("F Y",strtotime($tt->komisi_bagi_kedua_date));

            $earn['total_komisi'] = $tt->komisi_value;

            $json['payout']['first'][] = $earn;
        }

        foreach($arr['kedua'] as $tt) {
            $app = new AppAccount();
            $app->getByID($tt->komisi_app_id);

            $acc = new Account();
            $acc->getByID($tt->komisi_app_client_id);

            $paket = new Paket();
            $paket->getByID($tt->komisi_paket_id);


            $earn = array();
            $earn['order_id'] = $tt->komisi_order_id;
            $earn['komisi_app_date'] = $tt->komisi_app_date;
            $earn['app_name'] = $app->app_name;
            $earn['app_id'] = $app->app_id;
            $earn['client_name'] = $acc->admin_nama_depan;
            $earn['paket_id'] = $paket->paket_id;
            $earn['paket_name'] = $paket->paket_name;
//            $earn['komisi_tingtong'] = $tt->komisi_ting_tong;
//            $earn['komisi_tingtong_date'] = $tt->komisi_tingtong_date;
            $earn['komisi_bagi_pertama_value'] = $tt->komisi_bagi_pertama_value;
            $earn['komisi_bagi_pertama_date'] = date("F Y",strtotime($tt->komisi_bagi_pertama_date));
            $earn['komisi_bagi_kedua_value'] = $tt->komisi_bagi_kedua_value;
            $earn['komisi_bagi_kedua_date'] = date("F Y",strtotime($tt->komisi_bagi_kedua_date));

            $earn['total_komisi'] = $tt->komisi_value;

            $json['payout']['kedua'][] = $earn;
        }

        foreach($arr['bonus'] as $tt) {
            $app = new BonusKomisi();
            $app->getByID($tt->bagi_bk_id);

            $acc = new Account();
            $acc->getByID($tt->bagi_acc_id);


            $earn = array();
            $earn['bonus_name'] = "Bonus ".$tt->bagi_bk_id;
            $earn['bonus_date'] = $tt->bagi_date_acquire;
            $earn['bonus_value'] = $tt->bagi_value;

            $json['payout']['bonus'][] = $earn;
        }

        $json['payout_total'] = AppearSales::calculatePayout($agent_id,$mon,$y)['total'];

        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        echo json_encode($json);
        die();
    }
} 