<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SempoaLevel
 *
 * @author efindiongso
 */
class SempoaLevel extends Model {

    var $table_name = "sempoa__level";
    var $main_id = "id_level";
    //Default Coloms for read
    public $default_read_coloms = "id_level,level,level_sertifikat,level_group,level_desc";
//allowed colom in CRUD filter
    public $coloumlist = "id_level,level,level_sertifikat,level_group,level_desc";
    public $id_level;
    public $level;
    public $level_sertifikat;
    public $level_group;
    public $level_desc;

    public function overwriteForm($return, $returnfull) {
        parent::overwriteForm($return, $returnfull);
        $arrLevelGroup = Generic::getLevelGroup();
        $return['level_group'] = new Leap\View\InputSelect($arrLevelGroup, "level_group", "level_group", $this->level_group);
//     
        return $return;
    }

    public function overwriteRead($return) {
        $return = parent::overwriteRead($return);
        $arrLevelGroup = Generic::getLevelGroup();
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->level_group)) {
                $obj->level_group = $arrLevelGroup[$obj->level_group];
            }
        }

        return $return;
    }

    public function constraints() {
        //err id => err msg
        $err = array();

        return $err;
    }

}
