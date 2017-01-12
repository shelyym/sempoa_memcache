<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/1/16
 * Time: 8:31 PM
 */
class IboWeb extends WebService {

    static $lvl = "ibo";
    static $webclass = "IboWeb";
    static $orgModel = "TorgIBO";

    /*
     * [IboWeb] => Array
      (
      [0] => update_semua_ibo
      [1] => delete_semua_ibo
      [2] => create_ibo
      [3] => read_semua_ibo
      )
     */

    function create_ibo() {
        OrgWebContainer::create(self::$orgModel, self::$webclass, self::$lvl, "");
    }

    function update_semua_ibo() {
        OrgWebContainer::update_semua(self::$orgModel, self::$webclass, self::$lvl);
    }

    function delete_semua_ibo() {
        
    }

    function read_semua_ibo() {
        OrgWebContainer::read_semua(self::$orgModel, self::$webclass, self::$lvl);
    }

    function get_my_ibo() {
        Generic::myOrgData();
    }

    function read_semua_ibo_table() {
        $myOrgid = AccessRight::getMyOrgID();
        $objIBO = new SempoaOrg();
        $arrIbos = $objIBO->getWhere("org_type='ibo' AND org_parent_id=$myOrgid");
//        pr($arrIbos);
        ?>
        <section class="content-header">
            <center><h1>Data IBO</h1></center>

        </section>
        <section class="content table-responsive">
            <table class="table table-bordered table-striped" style="background-color: white">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Wilayah</th>
                        <th>Nama IBO</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat Rumah</th>
                        <th>No.Telp</th>
                        <th>No.HP</th>
                        <th>Email</th>
                        <th>Alamat IBO</th>
                        <th>Telp IBO</th>
                        <th>Email IBO</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach ($arrIbos as $key => $val) {
                        ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $val->nama; ?></td>
                            <td><?= $val->nama_pemilik; ?></td>
                            <td><?= $val->tanggal_lahir; ?></td>
                            <td><?= $val->alamat_rmh_priv; ?></td>
                            <td><?= $val->telp_priv; ?></td>
                            <td><?= $val->hp_priv; ?></td>
                            <td><?= $val->email_priv; ?></td>
                            <td><?= $val->alamat; ?></td>
                            <td><?= $val->nomor_telp; ?></td>
                            <td><?= $val->email; ?></td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </section>    

        <?
    }

    function read_semua_tc_table() {
        $myOrgid = AccessRight::getMyOrgID();
        $objIBO = new SempoaOrg();
        $KPOid = AccessRight::getMyOrgID();
        $arrIbos = Generic::getAllMyIBO($KPOid);
        $ibo_id = key($arrIbos);
        $arrMyTC = $objIBO->getWhere("org_parent_id=$ibo_id AND org_type='tc'");
        $bln = date("n");
        $thn = date("Y");
        $t = time();
        ?>
        <section class="content-header">
            <center><h1>Data TC</h1></center>
            <div class="box-tools pull-right">

                <label for="exampleInputName2">Pilih IBO:</label>
                <select id="pilih_IBO_<?= $t; ?>">

                    <?
                    foreach ($arrIbos as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_tc_<?= $t; ?>">submit</button>
                <script>
                    $('#submit_tc_<?= $t; ?>').click(function () {
                        var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                        $('#content_tc_<?= $t; ?>').load("<?= _SPPATH; ?>BIWebHelper/load_tc_table?ibo_id=" + ibo_id, function () {

                        }, 'json');
                    });

                </script>
            </div>

        </section>
        <div class="clearfix"></div>
        <section class="content table-responsive">
            <table class="table table-bordered table-striped" style="background-color: white">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Wilayah</th>
                        <th>Nama TC</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat Rumah</th>
                        <th>No.Telp</th>
                        <th>No.HP</th>
                        <th>Email</th>
                        <th>Tgl Kontrak s/d</th>
                        <th>Alamat TC</th>
                        <th>Telp TC</th>
                        <th>Email TC</th>
                        <th>Jmlh Coach</th>
                        <th>Jmlh Siswa</th>
                    </tr>
                </thead>
                <tbody id="content_tc_<?= $t; ?>">
                    <?
                    foreach ($arrMyTC as $key => $val) {
//                        $hlp = new StatusHisMuridModel();
                        $murid = new MuridModel();
                        $guru = new SempoaGuruModel();
                        ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
                            <td><?= $val->nama; ?></td>
                            <td><?= $val->nama_pemilik; ?></td>
                            <td><?= $val->tanggal_lahir; ?></td>
                            <td><?= $val->alamat_rmh_priv; ?></td>
                            <td><?= $val->telp_priv; ?></td>
                            <td><?= $val->hp_priv; ?></td>
                            <td><?= $val->email_priv; ?></td>
                            <td><?= $val->tgl_kontrak; ?></td>
                            <td><?= $val->alamat; ?></td>
                            <td><?= $val->nomor_telp; ?></td>
                            <td><?= $val->email; ?></td>
                            <td><?= $guru->getCountAktivGuruByTC($val->org_id); ?></td>
                            <td><?= $murid->getMuridAktiv($val->org_id) ?></td>
                        </tr>
                        <?
                    }
                    ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </section>    

        <?
    }

    function read_data_couch() {
        $myOrgid = AccessRight::getMyOrgID();
        $objIBO = new SempoaOrg();
        $KPOid = AccessRight::getMyOrgID();
        $arrIbos = Generic::getAllMyIBO($KPOid);
        $ibo_id = key($arrIbos);
        $arrMyTC = $objIBO->getWhere("org_parent_id=$ibo_id AND org_type='tc'");
        $bln = date("n");
        $thn = date("Y");
        $t = time();
        ?>
        <section class="content-header">
            <center><h1>Data Couch</h1></center>
            <div class="box-tools pull-right">

                <label for="exampleInputName2">Pilih IBO:</label>
                <select id="pilih_IBO_<?= $t; ?>">

                    <?
                    foreach ($arrIbos as $key => $val) {
                        ?>
                        <option value="<?= $key; ?>"><?= $val; ?></option>
                        <?
                    }
                    ?>
                </select>
                <button id="submit_couch_<?= $t; ?>">submit</button>
                <script>
                    $('#submit_couch_<?= $t; ?>').click(function () {
                        var ibo_id = $('#pilih_IBO_<?= $t; ?>').val();
                        $('#content_couch_tc_<?= $t; ?>').load("<?= _SPPATH; ?>BIWebHelper/load_coach_tc_table?ibo_id=" + ibo_id, function () {

                        }, 'json');
                    });

                </script>
            </div>

        </section>
        <div class="clearfix"></div>
        <section class="content table-responsive">
            <table class="table table-bordered table-striped" style="background-color: white">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Coach</th>
                        <th>Nama TC</th>
                        <th>Nama Director</th>
                        <th>Level Training Terakhir</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Email</th>
                        <th>Jmlh Siswa</th>
                    </tr>
                </thead>
                <tbody id="content_couch_tc_<?= $t; ?>">
                    <?
                    $i = 1;
                    foreach ($arrMyTC as $key => $val) {
                        $guru = new SempoaGuruModel();
                        $arrGuru = $guru->getAllGuruAktivByTC($val->org_id);
                        $sempoa = new SempoaOrg();
                        $sempoa->getByID($val->org_id);
//                        pr($sempoa);
                        foreach ($arrGuru as $valGuru) {

                            $mk = new MuridKelasMatrix();
                            $cnt = $mk->getJumlahSiswaByGuru($valGuru->guru_id, $val->org_id);
                            ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $valGuru->nama_guru; ?></td>
                                <td><?= $sempoa->nama; ?></td>
                                <td><?= $sempoa->nama_pemilik; ?></td>
                                <td><?= Generic::getLevelNameByID($valGuru->id_level_training_guru); ?></td>
                                <td><?= $valGuru->tanggal_lahir; ?></td>
                                <td><?= $valGuru->alamat; ?></td>
                                <td><?= $valGuru->nomor_hp; ?></td>
                                <td><?= $valGuru->email_guru; ?></td>
                                <td><?= $cnt; ?></td>
                            </tr>
                            <?
                            $i++;
                        }
                    }
                    ?>
                </tbody>
                <tfoot></tfoot>
            </table>
        </section>    

        <?
    }

}
