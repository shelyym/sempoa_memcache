<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/2/15
 * Time: 1:49 PM
 */

class PushNotResults extends WebService{

    function res(){

//        echo IMBAuth::createOAuth();
//        echo "<br>";
//        echo $_GET['token'];
        IMBAuth::checkOAuth();
        $id = addslashes($_GET['id']);

//        echo $id;
        if($id == "" || $id<1)die("No ID");

        $ps = new PushNotCamp();
        $ps->getByID($id);

//        pr($ps);



        $pss = new GCMResult();
        $arrs = $pss->getWhere("camp_id = '$id' ORDER BY gcm_date DESC");



        ?>
    <html>
    <head>
        <link href="<?= _SPPATH; ?>themes/adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= _SPPATH; ?>themes/adminlte/css/jqueryui.css">
        <script src="<?= _SPPATH; ?>themes/adminlte/js/jquery-1.11.1.min.js"></script>
        <script src="<?= _SPPATH; ?>js/jqueryui.js"></script>
        <script src="<?= _SPPATH; ?>themes/adminlte/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
    <div id="wait" style="display: none; position: absolute;  width: 100%; line-height: 30px; text-align: center; font-weight: bold;">
        <span style="background-color: red; color:white; padding: 10px; margin-top: 20px;">Loading....</span></div>
    <div class="container">
    <h1><?=$ps->camp_name;?></h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>Date</th>
                <th>Is Test?</th>
                <th>Success</th>
                <th>Failure</th>
                <th>Summary</th>
                <th>Results</th>
            </tr>
            <?
            $cnt = 0;
            foreach($arrs as $cc){
                $cnt++;
                ?>
            <tr>
                <td>
                    <?=$cnt;?>
                </td>
                <td>
                    <?=indonesian_date($cc->gcm_date);?>
                </td>
                <td>
                    <? if($cc->gcm_test){
                       echo "Yes";
                    }
                    else{
                        echo "No";
                    }?>
                </td>
                <td>
                    <?=$cc->success;?>
                </td>
                <td>
                    <?=$cc->failure;?>
                </td>
                <td>
                    <? echo round($cc->success/($cc->failure+$cc->success)*100,3);echo " %";?>
                </td>
                <td>
                    <button class="btn btn-primary" id="detail_<?=$cc->multicast_id;?>">Details</button>
                    <div id="multicast_<?=$cc->multicast_id;?>" style="padding: 10px; display: none;"></div>
                    <script>
                        $("#detail_<?=$cc->multicast_id;?>").click(function(){

                            var isHidden = $( "#multicast_<?=$cc->multicast_id;?>" ).is( ":hidden" );
                            if(isHidden) {
                                $.get("<?=_SPPATH;?>PushNotResults/detail?id=<?=$cc->multicast_id;?>", function (data) {
                                    $("#multicast_<?=$cc->multicast_id;?>").html(data);
                                    $("#multicast_<?=$cc->multicast_id;?>").show();
                                });
                            }
                            else{
                                $("#multicast_<?=$cc->multicast_id;?>").hide();
                            }
                        });
                    </script>
                    <?
//                    $ress = unserialize($cc->results);  pr($ress);


                    ?>
                </td>
            </tr>
                <?
            }

            ?>
        </thead>

    </table>
    </div>

    <?
//    pr($arrs);
    ?>
    <script>
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });

        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
    </script>
    <style>
        .hasil{
            border: 1px dashed #cccccc;
            margin: 5px;
            padding: 5px;
        }
        .red{
            color:red;
        }
        .green{
            color :darkgreen;
        }
    </style>
    </body>

    </html>

    <?
    }

    public $arrStatus = array(0=>"<b class='red'>Failed</b>",1=>"<b class='green'>Success</b>");
    function detail(){

        $id = addslashes($_GET['id']);

//        echo "in".$id;

        $nn = new PushLogger();
        $arrLogs = $nn->getWhere("log_multicast_id = '{$id}' ORDER BY log_id ASC");

//        pr($arrLogs);

        foreach($arrLogs as $log){
//            $acc = new LL_Account();
//            $acc->getByID($log->log_macc_id);
            ?>
            <div class="hasil">
                ID : <?=$log->log_device_id;?> <br>
                Status : <?=$this->arrStatus[$log->log_status];?><br>
                Message : <?=$log->log_text;?>
            </div>
            <?
        }
    }

    function test(){

        IMBAuth::checkOAuth();
        $id = addslashes($_GET['id']);

//        echo $id;
        if($id == "" || $id<1)die("No ID");

        $ps = new PushNotCamp();
        $ps->getByID($id);

        $llacc = new LL_Account();
        $arrAcc = $llacc->getOrderBy("macc_first_name ASC");


     ?><html>
    <head>
        <link href="<?= _SPPATH; ?>themes/adminlte/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= _SPPATH; ?>themes/adminlte/css/jqueryui.css">
        <script src="<?= _SPPATH; ?>themes/adminlte/js/jquery-1.11.1.min.js"></script>
        <script src="<?= _SPPATH; ?>js/jqueryui.js"></script>
        <script src="<?= _SPPATH; ?>themes/adminlte/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
    <div id="wait" style="display: none; position: absolute;  width: 100%; line-height: 30px; text-align: center; font-weight: bold;">
        <span style="background-color: red; color:white; padding: 10px; margin-top: 20px;">Loading....</span></div>
    <div class="container">
        <h4>Test Push Notification for</h4>
        <h1><?=$ps->camp_name;?></h1>
        Input Customer ID's <input class="form-control" type="text" id="ids" value="1576199,512260">
        <br><i>separated by commas</i><br><br>
        <button id="push" class="btn btn-danger">Push</button>
        <div id="testresults" style="background-color: #dedede; margin-top: 40px; padding: 20px;display: none;"></div>
    </div>

    <script>
        $("#push").click(function(){

            var ids = $("#ids").val();

            $.post("<?=_SPPATH;?>PushNotResults/pusher?token=<?=$_GET['token'];?>",{
                camp_id : <?=$id;?>,
                ids : ids
            } ,function (data) {
//                alert(data);
                $("#testresults").show();
                $("#testresults").html(data);
            });

        });
    </script>
    <?
    //    pr($arrs);
    ?>
    <script>
        $(document).ajaxStart(function(){
            $("#wait").css("display", "block");
        });

        $(document).ajaxComplete(function(){
            $("#wait").css("display", "none");
        });
    </script>
    <style>
        .hasil{
            border: 1px dashed #cccccc;
            margin: 5px;
            padding: 5px;
        }
        .red{
            color:red;
        }
        .green{
            color :darkgreen;
        }
    </style>
    </body>

        </html>
        <?

    }

    function pusher(){

        IMBAuth::checkOAuth();
//        pr($_POST);


//        if($_POST['ids'] == "")die("Please insert Customer ID");
        if($_POST['camp_id'] == "")die("Please insert Campaign ID");

//        $ids = addslashes($_POST['ids']);

        $ps = new PushNotCamp();
        $ps->getByID(addslashes($_POST['camp_id']));

        $app = new AppAccount();
        $app->getByID($ps->camp_client_id);
        $arrAcc = $ps->camp_client_id;

            //from acc get device ID
        Pusher::sendUsingArrayAcc($arrAcc, $ps,$app, 1); //1 for testing

    }
} 