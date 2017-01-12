<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SettingWeb2
 *
 * @author efindiongso
 */
class SettingWeb2 extends WebService
{

// KPO
    public function create_biaya_pendaftaran_minimal_semua_ibo()
    {

    }

    public function read_biaya_pendaftaran_minimal_semua_ibo()
    {
//        SettingWeb2Helper::formBiaya_KPO();
        SettingWeb2Helper::formBiaya();

    }

    public function read_biaya_pendaftaran_minimal_semua_ibo_efindi()
    {


        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_biaya_pendaftaran_minimal_semua_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_biaya_pendaftaran_minimal_semua_ibo");
        $crud->ar_delete = AccessRight::hasRight("delete_biaya_pendaftaran_minimal_semua_ibo");
        $like_1 = " (kpo_id LIKE '%, " . $myOrgID . "' OR " . " kpo_id LIKE '" . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " kpo_id LIKE '" . $myOrgID . "')";

//      pr(KEY::$REGISTER);
        $crud->run_custom($obj, "SettingWeb2", "read_biaya_pendaftaran_minimal_semua_ibo", " jenis_biaya ='" . KEY::$REGISTER . "'  AND ($like_1)  AND hide ='0' ");
    }

    public function delete_biaya_pendaftaran_minimal_semua_ibo()
    {

    }

    public function update_biaya_pendaftaran_minimal_semua_ibo()
    {

    }

    public function get_biaya_pendaftaran_ibo_tertentu()
    {

    }

    // IBO

    public function get_my_biaya_pendaftaran_min_ibo()
    {


        SettingWeb2Helper::formBiaya();
//
//        $obj = new JenisBiayaModel();
//        $myOrgID = AccessRight::getMyOrgID();
//        $myParentID = Generic::getMyParentID($myOrgID);
//        $crud = new CrudCustomSempoa();
//        $crud->ar_add = 0;
//        $crud->ar_edit = 1;
//        $crud->ar_delete = 1;
//        $crud->run_custom($obj, "SettingWeb2", "get_my_biaya_pendaftaran_min_ibo", " jenis_biaya ='" . KEY::$REGISTER . "' AND  ibo_id='$myOrgID' AND refID != 0 AND hide='0' ");
    }

    public function create_biaya_pendaftaran_all_tc()
    {

    }

    public function read_biaya_pendaftaran_all_tc()
    {


        $obj = new JenisBiayaModel();
        $myOrgID = AccessRight::getMyOrgID();
        $myParentID = Generic::getMyParentID($myOrgID);
        $crud = new CrudCustomSempoa();
        $crud->ar_add = AccessRight::hasRight("create_biaya_pendaftaran_all_tc");
        $crud->ar_edit = AccessRight::hasRight("update_biaya_pendaftaran_all_tc");
        $crud->ar_delete = AccessRight::hasRight("delete_biaya_pendaftaran_all_tc");

        $crud->run_custom($obj, "SettingWeb2", "read_biaya_pendaftaran_all_tc", " jenis_biaya ='" . KEY::$REGISTER . "' AND kpo_id='$myParentID' ");
    }

    public function update_biaya_pendaftaran_all_tc()
    {

    }

    public function delete_biaya_pendaftaran_all_tc()
    {

    }

    public function get_my_biaya_pendaftaran_tc()
    {

        SettingWeb2Helper::formBiaya();
//
////        Generic::getMyRoot();
//        $obj = new JenisBiayaModel();
//        $myOrgID = AccessRight::getMyOrgID();
//        $myParentID = Generic::getMyParentID($myOrgID);
//        $crud = new CrudCustomSempoa();
//        $crud->ar_add = 0;
//        $crud->ar_edit = 0;
//        $crud->ar_delete = 0;
//
//        $arrGroup = Generic::getGroup($myParentID, "1");
//        $arrKeyGroup = array_keys($arrGroup);
//
//        foreach ($arrKeyGroup as $key => $value) {
//            $arrTC = Generic::fgetGroupMember($value);
//            foreach ($arrTC as $key => $val) {
//
//                if (strpos($val, $myOrgID) !== false) {
//                    $index[] = $key;
//                }
//                // utk all
//                elseif ($val == '0') {
//                    $index[] = $key;
//                }
//            }
//        }
//        for ($i = 0; $i < count($index); ++$i) {
//            $help = $index[$i];
////            pr($help);
//            if ($i == (count($index) - 1)) {
//
//                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' ";
//            } else {
//
//                $like .= " tc_id LIKE '%," . $help . "' OR " . " tc_id LIKE '" . $help . ",%'" . " OR " . " tc_id LIKE '" . $help . "' OR ";
//            }
//        }
//        $crud->run_custom($obj, "SettingWeb2", "get_my_biaya_pendaftaran_tc", " jenis_biaya ='" . KEY::$REGISTER . "' AND tc_id = '$myOrgID' ");
    }


    public function edit_biaya_ibo()
    {

        $myOrgID = AccessRight::getMyOrgID();
        $arrMyIBO = Generic::getAllMyIBO($myOrgID);
        $t =time();
//        pr($arrMyIBO);

        ?>
        <section class="content-header">
            <h1>Daftar Harga di IBO</h1>
        </section>
        <div class="clearfix"></div>
        <section class="content table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>IBO</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?
                $k=1;
                foreach ($arrMyIBO as $idIBO => $iboName) {
                    $jm = new JenisBiayaModel();
                    $jm->getWhereOne("setting_org_id=$idIBO");
//                    if(!is_null($jm->id_setting_biaya)){
                        ?>
                        <tr>
                            <td><?=$k;?></td>
                            <td><?=$iboName;?></td>
                            <td><Button id="biaya_ibo_<?=$t . "_" . $idIBO;?>" class="btn-default">Edit</Button></td>
                        </tr>
                        <script>
                            $('#biaya_ibo_<?=$t . "_" . $idIBO;?>').click(function(){
                                openLw('biaya_ibo','<?=_SPPATH;?>SettingWeb2Helper/editBiaya?id_ibo=<?=$idIBO?>','fade');
//                               alert("test");
                            });
                        </script>
                        <?
                        $k++;
                    }
//                }
                ?>
                </tbody>
            </table>
        </section>
        <?


    }
}
