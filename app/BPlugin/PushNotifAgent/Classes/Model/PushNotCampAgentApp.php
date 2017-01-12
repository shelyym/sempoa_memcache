<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/21/15
 * Time: 8:04 PM
 */

class PushNotCampAgentApp extends Model{

    //

    //Nama Table
    public $table_name = "agent__pushnot_program";

    //Primary
    public $main_id = 'camp_id';

//Default Coloms for read
    public $default_read_coloms = "camp_id,camp_client_id,camp_start,camp_hour,camp_name,camp_title,camp_img,camp_msg,camp_url,camp_create_by,camp_active,camp_status,camp_send_date";

//allowed colom in CRUD filter
    public $coloumlist = "camp_id,camp_client_id,camp_start,camp_hour,camp_name,camp_title,camp_img,camp_msg,camp_url,camp_create_by,camp_active,camp_status,camp_send_date";
    public $camp_id;
    public $camp_client_id;
//    public $camp_app_id;
    public $camp_start;
    public $camp_hour;
    public $camp_name;
    public $camp_title;
    public $camp_img;
    public $camp_msg;
    public $camp_url;
    public $camp_create_by;
    public $camp_active;
    public $camp_status;
    public $camp_send_date;

//    public $camp_dev_ids;
//    public $camp_acc_ids;

    public $removeAutoCrudClick = array("Action");
    public $arrStatus = array("0"=>"Not Pushed","1"=>"Pushed");

    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);

        $return['camp_client_id'] = new \Leap\View\InputTextArea("camp_client_id", "camp_client_id", $this->camp_client_id);

        $return['camp_start'] = new \Leap\View\InputText("date","camp_start", "camp_start", $this->camp_start);

        for($x=0;$x<24;$x++){
            if($x<10)
                $arrs[$x] = "0".$x.".00";
            else
                $arrs[$x] = $x.".00";
        }

        $return['camp_hour'] = new \Leap\View\InputSelect($arrs,"camp_hour", "camp_hour", $this->camp_hour);
        $return['camp_active'] = new \Leap\View\InputSelect($this->arrayYesNO,"camp_active", "camp_active", $this->camp_active);


        $return['camp_msg'] = new \Leap\View\InputTextRTE("camp_msg", "camp_msg", $this->camp_msg);
        $return['camp_msg'] = new \Leap\View\InputTextArea("camp_msg", "camp_msg", $this->camp_msg);

        $return['camp_url'] = new \Leap\View\InputText("text","camp_url", "camp_url", $this->camp_url);

        $return['camp_img'] = new \Leap\View\InputFoto("camp_img", "camp_img", $this->camp_img);



        $return['camp_create_by'] = new \Leap\View\InputText("hidden","camp_create_by", "camp_create_by", Account::getMyID());
        $return['camp_status'] = new \Leap\View\InputSelect($this->arrStatus,"camp_status", "camp_status", $this->camp_status);



        $return['spdivider']['camp_client_id']  = "Filter";
        $return['spdivider']['camp_start']  = "Campaign";
        $return['spdivider']['camp_client_id']  = "Accounts";



        return $return;
    }

    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->camp_start)) {
            $err['camp_start'] = Lang::t('Start cannot be empty');
        }



        if (!isset($this->camp_hour)) {
            $err['camp_hour'] = Lang::t('Time cannot be empty');
        }

        if (!isset($this->camp_msg) && !isset($this->camp_url)) {
            $err['camp_msg'] = Lang::t('Either Msg or URL must be filled');
            $err['camp_url'] = Lang::t('Either Msg or URL must be filled');
        }
        if (!isset($this->camp_name)) {
            $err['camp_name'] = Lang::t('Name cannot be empty');
        }
        if (!isset($this->camp_title)) {
            $err['camp_title'] = Lang::t('Title cannot be empty');
        }


        return $err;
    }

    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        $oauth = IMBAuth::createOAuth();
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            $obj->removeAutoCrudClick = array("Action");
//            if (isset($obj->carousel_photo)) {
//                $obj->carousel_photo = \Leap\View\InputFoto::getAndMakeFoto($obj->carousel_photo, "car_image_" . $obj->carousel_id);
//            }
//
            if (isset($obj->camp_active)) {
                $obj->camp_active = $this->arrayYesNO[$obj->camp_active];
            }
            if (isset($obj->camp_status)) {
                $obj->camp_status = $this->arrStatus[$obj->camp_status];
            }
            $obj->Action = "<a class='btn  btn-default' href='"._SPPATH."PushNotResultsCaps/res?id=".$obj->camp_id."&token={$oauth}' target='_blank'>Results</a>
            <a class='btn  btn-default' href='"._SPPATH."PushNotResultsCaps/test?id=".$obj->camp_id."&token={$oauth}' target='_blank'>Test</a>";
        }
        return $return;
    }
} 