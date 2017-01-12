<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 1:52 PM
 */

class AppBalance extends WebService{

    function getBalance(){

        $app_id = AppAccount::getAppID();
        $app = AppAccount::getActiveAppObject();

        $limit = addslashes($_GET['lmt']);
        if($limit<30 || $limit == "")$limit = 30;
        ?>

        <div class="row">
            <div class="col-md-12 ">
                <div class="bg-green" style="padding: 10px; text-align: center;">
                <h1>Current Balance : <b><?=$app->app_pulsa;?></b> <i class="fa fa-mail-forward"></i> </h1>
                </div>
            </div>
        </div>
        <?

        //get transactions
        $apptrans = new AppPulsa();

        $arrB = $apptrans->getWhere("pulsa_app_id = '$app_id' ORDER BY pulsa_date DESC LIMIT 0,$limit ");

        $arrB = array_reverse($arrB);
//        pr($arrB);

        ?>
        <div class="row">
        <div class="col-md-12" style="margin-top: 30px;">
        <h1><i class="fa fa-mail-forward"></i> Balance Statement <small>Last <?=$limit;?> Transactions</small></h1>
            <ol class="breadcrumb">
                <li>
                    <?=Lang::t('Select Nr. of Transactions');?>
                </li>
                <li class="active">

                    <select id="nrtransaction">
                        <option  value="30">30</option>
                        <option <? if($limit==60)echo "selected";?> value="60">60</option>
                        <option <? if($limit==100)echo "selected";?> value="100">100</option>
                        <option <? if($limit==500)echo "selected";?> value="500">500</option>
                        <option <? if($limit==1000)echo "selected";?> value="1000">1000</option>
                    </select>

                </li>
            </ol>
    <script>
        $('#nrtransaction').change(function(){
           var slc =  $('#nrtransaction').val();
            openLw('Balance','<?=_SPPATH;?>AppBalance/getBalance?lmt='+slc,'fade');
        });
    </script>
        <div class="table-responsive" >
            <table class="table table-bordered" style="background-color: white;">
                <thead>
                <tr>
                    <th>
                        Date
                    </th>
                    <th>
                        Description
                    </th>
                    <th>
                        Debit
                    </th>
                    <th>
                        Credit
                    </th>
                    <th>
                        Balance
                    </th>

                </tr>

                </thead>
                <tbody>
                <?
                foreach($arrB as $bb){
                    ?>
                <tr>
                    <td><?=indonesian_date($bb->pulsa_date);?></td>
                    <td>
                        <?
                        if($bb->pulsa_action == "debit"){

                            ?>
                            Used in campaign. <a style="cursor: pointer;" id="camp_id_<?=$bb->pulsa_camp_id;?>" >view campaign</a>
                            <script>
                                $('#camp_id_<?=$bb->pulsa_camp_id;?>').click(function(){
//                                    var slc =  $('#nrtransaction').val();
                                    openLw('campView','<?=_SPPATH;?>AppBalance/campView?camp_id=<?=$bb->pulsa_camp_id;?>','fade');
                                });
                            </script>
                        <?
                        }else{
                            ?>
                                Topped-up
                            <?
                        }
                        ?>
                    </td>
                    <td class="duit">
                        <?
                        if($bb->pulsa_action == "debit"){
                            echo $bb->pulsa_jumlah;
                        }
                        ?>
                    </td>
                    <td class="duit">
                        <?
                        if($bb->pulsa_action == "credit"){
                            echo $bb->pulsa_jumlah;
                        }
                        ?>
                    </td>
                    <td class="duit">
                        <b><?=$bb->pulsa_new;?></b>
                    </td>

                </tr>
                    <?
                }
                ?>
                </tbody>
            </table>
        </div>
        </div>
        </div>
        <style>
            table.table td.duit{
                text-align: right;
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

    var $access_campView = "normal_user";
    function campView(){

        $id = addslashes($_GET['camp_id']);

//        echo $id;

        if($id == "" || $id<1) die("no id");

        $camp = new PushNotCamp();
        $camp->getByID($id);

        $arrStatus = array("0"=>"Not Pushed","1"=>"Pushed");

        if($camp->camp_app_id != AppAccount::getAppID()){
            die("camp mismatched");
        }
//        pr($camp);

        $onDate = "";
        if($camp->camp_status == 1){
            $onDate = " on ".indonesian_date($camp->camp_send_date);
        }


        //hitung openrate dll
        $targetedDev = count(explode(",",$camp->camp_dev_ids));

        $gcm = new GCMResult();
        $arrGCM = $gcm->getWhere("camp_id = '$id' ORDER BY gcm_date DESC");

        $succ = 0;
        $fail = 0;
        $seen_by = 0;

        foreach($arrGCM as $cc){
            $succ += $cc->success;
            $fail += $cc->failure;
            $seen_by += $cc->seen_by;
        }

        $openrate =round($seen_by/($succ)*100,3);


        $del = round($succ/($succ+$fail)*100,3);
        ?>
        <div class="row">
            <div class="col-md-12">
                <h1><?=$camp->camp_name;?> <small><?=$arrStatus[$camp->camp_status].$onDate;?> </small></h1>

            </div>

                <div class="col-md-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?=$openrate;?>%</h3>
                            <p>Open Rate</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-model-s"></i>
                        </div>
                        <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
            <div class="col-md-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?=$seen_by;?></h3>
                        <p>Seen By</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-purple">
                    <div class="inner">

                        <h3><?=$del;?>%</h3>

                        <p>Success Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-happy"></i>
                    </div>
                    <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                </div>
            </div>
                <div class="col-md-3">
                    <div class="small-box bg-yellow">
                        <div class="inner">

                            <h3><?=$targetedDev?></h3>

                            <p>Targeted Devices</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-iphone"></i>
                        </div>
                        <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-green">
                        <div class="inner">


                            <h3><?=$succ;?></h3>

                            <p>Success</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-thumbsup"></i>
                        </div>
                        <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-red">
                        <div class="inner">

                            <h3><?=$fail;?></h3>

                            <p>Failed</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-thumbsdown"></i>
                        </div>
                        <!--                            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
                    </div>
                </div>


            <div class="col-md-12">
                <p>
                    Content : <br>
                    <b><?=$camp->camp_title;?></b>
                </p>
                <p>
                    <button onclick="document.location='<?=_SPPATH;?>AppBalance/exportIt?cid=<?=$id;?>';" class="btn btn-primary">Download Results</button>
        <button  id="close_buttoncamp_<?= $id; ?>" class="btn btn-default"><?=Lang::t('cancel');?></button>
    <script>
    $( "#close_buttoncamp_<?= $id; ?>" ).click(function( event ) {
    event.preventDefault();
    lwclose(window.selected_page);
});
    </script>
                </p>
            </div>
        </div>
        <?
    }

    var $access_exportIt = "normal_user";
    public function exportIt ($return)
    {
        $id = addslashes($_GET['cid']);

//        echo $id;

        if($id == "" || $id<1) die("no id");

        $camp = new PushNotCamp();
        $camp->getByID($id);

        $arrStatus = array("0"=>"Not Pushed","1"=>"Pushed");

        if($camp->camp_app_id != AppAccount::getAppID()){
            die("camp mismatched");
        }
//        pr($camp);

        $onDate = "";
        if($camp->camp_status == 1){
            $onDate = " on ".indonesian_date($camp->camp_send_date);
        }


        //hitung openrate dll
        $targetedDev = count(explode(",",$camp->camp_dev_ids));

        $gcm = new GCMResult();
        $arrGCM = $gcm->getWhere("camp_id = '$id' ORDER BY gcm_date DESC");

        $succ = 0;
        $fail = 0;
        $seen_by = 0;

        foreach($arrGCM as $cc){
            $succ += $cc->success;
            $fail += $cc->failure;
            $seen_by += $cc->seen_by;
        }

        $openrate =round($seen_by/($succ)*100,3);


        $del = round($succ/($succ+$fail)*100,3);

        $filename = urlencode(str_replace(" ","_",$camp->camp_name))."_" . date('Ymd') . ".xls";

        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        $flag = false;


        print("Campaign Name : \t".$camp->camp_title); //judul
        print("\n");
        print("Status : \t".$arrStatus[$camp->camp_status].$onDate); //status and delieverd date
        print("\n");
        print("Content : \t".$camp->camp_title);
        print("\n");
        print("Open Rate : \t".$openrate);
        print("\n");
        print("Seen By : \t".$seen_by);
        print("\n");

        print("Deliverable Percentage : \t".$del);
        print("\n");

        print("Targeted Devices : \t".$targetedDev);
        print("\n");
        print("Success : \t".$succ);
        print("\n");
        print("Failed : \t".$fail);
        print("\n");

        print("\n");

        $logs = new PushLogger();
        $objs = $logs->getWhere("log_camp_id = '$id'");

        $filter = explode(",",$logs->exportList);

        foreach ($objs as $key => $obj) {


            foreach ($obj as $name => $value) {
                if(in_array($name,$filter))
                echo Lang::t($name) . "\t";
            }
            break;
        }
        print("\n");
        foreach ($objs as $key => $obj) {

            foreach ($obj as $name => $value) {
                if(in_array($name,$filter))
                echo $value . "\t";
            }
            print("\n");
        }
        exit;
    }
} 