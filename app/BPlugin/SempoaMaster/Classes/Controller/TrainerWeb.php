<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainerWeb
 *
 * @author efindiongso
 */
class TrainerWeb extends WebService
{

    // KPO
    public function read_level_trainer()
    {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_level_trainer");
        $crud->ar_edit = AccessRight::hasRight("update_level_trainer");
        $crud->ar_delete = AccessRight::hasRight("delete_level_trainer");
        $crud->run_custom($obj, "TrainerWeb", "read_level_trainer");
    }

    public function create_level_trainer()
    {

    }

    public function update_level_trainer()
    {

    }

    public function delete_level_trainer()
    {

    }

// KPO
    public function read_trainer_kpo()
    {
        $myOrg_id = AccessRight::getMyOrgID();
        $obj = new TrainerModel();
//        $obj->read_filter_array = array("tr_kpo_id" => $myOrg_id, "tr_ibo_id"=>0);
//        $crud = new CrudCustom();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_trainer_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_trainer_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_trainer_ikpo");
//        $crud->run_custom($obj, "TrainerWeb", "read_trainer_kpo");

        $crud->run_custom($obj, "TrainerWeb", "read_trainer_kpo", "tr_kpo_id='$myOrg_id' AND tr_ibo_id=0");


    }

    public function create_trainer_kpo()
    {
        $_GET['cmd'] = 'edit';
        $this->read_trainer_kpo();

    }

    public function update_trainer_kpo()
    {

    }

    public function delete_trainer_kpo()
    {

    }

    // IBO
    public function read_trainer_ibo()
    {
        $obj = new TrainerModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_trainer_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_trainer_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_trainer_ibo");
        $myOrg_id = AccessRight::getMyOrgID();
        $crud->run_custom($obj, "TrainerWeb", "read_trainer_ibo", " tr_ibo_id=$myOrg_id");
    }

    public function create_trainer_ibo()
    {
        $_GET['cmd'] = 'edit';
        $this->read_trainer_ibo;
    }

    public function update_trainer_ibo()
    {

    }

    public function delete_trainer_ibo()
    {

    }

    public function get_level_trainer()
    {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "TrainerWeb", "get_level_trainer");
    }


    public function get_trainer_ibo()
    {
        $myorgID = AccessRight::getMyOrgID();
        $obj = new TrainerModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_trainer_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_trainer_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_trainer_kpo");
        $myOrg_id = AccessRight::getMyOrgID();
        $crud->run_custom($obj, "TrainerWeb", "get_trainer_ibo", " tr_kpo_id=$myorgID AND tr_ibo_id !='' ");
    }

}
