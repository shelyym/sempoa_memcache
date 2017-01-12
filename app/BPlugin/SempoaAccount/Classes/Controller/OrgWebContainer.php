<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 9:38 PM
 */
class OrgWebContainer {

    public static function create($orgModel, $webClass, $lvl, $kode_ibo) {



        $kpo = new $orgModel();


        $t = time();
        $judul = "";
        $kode = "";
        $constraints = array();
        if ($lvl == KEY::$KPO) {
            $judul = "Add New KPO";
        } elseif ($lvl == KEY::$IBO) {
            $judul = "Add New IBO";
            $length_org_kode = 2;
        } elseif ($lvl == KEY::$TC) {
            $judul = "Add New TC";
            $length_org_kode = 5;
            $kode = $kode_ibo;
            $constraints[0] = "as";
        }
        /*
         * Objective to create dynamic form but remove oneness with regularcrud
         */
        $arrDetails = array(
            "org_kode" => new \Leap\View\InputTextWithMaxLength("text", "org_kode", "org_kode", $kode, $length_org_kode),
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
            "tgl_kontrak" => new \Leap\View\InputText("date", "tgl_kontrak", "tgl_kontrak", ""),
            "tgl_kontrak" => new \Leap\View\InputText("date", "tgl_kontrak", "tgl_kontrak", ""),
            "alamat_rmh_priv" => new \Leap\View\InputText("text", "alamat_rmh_priv", "alamat_rmh_priv", ""),
            "org_lat" => new \Leap\View\InputNumberWithStep("number","any", "org_lat", "org_lat", ""),
            "org_lng" => new \Leap\View\InputNumberWithStep("number","any", "org_lng", "org_lng", ""),
            "org_catatan" => new \Leap\View\InputTextRTE("org_catatan", "org_catatan", "")
//            "alamat" => new \Leap\View\InputMap("alamat".time(), "org_lat", "org_long","org_lat","org_long","alamat","")
        );
        FormCreator::receiveSempoa(array($orgModel, "form_constraints"));
        ?>
        <style>
            #kpo_form_<?= $t; ?> .form_title,#user_form_<?= $t; ?> .form_title{
                text-align: center;
            }
        </style>
        <div id="kpo_form_<?= $t; ?>">

            <?
            $onSuccess = "$('#kpo_form_" . $t . "').hide();$('#success_form_" . $t . "').show();$('#kpo_id_" . $t . "').val(data.id);";
//        pr($onSuccess);
            FormCreator::createFormSempoa($judul, $arrDetails, _SPPATH . $webClass . "/create_" . $lvl, $onSuccess);
            ?>
        </div>
        <input type="hidden" id="kpo_id_<?= $t; ?>">

        <div id="success_form_<?= $t; ?>" style="text-align: center;display: none;">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?= Lang::t('Data Added Successfully'); ?></h2>
            <div class="alert alert-info" style="margin-left: 20px; margin-right: 20px;">
                <h3 style="padding: 0; margin: 0px;">Do you want to add user to this <?= strtoupper($lvl); ?>?</h3>
                <p style="font-style: italic; padding: 10px;">You can add user later in <?= AccessRight::getRightObject('read_semua_' . $lvl)->ar_display_name; ?>.</p>
                <?
                $lanjutan = "$('#success_form_" . $t . "').hide();$('#user_form_" . $t . "').show();";
                $lanjutan = "openLw('create_user_$lvl','" . AccessRight::getRightURL('create_user_' . $lvl) . "?{$lvl}_id='+$('#kpo_id_$t').val(),'fade');";

                if (AccessRight::hasRight('create_user_' . $lvl)) {
                    ?>

                    <button class="btn btn-default" onclick="<?= $lanjutan; ?>"><?= Lang::t('YES'); ?></button>
                    <button onclick="lwclose(selected_page);" class="btn btn-default"><?= Lang::t('NO'); ?></button>
                <? } ?>
                <button onclick="openLw('read_semua_<?= $lvl; ?>', '<?= AccessRight::getRightURL('read_semua_' . $lvl); ?>', 'fade');" class="btn btn-default"><?= AccessRight::getRightObject('read_semua_' . $lvl)->ar_display_name; ?></button>
            </div>
        </div>



        <?
    }

    public static function update_semua($orgModel, $webClass, $lvl) {

        FormCreator::receive(array($orgModel, "form_constraints"));
        $id = addslashes($_GET['id']);

        $kpo = new $orgModel();
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
            "tgl_kontrak" => new \Leap\View\InputText("date", "tgl_kontrak", "tgl_kontrak", $kpo->tgl_kontrak),
            "alamat_rmh_priv" => new \Leap\View\InputText("text", "alamat_rmh_priv", "alamat_rmh_priv", $kpo->alamat_rmh_priv),
            "org_lat" => new \Leap\View\InputNumberWithStep("number","any", "org_lat", "org_lat", $kpo->org_lat),
            "org_lng" => new \Leap\View\InputNumberWithStep("number","any", "org_lng", "org_lng", $kpo->org_lng),
            "org_catatan" => new \Leap\View\InputTextRTE("org_catatan", "org_catatan", $kpo->org_catatan)
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
            FormCreator::createForm("Edit " . strtoupper($lvl), $arrDetails, _SPPATH . $webClass . "/update_semua_" . $lvl, $onSuccess);
            ?>
        </div>
        <input type="hidden" id="kpo_id_<?= $t; ?>" value="<?= $id; ?>">

        <div id="success_form_<?= $t; ?>" style="text-align: center;display: none;">
            <h2 style="padding-bottom: 20px; padding-top: 20px;"><?= Lang::t('Data Edited Successfully'); ?></h2>
            <div class="alert alert-info" style="margin-left: 20px; margin-right: 20px;">
                <h3 style="padding: 0; margin: 0px;">Do you want to add user to this <?= strtoupper($lvl); ?>?</h3>
                <p style="font-style: italic; padding: 10px;">You can add user later in <?= AccessRight::getRightObject('read_semua_' . $lvl)->ar_display_name; ?>.</p>
                <?
                $lanjutan = "$('#success_form_" . $t . "').hide();$('#user_form_" . $t . "').show();";
                $lanjutan = "openLw('create_user_$lvl','" . AccessRight::getRightURL('create_user_' . $lvl) . "?{$lvl}_id='+$('#kpo_id_$t').val(),'fade');";

                if (AccessRight::hasRight('create_user_' . $lvl)) {
                    ?>

                    <button class="btn btn-default" onclick="<?= $lanjutan; ?>"><?= Lang::t('YES'); ?></button>
                    <button onclick="lwclose(selected_page);" class="btn btn-default"><?= Lang::t('NO'); ?></button>
                <? } ?>
                <button onclick="openLw('read_semua_<?= $lvl; ?>', '<?= AccessRight::getRightURL('read_semua_' . $lvl); ?>', 'fade');" class="btn btn-default"><?= AccessRight::getRightObject('read_semua_' . $lvl)->ar_display_name; ?></button>
            </div>
        </div>



        <?
    }

    function delete_semua() {
        
    }

    public static function read_semua($orgModel, $webClass, $lvl) {
        $obj = new $orgModel();
//        $obj->removeAutoCrudClick = array("org_type");
        $obj->read_filter_array = array("org_parent_id" => AccessRight::getMyOrgID());
        $obj->hideColoums = array("org_parent_id", "org_type");
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_$lvl");
        $crud->ar_edit = AccessRight::hasRight("update_semua_$lvl");
        $crud->ar_delete = AccessRight::hasRight("delete_semua_$lvl");
        $crud->ar_add_url = AccessRight::getRightURL("create_$lvl");
        $crud->ar_edit_url = AccessRight::getRightURL("update_semua_$lvl");
        $crud->run_custom($obj, $webClass, "read_semua_$lvl");
    }

}
