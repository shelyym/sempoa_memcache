<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb3
 *
 * @author efindiongso
 */
class SettingWeb3 extends WebService {

    //put your code here
//    [SettingWeb3] => Array
//                        (
//                            [0] => create_biaya_bulanan_per_level_minimal_all_tc
//                            [1] => read_biaya_bulanan_per_level_minimal_all_tc
//                            [2] => update_biaya_bulanan_per_level_minimal_all_tc
//                            [3] => delete_biaya_bulanan_per_level_minimal_all_tc
//                            [4] => get_biaya_bulanan_per_level_tc_tertentu
    // KPO

    public function create_biaya_bulanan_per_level_minimal_all_ibo() {
        
    }

    public function read_biaya_bulanan_per_level_minimal_all_ibo() {
        $obj = new BiayaBulananModel();
//        $obj->printColumlistAsAttributes();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_biaya_bulanan_per_level_minimal_all_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_biaya_bulanan_per_level_minimal_all_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_biaya_bulanan_per_level_minimal_all_ibo");
        $crud->run_custom($obj, "SettingWeb3", "read_biaya_bulanan_per_level_minimal_all_ibo", " kpo_id='$myOrgID' ");
    }

    public function update_biaya_bulanan_per_level_minimal_all_ibo() {
        echo "create_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function delete_biaya_bulanan_per_level_minimal_all_ibo() {
        echo "create_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function get_biaya_bulanan_per_level_ibo_tertentu() {
        echo "create_biaya_bulanan_per_level_minimal_all_tc";
    }

    // IBO
    public function create_biaya_bulanan_per_level_minimal_all_tc() {
        echo "create_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function read_biaya_bulanan_per_level_minimal_all_tc() {
        echo "read_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function update_biaya_bulanan_per_level_minimal_all_tc() {
        echo "update_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function delete_biaya_bulanan_per_level_minimal_all_tc() {
        echo "delete_biaya_bulanan_per_level_minimal_all_tc";
    }

    public function get_biaya_bulanan_per_level_tc_tertentu() {
        echo "get_biaya_bulanan_per_level_tc_tertentu";
    }

    public function get_my_biaya_bulanan_per_level_minimal_ibo() {
        $obj = new BiayaBulananModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = 0;
        $crud->ar_edit = 1;
        $crud->ar_delete = 1;


        $like_1 = "( ibo_id LIKE '%, " . $myOrgID . "' OR " . " ibo_id LIKE '" . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '" . $myOrgID . "')";
        $crud->run_custom($obj, "SettingWeb3", "get_my_biaya_bulanan_per_level_minimal_ibo", "   $like_1");
    }

}
