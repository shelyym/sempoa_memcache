<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MuridWeb3
 *
 * @author efindiongso
 */
class MuridWeb3 extends WebService {

    //put your code here


    public function get_status_murid_ibo() {
        
    }

    public function read_permintaan_sertifikat() {
        $help = new MuridWebHelper();
        $help->read_request_certificate();
        die();
        $IBOid = AccessRight::getMyOrgID();
        $arrMyTC = Generic::getAllMyTC($IBOid);
        $tcid = (isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : key($arrMyTC));
        $t = time();
        ?>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="exampleInputName2">Pilih TC:</label>
                <select id="pilih_tc_<?= $t; ?>">

                    <?
                    foreach ($arrMyTC as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12">
            <button class="btn btn-default" id="submit_pilih_tc_<?= $t; ?>">Submit</button>
        </div>
        <div class="clearfix"></div>
        <div id = 'container_sertifikat_tc_<?= $t; ?>' class="section container table responsive"></div>
        <script>
            $('#submit_pilih_tc_<?= $t; ?>').click(function () {
                var slc = $('#pilih_tc_<?= $t; ?>').val();
                $('#container_sertifikat_tc_<?= $t; ?>').load("<?= _SPPATH; ?>MuridWebHelper/read_request_certificate?tc_id=" + slc, function () {
                }, 'json');
            });

        </script>
        <?
    }

    public function read_murid_ibo() {
        $crud = new CrudCustomSempoa();
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();
        $crud->ar_delete = AccessRight::hasRight("delete_murid_ibo");
        $crud->ar_edit = AccessRight::hasRight("update_murid_ibo");
        $crud->run_custom($obj, "MuridWeb3", "read_murid_ibo", " 1 ");
        pr($crud);
    }

    public function update_murid_ibo() {
        
    }

    public function delete_murid_ibo() {
        
    }

    public function read_murid_kpo() {
        $crud = new CrudCustomSempoa();
        $myOrgID = (AccessRight::getMyOrgID());
        $obj = new MuridModel();
        $crud->ar_delete = AccessRight::hasRight("delete_murid_kpo");
        $crud->ar_edit = AccessRight::hasRight("update_murid_kpo");
        $crud->run_custom($obj, "MuridWeb3", "read_murid_kpo", " 1 ");
    }

    public function update_murid_kpo() {
        
    }

    public function delete_murid_kpo() {
        
    }

}
