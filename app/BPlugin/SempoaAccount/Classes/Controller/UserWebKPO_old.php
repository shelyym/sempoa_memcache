<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/29/16
 * Time: 10:50 AM
 */

class UserWebKPO_old {

    function read_user_kpo(){

//        echo AccessRight::getMyOrgID();
        $obj = new SempoaAccount();
        $obj->read_filter_array = array("admin_ak_id"=>AccessRight::getMyOrgID());
        $obj->hideColoums = array("admin_username","admin_ak_id","admin_kpo_id","admin_ibo_id","admin_tc_id");
//        $obj->role_level = "KPO";
//        $obj->removeAutoCrudClick = array("role_edit_ar");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_user_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_user_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_user_kpo");
        $crud->ar_add_url = AccessRight::getRightURL("create_user_kpo");
        $crud->ar_edit_url = AccessRight::getRightURL("update_user_kpo");

        $crud->ar_onDeleteSuccess_js = "
                            alert('User Group Deleted. Please do not forget to update users associated with this group.');
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);";
        $crud->run_custom($obj,"UserWeb","read_user_kpo");

    }
    function update_user_kpo(){

        FormCreator::receive(array("SempoaAccount","form_constraints_edit"),array("admin_password"));

        $t = time().rand(0,10);
        $acc_id = isset($_GET['id'])?addslashes($_GET['id']):die("No ID");

        $acc = new SempoaAccount();
        $acc->getByID($acc_id);

        ?>
        <div id="user_form_<?=$t;?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '".AccessRight::getMyOrgID()."' AND role_active = 1");
            $new = array();
            foreach($arrRole as $rol){
                $new[$rol->role_id] =  $rol->role_name;
            }

            $arrDetails = array(
                "admin_id"=> new \Leap\View\InputText("hidden","admin_id","admin_id",$acc->admin_id),
                "admin_email"=> new \Leap\View\InputText("email","admin_email","admin_email",$acc->admin_email),
                "admin_nama_depan"=>new \Leap\View\InputText("text","admin_nama_depan","admin_nama_depan",$acc->admin_nama_depan),
                "admin_password"=>new \Leap\View\InputText("password","admin_password","admin_password",""),
//                "admin_password2"=>new \Leap\View\InputText("password","admin_password2","admin_password2",""),
                "admin_org_type"=>new \Leap\View\InputText("hidden","admin_org_type","admin_org_type","KPO"),
                "admin_org_id"=>new \Leap\View\InputText("hidden","admin_org_id","admin_org_id",$acc->admin_org_id),
                "admin_role"=>new \Leap\View\InputSelect($new,"admin_role","admin_role",$acc->admin_role),
                "admin_ak_id"=>new \Leap\View\InputText("hidden","admin_ak_id","admin_ak_id",AccessRight::getMyOrgID())
            );

            $kpo = new TorgKPO();
            $arrk = $kpo->getWhere("org_parent_id = '".AccessRight::getMyOrgID()."' AND org_type LIKE 'KPO'");
            foreach($arrk as $v){
                $arrKPO[$v->org_id] = $v->org_kode." ".$v->nama;
            }


            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arrKPO,"admin_org_id","admin_org_id",$acc->admin_org_id);

            $onSuccess = "lwrefresh(window.beforepage);$('#user_form_".$t."').hide();$('#success_form2_".$t."').show();";
            FormCreator::createForm("Edit User",$arrDetails,_SPPATH."UserWeb/update_user_kpo",$onSuccess);
            ?>

        </div>
        <div id="success_form2_<?=$t;?>" style="text-align: center;display: none; ">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?=Lang::t('Data Edited Successfully');?></h2>
            <button class="btn btn-default" onclick="lwclose(selected_page);"><?=Lang::t('CLOSE');?></button>
            <? if(AccessRight::hasRight('read_semua_kpo')){?>
                <button onclick="openLw('read_semua_kpo','<?=AccessRight::getRightURL('read_semua_kpo');?>','fade');" class="btn btn-default"><?=AccessRight::getRightObject('read_semua_kpo')->ar_display_name;?></button>
            <? } ?>
            <? if(AccessRight::hasRight('read_user_kpo')){?>
                <button onclick="openLw('read_user_kpo','<?=AccessRight::getRightURL('read_user_kpo');?>','fade');" class="btn btn-default"><?=AccessRight::getRightObject('read_user_kpo')->ar_display_name;?></button>
            <? } ?>
        </div>
    <?
    }
    function delete_user_kpo(){

    }
    function create_user_kpo(){
        FormCreator::receive(array("SempoaAccount","form_constraints"));
//        pr($_GET);
        $t = time().rand(0,10);
        $kpo_id = isset($_GET['kpo_id'])?addslashes($_GET['kpo_id']):0;

        ?>
        <div id="user_form_<?=$t;?>" >

            <?
            $chn = new SempoaRole();
            $arrRole = $chn->getWhere("role_org_id = '".AccessRight::getMyOrgID()."' AND role_active = 1");
            $new = array();
            foreach($arrRole as $rol){
                $new[$rol->role_id] =  $rol->role_name;
            }

            $arrDetails = array(
                "admin_email"=> new \Leap\View\InputText("email","admin_email","admin_email",""),
                "admin_nama_depan"=>new \Leap\View\InputText("text","admin_nama_depan","admin_nama_depan",""),
                "admin_password"=>new \Leap\View\InputText("password","admin_password","admin_password",""),
                "admin_password2"=>new \Leap\View\InputText("password","admin_password2","admin_password2",""),
                "admin_org_type"=>new \Leap\View\InputText("hidden","admin_org_type","admin_org_type","KPO"),
                "admin_org_id"=>new \Leap\View\InputText("hidden","admin_org_id","admin_org_id",""),
                "admin_role"=>new \Leap\View\InputSelect($new,"admin_role","admin_role",""),
                "admin_ak_id"=>new \Leap\View\InputText("hidden","admin_ak_id","admin_ak_id",AccessRight::getMyOrgID())
            );

            //            if($kpo_id==0){
            //            echo "org_parent_id = '".AccessRight::getMyOrgID()."' AND org_type LIKE 'KPO'";
            $kpo = new TorgKPO();
            $arrk = $kpo->getWhere("org_parent_id = '".AccessRight::getMyOrgID()."' AND org_type LIKE 'KPO'");
            foreach($arrk as $v){
                $arrKPO[$v->org_id] = $v->org_kode." ".$v->nama;
            }

            $def = $kpo_id;
            $arrDetails['admin_org_id'] = new \Leap\View\InputSelect($arrKPO,"admin_org_id","admin_org_id",$def);
            //            }


            //            $onPost = "$(\"#user_form_$t input[name='admin_org_id']\").val($('#kpo_id_$t').val());";
            $onSuccess = "$('#user_form_".$t."').hide();$('#success_form2_".$t."').show();";
            FormCreator::createForm("Add New User",$arrDetails,_SPPATH."UserWeb/create_user_kpo",$onSuccess);
            ?>

        </div>
        <div id="success_form2_<?=$t;?>" style="text-align: center;display: none; ">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?=Lang::t('Data Added Successfully');?></h2>
            <button class="btn btn-default" onclick="lwclose(selected_page);"><?=Lang::t('CLOSE');?></button>
            <? if(AccessRight::hasRight('read_semua_kpo')){?>
                <button onclick="openLw('read_semua_kpo','<?=AccessRight::getRightURL('read_semua_kpo');?>','fade');" class="btn btn-default"><?=AccessRight::getRightObject('read_semua_kpo')->ar_display_name;?></button>
            <? } ?>
            <? if(AccessRight::hasRight('read_user_kpo')){?>
                <button onclick="openLw('read_user_kpo','<?=AccessRight::getRightURL('read_user_kpo');?>','fade');" class="btn btn-default"><?=AccessRight::getRightObject('read_user_kpo')->ar_display_name;?></button>
            <? } ?>
        </div>
    <?
    }
    function read_user_grup_kpo(){


        $obj = new SempoaRole();
        $obj->read_filter_array = array("role_org_id"=>AccessRight::getMyOrgID());
        $obj->hideColoums = array("role_org_id","role_level");
        $obj->role_level = "kpo";
        $obj->removeAutoCrudClick = array("role_edit_ar");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_user_grup_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_user_grup_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_user_grup_kpo");
        $crud->ar_onDeleteSuccess_js = "
                            alert('User Group Deleted. Please do not forget to update users associated with this group.');
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);";
        $crud->run_custom($obj,"UserWeb","read_user_grup_kpo");

        /*
         * read_user_grup_kpo
                                    [5] => update_user_grup_kpo
                                    [6] => delete_user_grup_kpo
                                    [7] => create_user_grup_kpo
         */
    }
    function update_user_grup_kpo(){

//        pr($_GET);
        if($_GET['mode'] == "edit_ugrup_ar"){
            SempoaRole::role2armatrix(AccessRight::getMyOrgID(),"KPO");
        }
    }
    function delete_user_grup_kpo(){

    }
    function create_user_grup_kpo(){
        $_GET['cmd'] = "edit";
        $this->read_user_grup_kpo();
    }
} 