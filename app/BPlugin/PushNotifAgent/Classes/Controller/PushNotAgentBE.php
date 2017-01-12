<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/30/16
 * Time: 4:32 PM
 */

class PushNotAgentBE extends WebService{

    var $access_PushNotCampAgentApp = "admin";
    function PushNotCampAgentApp(){

        $cal = new PushNotCampAgentApp();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }

    var $access_GCMResultAgentApp = "admin";
    function GCMResultAgentApp(){

        $cal = new GCMResultAgentApp();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }
    var $access_PushLoggerAgentApp = "admin";
    function PushLoggerAgentApp(){

        $cal = new PushLoggerAgentApp();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }

    var $access_DeviceModelAgentApp = "admin";
    function DeviceModelAgentApp(){

        $cal = new DeviceModelAgentApp();
//        $cal->printColumlistAsAttributes();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

    }




    function testPush(){

        $devs = new DeviceModelAgentApp();
        global $db;
        $q = "SELECT DISTINCT acc_id FROM {$devs->table_name}";
        $arrDevs = $db->query($q,2);



        $inputID = "to";
        ?>
        <form method="post" action="<?=_SPPATH;?>PushNotCapsBE/send" id="sendPN">
            <div id="formgroup" class="form-group">
                <label for="<?= $inputID; ?>" class="col-sm-2 control-label"><?= Lang::t($inputID); ?></label>

                <div class="col-sm-10">
                    <select class="form-control" id="<?= $inputID; ?>" name="<?= $inputID; ?>">
                        <?
                        foreach ($arrDevs as $acc_id) {
                            $acc = new Account();
                            $acc->getByID($acc_id->acc_id);
                            ?>
                            <option value="<?=$acc->admin_id;?>"><?=$acc->admin_nama_depan;?></option>
                        <?
                        }

                        ?>
                    </select>
                    <span class="help-block" id="warning_<?= $inputID; ?>"></span>
                </div>
                <? $inputID = 'msg';?>
                <label for="<?= $inputID; ?>" class="col-sm-2 control-label"><?= Lang::t($inputID); ?></label>

                <div class="col-sm-10">
                    <input class="form-control" type="text" id="<?= $inputID; ?>" name="<?= $inputID; ?>" placeholder="<?= Lang::t($inputID); ?>">
                    <span class="help-block" id="warning_<?= $inputID; ?>"></span>
                </div>

                <? $inputID = 'action';?>
                <div style="display: none;">
                    <label for="<?= $inputID; ?>" class="col-sm-2 control-label"><?= Lang::t($inputID); ?></label>

                    <div class="col-sm-10" >
                        <input class="form-control" type="url" id="<?= $inputID; ?>" name="<?= $inputID; ?>" placeholder="<?= Lang::t($inputID); ?>">
                        <span class="help-block" id="warning_<?= $inputID; ?>"></span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-lg"><?= Lang::t('Send'); ?></button>

        </form>

        <script type="text/javascript">
            // console.log(array_rte);
            $("#sendPN").submit(function (event) {
                //alert( "Handler for .submit() called." );



                // Stop form from submitting normally
                event.preventDefault();

                // Get some values from elements on the page:
                var $form = $(this),
                    url = $form.attr("action");

                // Send the data using post
                var posting = $.post(url, $form.serialize(), function (data) {
//                    alert(data);
                    console.log( data ); // John
                    //console.log( data.bool ); // 2pm
                    if(data.bool){
                        alert('Success');
                    }else{
                        var obj = data.err;
//                        var tim = data.timeId;
                        //console.log( obj );
                        for (var property in obj) {
//                            alert(property);

                            if (obj.hasOwnProperty(property)) {

                                alert(obj[property]);

                            }
                        }
                    }
                },'json');


            });
        </script>
    <?
    }


    function send(){

        //pr($_POST);

        $json = array();
        $json['bool'] = 0;
        //check if url valid
        $website = addslashes($_POST["action"]);
        if($website!="")
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
                $json['err'][] = "Invalid URL";
            }

        $msg = addslashes($_POST['msg']);
        if($msg == "")$json['err'][] = "Invalid Msg";

        $to = addslashes($_POST['to']);
        if($to == "")$json['err'][] = "Invalid Acc";



        if(count($json['err'])<1){



            $dev = new DeviceModelCapsule();
            $arrD = $dev->getWhere("acc_id = '$to' AND dev_not_send = 0 ");
//            $json['arrD'] = $arrD;
            foreach($arrD as $d) {
                $json['dev'] = $d->device_id;
//                if($d->device_id == "")continue;
                $hasil = self::push($d->device_id, $msg, $website);
//                $json['hasil'] = $hasil;
                if ($hasil->success > 0) {
                    $json['bool'] = 1;
//                    $json['hasil'] = $hasil;
                }
            }
            if(!$json['bool'])
                $json['err'][] = "Invalid Device ID";
        }



        echo json_encode($json);
        die();
    }

    static function push($id,$msg,$action)
    {

        // API access key from Google API's Console
//        define('API_ACCESS_KEY', 'AIzaSyB9xx9AEJhINwTaxCEwCD7XLrV0nQ6tzjY');
        $api_key = Efiwebsetting::getData("PUSH_Api_key_capsule");


        $registrationIds = array($id);

        // prep the bundle
        $msg = array
        (
            'message' => $msg,
            'title' => $msg,
            'subtitle' => $action,
            'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate' => 1,
            'sound' => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon'

        );

        $notifications = array(
            "sound" => "default",
            "badge" => "1",
            "title" => Efiwebsetting::getData("PUSH_default_sender_capsule"),
            "body" => $msg
        );

        $fields = array
        (
            'registration_ids' => $registrationIds,
            'data' => $msg,
            'notification' => $notifications,
            'priority'=>"high"
        );



        $headers = array
        (
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        return $result;
    }
} 