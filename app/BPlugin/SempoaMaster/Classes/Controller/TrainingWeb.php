<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainingWeb
 *
 * @author efindiongso
 */
class TrainingWeb extends WebService {

    //put your code here

//    public function create_biaya_training() {
//        $_GET['cmd'] = 'edit';
//        $this->read_biaya_training();
//    }
//
//    public function read_biaya_training() {
//        $obj = new BiayaTrainingModel();
//        $crud = new CrudCustom();
//        $crud->ar_add = AccessRight::hasRight("create_biaya_training");
//        $crud->ar_edit = 1;
//        $crud->ar_delete = 1;
//        $crud->run_custom($obj, "TrainingWeb", "read_biaya_training");
//    }

    public function create_jadwal_training_guru() {
        $_GET['cmd'] = 'edit';
        $this->read_jadwal_training_guru();
    }

    public function read_jadwal_training_guru() {
        $myOrgId = AccessRight::getMyOrgID();
        $obj = new JadwalTrainingModel();
        $crud = new CrudCustom();
        $obj->read_filter_array = array("jt_ibo_id" => $myOrgId);
        $crud->ar_add = AccessRight::hasRight("create_jadwal_training_guru");
        $crud->ar_edit = AccessRight::hasRight("update_jadwal_training_guru");
        $crud->ar_delete = AccessRight::hasRight("delete_jadwal_training_guru");
        $crud->run_custom($obj, "TrainingWeb", "read_jadwal_training_guru");
    }

    // TC

    public function get_jadwal_training_guru_tc() {
        $myIBOId = Generic::getMyParentID(AccessRight::getMyOrgID());
        $obj = new JadwalTrainingModel();
        $obj->read_filter_array = array("jt_ibo_id" => $myIBOId);
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jadwal_training_guru");
        $crud->ar_edit = AccessRight::hasRight("update_jadwal_training_guru");
        $crud->ar_delete = AccessRight::hasRight("delete_jadwal_training_guru");
        $crud->run_custom($obj, "TrainingWeb", "read_jadwal_training_guru");
    }

    public function read_jadwal_training_evaluasi_tc() {
        $obj = new JadwalTrainingModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_jadwal_training_guru");
        $crud->ar_edit = AccessRight::hasRight("update_jadwal_training_guru");
        $crud->ar_delete = AccessRight::hasRight("delete_jadwal_training_guru");
        $myIBOId = Generic::getMyParentID(AccessRight::getMyOrgID());
        $crud->run_custom($obj, "TrainingWeb", "read_jadwal_training_guru", "jt_ibo_id='$myIBOId' AND jt_jenis=1");
    }

    public function read_jadwal_training_evaluasi_ibo() {
        $obj = new JadwalTrainingModel();
        $crud = new CrudCustomSempoa();
//        $crud->ar_add = AccessRight::hasRight("create_jadwal_training_guru");
//        $crud->ar_edit = AccessRight::hasRight("update_jadwal_training_guru");
//        $crud->ar_delete = AccessRight::hasRight("delete_jadwal_training_guru");
        $myOrgId = AccessRight::getMyOrgID();
        $crud->run_custom($obj, "TrainingWeb", "read_jadwal_training_guru", "jt_ibo_id='$myOrgId' AND jt_jenis = 1");
    }


}
