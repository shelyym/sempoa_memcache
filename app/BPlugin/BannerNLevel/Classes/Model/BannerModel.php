<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 2:32 PM
 */

class BannerModel extends Model{

    var $table_name = "push__banner";
    var $main_id = "banner_id";

//Default Coloms for read
    public $default_read_coloms = "banner_id,banner_img,banner_interval_begin,banner_interval_end,banner_active,banner_link_url";

//allowed colom in CRUD filter
    public $coloumlist = "banner_id,banner_img,banner_interval_begin,banner_interval_end,banner_active,banner_link_url";
    public $banner_id;
    public $banner_img;
    public $banner_interval_begin;
    public $banner_interval_end;
    public $banner_active;
    public $banner_link_url;


    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);




        $return['banner_active'] = new Leap\View\InputSelect($this->arrayYesNO, "banner_active", "banner_active",
            $this->banner_active);


        $return['banner_img'] = new Leap\View\InputFoto("banner_img","banner_img",$this->banner_img);
//        $return['app_contract_end'] = new Leap\View\InputText("date","app_contract_end","app_contract_end",$this->app_contract_end);
        return $return;
    }
} 