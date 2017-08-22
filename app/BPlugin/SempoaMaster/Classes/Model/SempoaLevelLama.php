<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 7/26/17
 * Time: 3:37 PM
 */
class SempoaLevelLama extends Model
{
    var $table_name = "sempoa__level_lama";
    var $main_id = "id_level_lama";
    //Default Coloms for read
    public $default_read_coloms = "id_level_lama,level_lama,level_sertifikat_lama,level_group_lama,level_lama_no_buku,level_desc_lama";
//allowed colom in CRUD filter
    public $coloumlist = "id_level_lama,level_lama,level_sertifikat_lama,level_group_lama,level_lama_no_buku,level_desc_lama";
    public $id_level_lama;
    public $level_lama;
    public $level_sertifikat_lama;
    public $level_group_lama;
    public $level_lama_no_buku;
    public $level_desc_lama;

    public function overwriteForm($return, $returnfull) {
        parent::overwriteForm($return, $returnfull);
        $arrLevelGroup = Generic::getLevelGroup();
        $return['level_group_lama'] = new Leap\View\InputSelect($arrLevelGroup, "level_group_lama", "level_group_lama", $this->level_group_lama);
//
        return $return;
    }

    public function overwriteRead($return) {
        $return = parent::overwriteRead($return);
        $arrLevelGroup = Generic::getLevelGroup();
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->level_group_lama)) {
                $obj->level_group_lama = $arrLevelGroup[$obj->level_group_lama];
            }
        }

        return $return;
    }


}