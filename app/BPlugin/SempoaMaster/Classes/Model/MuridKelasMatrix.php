<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/11/16
 * Time: 1:59 PM
 */

class MuridKelasMatrix extends Model{
    var $table_name = "sempoa__murid_kelas_matrix";
    var $main_id = "mk_id";
    var $mk_id;
    var $murid_id;
    var $kelas_id;

    public $default_read_coloms = "murid_id,kelas_id,mk_id,active_status,active_date,nonactive_date,guru_id,nama_guru,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "murid_id,kelas_id,mk_id,active_status,active_date,nonactive_date,guru_id,nama_guru,tc_id,level_murid,level_kelas";
    public $customColumnList = "murid_id,kelas_id,mk_id,active_status,active_date,nonactive_date,guru_id,nama_guru,tc_id,level_murid,level_kelas";

    var $active_status;
    var $active_date;
    var $nonactive_date;
    var $guru_id;
    var $nama_guru;
    var $tc_id;
    var $level_murid;
    var $level_kelas;

    //TODO tambah guru_id, dan nama
    //TODO tambah tc_id

    public function getJumlahSiswaByGuru($guru_id, $tc_id){
        $count = $this->getJumlah("guru_id=$guru_id AND tc_id=$tc_id AND active_status=1");
        return $count;
    }
} 