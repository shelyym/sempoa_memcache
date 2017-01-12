<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BukuWeb
 *
 * @author efindiongso
 */
class BukuWeb extends WebService {

    public function read_jenis_dan_harga_buku() {

        BukuWebHelper::formBiaya();
//        echo $mytype;
//        pr($arr);

//        $myOrgID = (AccessRight::getMyOrgID());
//        $obj = new HargaBukuModel();
////        $obj->printColumlistAsAttributes();
//        $crud = new CrudCustomSempoa();
//        $crud->ar_add = AccessRight::hasRight("create_jenis_dan_harga_buku");
//        $crud->ar_delete = AccessRight::hasRight("delete_jenis_dan_harga_buku");
//        $crud->ar_edit = AccessRight::hasRight("update_jenis_dan_harga_buku");
//        $crud->run_custom($obj, "BukuWeb", "read_jenis_dan_harga_buku", " kpo_id LIKE '%$myOrgID%' ");
    }

    public function create_jenis_dan_harga_buku() {
        
    }

    public function update_jenis_dan_harga_buku() {
        
    }

    public function delete_jenis_dan_harga_buku() {
        
    }

    // IBO


    public function create_jenis_dan_harga_buku_ibo() {
        
    }

    public function read_jenis_dan_harga_buku_ibo() {
        
    }

    public function update_jenis_dan_harga_buku_ibo() {
        
    }

    public function delete_jenis_dan_harga_buku_ibo() {
        
    }

    public function get_jenis_dan_harga_buku_my_ibo() {
        BukuWebHelper::formBiaya();
//        $obj = new HargaBukuModel();
//        $myOrgID = (AccessRight::getMyOrgID());
//        $crud = new CrudCustomSempoa();
//        $like = "( ibo_id LIKE '%, " . $myOrgID . "' OR " . " ibo_id LIKE '" . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '%, " . $myOrgID . ", %'" . " OR " . " ibo_id LIKE '" . $myOrgID . "')";
//
//        $crud->run_custom($obj, "BukuWeb", "get_jenis_dan_harga_buku_my_ibo", " $like ");
    }

    // TC

    public function get_jenis_dan_harga_buku_my_tc() {
        $myOrgID = (AccessRight::getMyOrgID());
        $myParentID = Generic::getMyParentID($myOrgID);
        $obj = new HargaBukuModel();
        $crud = new CrudCustomSempoa();
        $crud->ar_add = "0";
        $crud->ar_edit = "0";
        $crud->ar_delete = "0";
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

        $crud->run_custom($obj, "BukuWeb", "get_jenis_dan_harga_buku_my_tc", " $like ");
    }


    public function edit_harga_barang_ibo(){
        $myOrgID = AccessRight::getMyOrgID();
        $t = time();
        $arrMyIBO = Generic::getAllMyIBO($myOrgID);
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
                    $jm = new SettingHargaBarang();
                    $jm->getWhereOne("setting_org_id=$idIBO");
//                    if(!is_null($jm->id_setting_biaya)){
                    ?>
                    <tr>
                        <td><?=$k;?></td>
                        <td><?=$iboName;?></td>
                        <td><Button id="biaya_ibo_<?=$t . "_" . $idIBO;?>" class="btn-default">Edit</Button></td>
                    </tr>
                    <script>
                        $('#biaya_ibo_<?=$t . "_" .$idIBO;?>').click(function(){
                            openLw('biaya_ibo','<?=_SPPATH;?>BukuWebHelper/editBiaya?id_ibo=<?=$idIBO?>','fade');
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
