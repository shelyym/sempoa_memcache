<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/19/15
 * Time: 12:35 PM
 */

class BIWebDemographic extends WebService{

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    function demographic(){

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


        //male female
        $ll = new LL_Account();
        global $db;

        $query3="Select (Select count(*) from {$ll->table_name} where macc_gender='Male' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS Male,
(Select count(*) from {$ll->table_name} where macc_gender='Female' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS Female ";

        $gender = $db->query($query3,1);
//        pr($gender);


//        macc_lyb_status
        $query4="Select (Select count(*) from {$ll->table_name} where macc_lyb_status='LYB Club' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS Club,
(Select count(*) from {$ll->table_name} where macc_lyb_status='The Body Shop Friend' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS Stampcard,
(Select count(*) from {$ll->table_name} where macc_lyb_status='LYB Fan' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS Fan ";

        $lyb = $db->query($query4,1);
//        pr($lyb);


        //macc_address_city
        $query5="SELECT DISTINCT macc_address_city FROM {$ll->table_name} ";

        $cities = $db->query($query5,2);
//        pr($cities);

        foreach($cities as $city){
            if($city->macc_address_city!="")
            $text[] = "(Select count(*) from {$ll->table_name} where macc_address_city='{$city->macc_address_city}' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now')) AS ".str_replace("/","",str_replace(" ","_",$city->macc_address_city));
        }
//        pr($text);
        $imp = "Select ". implode(",",$text);

//        echo $imp;
        $nrcities = $db->query($imp,2);
//        pr($nrcities);
?>
<div class="row">
    <div class="col-md-12">
        <h1>
            Demographic Dashboard
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
                        openLw("Demographic","<?=_SPPATH;?>BIWebDemographic/demographic?m="+slc,"fade");
                    });
                </script>
            </li>
        </ol>
    </div>
</div>

        <?

        $arrUserswPic = $ll->getWhere("macc_foto != '' AND (macc_acquire_date BETWEEN '$days_ago' AND '$days_now') ORDER BY macc_acquire_date DESC LIMIT 0,8");
        $arrUsers = $ll->getOrderBy(" macc_acquire_date DESC LIMIT 0,8");
        ?>
        <div class="row">
            <!--<div class="col-md-6">

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

                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            <? foreach($arrUsers as $user){
                                if($user->macc_foto==""){
                                    $url = _SPPATH."images/noimage.jpg";
                                }
                                else{
                                    $url =  "http://43.231.128.129/".$user->macc_foto;
                                }
                                ?>
                            <li>
                                <img src="<?=$url;?>" alt="<?=$user->macc_first_name." ".$user->macc_last_name;?>">
                                <a class="users-list-name" href="#"><?=$user->macc_first_name." ".$user->macc_last_name;?></a>
                                <span class="users-list-date"><?=ago(strtotime($user->macc_acquire_date));?></span>
                            </li>
                            <? } ?>

                        </ul>

                    </div>

                    <div class="box-footer text-center">
                        <a href="javascript::" class="uppercase">View All Users</a>
                    </div>

                </div>

            </div>
            -->
            <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Customers</h3>

                        <!--<div class="box-tools pull-right">
                            <span class="label label-danger">8 New Members</span>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>-->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            <? foreach($arrUserswPic as $user){ ?>
                                <li style="height: 160px;">
                                    <img src="http://43.231.128.129/<?=$user->macc_foto;?>" alt="User Image">
                                    <span class="users-list-name" ><?=$user->macc_first_name." ".$user->macc_last_name;?></span>
                                    <span class="users-list-date"><?=ago(strtotime($user->macc_acquire_date));?></span>
                                </li>
                            <? } ?>

                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="javascript:openLw('LL_Account', '<?=_SPPATH;?>LLAccWeb/LL_Account', 'fade'); activkanMenuKiri('LL_Account');" class="uppercase">View All Customers</a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!--/.box -->
            </div>

            <?
            $arrColor = array("#00a65a","#00c0ef");

            $c = new Charting();
            $c->color = array_pop($arrColor);
            $c->label = "Male";
            $c->value = $gender->Male;
            $arrData[] = $c;

            $c = new Charting();
            $c->color = array_pop($arrColor);
            $c->label = "Female";
            $c->value = $gender->Female;
            $arrData[] = $c;




            ?><div class="col-md-3"><?
                Charting::morrisDonut("287px",$arrData,1,"Gender","default");
                ?>

            </div>
            <?
            $arrColor = array("#4da65a","#7bcd03","#53ddde");

            $arrData = array();
            $c = new Charting();
            //            $c->color = array_pop($arrColor);
            $c->color = "#e90057";
            $c->label = "Fan";
            $c->value = $lyb->Fan;
            $arrData[] = $c;

            $c = new Charting();
            //            $c->color = array_pop($arrColor);
            $c->color = "#cd6949";
            $c->label = "Club";
            $c->value = $lyb->Club;
            $arrData[] = $c;

            $c = new Charting();
            //            $c->color = array_pop($arrColor);
            $c->color = "#f4bb1b";
            $c->label = "Stampcard";
            $c->value = $lyb->Stampcard;
            $arrData[] = $c;




            ?><div class="col-md-3"><?
                Charting::morrisDonut("287px",$arrData,1,"Member Type","default");
                ?>

            </div>

            <?
            $arrData = array();
            $arrlegend = array();
            foreach($nrcities[0] as $attr=>$value) {


                $c = new Charting();
                $c->color = "#".$this->random_color();
                $c->label = ucwords(strtolower(str_replace("_"," ",$attr)));
                $c->value = $value;
                $arrData[] = $c;

                $arrlegend[$attr] = $value;

            }

            asort($arrlegend);
            //pr($arrlegend);
            $arrlegend = array_reverse($arrlegend,1);
            $arrData = array();
            foreach($arrlegend as $attr=>$value){
                $c = new Charting();
                $c->color = "#".$this->random_color();
                $c->label = ucwords(strtolower(str_replace("_"," ",$attr)));
                $c->value = $value;
                $arrData[] = $c;
                $arrColors[$attr] = $c->color;
//                $arrlegend[$attr] = $value;
            }




            ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Locations</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body chart-responsive">

                <div class="col-md-6">
                <?
                Charting::morrisDonut("300px",$arrData,0,"Locations","default",0);
                ?>
                </div>
                <div class="col-md-6">
                    <?


                    ?>
                    <ul class="nav nav-pills nav-stacked">
                        <? foreach($arrlegend as $attr=>$value){ ?>
                        <li style="line-height: 30px;">
                            <div style="margin-top:5px; float: left; width: 20px; height: 20px; background-color: <?=$arrColors[$attr];?>;"></div>
                            &nbsp; <?=ucwords(str_replace("_"," ",strtolower($attr)));?>
                                <span class="pull-right "> <?=$value;?></span></li>

                        <? } ?>
                    </ul>
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
            .users-list-name{
                white-space: nowrap;
            }
        </style>
<?
    }
} 