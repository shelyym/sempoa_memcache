<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UjianWebHelper
 *
 * @author efindiongso
 */
class UjianWebHelper extends WebService {

    function load_murid() {
        $tc_id = addslashes($_GET['tc_id']);
        $ujian_id = addslashes($_GET['ujian_id']);

        $mn = new MatrixNilaiModel();
        $arrMuriddiKelas = $mn->getWhere("mu_tc_id='$tc_id' AND mu_ujian_id='$ujian_id' AND mu_active_status = 1");

        $ujian = new UjianModel();
        $ujian->getByID($ujian_id);

        $ids = array();
        foreach ($arrMuriddiKelas as $mur) {
            $ids[] = "id_murid != '" . $mur->mu_murid_id . "'";
        }
//        pr($ids);
        $imp = implode(" AND ", $ids);
        if (count($ids) > 0)
            $imp = $imp . " AND ";

        $objMurid = new MuridModel();
        $arrMuridYangBlomKursus = $objMurid->getWhere($imp . " (id_level_sekarang >= '{$ujian->ujian_from_level}' AND  id_level_sekarang <= '{$ujian->ujian_to_level}') AND murid_tc_id = '$tc_id' ORDER BY id_level_sekarang ASC");
        ?>
        <select class="form-control" id="murid_kelas_select">
            <?
            foreach ($arrMuridYangBlomKursus as $num => $muri) {
                ?>
            <option value="<?= $muri->id_murid; ?>"><?= $muri->nama_siswa . " - " . Generic::getLevelNameByID($muri->id_level_sekarang); ?></option>
                <?
            }
            ?>
        </select>
        <script>
            ujian_id = '<?= $ujian_id; ?>';
        <? if (count($arrMuridYangBlomKursus) > 0) { ?>
                id_murid = '<?= $arrMuridYangBlomKursus[0]->id_murid; ?>';
        <? } ?>
            $('#murid_kelas_select').change(function () {
                var slc = $('#murid_kelas_select').val();
                id_murid = slc;
            });
        </script>
        <?
    }
    function load_murid_aktiv() {
        $tc_id = addslashes($_GET['tc_id']);
        $ujian_id = addslashes($_GET['ujian_id']);

        $mn = new MatrixNilaiModel();
        $arrMuriddiKelas = $mn->getWhere("mu_tc_id='$tc_id' AND mu_ujian_id='$ujian_id' AND mu_active_status = 1");

        $ujian = new UjianModel();
        $ujian->getByID($ujian_id);

        $ids = array();
        foreach ($arrMuriddiKelas as $mur) {
            $ids[] = "id_murid != '" . $mur->mu_murid_id . "'";
        }
//        pr($ids);
        $imp = implode(" AND ", $ids);
        if (count($ids) > 0)
            $imp = $imp . " AND ";

        $objMurid = new MuridModel();
        $arrMuridYangBlomKursus = $objMurid->getWhere($imp . " (id_level_sekarang >= '{$ujian->ujian_from_level}' AND  id_level_sekarang <= '{$ujian->ujian_to_level}') AND murid_tc_id = '$tc_id' AND status=1 ORDER BY id_level_sekarang ASC");
        ?>
        <select class="form-control" id="murid_kelas_select">
            <?
            foreach ($arrMuridYangBlomKursus as $num => $muri) {
                ?>
                <option value="<?= $muri->id_murid; ?>"><?= $muri->nama_siswa . " - " . Generic::getLevelNameByID($muri->id_level_sekarang); ?></option>
                <?
            }
            ?>
        </select>
        <script>
            ujian_id = '<?= $ujian_id; ?>';
            <? if (count($arrMuridYangBlomKursus) > 0) { ?>
            id_murid = '<?= $arrMuridYangBlomKursus[0]->id_murid; ?>';
            <? } ?>
            $('#murid_kelas_select').change(function () {
                var slc = $('#murid_kelas_select').val();
                id_murid = slc;
            });
        </script>
        <?
    }
    public function add_murid_to_ujian() {
        $id_murid = addslashes($_POST['id_murid']);
        $ujian_id = addslashes($_POST['ujian_id']);



        $murid = new MuridModel();
        $murid->getByID($id_murid);

        $mn = new MatrixNilaiModel();
        $arr = $mn->getWhere("mu_murid_id=$id_murid AND mu_ujian_id =$ujian_id ");
        if (count($arr) > 0) {
            $arr[0]->mu_active_status = 1;
            $arr[0]->mu_date = leap_mysqldate();
            if ($arr[0]->save(1)) {

                $json['status_code'] = 1;
                $json['status_message'] = "Ok";
                echo json_encode($json);
                die();
            }
        }
        $mn->mu_ujian_id = $ujian_id;
        $mn->mu_murid_id = $id_murid;
        $mn->mu_active_status = 1;

        $mn->mu_date = leap_mysqldate();
        $mn->mu_tc_id = AccessRight::getMyOrgID();
        $mn->mu_ibo_id = Generic::getMyParentID(AccessRight::getMyOrgID());
        $mn->mu_kpo_id = Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID()));
        $mn->mu_ak_id = Generic::getMyParentID(Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID())));

        if ($mn->save()) {

            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    function remove_murid_from_ujian() {
        $mu_id = addslashes($_POST['mu_id']);
        $mn = new MatrixNilaiModel();
        $mn->getByID($mu_id);
        $mn->mu_active_status = 0;
        $json['mu_id'] = $mu_id;
        if ($mn->save()) {

            $json['status_code'] = 1;
            $json['status_message'] = "Ok";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 0;
        $json['status_message'] = "Save Failed";
        echo json_encode($json);
        die();
    }

    public function setnilai() {
        $id_murid = addslashes($_GET['id_murid']);
        $ujian_id = addslashes($_GET['ujian_id']);
        $nilai = addslashes($_GET['nilai']);


        $matrixNilai = new MatrixNilaiModel();
        $matrixNilai->getWhereOne("mu_murid_id='$id_murid' AND mu_ujian_id='$ujian_id'");
        $matrixNilai->mu_nilai = $nilai;
        if ($matrixNilai->save(1)) {
            $json['status_code'] = 1;
            $json['nilai'] = $nilai;
            $json['status_message'] = "Update success!";
            echo json_encode($json);
            die();
        }

        $json['status_code'] = 0;
        $json['status_message'] = "Update failed!";
        echo json_encode($json);
        die();
    }

    function loadPerlombaan() {
        $ujian_id = addslashes($_GET['ujian_id']);
        $ibo_id = addslashes($_GET['ibo_id']);
        $nm = new MatrixNilaiModel();
        $arrNilai = $nm->getWhere("mu_ujian_id='$ujian_id' AND mu_ibo_id='$ibo_id' AND mu_active_status=1 ORDER BY mu_nilai DESC,  mu_tc_id ASC");

        foreach ($arrNilai as $key => $valNilai) {
            ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td><?= Generic::getMuridNamebyID($valNilai->mu_murid_id); ?></td>
                 <td><?= $nm->getNamaUjian($valNilai->mu_ujian_id); ?></td>
                <td id="nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>"><?= $valNilai->mu_nilai; ?></td>
                <td><?= Generic::getTCNamebyID($valNilai->mu_tc_id); ?></td>
            </tr>
            <script>
                $('#nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').dblclick(function () {
                    var html = "<input id='inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>' type=\"number\" name=\"nilai\">";
                    $('#nilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').html(html);

                    $('#inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>').change(function () {
                        var current = $("#inputNilai_<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>").val();

                        if (confirm("Anda yakin?")) {
                            //                                        alert(<?= $valNilai->mu_murid_id . "_" . $valNilai->mu_ujian_id; ?>);
                            $.get("<?= _SPPATH; ?>UjianWebHelper/setnilai?id_murid=<?= $valNilai->mu_murid_id; ?>" + "&ujian_id=<?= $valNilai->mu_ujian_id; ?>&nilai=" + current, function (data) {
                                                if (data.status_code) {
                                                    alert(data.status_message);
                                                    lwrefresh(selected_page);
                                                } else {
                                                    alert(data.status_message);
                                                }
                                            }, 'json'
                                                    );
                                        }
                                    });

                                });
            </script>
            <?
        }
    }

}
