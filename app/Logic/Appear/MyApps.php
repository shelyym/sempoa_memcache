<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/5/16
 * Time: 10:29 AM
 */

class MyApps {

    static function getMyApps(){

        $acc = Account::getAccountObject();



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
                #session{
                    margin-left: 15px; margin-right: 15px;
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
                <img src="<?=_SPPATH;?>images/logodlm.png" >
            </a>
        </div>

        <div id="attratas">
            <button id="list" onclick="$('#list').hide();$('#icons').show();$('#app_icons').hide();$('#app_lists').show();" class="btn btn-success btn-abu" style="margin: 0px;display: none;"><i class="glyphicon glyphicon-th-list"></i></button>
            <button id="icons" onclick="$('#list').show();$('#icons').hide();$('#app_icons').show();$('#app_lists').hide();" class="btn btn-success btn-abu" style="margin: 0px;"><i class="glyphicon glyphicon-th"></i></button>
          <?/*  <button onclick="document.location='<?=_SPPATH;?>//mydashboard';" class="btn btn-success btn-abu" style="margin: 0px;">Dashboard</button>
<button onclick="document.location='<?=_SPPATH;?>apps/makenew';" class="btn btn-success btn-abu" style="margin: 0px;">Create New Apps</button>

            */?>
            <button onclick="document.location='<?=_SPPATH;?>MyApp/newApp';" class="btn btn-success btn-abu" style="margin: 0px;">Create New Apps</button>

        </div>
        <?
        if(ZAppFeature::checkRemainingSession()){

            $link = _SPPATH."apps/make";
            if($_SESSION['ZAppFeature']['app_id']>0){
            $link = _SPPATH."apps/make?id=".$_SESSION['ZAppFeature']['app_id'];
            }
            ?>

    <div id="session" class="alert alert-warning" role="alert" >
        You have unsaved edit Sessions. Click <a href="<?=$link;?>">here</a> to continue work on your app
        </div>



        <?
        }
        ?>
        <?
        if(in_array("master_admin",Account::getMyRoles())){

            $acc = new AppAccount();
            $apps = $acc->getAll();
//http://localhost:8888/appear/PushHome/home?st=Balance


        }else{
            $acc = new App2Acc();
            //AND app_active = 1
            $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id ",array("AppAccount"));

        }
        if(count($apps)>0){
            ?>
<div id="app_icons" style="display: none;">
            <?
            foreach($apps as $num=>$ap){


                $parsed = parse_url($ap->app_icon);
                if (empty($parsed['scheme'])) {
                    $ap->app_icon = _SPPATH._PHOTOURL.$ap->app_icon;
                }
                ?>
                <div class="col-md-3 col-sm-12 col-xs-12 myapp">
                    <div id="detail_<?=$num;?>" class="app_detail" style="display: none;" onclick="openDetails('<?=$num;?>');">
                        <div style="padding: 20px;">
                            <h3><?=$ap->app_name;?></h3>
                            <?
                            $paket = new Paket();
                            if($ap->app_paket_id >0){
                                $paket->getByID($ap->app_paket_id);

                                echo '<div class="app_paket">'.$paket->paket_name.'</div>';
                            }

                            ?>
                            <?
                            $status = $ap->app_active;
                            echo '<div class="app_status">';
                            if($status == 0){
                                echo "Not active";
                            }
                            if($status == 1){
                                if($ap->app_type == 1)
                                    echo "pending approval";
                                else
                                echo "App is being created";
                            }
                            if($status == 2){
                                echo "Up and running";
                            }
                            echo "</div>";
                            ?>
                            <? if($ap->app_active>0 && $ap->app_type == 0){

                                echo '<div class="app_contract">contract ends : '.date("d-m-Y",strtotime($ap->app_contract_end));

                                if($ap->app_active == 2) {
                                    if ($ap->app_paket_id > 1) {
                                        ?>
                                        <br>
                                        <a  href="<?=_SPPATH;?>PaymentWeb/extend?app_id=<?=$ap->app_id;?>">extend</a>
                                    <?
                                    } elseif ($ap->app_paket_id == 1) {
                                        //check if tinggal sebulan
                                        $diff = dateDifference(date("Y-m-d", strtotime($ap->app_contract_end)), date("Y-m-d"), "%a");
//                                    echo "<br>".$diff;
                                        if ($diff <= 30) {
                                            ?>
<br>
                                            <a  href="<?=_SPPATH;?>PaymentWeb/extend_paket_1?app_id=<?=$ap->app_id;?>">extend</a>
                                        <?
                                        }
                                    }
                                }
                                echo '</div>';
                            }?>

                            <? if($ap->app_active == 2){
                                if($ap->app_paket_id == 1 || $ap->app_paket_id == 2){
                                    ?>
                                    <a href='<?=_SPPATH;?>PaymentWeb/upgrade?app_id=<?=$ap->app_id;?>'  class="btn btn-success">Upgrade</a>

                                <?
                                }
                                ?>

                                <a href='<?=_SPPATH;?>pushnotif?app_id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Push Notifications</a>
                                <br>
                            <? }else if($ap->app_active == 0){ ?>
                                <!--                                    <a href='--><?//=_SPPATH;?><!--MyApp/appView?id=--><?//=$ap->app_id;?><!--'  class="btn btn-danger">Payment</a>-->
                                <a href='<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$ap->app_id;?>'  class="btn btn-danger">Payment</a>
                                <a href='<?=_SPPATH;?>delete_app?app_id=<?=$ap->app_id;?>' onclick="return confirm('This will delete this App?')"  class="btn btn-success btn-abu">Delete</a>

                            <? } ?>

                            <a href='<?=_SPPATH;?>MyApp/editbridge?id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Edit</a>
                            <a href='<?=_SPPATH;?>preview?id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Preview</a>
                            <a href='<?=_SPPATH;?>uploads/json/<?=$ap->app_keywords;?>.json' target="_blank"  class="btn btn-success btn-abu">JSON</a>

                        </div>
                    </div>
                    <div id="app_<?=$num;?>" class="app_icon" onclick="openDetails('<?=$num;?>');">
                        <img width="100%" src="<?=$ap->app_icon;?>">
                        <div style="display:none;position: absolute; background-color: rgba(0,0,0,0.5); border-radius: 0px; text-align: center; font-size: 18px; padding: 10px; margin-top: -53px; margin-left:10px; z-index:1; color: #ffffff;">
                            <?=$ap->app_name;?>
                        </div>
                    </div>
                </div>
            <? } ?>
            <script>
                function openDetails(n){
                    $('#detail_'+n).fadeToggle( "slow", "linear" );
                    console.log($('#app_'+n).width());
                    $('#detail_'+n).css("width",$('#app_'+n).width()+'px');
                    $('#detail_'+n).css("height",$('#app_'+n).height()+'px');
                }
            </script>
            <style>
                .app_detail{
                    position: absolute;
                    background-color: rgba(0,0,0,0.8);
                    width: 100px;
                    height: 200px;
                    color: #ffffff;
                    text-align: center;
                    z-index: 10;
                }
                .myapp{
                    cursor: pointer;
                }
                .app_contract{
                    font-style: italic;
                    font-size: 12px;
                }
                .myapp a{
                    color: #B2DFDB;
                    text-decoration: underline;
                }
                .myapp a.btn{
                    text-decoration: none;
                    margin: 5px;
                    color: #ffffff;
                }
                .entry{
                    padding: 5px;
                    background-color: #F7F7F7;
                    margin: 5px;
                }
                .entry a.btn{
                    text-decoration: none;
                    margin: 2px;
                    color: #ffffff;
                }
            </style>
            </div>
            <div class="clearfix"></div>
            <div id="app_lists" >
            <?
            foreach($apps as $num=>$ap){
//                        $paket = new Paket();
//                        $paket->getByID($ap->app_paket_id);
                ?>

                <div class=" col-md-6 col-sm-12 col-xs-12">
                <div class="entry">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <img width="100%" src="<?=$ap->app_icon;?>">

                </div>
                <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center;">
                    <h3><?=$ap->app_name;?></h3>
                    <?
                    $paket = new Paket();
                    if($ap->app_paket_id >0){
                        $paket->getByID($ap->app_paket_id);

                        echo '<div class="app_paket">'.$paket->paket_name.'</div>';
                    }

                    ?>
                    <?
                    $status = $ap->app_active;
                    echo '<div class="app_status">';
                    if($status == 0){
                        echo "Not active";
                    }
                    if($status == 1){
                        if($ap->app_type == 1)
                            echo "pending approval";
                        else
                        echo "App is being created";
                    }
                    if($status == 2){
                        echo "Up and running";
                    }
                    echo "</div>";
                    ?>
                    <? if($ap->app_active>0 && $ap->app_type == 0){

                        echo '<div class="app_contract">contract ends : '.date("d-m-Y",strtotime($ap->app_contract_end));

                        if($ap->app_active == 2) {
                            if ($ap->app_paket_id > 1) {
                                ?>
                                <br>
                                <a  href="<?=_SPPATH;?>PaymentWeb/extend?app_id=<?=$ap->app_id;?>">extend</a>
                            <?
                            } elseif ($ap->app_paket_id == 1) {
                                //check if tinggal sebulan
                                $diff = dateDifference(date("Y-m-d", strtotime($ap->app_contract_end)), date("Y-m-d"), "%a");
//                                    echo "<br>".$diff;
                                if ($diff <= 30) {
                                    ?>
                                    <br>
                                    <a  href="<?=_SPPATH;?>PaymentWeb/extend_paket_1?app_id=<?=$ap->app_id;?>">extend</a>
                                <?
                                }
                            }
                        }
                        echo '</div>';
                    }?>

                    <? if($ap->app_active == 2){
                        if($ap->app_paket_id == 1 || $ap->app_paket_id == 2){
                            ?>
                            <a href='<?=_SPPATH;?>PaymentWeb/upgrade?app_id=<?=$ap->app_id;?>'  class="btn btn-success">Upgrade</a>

                        <?
                        }
                        ?>

                        <a href='<?=_SPPATH;?>pushnotif?app_id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Push Notifications</a>
                        <br>
                    <? }else if($ap->app_active == 0){ ?>
                        <!--                                    <a href='--><?//=_SPPATH;?><!--MyApp/appView?id=--><?//=$ap->app_id;?><!--'  class="btn btn-danger">Payment</a>-->
                        <a href='<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$ap->app_id;?>'  class="btn btn-danger">Payment</a>
                        <a href='<?=_SPPATH;?>delete_app?app_id=<?=$ap->app_id;?>' onclick="return confirm('This will delete this App?')"  class="btn btn-success btn-abu">Delete</a>

                    <? } ?>

                    <a href='<?=_SPPATH;?>MyApp/editbridge?id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Edit</a>
                    <a href='<?=_SPPATH;?>preview?id=<?=$ap->app_id;?>'  class="btn btn-success btn-abu">Preview</a>
                    <a href='<?=_SPPATH;?>uploads/json/<?=$ap->app_keywords;?>.json' target="_blank"  class="btn btn-success btn-abu">JSON</a>

                </div>

                    <div class="clearfix"></div>
                </div>
                </div>

            <? } ?>
            </div>
            <style>
                .table{
                    background-color: white;
                }
            </style>
            <div id="app_table" class="table-responsive" style="margin-top: 20px; display: none;">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>
                            No.
                        </th>
                        <th>App</th>
                        <th>Action</th>
                        <th>Paket</th>
                        <th>Expired Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    foreach($apps as $num=>$ap){
//                        $paket = new Paket();
//                        $paket->getByID($ap->app_paket_id);
                        ?>
                        <tr>
                            <td><?=$num+1;?></td>
                            <td style="text-align: center;">
                                <div class="foto100">
                                    <img width="100px" src="<?=$ap->app_icon;?>">
                                </div>

                                <?=$ap->app_name;?>
                            </td>
                            <td>
                                <!--                                <a href='--><?//=_SPPATH;?><!--MyApp/appView?id=--><?//=$ap->app_id;?><!--'  class="btn btn-info">Edit</a>-->
                                <? if($ap->app_active == 2){
                                    if($ap->app_paket_id == 1 || $ap->app_paket_id == 2){
                                        ?>
                                        <a href='<?=_SPPATH;?>PaymentWeb/upgrade?app_id=<?=$ap->app_id;?>'  class="btn btn-success">Upgrade</a>

                                    <?
                                    }
                                    ?>

                                    <a href='<?=_SPPATH;?>pushnotif?app_id=<?=$ap->app_id;?>'  class="btn btn-success">Push Notifications</a>
                                    <br>
                                <? }else if($ap->app_active == 0){ ?>
                                    <!--                                    <a href='--><?//=_SPPATH;?><!--MyApp/appView?id=--><?//=$ap->app_id;?><!--'  class="btn btn-danger">Payment</a>-->
                                    <a href='<?=_SPPATH;?>PaymentWeb/pay?app_id=<?=$ap->app_id;?>'  class="btn btn-danger">Payment</a>
                                    <a href='<?=_SPPATH;?>delete_app?app_id=<?=$ap->app_id;?>' onclick="return confirm('This will delete this App?')"  class="btn btn-danger">Delete</a>

                                <? } ?>

                                <a href='<?=_SPPATH;?>MyApp/editbridge?id=<?=$ap->app_id;?>'  class="btn btn-danger">Edit</a>
                                <a href='<?=_SPPATH;?>preview?id=<?=$ap->app_id;?>'  class="btn btn-danger">Preview</a>
                                <a href='<?=_SPPATH;?>uploads/json/<?=$ap->app_keywords;?>.json' target="_blank"  class="btn btn-danger">JSON</a>
                            </td>
                            <td>
                                <?
                                $paket = new Paket();
                                if($ap->app_paket_id >0){
                                    $paket->getByID($ap->app_paket_id);

                                    echo $paket->paket_name;
                                }

                                ?>
                            </td>
                            <td>
                                <? if($ap->app_active>0){

                                    echo date("d-m-Y",strtotime($ap->app_contract_end));

                                    if($ap->app_active == 2) {
                                        if ($ap->app_paket_id > 1) {
                                            ?>
                                            <br>
                                            <a class="btn btn-default" href="<?=_SPPATH;?>PaymentWeb/extend?app_id=<?=$ap->app_id;?>">extend</a>
                                        <?
                                        } elseif ($ap->app_paket_id == 1) {
                                            //check if tinggal sebulan
                                            $diff = dateDifference(date("Y-m-d", strtotime($ap->app_contract_end)), date("Y-m-d"), "%a");
//                                    echo "<br>".$diff;
                                            if ($diff <= 30) {
                                                ?>
                                                <br>
                                                <a class="btn btn-default" href="<?=_SPPATH;?>PaymentWeb/extend_paket_1?app_id=<?=$ap->app_id;?>">extend</a>
                                            <?
                                            }
                                        }
                                    }
                                }?>
                            </td>

                            <td><?
                                $status = $ap->app_active;
                                if($status == 0){
                                    echo "Your App is not active";
                                }
                                if($status == 1){
                                    echo "Your App is being created.<br>For Android App, it will take up to 2 working days.<br>For iOS, it will take up to 3 weeks.";
                                }
                                if($status == 2){
                                    echo "Your App is up and running";
                                }

                                ?></td>

                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </div>
            </div>
            <div class="clearfix" style="margin-bottom: 100px;"></div>

            </div>
        <?
        }else {

            header("Location:"._SPPATH."apps/make");
            exit();

        }
    }
} 