<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/10/15
 * Time: 10:22 AM
 */

class LLSetting extends Model{
    var $table_name = "ll_setting";
    var $main_id    = "ll_set_prim";

    var $default_read_coloms = "ll_set_prim,ll_set_id,ll_set_date_begin,ll_set_date_end,ll_set_value,ll_set_active";
    var $ll_set_prim;
    var $ll_set_id;
    //var	$set_name;
    var $ll_set_date_begin;
    var $ll_set_date_end;
    var $ll_set_value;
    var $ll_set_active;


    //allowed colom in database
    var $coloumlist = "ll_set_prim,ll_set_id,ll_set_date_begin,ll_set_date_end,ll_set_value,ll_set_active";
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = "ll_set_prim,ll_set_id,ll_set_date_begin,ll_set_date_end,ll_set_value,ll_set_active";

    public function loadToSession ($whereClause = '', $selectedColom = "*")
    {
        $whereClause = "ll_set_date_begin < NOW() AND ll_set_date_end > NOW() AND ll_set_active = 1 ORDER BY ll_set_date_begin DESC";

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
        $sem = array();
        foreach ($arr as $ss) {
            if(!array_key_exists($ss->ll_set_id,$sem)){
                $sem[$ss->ll_set_id] = $ss->ll_set_value;
            }

        }
        $_SESSION[get_called_class()] = $sem;
        //}
        //pr($_SESSION);die();
    }
    public static function getData($id){
        return $_SESSION[get_called_class()][$id];
    }
    public static function setData($id,$val,$begin,$end,$active = 1){
        self::setDataSementara($id, $val);
        $ef = new LLSetting();
        $ef->ll_set_id = $id;
        $ef->ll_set_value = $val;
        $ef->ll_set_date_begin = $begin;
        $ef->ll_set_date_end = $end;
        $ef->ll_set_active = $active;
        return $ef->save();
    }
    public static function setDataSementara($id,$val){
        $_SESSION[get_called_class()][$id] = $val;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->ll_set_id)) {
            $err['ll_set_id'] = Lang::t('ID cannot be empty');
        }


        if (!isset($this->ll_set_value)) {
            $err['ll_set_value'] = Lang::t('Value cannot be empty');
        }
        if (!isset($this->ll_set_date_begin)) {
            $err['ll_set_date_begin'] = Lang::t('Value cannot be empty');
        }
        if (!isset($this->ll_set_date_end)) {
            $err['ll_set_date_end'] = Lang::t('Value cannot be empty');
        }


        return $err;
    }
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);


        $return['ll_set_date_end'] = new \Leap\View\InputText("date","ll_set_date_end", "ll_set_date_end", $this->ll_set_date_end);

        $return['ll_set_date_begin'] = new \Leap\View\InputText("date","ll_set_date_begin", "ll_set_date_begin", $this->ll_set_date_begin);
        $return['ll_set_active'] = new Leap\View\InputSelect($this->arrayYesNO, "ll_set_active", "ll_set_active",
            $this->ll_set_active);



        return $return;
    }

} 