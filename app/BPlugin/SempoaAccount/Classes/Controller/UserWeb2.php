<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserWeb2
 *
 * @author efindiongso
 */
class UserWeb2 extends WebService {

    //put your code here

    static $lvl = "ibo";
    static $webclass = "UserWeb2";
    static $orgModel = "TorgIBO";

    public static function read_user($group, $group_id) {
        $obj = new SempoaAccount();
        $obj->read_filter_array = array("admin_org_id" => $group_id);
        $obj->hideColoums = array("admin_username", "admin_ak_id", "admin_ibo_id", "admin_ibo_id", "admin_tc_id","admin_kpo_id");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_user_my_" . $group);
        $crud->ar_delete = AccessRight::hasRight("delete_user_my_" . $group);
        $crud->ar_edit = AccessRight::hasRight("update_user_my_" . $group);
        $crud->ar_add_url = AccessRight::getRightURL("create_user_my_" . $group);
        $crud->ar_edit_url = AccessRight::getRightURL("update_user_my_" . $group);

        $crud->ar_onDeleteSuccess_js = "
                            alert('User Group Deleted. Please do not forget to update users associated with this group.');
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);";
        $crud->run_custom($obj, $webclass, "read_user_my_" . $group);
    }

    public static function create_user($group, $group_id) {
        FormCreator::receive(array("SempoaAccount", "form_constraints"));
        $t = time() . rand(0, 10);
        $parent = Generic::getMyParentID($group_id);
        $myOrg = new SempoaOrg();
        $myOrg->getByID($group_id);
        ?>
        <div id="user_form_<?= $group_id . $t; ?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '" . $parent . "' AND role_active = 1");
//            pr($chn);
            $new = array();
            foreach ($arrRole as $rol) {
                $new[$rol->role_id] = $rol->role_name;
            }

            $arrDetails = array(
                "admin_email" => new \Leap\View\InputText("email", "admin_email", "admin_email", ""),
                "admin_nama_depan" => new \Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan", ""),
                "admin_password" => new \Leap\View\InputText("password", "admin_password", "admin_password", ""),
                "admin_password2" => new \Leap\View\InputText("password", "admin_password2", "admin_password2", ""),
                "admin_org_type" => new \Leap\View\InputText("hidden", "admin_org_type", "admin_org_type", strtolower($group)),
                "admin_org_id" => new \Leap\View\InputText("hidden", "admin_org_id", "admin_org_id", ""),
                "admin_role" => new \Leap\View\InputSelect($new, "admin_role", "admin_role", ""),
                "admin_" . $group . "_id" => new \Leap\View\InputText("hidden", "admin_" . $group . "_id", "admin_" . $group . "_id", $parent)
            );
            if ($group == KEY::$IBO) {
                $ibo = new TorgIBO();
            } elseif ($group == KEY::$TC) {
                $ibo = new TorgTC();
            } elseif ($group == KEY::$KPO) {
                $ibo = new TorgKPO();
            } elseif ($group == KEY::$AK) {
                $ibo = new TorgAK();
            }
            $arribo[$myOrg->org_id] = $myOrg->org_kode . " " . $myOrg->nama;
            $def = $group_id;
            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arribo, "admin_org_id", "admin_org_id", $def);
            $onSuccess = "$('#user_form_" . $group_id . $t . "').hide();lwclose(selected_page);";
            FormCreator::createForm("Add New User", $arrDetails, _SPPATH . self::$webclass . "/create_user_my_" . $group, $onSuccess);
            ?>

        </div>
        <?
    }
    /*
     * $group_id ini adalah tc_id, ibo_id oder kpo_id
     * $group ini seperti tc, ibo oder kpo
     */
    public static function update_user($group, $group_id) {
//        pr($group_id);
        FormCreator::receive(array("SempoaAccount", "form_constraints_edit"), array("admin_password"));
        $t = time() . rand(0, 10);
        $acc_id = isset($_GET['id']) ? addslashes($_GET['id']) : die("No ID");
        $acc = new SempoaAccount();
        $acc->getByID($acc_id);
        $parent = Generic::getMyParentID($group_id);
        $myOrg = new SempoaOrg();
        $myOrg->getByID($group_id);
        ?>
        <div id="user_form_<?= $group_id . $t; ?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '" . $parent . "' AND role_active = 1");
            $new = array();
            foreach ($arrRole as $rol) {
                $new[$rol->role_id] = $rol->role_name;
            }
//            pr($acc);
            $arrDetails = array(
                "admin_id" => new \Leap\View\InputText("hidden", "admin_id", "admin_id", $acc->admin_id),
                "admin_email" => new \Leap\View\InputText("email", "admin_email", "admin_email", $acc->admin_email),
                "admin_nama_depan" => new \Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan", $acc->admin_nama_depan),
                "admin_password" => new \Leap\View\InputText("password", "admin_password", "admin_password", ""),
                "admin_org_type" => new \Leap\View\InputText("hidden", "admin_org_type", "admin_org_type", $group),
                "admin_org_id" => new \Leap\View\InputText("hidden", "admin_org_id", "admin_org_id", $acc->admin_org_id),
                "admin_role" => new \Leap\View\InputSelect($new, "admin_role", "admin_role", $acc->admin_role),
                "admin_" . $group . "_id" => new \Leap\View\InputText("hidden", "admin_" . $group . "_id", "admin_" . $group . "_id", $parent)
            );


            if ($group == KEY::$IBO) {
                $ibo = new TorgIBO();
            } elseif ($group == KEY::$TC) {
                $ibo = new TorgTC();
            } elseif ($group == KEY::$KPO) {
                $ibo = new TorgKPO();
            } elseif ($group == KEY::$AK) {
                $ibo = new TorgAK();
            }
            $arribo[$myOrg->org_id] = $myOrg->org_kode . " " . $myOrg->nama;

            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arribo, "admin_org_id", "admin_org_id", $group_id);
//            $onSuccess = "$('#user_form_" . $ibo->org_id . $t . "').hide();lwclose(selected_page);";
            $onSuccess = "$('#user_form_" . $group_id . $t . "').hide();lwclose(selected_page);";

            FormCreator::createForm("Edit User", $arrDetails, _SPPATH . self::$webclass . "/update_user_my_" . $group, $onSuccess);
            ?>
        </div>
        <?
    }

    public function read_user_my_ibo() {
        $group = "ibo";
        $ibo_id = AccessRight::getMyOrgID();


        self::read_user($group, $ibo_id);
        die();
        $parent = Generic::getMyParentID(AccessRight::getMyOrgID());
        $obj = new SempoaAccount();
        $obj->read_filter_array = array("admin_org_id" => $ibo_id);
        $obj->hideColoums = array("admin_username", "admin_ak_id", "admin_ibo_id", "admin_ibo_id", "admin_tc_id");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_user_my_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_user_my_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_user_my_ibo");
        $crud->ar_add_url = AccessRight::getRightURL("create_user_my_ibo");
        $crud->ar_edit_url = AccessRight::getRightURL("update_user_my_ibo");

        $crud->ar_onDeleteSuccess_js = "
                            alert('User Group Deleted. Please do not forget to update users associated with this group.');
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);";
        $crud->run_custom($obj, $webclass, "read_user_my_ibo");
    }

    public function delete_user_my_ibo() {
        
    }

    public function update_user_my_ibo() {
        FormCreator::receive(array("SempoaAccount", "form_constraints_edit"), array("admin_password"));
        $t = time() . rand(0, 10);
        $acc_id = isset($_GET['id']) ? addslashes($_GET['id']) : die("No ID");
        $acc = new SempoaAccount();
        $acc->getByID($acc_id);
        $ibo_id = AccessRight::getMyOrgID();
        $parent = Generic::getMyParentID($ibo_id);
        $myOrg = new SempoaOrg();
        $myOrg->getByID($ibo_id);
        ?>
        <div id="user_form_<?= $ibo_id . $t; ?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '" . Generic::getMyParentID(AccessRight::getMyOrgID()) . "' AND role_active = 1");
            $new = array();
            foreach ($arrRole as $rol) {
                $new[$rol->role_id] = $rol->role_name;
            }
            $arrDetails = array(
                "admin_id" => new \Leap\View\InputText("hidden", "admin_id", "admin_id", $acc->admin_id),
                "admin_email" => new \Leap\View\InputText("email", "admin_email", "admin_email", $acc->admin_email),
                "admin_nama_depan" => new \Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan", $acc->admin_nama_depan),
                "admin_password" => new \Leap\View\InputText("password", "admin_password", "admin_password", ""),
                "admin_org_type" => new \Leap\View\InputText("hidden", "admin_org_type", "admin_org_type", "ibo"),
                "admin_org_id" => new \Leap\View\InputText("hidden", "admin_org_id", "admin_org_id", $acc->admin_org_id),
                "admin_role" => new \Leap\View\InputSelect($new, "admin_role", "admin_role", $acc->admin_role),
                "admin_" . self::$lvl . "_id" => new \Leap\View\InputText("hidden", "admin_" . self::$lvl . "_id", "admin_" . self::$lvl . "_id", $parent)
            );


            $ibo = new TorgIBO();
            $arribo[$myOrg->org_id] = $myOrg->org_kode . " " . $myOrg->nama;

            $def = $ibo_id;
            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arribo, "admin_org_id", "admin_org_id", $def);
            $onSuccess = "$('#user_form_" . $ibo_id . $t . "').hide();lwclose(selected_page);";
            FormCreator::createForm("Edit User", $arrDetails, _SPPATH . self::$webclass . "/update_user_my_ibo", $onSuccess);
            ?>
        </div>
        <?
    }

    public function create_user_my_ibo() {

        FormCreator::receive(array("SempoaAccount", "form_constraints"));
        $t = time() . rand(0, 10);
        $ibo_id = AccessRight::getMyOrgID();
        $parent = Generic::getMyParentID($ibo_id);
        $myOrg = new SempoaOrg();
        $myOrg->getByID($ibo_id);
        ?>
        <div id="user_form_<?= $ibo_id . $t; ?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '" . $parent . "' AND role_active = 1");
//            pr($chn);
            $new = array();
            foreach ($arrRole as $rol) {
                $new[$rol->role_id] = $rol->role_name;
            }

            $arrDetails = array(
                "admin_email" => new \Leap\View\InputText("email", "admin_email", "admin_email", ""),
                "admin_nama_depan" => new \Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan", ""),
                "admin_password" => new \Leap\View\InputText("password", "admin_password", "admin_password", ""),
                "admin_password2" => new \Leap\View\InputText("password", "admin_password2", "admin_password2", ""),
                "admin_org_type" => new \Leap\View\InputText("hidden", "admin_org_type", "admin_org_type", strtolower(self::$lvl)),
                "admin_org_id" => new \Leap\View\InputText("hidden", "admin_org_id", "admin_org_id", ""),
                "admin_role" => new \Leap\View\InputSelect($new, "admin_role", "admin_role", ""),
                "admin_" . self::$lvl . "_id" => new \Leap\View\InputText("hidden", "admin_" . self::$lvl . "_id", "admin_" . self::$lvl . "_id", $parent)
            );

            $ibo = new TorgIBO();
            $arribo[$myOrg->org_id] = $myOrg->org_kode . " " . $myOrg->nama;

            $def = $ibo_id;
            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arribo, "admin_org_id", "admin_org_id", $def);
            $onSuccess = "$('#user_form_" . $ibo_id . $t . "').hide();lwclose(selected_page);";
            FormCreator::createForm("Add New User", $arrDetails, _SPPATH . self::$webclass . "/create_user_my_ibo", $onSuccess);
            ?>

        </div>
        <?
    }

    public function read_user_my_tc() {
        $group = "tc";
        $tc_id = AccessRight::getMyOrgID();


        self::read_user($group, $tc_id);
    }

    public function delete_user_my_tc() {
        
    }

    public function update_user_my_tc() {
        $group = "tc";
//        $tc_id= $_GET['id'];
        $org_id = AccessRight::getMyOrgID();
        self::update_user($group, $org_id);
    }

    public function create_user_my_tc() {
        $group = "tc";
        $tc_id = AccessRight::getMyOrgID();
        self::create_user($group, $tc_id);
    }

    public function read_user_my_kpo() {
        $group = "kpo";
        $kpo_id = AccessRight::getMyOrgID();
        self::read_user($group, $kpo_id);
    }

    public function delete_user_my_kpo() {
        
    }

    public function update_user_my_kpo() {
        $group = "kpo";
        $kpo_id = AccessRight::getMyOrgID();
        self::update_user($group, $kpo_id);
    }

    public function create_user_my_kpo() {
        $group = "kpo";
        $kpo_id = AccessRight::getMyOrgID();
        self::create_user($group, $kpo_id);
    }

    public function read_user_my_ak() {
        $group = KEY::$AK;
        $ak_id = AccessRight::getMyOrgID();
        self::read_user($group, $ak_id);
    }

    public function delete_user_my_ak() {
        
    }

    public function update_user_my_ak() {
        $group = KEY::$AK;
        $ak_id = AccessRight::getMyOrgID();
        self::update_user($group, $ak_id);
    }

    public function create_user_my_ak() {
        $group = KEY::$AK;
        $ak_id = AccessRight::getMyOrgID();
        self::create_user($group, $ak_id);
    }

}
