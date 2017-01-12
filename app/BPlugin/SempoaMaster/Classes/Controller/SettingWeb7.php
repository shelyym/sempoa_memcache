<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JenisPembayaran
 *
 * @author efindiongso
 */
class SettingWeb7 extends WebService {

    // KPO
    public function read_jenis_biaya() {
        $obj = new SettingJenisBiayaModel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_biaya");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_biaya");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_biaya");
        $crud->run_custom($obj, "SettingWeb7", "read_jenis_biaya");
    }

    public function create_jenis_biaya() {
        
    }

    public function update_jenis_biaya() {
        
    }

    public function delete_jenis_biaya() {
        
    }

// IBO
    public function get_jenis_biaya_ibo() {
        $obj = new SettingJenisBiayaModel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;

        $crud->run_custom($obj, "SettingWeb7", "get_jenis_biaya_ibo");
    }

// TC
    public function get_jenis_biaya_tc() {
        $obj = new SettingJenisBiayaModel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;

        $crud->run_custom($obj, "SettingWeb7", "get_jenis_biaya_tc");
    }

    public function read_jenis_buku() {
        $myOrgID = AccessRight::getMyOrgID();
        $obj = new JenisBukuModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = 1;
        $crud->ar_edit = 1;
        $crud->ar_delete = 1;
//        $crud->ar_add = AccessRight::hasRight("create_jenis_buku");
//        $crud->ar_edit = AccessRight::hasRight("update_jenis_buku");
//        $crud->ar_delete = AccessRight::hasRight("delete_jenis_buku");

        $crud->run_custom($obj, "SettingWeb7", "read_jenis_buku", " kpo_id='$myOrgID' ");
    }

    public function create_jenis_buku() {
        
    }

    public function update_jenis_buku() {
        
    }

    public function delete_jenis_buku() {
        
    }

}
