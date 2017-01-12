<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 2:36 PM
 */

class LevelModel extends Model{

    var $table_name = "push__levels";
    var $main_id = "level_id";

    //Default Coloms for read
    public $default_read_coloms = "level_id,level_name,level_img,level_start,level_end,level_active";

//allowed colom in CRUD filter
    public $coloumlist = "level_id,level_name,level_img,level_start,level_end,level_active";
    public $level_id;
    public $level_name;
    public $level_img;
    public $level_start;
    public $level_end;
    public $level_active;

    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);




        $return['level_active'] = new Leap\View\InputSelect($this->arrayYesNO, "level_active", "level_active",
            $this->level_active);


        $return['level_img'] = new Leap\View\InputFoto("level_img","level_img",$this->level_img);
//        $return['app_contract_end'] = new Leap\View\InputText("date","app_contract_end","app_contract_end",$this->app_contract_end);
        return $return;
    }
} 