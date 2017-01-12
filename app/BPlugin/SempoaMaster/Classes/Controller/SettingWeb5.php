<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb5
 *
 * @author efindiongso
 */
class SettingWeb5 extends WebService {

    //put your code here
//> read_level_murid
//                            [1] => create_level_murid
//                            [2] => update_level_murid
//                            [3] => delete_level_murid
    // KPO
    public function create_level_murid() {
        $_GET['cmd'] = 'edit';
        $this->read_level_murid();
    }

    public function read_level_murid() {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_level_murid");
        $crud->ar_edit = AccessRight::hasRight("update_level_murid");
        $crud->ar_delete = AccessRight::hasRight("delete_level_murid");
        $crud->run_custom($obj, "SettingWeb5", "read_level_murid");
    }

    public function create_tingkatan_kelas_form() {


        FormCreator::receive(array("SempoaAccount", "form_constraints_edit"));

        $acc = new Account();
        $arrDetails = array(
            "admin_id" => new \Leap\View\InputText("hidden", "admin_id", "admin_id", $acc->admin_id),
            "admin_email" => new \Leap\View\InputText("email", "admin_email", "admin_email", $acc->admin_email),
            "admin_nama_depan" => new \Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan", $acc->admin_nama_depan),
            "admin_password" => new \Leap\View\InputText("password", "admin_password", "admin_password", ""),
//                "admin_password2"=>new \Leap\View\InputText("password","admin_password2","admin_password2",""),
            "admin_org_type" => new \Leap\View\InputText("hidden", "admin_org_type", "admin_org_type", "ibo"),
            "admin_org_id" => new \Leap\View\InputText("hidden", "admin_org_id", "admin_org_id", $acc->admin_org_id),
            "admin_role" => new \Leap\View\InputSelect($new, "admin_role", "admin_role", $acc->admin_role),
            "admin_ak_id" => new \Leap\View\InputText("hidden", "admin_ak_id", "admin_ak_id", "")
        );

//        $onSuccess = "lwrefresh(window.beforepage);$('#user_form_" . $t . "').hide();$('#success_form2_" . $t . "').show();";
        FormCreator::createForm("Edit User", $arrDetails, _SPPATH . "SettingWeb5" . "/create_tingkatan_kelas_form", '');
    }

    public function delete_level_murid() {
        
    }

    public function get_level_murid_ibo() {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "SettingWeb5", "get_level_murid_ibo");
    }

    // TC
    public function get_level_murid_tc() {
        $obj = new SempoaLevel();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "SettingWeb5", "get_level_murid_tc");
    }

    public function get_my_iuran_buku_tc() {
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
        $crud->run_custom($obj, "SettingWeb5", "get_my_iuran_buku_tc", " jenis_biaya ='" . KEY::$IURANBUKU . "' AND ( " .  $like ." )");
    }

}
