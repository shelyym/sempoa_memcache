<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb8
 *
 * @author efindiongso
 */
class SettingWeb8 extends WebService {

    // Create Jenis Biaya
    public function read_jenis_biaya_ak() {
        $obj = new SettingJenisBiayaModel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_biaya_ak");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_biaya_ak");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_biaya_ak");
        $crud->run_custom($obj, "SettingWeb8", "read_jenis_biaya_ak");
    }

    public function create_jenis_biaya_ak() {
        
    }

    public function delete_jenis_biaya_ak() {
        
    }

    public function update_jenis_biaya_ak() {
        
    }

// Level
    public function read_level_ak() {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_level_ak");
        $crud->ar_edit = AccessRight::hasRight("update_level_ak");
        $crud->ar_delete = AccessRight::hasRight("delete_level_ak");
        $crud->run_custom($obj, "SettingWeb8", "read_level_ak");
    }

    public function create_level_ak() {
        
    }

    public function delete_level_ak() {
        
    }

    public function update_level_ak() {
        
    }

// Status Guru
    public function read_status_guru_ak() {
        $obj = new GuruWeb4Model();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_status_guru_ak");
        $crud->ar_edit = AccessRight::hasRight("update_status_guru_ak");
        $crud->ar_delete = AccessRight::hasRight("delete_status_guru_ak");
        $crud->run_custom($obj, "SettingWeb8", "read_status_guru_ak");
    }

    public function create_status_guru_ak() {
        
    }

    public function update_status_guru_ak() {
        
    }

    public function delete_status_guru_ak() {
        
    }

    // Status Murid
    public function read_status_murid_ak() {
        $obj = new MuridWeb2Model();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_status_murid_ak");
        $crud->ar_edit = AccessRight::hasRight("update_status_murid_ak");
        $crud->ar_delete = AccessRight::hasRight("delete_status_murid_ak");
        $crud->run_custom($obj, "SettingWeb8", "read_status_murid_ak");
    }

    public function create_status_murid_ak() {
        
    }

    public function update_status_murid_ak() {
        
    }

    public function delete_status_murid_ak() {
        
    }

    // Cara pembayaran
    public function read_cara_pembayaran_ak() {
        $obj = new PembayaranWeb2Model();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_cara_pembayaran_ak");
        $crud->ar_edit = AccessRight::hasRight("update_cara_pembayaran_ak");
        $crud->ar_delete = AccessRight::hasRight("delete_cara_pembayaran_ak");
        $crud->run_custom($obj, "SettingWeb8", "read_cara_pembayaran_ak");
    }

    public function create_cara_pembayaran_ak() {
        
    }

    public function update_cara_pembayaran_ak() {
        
    }

    public function delete_cara_pembayaran_ak() {
        
    }

}
