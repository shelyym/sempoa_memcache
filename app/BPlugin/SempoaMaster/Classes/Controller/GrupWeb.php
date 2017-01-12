<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Group
 *
 * @author efindiongso
 */
class GrupWeb extends WebService {

    //put your code here

    public function read_grup_ibo() {
        $myOrgID = (AccessRight::getMyOrgID());
        $myParentID = Generic::getMyParentID($myOrgID);
        $arrMyAllIBO = Generic::getAllMyIBO($myOrgID);
        $arrKeyMyIBO = array_keys($arrMyAllIBO);
//        pr($arrMyAllIBO);
        for ($i = 0; $i < count($arrKeyMyIBO); ++$i) {
            //like '193,%'
            //groups LIKE '3,%' or groups like '3'
            $help = $arrKeyMyIBO[$i];
//            pr($help);
            if ($i == (count($arrKeyMyIBO) - 1)) {

                if ($help == "0") {
                    $like .= " groups LIKE '%'";
                } else {
                    $like .= " groups LIKE '%," . $help . "' OR " . " groups LIKE '" . $help . ",%'" . " OR " . " groups LIKE '" . $help . "' ";
                }
            } else {
                if ($arrKeyMyIBO[$i] == "All") {
                    $like .= " groups LIKE '%' OR ";
                } else {
                    $like .= " groups LIKE '%," . $help . "' OR " . " groups LIKE '" . $help . ",%'" . " OR " . " groups LIKE '" . $help . "' OR ";
                }
            }
        }
//        pr($like);

        $obj = new GroupsModel();

        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_grup_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_grup_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_grup_ibo");
        $crud->run_custom($obj, "GrupWeb", "read_grup_ibo", " $like ");
    }

    public function create_grup_ibo() {
        $_GET['cmd'] = 'edit';
        $this->read_grup_ibo();
    }

    public function update_grup_ibo() {
        
    }

    public function delete_grup_ibo() {
        
    }

    public function create_grup_tc() {
        $_GET['cmd'] = 'edit';
        $this->read_grup_tc();
    }

    public function read_grup_tc() {
        
        $myOrgID = (AccessRight::getMyOrgID());
        $myParentID = Generic::getMyParentID($myOrgID);
        $arrMyGroup = Generic::getGroup($myOrgID, "1");
        $arrKeyMyGroup = array_keys($arrMyGroup);
        for ($i = 0; $i < count($arrKeyMyGroup); ++$i) {
            $help = $arrKeyMyGroup[$i];
//            pr($help);
            if ($i == (count($arrKeyMyGroup) - 1)) {

                if ($help == "0") {
                    $like .= " id_group LIKE '%'";
                } else {
                    $like .= " id_group LIKE '%," . $help . "' OR " . " id_group LIKE '" . $help . ",%'" . " OR " . " id_group LIKE '" . $help . "' ";
                }
            } else {
                if ($arrKeyMyTC[$i] == "All") {
                    $like .= " id_group LIKE '%' OR ";
                } else {
                    $like .= " id_group LIKE '%," . $help . "' OR " . " id_group LIKE '" . $help . ",%'" . " OR " . " id_group LIKE '" . $help . "' OR ";
                }
            }
        }

//        pr($like);
        

        $obj = new GroupsModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_grup_tc");
        $crud->ar_edit = AccessRight::hasRight("update_grup_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_grup_tc");
        $crud->run_custom($obj, "GrupWeb", "read_grup_tc", " $like ");
    }

    public function update_grup_tc() {
        
    }

    public function delete_grup_tc() {
        
    }

}
