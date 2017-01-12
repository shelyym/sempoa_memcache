<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/1/16
 * Time: 12:03 PM
 */
class BukuWebHelper extends WebService
{

    public function updateAllBiayaKPO()
    {

        $ibo = $_POST['ibo'];
        $ibo_id = Generic::getOrgIDByName($ibo);
        $json['ibo_id'] = $ibo_id;
        $mytype = AccessRight::getMyOrgType();
        $set = new BarangWebModel();
        $arr = $set->getAll();


        $err = array();

        foreach ($arr as $barang) {
            $val = $_POST['barang_' . $barang->id_barang_harga];

            $rule = $mytype . "_rule";
            list($action, $constraint) = explode(";", $barang->$rule);

            if ($action == "No") continue;
            if ($action == "Edit") {

                $jenisbm_parent = new SettingHargaBarang();
                $jenisbm_parent->getByID($ibo_id . "_" . $barang->id_barang_harga);

                if ($constraint == ">=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val >= $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                        continue;
                    }
                }
                if ($constraint == "=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar

                    if ($val == $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus  sama dengan";
                        continue;
                    }

                }
                if ($constraint == "<=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar

                    if ($val <= $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih kecil sama dengan";
                        continue;
                    }
                }
                if ($constraint == ">") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val > $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar";
                        continue;
                    }
                }
                if ($constraint == "<") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val < $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                        continue;
                    }
                }
            }

            //untuk sendiri
            $jenisbm = new SettingHargaBarang();
            $jenisbm->id_setting_biaya = $ibo_id . "_" . $barang->id_barang_harga;
            $jenisbm->harga = $val;
            $jenisbm->setting_org_id = $ibo_id;
            $jenisbm->jenis_biaya = $barang->id_barang_harga;

            $suc = $jenisbm->save(1);

        }

        $json['status_code'] = 1;
        if (count($err) > 0) {
            $json['status_code'] = 0;
        }

        $json['err'] = $err;
        $json['post'] = $_POST;
        echo json_encode($json);
        die();
    }

    public function updateAllBiaya()
    {
//
//        ini_set('display_errors', '1');
//error_reporting(E_ALL);

        $mytype = AccessRight::getMyOrgType();

        $org = new SempoaOrg();
        $org->getByID(AccessRight::getMyOrgID());

        //AK blom dihandle
        $id = AccessRight::getMyOrgID();
        if (strtolower($org->org_type) == "ibo") {
            //naik sekali
            $id = $org->org_parent_id;
        }
        if (strtolower($org->org_type) == "tc") {
            //naik dua kali
            $ibo_id = $org->org_parent_id;
            $org = new SempoaOrg();
            $org->getByID($ibo_id);

            $id = $org->org_parent_id;
        }

        $set = new BarangWebModel();
        $arr = $set->getWhere("kpo_id = '$id'");


        $children = Generic::getChildren(AccessRight::getMyOrgID());

        $json['children'] = $children;

        $err = array();

        foreach ($arr as $barang) {
            $val = $_POST['barang_' . $barang->id_barang_harga];

            $rule = $mytype . "_rule";
            list($action, $constraint) = explode(";", $barang->$rule);

            if ($action == "No") continue;
            if ($action == "Edit") {

                $jenisbm_parent = new SettingHargaBarang();
                $jenisbm_parent->getByID($id . "_" . $barang->id_barang_harga);

                if ($constraint == ">=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val >= $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                        continue;
                    }
                }
                if ($constraint == "=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar

                    if ($val == $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus  sama dengan";
                        continue;
                    }

                }
                if ($constraint == "<=") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar

                    if ($val <= $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih kecil sama dengan";
                        continue;
                    }
                }
                if ($constraint == ">") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val > $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar";
                        continue;
                    }
                }
                if ($constraint == "<") {
                    //ambil harga dari ref (parent nya)
                    //cek hrg baru apa lebih besar
                    if ($val < $jenisbm_parent->harga) {

                    } else {
                        //error
                        $err["barang_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                        continue;
                    }
                }
            }

            //untuk sendiri
            $jenisbm = new SettingHargaBarang();
            $jenisbm->id_setting_biaya = AccessRight::getMyOrgID() . "_" . $barang->id_barang_harga;
            $jenisbm->harga = $val;
            $jenisbm->setting_org_id = AccessRight::getMyOrgID();
            $jenisbm->jenis_biaya = $barang->id_barang_harga;

            $suc = $jenisbm->save(1);
//            $jenisbm->refID = 0;

            //untuk anak2nya
            foreach ($children as $child) {

                $org_id = $child->org_id;

                $jenisbm = new SettingHargaBarang();
                $jenisbm->id_setting_biaya = $org_id . "_" . $barang->id_barang_harga;
                $jenisbm->harga = $val;
                $jenisbm->setting_org_id = $org_id;
                $jenisbm->jenis_biaya = $barang->id_barang_harga;

                $suc = $jenisbm->save(1);

                //inform ke anak2 kalau ada perubahan harga

//                SempoaInboxModel::sendMsg($org_id,AccessRight::getMyOrgID(),"Ada perubahan biaya","Ada perubahan biaya <br> Tolong sesuaikan harga anda");
            }

        }

        foreach ($children as $child) {

            $org_id = $child->org_id;
            SempoaInboxModel::sendMsg($org_id, AccessRight::getMyOrgID(), "Ada perubahan harga barang", "Ada perubahan harga barang  <br> Tolong sesuaikan harga anda");
        }

        $json['status_code'] = 1;
        if (count($err) > 0) {
            $json['status_code'] = 0;
        }

        $json['err'] = $err;
        $json['post'] = $_POST;
        echo json_encode($json);
        die();
    }

    public function updateAllBiayaGroup()
    {

        $mytype = AccessRight::getMyOrgType();

        $org = new SempoaOrg();
        $org->getByID(AccessRight::getMyOrgID());

        //AK blom dihandle
        $id = AccessRight::getMyOrgID();
        if (strtolower($org->org_type) == "ibo") {
            //naik sekali
            $id = $org->org_parent_id;
        }
        if (strtolower($org->org_type) == "tc") {
            //naik dua kali
            $ibo_id = $org->org_parent_id;
            $org = new SempoaOrg();
            $org->getByID($ibo_id);

            $id = $org->org_parent_id;
        }

        $set = new BarangWebModel();
        $arr = $set->getWhere("kpo_id = '$id'");
        $group = new GroupsModel();
        $children = $group->getWhere("parent_id = '" . AccessRight::getMyOrgID() . "'");

        if (strtolower($org->org_type) == "ibo") {
            //naik sekali
            $id = AccessRight::getMyOrgID();
        }

//        $children = Generic::getChildren(AccessRight::getMyOrgID());

        $json['children'] = $children;

        $err = array();

        foreach ($arr as $barang) {

            foreach ($children as $child) {

                $val = $_POST['barang_' . $child->id_group . "_" . $barang->id_barang_harga];

                $rule = $mytype . "_rule";
                list($action, $constraint) = explode(";", $barang->$rule);

                if ($action == "No") continue;
                if ($action == "Edit") {

                    $jenisbm_parent = new SettingHargaBarang();
                    $jenisbm_parent->getByID($id . "_" . $barang->id_barang_harga);

                    if ($constraint == ">=") {
                        //ambil harga dari ref (parent nya)
                        //cek hrg baru apa lebih besar
                        if ($val >= $jenisbm_parent->harga) {

                        } else {
                            //error
                            $err["barang_" . $child->id_group . "_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                            continue;
                        }
                    }
                    if ($constraint == "=") {
                        //ambil harga dari ref (parent nya)
                        //cek hrg baru apa lebih besar

                        if ($val == $jenisbm_parent->harga) {

                        } else {
                            //error
                            $err["barang_" . $child->id_group . "_" . $barang->id_barang_harga] = "Harga harus  sama dengan";
                            continue;
                        }

                    }
                    if ($constraint == "<=") {
                        //ambil harga dari ref (parent nya)
                        //cek hrg baru apa lebih besar

                        if ($val <= $jenisbm_parent->harga) {

                        } else {
                            //error
                            $err["barang_" . $child->id_group . "_" . $barang->id_barang_harga] = "Harga harus lebih kecil sama dengan";
                            continue;
                        }
                    }
                    if ($constraint == ">") {
                        //ambil harga dari ref (parent nya)
                        //cek hrg baru apa lebih besar
                        if ($val > $jenisbm_parent->harga) {

                        } else {
                            //error
                            $err["barang_" . $child->id_group . "_" . $barang->id_barang_harga] = "Harga harus lebih besar";
                            continue;
                        }
                    }
                    if ($constraint == "<") {
                        //ambil harga dari ref (parent nya)
                        //cek hrg baru apa lebih besar
                        if ($val < $jenisbm_parent->harga) {

                        } else {
                            //error
                            $err["barang_" . $child->id_group . "_" . $barang->id_barang_harga] = "Harga harus lebih besar sama dengan";
                            continue;
                        }
                    }
                }

                //untuk sendiri
                $jenisbm = new SettingHargaBarangGroup();
                $jenisbm->id_setting_biaya = $child->id_group . "_" . $barang->id_barang_harga;
                $jenisbm->harga = $val;
                $jenisbm->setting_org_id = AccessRight::getMyOrgID();
                $jenisbm->jenis_biaya = $barang->id_barang_harga;

                $suc = $jenisbm->save(1);
//            $jenisbm->refID = 0;
                //ambil anak explode group
                $exp = explode(",", $child->groups);
                //untuk anak2nya
                foreach ($exp as $org_id) {

//                    $org_id = $child->org_id;

                    $jenisbm = new SettingHargaBarang();
                    $jenisbm->id_setting_biaya = trim(rtrim($org_id)) . "_" . $barang->id_barang_harga;
                    $jenisbm->harga = $val;
                    $jenisbm->setting_org_id = $org_id;
                    $jenisbm->jenis_biaya = $barang->id_barang_harga;

                    $suc = $jenisbm->save(1);

                    //inform ke anak2 kalau ada perubahan harga
//                    SempoaInboxModel::sendMsg($org_id,AccessRight::getMyOrgID(),"Ada perubahan biaya","Ada perubahan biaya <br> Tolong sesuaikan harga anda");

                }
            }


        }

        $children2 = Generic::getChildren(AccessRight::getMyOrgID());
        foreach ($children2 as $child) {

            $org_id = $child->org_id;
            SempoaInboxModel::sendMsg($org_id, AccessRight::getMyOrgID(), "Ada perubahan harga barang", "Ada perubahan harga barang <br> Tolong sesuaikan harga anda");
        }


        $json['status_code'] = 1;
        if (count($err) > 0) {
            $json['status_code'] = 0;
        }

        $json['err'] = $err;
        $json['post'] = $_POST;
        echo json_encode($json);
        die();
    }

    public static function formBiaya()
    {
        $mytype = AccessRight::getMyOrgType();

        $org = new SempoaOrg();
        $org->getByID(AccessRight::getMyOrgID());

        //AK blom dihandle
        $id = AccessRight::getMyOrgID();
        if (strtolower($org->org_type) == "ibo") {
            //naik sekali
            $id = $org->org_parent_id;
        }
        if (strtolower($org->org_type) == "tc") {
            //naik dua kali
            $ibo_id = $org->org_parent_id;
            $org = new SempoaOrg();
            $org->getByID($ibo_id);

            $id = $org->org_parent_id;
        }


        $set = new BarangWebModel();
        $arr = $set->getWhere("kpo_id = '$id'");


        //nanti load biaya aktual
        $jenisbm = new SettingHargaBarang();
        $arr2 = $jenisbm->getWhere("setting_org_id = '" . AccessRight::getMyOrgID() . "' ");

        $byID = array();
        foreach ($arr2 as $isinya) {
            $byID[$isinya->jenis_biaya] = $isinya;
        }
//
//        $x = 0;
        if (strtolower($mytype) == "ibo") {

            //nanti load biaya aktual
            $jenisbm = new SettingHargaBarangGroup();
            $arr2 = $jenisbm->getWhere("setting_org_id = '" . AccessRight::getMyOrgID() . "'");

            $byID_anak = array();
            foreach ($arr2 as $isinya) {
                $byID_anak[$isinya->jenis_biaya] = $isinya;
            }

            $group = new GroupsModel();
            $children = $group->getWhere("parent_id = '" . AccessRight::getMyOrgID() . "'" );
            //create table harga
            ?>
            <form id="barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Harga Barang \ TC Group</th>
                            <?
                            foreach ($children as $child) {
                                ?>
                                <th><?= $child->nama; ?></th>
                                <?
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arr as $barang) {
                            $rule = $mytype . "_rule";
                            list($action, $constraint) = explode(";", $barang->$rule);
                            ?>
                            <tr>
                                <td><?= $barang->kode_barang; ?> <?= $barang->nama_barang; ?></td>
                                <?
                                foreach ($children as $child) {
                                    $jenisbm = new SettingHargaBarangGroup();
                                    $jenisbm->getByID($child->id_group . "_" . $barang->id_barang_harga);

                                    $val = $jenisbm->harga;
                                    if ($val == "") {
                                        $val = $byID[$barang->id_barang_harga]->harga;
                                    }
//                                    pr($val);
                                    ?>
                                    <td>
                                        <input <? if ($action == "No") echo "disabled"; ?>
                                            name="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>"
                                            type="number" value="<?= $val; ?>"
                                            class="form-control"
                                            id="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>"
                                            placeholder="<?= $barang->nama_barang; ?>">

                                        <div class="err_text"
                                             id="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>_text"></div>

                                    </td>
                                    <?
                                }
                                ?>
                            </tr>
                            <?
                        }


                        ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-default" type="submit">Submit</button>
            </form>

            <style>
                .err_text {
                    padding: 5px;
                    margin: 5px;
                    background-color: #dedede;
                    display: none;
                }

                .input_bordered {
                    border-color: #ff0000;
                }
            </style>
            <script>
                $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").submit(function (event) {
//                alert( "Handler for .submit() called." );
                    event.preventDefault();

                    var post = $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").serialize();
                    console.log(post);
                    $('.err_text').hide();
                    $('.input_bordered').removeClass("input_bordered");
                    $.post("<?=_SPPATH;?>BukuWebHelper/updateAllBiayaGroup", post, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            alert("Data berhasil tersimpan");
                        } else {
                            var err = data.err;

                            for (x in err) {
                                $('#' + x).addClass("input_bordered");
                                var text = err[x];
                                $('#' + x + "_text").html(text).show();
                            }
                        }
                    }, 'json');
                });
            </script>


            <?


        } else {
            ?>
            <form id="barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>">
                <?

                foreach ($arr as $barang) {
                    $val = $byID[$barang->id_barang_harga]->harga;
                    if ($val == "") $val = 0;

                    $rule = $mytype . "_rule";
                    list($action, $constraint) = explode(";", $barang->$rule);


                    ?>
                    <div class="form-group">
                        <label
                            for="exampleInputEmail1"><?= $barang->kode_barang; ?> <?= $barang->nama_barang; ?></label>
                        <input <? if ($action == "No") echo "disabled"; ?>
                            name="barang_<?= $barang->id_barang_harga; ?>"
                            type="number" value="<?= $val; ?>"
                            class="form-control"
                            id="barang_<?= $barang->id_barang_harga; ?>"
                            placeholder="<?= $barang->nama_barang; ?>">

                        <div class="err_text" id="barang_<?= $barang->id_barang_harga; ?>_text"></div>
                    </div>


                    <?
                }

                ?>
                <button class="btn btn-default" type="submit">Submit</button>
            </form>
            <style>
                .err_text {
                    padding: 5px;
                    margin: 5px;
                    background-color: #dedede;
                    display: none;
                }

                .input_bordered {
                    border-color: #ff0000;
                }
            </style>
            <script>
                $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").submit(function (event) {
//                alert( "Handler for .submit() called." );
                    event.preventDefault();

                    var post = $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").serialize();
                    $('.err_text').hide();
                    $('.input_bordered').removeClass("input_bordered");
                    $.post("<?=_SPPATH;?>BukuWebHelper/updateAllBiaya", post, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            alert("Data berhasil tersimpan");
                        } else {
                            var err = data.err;

                            for (x in err) {
                                $('#' + x).addClass("input_bordered");
                                var text = err[x];
                                $('#' + x + "_text").html(text).show();
                            }
                        }
                    }, 'json');
                });
            </script>
            <?
        }
    }

    public static function formBiayaKPO()
    {
        $mytype = AccessRight::getMyOrgType();

        $org = new SempoaOrg();
        $org->getByID(AccessRight::getMyOrgID());

        //AK blom dihandle
        $id = AccessRight::getMyOrgID();
        if (strtolower($org->org_type) == "ibo") {
            //naik sekali
            $id = $org->org_parent_id;
        }
        if (strtolower($org->org_type) == "tc") {
            //naik dua kali
            $ibo_id = $org->org_parent_id;
            $org = new SempoaOrg();
            $org->getByID($ibo_id);

            $id = $org->org_parent_id;
        }


        $set = new BarangWebModel();
        $arr = $set->getWhere("kpo_id = '$id'");


        //nanti load biaya aktual
        $jenisbm = new SettingHargaBarang();
        $arr2 = $jenisbm->getWhere("setting_org_id = '" . AccessRight::getMyOrgID() . "'");

        $byID = array();
        foreach ($arr2 as $isinya) {
            $byID[$isinya->jenis_biaya] = $isinya;
        }

//
//        $x = 0;
        if (strtolower($mytype) == "ibo") {

            //nanti load biaya aktual
            $jenisbm = new SettingHargaBarangGroup();
            $arr2 = $jenisbm->getWhere("setting_org_id = '" . AccessRight::getMyOrgID() . "'");

            $byID_anak = array();
            foreach ($arr2 as $isinya) {
                $byID_anak[$isinya->jenis_biaya] = $isinya;
            }


            $group = new GroupsModel();
            $children = $group->getWhere("parent_id = '" . AccessRight::getMyOrgID() . "'");
            //create table harga
            ?>
            <form id="barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Harga Barang \ TC Group</th>
                            <?
                            foreach ($children as $child) {
                                ?>
                                <th><?= $child->nama; ?></th>
                                <?
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        foreach ($arr as $barang) {

                            $rule = $mytype . "_rule";
                            list($action, $constraint) = explode(";", $barang->$rule);
                            ?>
                            <tr>
                                <td><?= $barang->kode_barang; ?> <?= $barang->nama_barang; ?></td>
                                <?
                                foreach ($children as $child) {
                                    $jenisbm = new SettingHargaBarangGroup();
                                    $jenisbm->getByID($child->id_group . "_" . $barang->id_barang_harga);

                                    $val = $jenisbm->harga;
                                    if ($val == "") {
                                        $val = $byID[$barang->id_barang_harga]->harga;
                                    }
                                    ?>
                                    <td>
                                        <input <? if ($action == "No") echo "disabled"; ?>
                                            name="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>"
                                            type="number" value="<?= $val; ?>"
                                            class="form-control"
                                            id="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>"
                                            placeholder="<?= $barang->nama_barang; ?>">

                                        <div class="err_text"
                                             id="barang_<?= $child->id_group; ?>_<?= $barang->id_barang_harga; ?>_text"></div>

                                    </td>
                                    <?
                                }
                                ?>
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-default" type="submit">Submit</button>
            </form>

            <style>
                .err_text {
                    padding: 5px;
                    margin: 5px;
                    background-color: #dedede;
                    display: none;
                }

                .input_bordered {
                    border-color: #ff0000;
                }
            </style>
            <script>
                $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").submit(function (event) {
//                alert( "Handler for .submit() called." );
                    event.preventDefault();

                    var post = $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").serialize();
                    $('.err_text').hide();
                    $('.input_bordered').removeClass("input_bordered");
                    $.post("<?=_SPPATH;?>BukuWebHelper/updateAllBiayaGroup", post, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            alert("Data berhasil tersimpan");
                        } else {
                            var err = data.err;

                            for (x in err) {
                                $('#' + x).addClass("input_bordered");
                                var text = err[x];
                                $('#' + x + "_text").html(text).show();
                            }
                        }
                    }, 'json');
                });
            </script>


            <?


        } else {
            ?>
            <form id="barang_<?= $mytype; ?>_<?= AccessRight::getMyOrgID(); ?>">
                <?

                foreach ($arr as $barang) {
                    $val = $byID[$barang->id_barang_harga]->harga;
                    if ($val == "") $val = 0;

                    $rule = $mytype . "_rule";
                    list($action, $constraint) = explode(";", $barang->$rule);


                    ?>
                    <div class="form-group">
                        <label
                            for="exampleInputEmail1"><?= $barang->kode_barang; ?> <?= $barang->nama_barang; ?></label>
                        <input <? if ($action == "No") echo "disabled"; ?>
                            name="barang_<?= $barang->id_barang_harga; ?>"
                            type="number" value="<?= $val; ?>"
                            class="form-control"
                            id="barang_<?= $barang->id_barang_harga; ?>"
                            placeholder="<?= $barang->nama_barang; ?>">

                        <div class="err_text" id="barang_<?= $barang->id_barang_harga; ?>_text"></div>
                    </div>


                    <?
                }

                ?>
                <button class="btn btn-default" type="submit">Submit</button>
            </form>
            <style>
                .err_text {
                    padding: 5px;
                    margin: 5px;
                    background-color: #dedede;
                    display: none;
                }

                .input_bordered {
                    border-color: #ff0000;
                }
            </style>
            <script>
                $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").submit(function (event) {
//                alert( "Handler for .submit() called." );
                    event.preventDefault();

                    var post = $("#barang_<?=$mytype;?>_<?=AccessRight::getMyOrgID();?>").serialize();
                    $('.err_text').hide();
                    $('.input_bordered').removeClass("input_bordered");
                    $.post("<?=_SPPATH;?>BukuWebHelper/updateAllBiaya", post, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            alert("Data berhasil tersimpan");
                        } else {
                            var err = data.err;

                            for (x in err) {
                                $('#' + x).addClass("input_bordered");
                                var text = err[x];
                                $('#' + x + "_text").html(text).show();
                            }
                        }
                    }, 'json');
                });
            </script>
            <?
        }
    }

    public function editBiaya()
    {

        $id_ibo = addslashes($_GET['id_ibo']);
        $set = new BarangWebModel();
        $arr = $set->getAll();


        //nanti load biaya aktual
        $jenisbm = new SettingHargaBarang();
        $arr2 = $jenisbm->getWhere("setting_org_id = '$id_ibo'");

        $byID = array();
        foreach ($arr2 as $isinya) {
            $byID[$isinya->jenis_biaya] = $isinya;
        }


        $arrMyIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
        ?>
        <form id="biaya_<?= $id_ibo; ?>">
            <div class="form-group">
                <label for=ibo">IBO</label>
                <input name="ibo" class="form-control" id="ibo_<?= $id_ibo; ?>"
                       value="<?= Generic::getTCNamebyID($id_ibo); ?>" readonly>

            </div>
            <?

            foreach ($arr as $barang) {
                $val = $byID[$barang->id_barang_harga]->harga;
                if ($val == "") $val = 0;

                $rule = $id_ibo . "_rule";
                list($action, $constraint) = explode(";", $barang->$rule);


                ?>
                <div class="form-group">
                    <label
                        for="exampleInputEmail1"><?= $barang->kode_barang; ?> <?= $barang->nama_barang; ?></label>
                    <input <? if ($action == "No") echo "disabled"; ?>
                        name="barang_<?= $barang->id_barang_harga; ?>"
                        type="number" value="<?= $val; ?>"
                        class="form-control"
                        id="barang_<?= $barang->id_barang_harga; ?>"
                        placeholder="<?= $barang->nama_barang; ?>">

                    <div class="err_text" id="barang_<?= $barang->id_barang_harga; ?>_text"></div>
                </div>


                <?
            }

            ?>
            <button class="btn btn-default" type="submit">Submit</button>
            <button class="btn btn-default" type="button" id="close_<?= $id_ibo ?>">Close</button>
            <script>

                $("#biaya_<?= $id_ibo; ?>").submit(function (event) {
                    event.preventDefault();
                    var post = $("#biaya_<?= $id_ibo; ?>").serialize();
                    console.log(post);
                    $('.err_text').hide();
                    $('.input_bordered').removeClass("input_bordered");
                    $.post("<?= _SPPATH; ?>BukuWebHelper/updateAllBiayaKPO", post, function (data) {
                        console.log(data);
                        if (data.status_code) {
                            alert("Data berhasil tersimpan");
                        } else {
                            var err = data.err;

                            for (x in err) {
                                $('#' + x).addClass("input_bordered");
                                var text = err[x];
                                $('#' + x + "_text").html(text).show();
                            }
                        }
                    }, 'json');


                });

                //                updateAllBiayaKPO
                $('#close_<?=$id_ibo?>').click(function () {
                    lwclose(window.selected_page);
                });
            </script>
        </form>
        <style>
            .err_text {
                padding: 5px;
                margin: 5px;
                background-color: #dedede;
                display: none;
            }

            .input_bordered {
                border-color: #ff0000;
            }
        </style>
        <?
    }
} 