<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb4
 *
 * @author efindiongso
 */
class SettingWeb4 extends WebService {

    //put your code here

    public function create_iuran_buku_minimal_semua_ibo() {
        
    }

    public function read_iuran_buku_minimal_semua_ibo() {
        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_iuran_buku_minimal_semua_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_iuran_buku_minimal_semua_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_iuran_buku_minimal_semua_ibo");
        $like = " (kpo_id LIKE '%, " . $myOrgID . "' OR " . " kpo_id LIKE '" . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '" . $myOrgID . "')";

        $crud->run_custom($obj, "SettingWeb4", "read_iuran_buku_minimal_semua_ibo", " jenis_biaya ='" . KEY::$IURANBUKU . "'  AND $like ");
    }

    public function delete_iuran_buku_minimal_semua_ibo() {
        
    }

    public function update_iuran_buku_minimal_semua_ibo() {
        
    }

    public function get_iuran_buku_ibo_tertentu() {
        
    }

    // IBO

    public function get_my_iuran_buku_min_ibo() {

//        Generic::getMyRoot();
        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = 0;
        $crud->ar_edit = 1;
        $crud->ar_delete = 1;
        $like_1 = " (ibo_id LIKE '%, " . $myOrgID . "' OR " . " ibo_id LIKE '" . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '" . $myOrgID . "')";
        $crud->run_custom($obj, "SettingWeb4", "get_my_iuran_buku_min_ibo", " jenis_biaya = " . KEY::$IURANBUKU . " AND $like_1");
    }

// TC

    public function get_my_biaya_bulanan_per_level_minimal_tc() {
        $obj = new BiayaBulananModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
//        $crud->ar_add = 0;
//        $crud->ar_edit = 0;
//        $crud->ar_delete = 0;

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
            if ($i == (count($index) - 1)) {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' ";
            } else {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' OR ";
            }
        }

        $crud->run_custom($obj, "SettingWeb4", "get_my_biaya_bulanan_per_level_minimal_tc", "  $like  ");
    }

    public function create_biaya_bulanan_per_level_tc() {
        
    }

    public function read_biaya_bulanan_per_level_tc() {
        $obj = new BiayaBulananModel();
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
            if ($i == (count($index) - 1)) {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' ";
            } else {

                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' OR ";
            }
        }

        $crud->run_custom($obj, "SettingWeb4", "read_biaya_bulanan_per_level_tc", "  $like  ");
    }

    public function update_biaya_bulanan_per_level_tc() {
        
    }

    public function delete_biaya_bulanan_per_level_tc() {
        
    }

}
