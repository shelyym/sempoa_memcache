<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/1/16
 * Time: 9:34 AM
 */

class JobBE extends WebService{

    var $access_queue = "master_admin";
    function queue(){

        $app = new AppAccount();
        $arrApp = $app->getWhere("app_active = 1 AND app_type = 0 ORDER BY app_contract_start ASC");
//        pr($arrApp);
        ?>
        <h1>Developer Job Queue</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            App ID
                        </th>
                        <th>
                            App Name
                        </th>
                        <th>
                            User & Agent
                        </th>
                        <th>
                            Contract
                        </th>
                        <th>
                            Paket
                        </th>
                        <th>
                            Status
                        </th>

                    </tr>
                </thead>
                <tbody>
                <? foreach($arrApp as $app){
                    $paket = new Paket();
                    $paket->getByID($app->app_paket_id);
                    $acc = new Account();
                    $acc->getByID($app->app_client_id);

                    $agent = new Account();
                    if($acc->admin_marketer!="")
                        $agent->getByUsername($acc->admin_marketer);

                    $vp = new VpTransaction();
                    $arrT = $vp->getWhere("order_app_id = '{$app->app_id}'");
                    ?>
                    <tr>
                        <td><?=$app->app_id;?></td>
                        <td><?=$app->app_name;?></td>
                        <td>
                            <?=$acc->admin_username;?>
                            <?=$acc->admin_nama_depan;?>
                            <br>
                            <?=$acc->admin_email;?><br>
                            <?=$acc->admin_phone;?>
                            <hr>
                            Agent <br>
                            <?=$agent->admin_username;?>
                            <?=$agent->admin_nama_depan;?>
                            <br>
                            <?=$agent->admin_email;?><br>
                            <?=$agent->admin_phone;?>
                        </td>
                        <td>Start :
                            <?=$app->app_contract_start;?>
                            &nbsp; End :
                            <?=$app->app_contract_end;?>
                            <br>
                            <? foreach($arrT as $order){?>
                                <div class="order">
                                    Order ID : <?=$order->order_id;?><br>
                                    Date : <?=$order->order_date;?> <br>Payment Status : <?=$order->order_status;?>

                                <? if($order->order_status == "1" || $order->order_status== "2"){?>
                            <br><a href="<?=_SPPATH;?>PaymentWeb/receipt?order_id=<?=$order->order_id;?>" target="_blank">receipt</a>
                                    <? } ?>
                                    <hr>
                                </div>
                            <? } ?>
                        </td>
                        <td><?=$paket->paket_name;?></td>
                        <td>
                            <?=$app->app_active;?><br>
                            <button class="btn btn-default">create App</button><br>
                            <button class="btn btn-default">update status</button>
                        </td>
                    </tr>
                    <?
                    }
                ?>
                </tbody>
            </table>
        </div>
        <?
    }


    var $access_free = "master_admin";
    function free(){

        $app = new AppAccount();
        $arrApp = $app->getWhere("app_active = 1 AND app_type = 1 ORDER BY app_contract_start ASC");
//        pr($arrApp);
        ?>
        <h1>Free Approval Queue</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        App Details
                    </th>
                    <th>
                        Organization Details
                    </th>
                    <th>
                        User & Agent
                    </th>
                    <th>
                        Contract
                    </th>
                    <th>
                        Paket
                    </th>
                    <th>
                        Status
                    </th>

                </tr>
                </thead>
                <tbody>
                <? foreach($arrApp as $app){
                    $paket = new Paket();
                    $paket->getByID($app->app_paket_id);
                    $acc = new Account();
                    $acc->getByID($app->app_client_id);

                    $agent = new Account();
                    if($acc->admin_marketer!="")
                        $agent->getByUsername($acc->admin_marketer);

                    $vp = new VpTransaction();
                    $arrT = $vp->getWhere("order_app_id = '{$app->app_id}'");

                    $free = new AppFree();
                    $free->getByID($app->app_id);
                    ?>
                    <tr>
                        <td>
                            ID :<?=$app->app_id;?><br>
                            <?=$app->app_name;?>
                        </td>
                        <td>
                            Apply Date : <?=$free->free_date;?><br>
                            Org Name : <?=$free->free_org_name;?><br>
                            Org Type : <?=$free->free_org_type;?><br>
                            Address : <?=$free->free_address;?><br>
                            Contact Name : <?=$free->free_org_name;?><br>
                            Phone : <?=$free->free_org_name;?><br>
                            Email : <?=$free->free_org_name;?><br>
                            Docs : <br><?
                            $exp = explode(",",$free->free_org_docs);
                            foreach($exp as $x){
                                ?>
                                <a href="<?=_SPPATH._PHOTOURL."inputfiles/".$x;?>" target="_blank">
                                    <img src="<?=_SPPATH._PHOTOURL."inputfiles/".$x;?>" width="100px">
                                </a>
                                <?
                            }
                            ?>


                        </td>
                        <td>
                            <?=$acc->admin_username;?>
                            <?=$acc->admin_nama_depan;?>
                            <br>
                            <?=$acc->admin_email;?><br>
                            <?=$acc->admin_phone;?>
                            <hr>
                            Agent <br>
                            <?=$agent->admin_username;?>
                            <?=$agent->admin_nama_depan;?>
                            <br>
                            <?=$agent->admin_email;?><br>
                            <?=$agent->admin_phone;?>
                        </td>
                        <td>Start :
                            <?=$app->app_contract_start;?>
                            <br> End :
                            <?=$app->app_contract_end;?>

                        </td>
                        <td><?=$paket->paket_name;?></td>
                        <td>
                            <?=$app->app_active;?><br>
                            <button onclick="accept_free('<?=$app->app_id;?>');"  class="btn btn-default">Accept App</button><br>
                            <button onclick="reject_free('<?=$app->app_id;?>');" class="btn btn-default">Reject App</button><br>
                            <button onclick="view_free('<?=$app->app_id;?>');" class="btn btn-default">View App</button>
                        </td>
                    </tr>
                <?
                }
                ?>
                </tbody>
            </table>
        </div>
        <script>

            function accept_free(id){

                if(confirm("this will accept the app"))
                $.post("<?=_SPPATH;?>JobBE/actionfree",{app_id:id,action : "accept"},function(data){

                    console.log(data);
                    if(data.bool){
                        alert("Sukses");
                        lwrefresh('Accept_Free_Apps');
                    }else{
                        alert("Gagal");
                    }
                },'json');

            }
            function reject_free(id){
                if(confirm("this will reject the app"))
                $.post("<?=_SPPATH;?>JobBE/actionfree",{app_id:id,action : "reject"},function(data){

                    console.log(data);
                    if(data.bool){
                        alert("Sukses");
                        lwrefresh('Accept_Free_Apps');
                    }else{
                        alert("Gagal");
                    }
                },'json');
            }
            function view_free(id){

            }
        </script>
    <?
    }

    var $access_actionfree = "master_admin";
    function actionfree(){

        $id = addslashes($_POST['app_id']);
        $action = addslashes($_POST['action']);
        $app = new AppAccount();
        $app->getByID($id);

        $acc = new Account();
        $acc->getByID($app->app_client_id);

        $agent = new Account();
        if($acc->admin_marketer!="")
            $agent->getByUsername($acc->admin_marketer);

        $dataemail = new DataEmail();

        $json['bool'] = 0;

        if($action == "accept"){

            //status = 1 tetap
            $app->app_type = 0;
            //type = 0
            //contract start n end
            $app->app_contract_start = date("Y-m-d");
            $app->app_contract_end = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
            $app->app_paket_id = 1; //free
            $succ = $app->save();


            //spy masuk ke job queue
            //email ke marcel

            //komisi untuk agent nya...

            if($succ){
                //notify Admins kalau ada app active

                $dataemail->appBisaDibuat($app->app_name,$app->app_id,"Free App Accepted");

                //notify User

                $dataemail->freeAppAccepted($acc->admin_email,$acc->admin_username,$app->app_name);

                $vpt = new VpTransaction();
                $vpt->order_id = time();
                //hitung komisi
                //ini belum bener
                //TODO 31 maret 2016
                KomisiModel::log($app,$vpt);
                $json['bool'] =$succ;
            }
        }
        if($action == "reject"){


            //status = 0
            $app->app_active = 0;
            //type = 0
            $app->app_type = 0;
            $app->app_paket_id = 0;
            $succ = $app->save();

            //email ke client & agent

            if($succ) {
                $dataemail->freeRequestRejected($acc->admin_email, $acc->admin_username, $app->app_name);

                if ($acc->admin_marketer != "")
                    $dataemail->freeRequestRejectedAgent($agent->admin_email, $acc->admin_username, $app->app_name, $agent->admin_username);

                $json['bool'] =$succ;
            }
        }

        echo json_encode($json);
        die();

    }


    var $access_agent = "master_admin";
    function agent(){

        $app = new Account();
        $arrApp = $app->getWhere("admin_isAgent = -1 ORDER BY admin_id DESC");
//        pr($arrApp);
        ?>
        <h1>Agent Approval Queue</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        Agent Account
                    </th>
                    <th>
                        Agent Details
                    </th>
                    <th>
                        Record Penjualan
                    </th>
                    <th>
                        Status
                    </th>

                </tr>
                </thead>
                <tbody>
                <? foreach($arrApp as $acc){

                    ?>
                    <tr>
                        <td>
                            <?=$acc->admin_id;?>
                            <?=$acc->admin_username;?>
                            <?=$acc->admin_nama_depan;?>
                            <br>
                            <?=$acc->admin_email;?><br>
                            <?=$acc->admin_phone;?>

                        </td>
                        <td>
                            <a href="<?=_SPPATH._PHOTOURL.$acc->admin_ktp;?>" target="_blank">
                                <img src="<?=_SPPATH._PHOTOURL.$acc->admin_ktp;?>" width="100px">
                            </a>
                            <a href="<?=_SPPATH._PHOTOURL.$acc->admin_npwp;?>" target="_blank">
                                <img src="<?=_SPPATH._PHOTOURL.$acc->admin_npwp;?>" width="100px">
                            </a>
                            <hr>
                            Bank :<?=$acc->admin_bank;?><br>
                            Acc Nr. : <?=$acc->admin_bank_acc;?>
                            <br>
                            Acc Name :<?=$acc->admin_bank_acc_name;?><br>
                            KCU : <?=$acc->admin_bank_kcu;?>
                        </td>
                        <td>
                            Paid :<?=$acc->admin_total_paid_sales;?><br>
                            Free : <?=$acc->admin_total_free_sales;?>
                        </td>


                        <td>
                            <?=$acc->admin_isAgent;?><br>
                            <button onclick="accept_agent('<?=$acc->admin_id;?>');"  class="btn btn-default">Accept </button><br>
                            <button onclick="reject_agent('<?=$acc->admin_id;?>');" class="btn btn-default">Reject </button><br>

                        </td>
                    </tr>
                <?
                }
                ?>
                </tbody>
            </table>
        </div>
        <script>

            function accept_agent(id){

                if(confirm("this will accept the app"))
                    $.post("<?=_SPPATH;?>JobBE/actionAgent",{acc_id:id,action : "accept"},function(data){

                        console.log(data);
                        if(data.bool){
                            alert("Sukses");
                            lwrefresh('Accept_Agent');
                        }else{
                            alert("Gagal");
                        }
                    },'json');

            }
            function reject_agent(id){
                if(confirm("this will reject the app"))
                    $.post("<?=_SPPATH;?>JobBE/actionAgent",{acc_id:id,action : "reject"},function(data){

                        console.log(data);
                        if(data.bool){
                            alert("Sukses");
                            lwrefresh('Accept_Agent');
                        }else{
                            alert("Gagal");
                        }
                    },'json');
            }

        </script>
    <?
    }

    var $access_actionAgent = "master_admin";
    function actionAgent(){

        $id = addslashes($_POST['acc_id']);
        $action = addslashes($_POST['action']);



        $acc = new Account();
        $acc->getByID($id);



        $dataemail = new DataEmail();

        $json['bool'] = 0;

        if($action == "accept"){

            $acc->admin_isAgent = 1;
            $acc->admin_inbox_update = leap_mysqldate();
            $succ = $acc->save();



            if($succ){
                //notify Agent kalau sudah di approve
                $dataemail->agentAccepted($acc->admin_email,$acc->admin_username);
                $json['bool'] =$succ;
            }
        }
        if($action == "reject"){


            $acc->admin_isAgent = 0;
            $acc->admin_inbox_update = leap_mysqldate();
            $succ = $acc->save();

            //email ke client & agent

            if($succ) {
                //email ke agent
                $dataemail->agentRejected($acc->admin_email,$acc->admin_username);
                $json['bool'] =$succ;
            }
        }

        echo json_encode($json);
        die();

    }
} 