<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RekapAbsenCoach
 *
 * @author efindiongso
 */
class RekapAbsenCoach extends Model {

    //put your code here
    var $table_name = "bi__rekap_absen_coach";
    var $main_id = "id_absen_coach";
    //Default Coloms for read
    public $default_read_coloms = "id_absen_coach,ac_guru_id,ac_nama_tc,ac_nama_guru,ac_id_guru_dtg,ac_nama_guru_dtg,ac_week,ac_tahun,ac_tc_id,ac_ibo_id,ac_kpo_id,ac_ak_id,ac_1,ac_level_1,ac_2,ac_level_2,ac_3,ac_level_3,ac_4,ac_level_4,ac_5,ac_level_5,ac_6,ac_level_6";
//allowed colom in CRUD filter
    public $coloumlist = "id_absen_coach,ac_guru_id,ac_nama_tc,ac_nama_guru,ac_id_guru_dtg,ac_nama_guru_dtg,ac_week,ac_tahun,ac_tc_id,ac_ibo_id,ac_kpo_id,ac_ak_id,ac_1,ac_level_1,ac_2,ac_level_2,ac_3,ac_level_3,ac_4,ac_level_4,ac_5,ac_level_5,ac_6,ac_level_6";
    public $id_absen_coach;
    public $ac_guru_id;
    public $ac_nama_tc;
    public $ac_nama_guru;
    public $ac_id_guru_dtg;
    public $ac_nama_guru_dtg;
    public $ac_week;
    public $ac_tahun;
    public $ac_tc_id;
    public $ac_ibo_id;
    public $ac_kpo_id;
    public $ac_ak_id;
    public $ac_1;
    public $ac_level_1;
    public $ac_2;
    public $ac_level_2;
    public $ac_3;
    public $ac_level_3;
    public $ac_4;
    public $ac_level_4;
    public $ac_5;
    public $ac_level_5;
    public $ac_6;
    public $ac_level_6;

    public function addAbsenCouchFromMurid($guru_id, $ak_id, $kpo_id, $ibo_id, $tc_id, $date, $levelmurid) {

//        $date = new DateTime('today');
        $week = $date->format("W");
        $hari = $date->format("w");
        $hlpHari = 'ac_' . $hari;
        $hlpLevel = 'ac_level_' . $hari;
        $id = $guru_id . "_" . $week;
        //cari dulu, sdh ada d db belum
        $count = $this->searchMuridSdhAbsen($id, $date);
        if ($count > 0) {
            $newRekap = new RekapAbsenCoach();
            $newRekap->getByID($id);
            $newRekap->$hlpHari = $newRekap->$hlpHari + 1;
//            $newRekap->$hlpLevel = $levelmurid . "," . $newRekap->$hlpLevel;

            if ($newRekap->$hlpLevel == "") {
                $newRekap->$hlpLevel = $levelmurid;
            } else {
                $newRekap->$hlpLevel = $levelmurid . "," . $newRekap->$hlpLevel;
            }

            $newRekap->save(1);
        } else {
            $this->id_absen_coach = $guru_id . "_" . $week;
            $this->ac_guru_id = $guru_id;
            $this->ac_nama_guru = Generic::getGuruNamebyID($guru_id);
            $this->ac_nama_tc = Generic::getTCNamebyID($tc_id);
            $this->ac_week = $week;
            $this->ac_tahun = $date->format('Y');
            $this->ac_ak_id = $ak_id;
            $this->ac_kpo_id = $kpo_id;
            $this->ac_ibo_id = $ibo_id;
            $this->ac_tc_id = $tc_id;
            $this->$hlpHari = 1;
            $this->$hlpLevel = $levelmurid;
            $this->save();
        }
    }

    public function searchMuridSdhAbsen($id_absen_coach, $date) {
        $week = $date->format("W");
        $count = $this->getJumlah("id_absen_coach='$id_absen_coach' AND ac_week=$week");
        return $count;
    }

    public function updateGuruName($id_absen_coach, $guru_id) {
        $newRekap = new RekapAbsenCoach();
        $newRekap->getByID($id_absen_coach);
        $newRekap->ac_id_guru_dtg = $guru_id;
        $newRekap->ac_nama_guru_dtg = Generic::getGuruNamebyID($guru_id);
        $newRekap->save(1);
    }

    public function addAbsenCouchFromGuru($guru_id, $ak_id, $kpo_id, $ibo_id, $tc_id, $date) {
        $week = $date->format("W");
        $id = $guru_id . "_" . $week;
        $this->id_absen_coach = $guru_id . "_" . $week;
        $this->ac_guru_id = $guru_id;
        $this->ac_nama_guru = Generic::getGuruNamebyID($guru_id);
        $this->ac_nama_tc = Generic::getTCNamebyID($tc_id);
        $this->ac_id_guru_dtg = $guru_id;
        $this->ac_nama_guru_dtg = Generic::getGuruNamebyID($guru_id);
        $this->ac_week = $week;
        $this->ac_tahun = $date->format('Y');
        $this->ac_ak_id = $ak_id;
        $this->ac_kpo_id = $kpo_id;
        $this->ac_ibo_id = $ibo_id;
        $this->ac_tc_id = $tc_id;
        $this->save();
    }

}
