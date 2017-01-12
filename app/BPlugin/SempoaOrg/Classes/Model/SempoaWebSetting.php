<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/9/16
 * Time: 5:14 PM
 */

class SempoaWebSetting extends Model {
    //my table name
    var $table_name = "sempoa__org_setting";
    var $main_id    = "set_id_prim";

    var $default_read_coloms = "set_id_prim,set_id,set_value,set_org_id";
    var $set_id_prim;
    var $set_id;
    //var	$set_name;
    var $set_value;
    var $set_org_id;

    //allowed colom in database
    var $coloumlist = "set_id_prim,set_id,set_value,set_org_id";
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = "set_id_prim,set_id,set_value,set_org_id";



    public function loadToSession ( $selectedColom = "*")
    {
        $whereClause = "set_org_id = '".AccessRight::getMyOrgID()."'";
        //cek apakah sudah ada di session
        //if(count($_SESSION[get_called_class()])<1){
        global $db;
        $where = "";
        if ($whereClause != '') {
            $where = " WHERE " . $whereClause;
        }
        $q = "SELECT {$selectedColom} FROM {$this->table_name} $where";
        $arr = $db->query($q, 2);
        //pr($arr);
        foreach ($arr as $ss) {
            $_SESSION[get_called_class()][$ss->set_id] = $ss->set_value;
        }
        //}
        //pr($_SESSION);die();
    }
    public static function getData($id){
        return $_SESSION[get_called_class()][$id];
    }
    public static function setData($id,$val,$org_id){
        self::setDataSementara($id, $val);
        $ef = new SempoaWebSetting();
        //ambil dulu di database kalau ada ...
        $ef->getWhereOne("set_id = '$id' AND set_org_id = '$org_id'");
        if($ef->set_id_prim=="")$ef->load = 0;
        $ef->set_id = $id;
        $ef->set_value = $val;
        $ef->set_org_id = $org_id;
        return $ef->save();
    }
    public static function setDataSementara($id,$val){
        $_SESSION[get_called_class()][$id] = $val;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->set_id)) {
            $err['set_id'] = Lang::t('ID cannot be empty');
        }


        if (!isset($this->set_value)) {
            $err['set_value'] = Lang::t('Value cannot be empty');
        }



        return $err;
    }
}