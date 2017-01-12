<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/11/16
 * Time: 3:04 PM
 */

class AbsenGuruModel extends Model{


    var $table_name = "sempoa_absen_guru";
    var $main_id = "absen_id";

    //Default Coloms for read
    public $default_read_coloms = "absen_id,absen_kelas_id,absen_tc_id,absen_guru_id,absen_mk_id,absen_ibo_id,absen_kpo_id,absen_ak_id,absen_date,absen_reg_date,absen_pengabsen_id";

//allowed colom in CRUD filter
    public $coloumlist = "absen_id,absen_kelas_id,absen_tc_id,absen_guru_id,absen_mk_id,absen_ibo_id,absen_kpo_id,absen_ak_id,absen_date,absen_reg_date,absen_pengabsen_id";
    public $absen_id;
    public $absen_kelas_id;
    public $absen_tc_id;
    public $absen_guru_id;
    public $absen_mk_id;
    public $absen_ibo_id;
    public $absen_kpo_id;
    public $absen_ak_id;
    public $absen_date;
    public $absen_reg_date;
    public $absen_pengabsen_id;

}