<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ujian
 *
 * @author efindiongso
 */
class Ujian extends WebService {

    //put your code here

    public function create_ujian_ibo() {
          $_GET['cmd'] = 'edit';
          $this->read_ujian_ibo();
    }

    public function read_ujian_ibo() {
        $ibo_id = AccessRight::getMyOrgID();
        $obj = new UjianModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_ujian_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_ujian_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_ujian_ibo");
        $crud->run_custom($obj, "Ujian", "read_ujian_ibo", "ujian_ibo_id='$ibo_id'");
    }

    public function update_ujian_ibo() {
        
    }

    public function delete_ujian_ibo() {
        
    }

  
}
