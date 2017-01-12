<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/26/16
 * Time: 10:43 PM
 */
class KPOWeb extends WebService {

    public function create_kpo() {


//        error_reporting(E_ALL);
//        ini_set('display_errors', 1);

        $kpo = new TorgKPO();
//        pr($kpo);
//        pr($_SESSION);

        $t = time();
//nomor_telp,email,propinsi
        /*
         * Objective to create dynamic form but remove oneness with regularcrud
         */
        $arrDetails = array(
            "org_kode" => new \Leap\View\InputText("text", "org_kode", "org_kode", ""),
            "nama" => new \Leap\View\InputText("text", "nama", "nama", ""),
            "alamat" => new \Leap\View\InputText("text", "alamat", "alamat", ""),
            "propinsi" => new \Leap\View\InputText("text", "propinsi", "propinsi", ""),
            "nomor_telp" => new \Leap\View\InputText("text", "nomor_telp", "nomor_telp", ""),
            "email" => new \Leap\View\InputText("email", "email", "email", ""),
            "nama_pemilik" => new \Leap\View\InputText("text", "nama_pemilik", "nama_pemilik", ""),
            "tanggal_lahir" => new \Leap\View\InputText("date", "tanggal_lahir", "tanggal_lahir", ""),
            "alamat_rmh_priv" => new \Leap\View\InputText("text", "alamat_rmh_priv", "alamat_rmh_priv", ""),
            "telp_priv" => new \Leap\View\InputText("text", "telp_priv", "telp_priv", ""),
            "hp_priv" => new \Leap\View\InputText("text", "hp_priv", "hp_priv", ""),
            "email_priv" => new \Leap\View\InputText("email", "email_priv", "email_priv", ""),
            "tgl_kontrak" => new \Leap\View\InputText("date", "tgl_kontrak", "tgl_kontrak", "")

        );
        FormCreator::receive(array("TorgKPO", "form_constraints"));
        ?>
        <style>
            #kpo_form_<?= $t; ?> .form_title,#user_form_<?= $t; ?> .form_title{
                text-align: center;
            }
        </style>
        <div id="kpo_form_<?= $t; ?>">
            <?
            $onSuccess = "$('#kpo_form_" . $t . "').hide();$('#success_form_" . $t . "').show();$('#kpo_id_" . $t . "').val(data.id);";
            FormCreator::createForm("Add New KPO", $arrDetails, _SPPATH . "KPOWeb/create_kpo", $onSuccess);
            ?>
        </div>
        <input type="hidden" id="kpo_id_<?= $t; ?>">

        <div id="success_form_<?= $t; ?>" style="text-align: center;display: none;">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?= Lang::t('Data Added Successfully'); ?></h2>
            <div class="alert alert-info" style="margin-left: 20px; margin-right: 20px;">
                <h3 style="padding: 0; margin: 0px;">Do you want to add user to this KPO?</h3>
                <p style="font-style: italic; padding: 10px;">You can add user later in <?= AccessRight::getRightObject('read_semua_kpo')->ar_display_name; ?>.</p>
                <?
                $lanjutan = "$('#success_form_" . $t . "').hide();$('#user_form_" . $t . "').show();";
                $lanjutan = "openLw('create_user_kpo','" . AccessRight::getRightURL('create_user_kpo') . "?kpo_id='+$('#kpo_id_$t').val(),'fade');";

                if (AccessRight::hasRight('create_user_kpo')) {
                    ?>

                    <button class="btn btn-default" onclick="<?= $lanjutan; ?>"><?= Lang::t('YES'); ?></button>
                    <button onclick="lwclose(selected_page);" class="btn btn-default"><?= Lang::t('NO'); ?></button>
        <? } ?>
                <button onclick="openLw('read_semua_kpo', '<?= AccessRight::getRightURL('read_semua_kpo'); ?>', 'fade');" class="btn btn-default"><?= AccessRight::getRightObject('read_semua_kpo')->ar_display_name; ?></button>
            </div>
        </div>



        <?
    }

//    public function TorgKPO ()
//    {
//        //create the model object
//        $cal = new TorgKPO();
////        $cal->printColumlistAsAttributes();
//        //send the webclass
//        $webClass = __CLASS__;
//
//        //run the crud utility
//        Crud::run($cal, $webClass);
//
//        //pr($mps);
//    }

    public function read_semua_kpo() {
//create the model object
//        $cal = new TorgKPO();
////        $cal->printColumlistAsAttributes();
//        //send the webclass
//        $webClass = __CLASS__;
//
//        //run the crud utility
//        Crud::run($cal, $webClass);
        $obj = new TorgKPO();
//        $obj->removeAutoCrudClick = array("org_type");
        $obj->read_filter_array = array("org_parent_id" => AccessRight::getMyOrgID());
        $obj->hideColoums = array("org_parent_id", "org_type");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_semua_kpo");
        $crud->ar_delete = AccessRight::hasRight("delete_semua_kpo");
        $crud->ar_add_url = AccessRight::getRightURL("create_kpo");
        $crud->ar_edit_url = AccessRight::getRightURL("update_semua_kpo");
        $crud->run_custom($obj, "KPOWeb", "read_semua_kpo");
    }

    function delete_semua_kpo() {
        
    }

    function update_semua_kpo() {

        FormCreator::receive(array("TorgKPO", "form_constraints"));
        $id = addslashes($_GET['id']);

        $kpo = new TorgKPO();
        $kpo->getByID($id);
//        pr($kpo);
//        pr($_SESSION);

        $t = time();
//nomor_telp,email,propinsi
        /*
         * Objective to create dynamic form but remove oneness with regularcrud
         */
        $arrDetails = array(
            "org_id" => new \Leap\View\InputText("hidden", "org_id", "org_id", $kpo->org_id),
            "org_kode" => new \Leap\View\InputText("text", "org_kode", "org_kode", $kpo->org_kode),
            "nama" => new \Leap\View\InputText("text", "nama", "nama", $kpo->nama),
            "alamat" => new \Leap\View\InputText("text", "alamat", "alamat", $kpo->alamat),
            "propinsi" => new \Leap\View\InputText("text", "propinsi", "propinsi", $kpo->propinsi),
            "nomor_telp" => new \Leap\View\InputText("text", "nomor_telp", "nomor_telp", $kpo->nomor_telp),
            "email" => new \Leap\View\InputText("email", "email", "email", $kpo->email),
            "nama_pemilik" => new \Leap\View\InputText("text", "nama_pemilik", "nama_pemilik", $kpo->nama_pemilik),
            "tanggal_lahir" => new \Leap\View\InputText("date", "tanggal_lahir", "tanggal_lahir", $kpo->tanggal_lahir),
            "alamat_rmh_priv" => new \Leap\View\InputText("text", "alamat_rmh_priv", "alamat_rmh_priv", $kpo->alamat_rmh_priv),
            "telp_priv" => new \Leap\View\InputText("text", "telp_priv", "telp_priv", $kpo->telp_priv),
            "hp_priv" => new \Leap\View\InputText("text", "hp_priv", "hp_priv", $kpo->hp_priv),
            "email_priv" => new \Leap\View\InputText("email", "email_priv", "email_priv", $kpo->email_priv),
            "org_catatan" => new \Leap\View\InputText("date", "tgl_kontrak", "tgl_kontrak", $kpo->tgl_kontrak)
        );
        ?>
        <style>
            #kpo_form_<?= $t; ?> .form_title,#user_form_<?= $t; ?> .form_title{
                text-align: center;
            }
        </style>
        <div id="kpo_form_<?= $t; ?>">
        <?
        $onSuccess = "$('#kpo_form_" . $t . "').hide();$('#success_form_" . $t . "').show();";
        FormCreator::createForm("Edit KPO", $arrDetails, _SPPATH . "KPOWeb/update_semua_kpo", $onSuccess);
        ?>
        </div>
        <input type="hidden" id="kpo_id_<?= $t; ?>" value="<?= $id; ?>">

        <div id="success_form_<?= $t; ?>" style="text-align: center;display: none;">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?= Lang::t('Data Edited Successfully'); ?></h2>
            <div class="alert alert-info" style="margin-left: 20px; margin-right: 20px;">
                <h3 style="padding: 0; margin: 0px;">Do you want to add user to this KPO?</h3>
                <p style="font-style: italic; padding: 10px;">You can add user later in <?= AccessRight::getRightObject('read_semua_kpo')->ar_display_name; ?>.</p>
        <?
        $lanjutan = "$('#success_form_" . $t . "').hide();$('#user_form_" . $t . "').show();";
        $lanjutan = "openLw('create_user_kpo','" . AccessRight::getRightURL('create_user_kpo') . "?kpo_id='+$('#kpo_id_$t').val(),'fade');";

        if (AccessRight::hasRight('create_user_kpo')) {
            ?>

                    <button class="btn btn-default" onclick="<?= $lanjutan; ?>"><?= Lang::t('YES'); ?></button>
                    <button onclick="lwclose(selected_page);" class="btn btn-default"><?= Lang::t('NO'); ?></button>
        <? } ?>
                <button onclick="openLw('read_semua_kpo', '<?= AccessRight::getRightURL('read_semua_kpo'); ?>', 'fade');" class="btn btn-default"><?= AccessRight::getRightObject('read_semua_kpo')->ar_display_name; ?></button>
            </div>
        </div>



        <?
    }

    function get_my_kpo() {
        Generic::myOrgData();
    }

}
