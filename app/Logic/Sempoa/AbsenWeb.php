<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/30/16
 * Time: 3:56 PM
 */
class AbsenWeb extends WebApps
{

    function absenkan()
    {


        $id_murid = base64_decode($_GET['gjkres']);
        $id_murid = (string)$id_murid;
        if ($id_murid != "") {
            $murid = new MuridModel();
            $murid->getByID($id_murid);
            if (!is_null($murid->id_murid)) {
                $kelas = new KelasWebModel();
                $matrixKelas = new MuridKelasMatrix();
                $date = new DateTime('now');
                $hari_ini = $date->format("w");
                $today = $date->format("Y-m-d");
                $jam_skrg = $date->format("H:i:s");
                $arrHari = Generic::getNamaHari();
                $schonSaved = false;
                $text = "";
                global $db;

//                $q = "SELECT * FROM {$kelas->table_name} kls  INNER JOIN {$matrixKelas->table_name} mk ON kls.id_kelas = mk.kelas_id WHERE kls.hari_kelas = $hari_ini AND mk.murid_id=$id_murid AND mk.active_status=1 AND kls.jam_mulai_kelas >= CURRENT_TIME ORDER BY kls.jam_mulai_kelas ASC";

                $q = "SELECT * FROM {$kelas->table_name} kls  INNER JOIN {$matrixKelas->table_name} mk ON kls.id_kelas = mk.kelas_id WHERE kls.hari_kelas = $hari_ini AND mk.murid_id=$id_murid AND mk.active_status=1 ORDER BY CURRENT_TIME, kls.jam_mulai_kelas ASC";
                $arrMatrixKelas = $db->query($q, 2);
                if (count($arrMatrixKelas) == 0) {
                    $text = Generic::getMuridNamebyID($id_murid) . " pada " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . " tidak ada kelas!";
                    $schonSaved = true;

                } else {
                    foreach ($arrMatrixKelas as $val) {

//                        pr("masuk");
                        $kls_id_hlp = $val->kelas_id;
                        $absenMurid = new AbsenEntryModel();
                        $absenMurid->getWhereOne("absen_murid_id=$id_murid AND absen_kelas_id=$kls_id_hlp AND absen_date='$today'");
                        if (is_null($absenMurid->absen_id)) {
                            $klsWS = new KelasWebHelper();
                            $klsWS->absen_murid_dikelas_WS($val->mk_id, $id_murid, $kls_id_hlp);
                            $text = Generic::getMuridNamebyID($id_murid) . " untuk kelas " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . ", jam: " . $val->jam_mulai_kelas . " sudah berhasil diabsen!<br>";
                            $schonSaved = true;
                            break;
                        } else {
                            $text = Generic::getMuridNamebyID($id_murid) . " di kelas " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . ", jam: " . $val->jam_mulai_kelas . " sudah terabsen!<br>";
                        }


                    }
                }


                if (!$schonSaved) {


                    // Check hari ini tidak ada kelas
                    $q = "SELECT * FROM {$kelas->table_name} kls  INNER JOIN {$matrixKelas->table_name} mk ON kls.id_kelas = mk.kelas_id WHERE kls.hari_kelas = $hari_ini AND mk.murid_id=$id_murid AND mk.active_status=1 AND kls.jam_mulai_kelas <= CURRENT_TIME ORDER BY kls.jam_mulai_kelas ASC";
                    $arrMatrixKelas = $db->query($q, 2);
                    if (count($arrMatrixKelas) == 0) {
                        $text = Generic::getMuridNamebyID($id_murid) . " pada " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . " sudah absen!";
//                        $text = Generic::getMuridNamebyID($id_murid) . " pada " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . " tidak ada kelas!";

                    }


                    foreach ($arrMatrixKelas as $val) {
                        $kls_id_hlp = $val->kelas_id;
                        $absenMurid = new AbsenEntryModel();
                        $absenMurid->getWhereOne("absen_murid_id=$id_murid AND absen_kelas_id=$kls_id_hlp AND absen_date='$today'");
//                pr($absenMurid);
                        if (is_null($absenMurid->absen_id)) {
                            $klsWS = new KelasWebHelper();
                            $klsWS->absen_murid_dikelas_WS($val->mk_id, $id_murid, $kls_id_hlp);
                            $text = Generic::getMuridNamebyID($id_murid) . " untuk kelas " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . ", jam: " . $val->jam_mulai_kelas . " sudah berhasil diabsen!";
                            break;
                        } else {
                            $text = Generic::getMuridNamebyID($id_murid) . " di kelas " . $arrHari[$hari_ini] . ", " . date("d-m-Y") . ", jam: " . $val->jam_mulai_kelas . " sudah terabsen!";
                        }
                    }
                }
                ?>
                <h1 style="padding-top: 30px"><center>Absen Murid <?= Generic::getMuridNamebyID($_GET['murid_id']); ?></center></h1>
                <h3><center><?= $text; ?></center></h3>
                <?
            } else {
                ?>
                <h1><center>ID Murid tidak ditemukan!</center></h1>
                <?
            }

        } else {
            echo "<h1><center>ID Murid Kosong!</center></h1>";
        }

    }
} 