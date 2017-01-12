<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb6
 *
 * @author efindiongso
 */
class SettingWeb6 extends WebService {

//put your code here
    public function create_biaya_perlengkapan_minimal_semua_ibo() {
        
    }

    public function read_biaya_perlengkapan_minimal_semua_ibo() {
        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_biaya_perlengkapan_minimal_semua_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_biaya_perlengkapan_minimal_semua_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_biaya_perlengkapan_minimal_semua_ibo");
        $like = " (kpo_id LIKE '%, " . $myOrgID . "' OR " . " kpo_id LIKE '" . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '" . $myOrgID . "')";

        $crud->run_custom($obj, "SettingWeb6", "read_biaya_perlengkapan_minimal_semua_ibo", " jenis_biaya ='" . KEY::$PERLENGKAPAN . "'  AND $like ");
    }

    public function update_biaya_perlengkapan_minimal_semua_ibo() {
        
    }

    public function delete_biaya_perlengkapan_minimal_semua_ibo() {
        
    }

    public function get_biaya_perlengkapan_ibo_tertentu() {
        
    }

    public function get_my_biaya_perlengkapan_min_ibo() {
        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = 0;
        $crud->ar_edit = 1;
        $crud->ar_delete = 1;
        $like_1 = " (ibo_id LIKE '%, " . $myOrgID . "' OR " . " ibo_id LIKE '" . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '" . $myOrgID . "')";
        $crud->run_custom($obj, "SettingWeb6", "get_my_biaya_perlengkapan_min_ibo", " jenis_biaya = " . KEY::$PERLENGKAPAN . " AND $like_1");
    }

    public function create_biaya_perlengkapan_all_tc() {
        
    }

    public function read_biaya_perlengkapan_all_tc() {
        
    }

    public function update_biaya_perlengkapan_all_tc() {
        
    }

    public function delete_biaya_perlengkapan_all_tc() {
        
    }

    
    // TC
    
    public function get_my_biaya_perlengkapan_tc(){
        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;

        $arrGroup = Generic::getGroup($myParentID, "1");
        $arrKeyGroup = array_keys($arrGroup);

        foreach ($arrKeyGroup as $key => $value) {
            $arrTC = Generic::fgetGroupMember($value);
            foreach ($arrTC as $key => $val) {

                if (strpos($val, $myOrgID) !== false) {
                    $index[] = $key;
                }
                // utk all
                elseif ($val == '0') {
                    $index[] = $key;
                }
            }
        }
        for ($i = 0; $i < count($index); ++$i) {
            $help = $index[$i];
//            pr($help);
            if ($i == (count($index) - 1)) {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' ";
            } else {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' OR ";
            }
        }
        $crud->run_custom($obj, "SettingWeb2", "get_my_biaya_pendaftaran_tc", " jenis_biaya ='" . KEY::$PERLENGKAPAN . "' AND ( " . $like . " ) ");
  
    }
}
