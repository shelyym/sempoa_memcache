<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MatrixNilaiModel
 *
 * @author efindiongso
 */
class MatrixNilaiModel extends Model {

    //put your code here
    var $table_name = "sempoa__matrix_ujian";
    var $main_id = "mu_id";
    //Default Coloms for read
    public $default_read_coloms = "mu_id,mu_ujian_id,mu_murid_id,mu_nilai,mu_ranking,mu_active_status,mu_date,mu_ak_id,mu_kpo_id,mu_ibo_id,mu_tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "mu_id,mu_ujian_id,mu_murid_id,mu_nilai,mu_ranking,mu_active_status,mu_date,mu_ak_id,mu_kpo_id,mu_ibo_id,mu_tc_id";
    public $mu_id;
    public $mu_ujian_id;
    public $mu_murid_id;
    public $mu_nilai;
    public $mu_ranking;
    public $mu_active_status;
    public $mu_date;
    public $mu_ak_id;
    public $mu_kpo_id;
    public $mu_ibo_id;
    public $mu_tc_id;

    public function getNamaUjian($mu_ujian_id){
        $ujian = new UjianModel();
        $ujian->getByID($mu_ujian_id);
        return $ujian->ujian_jenis;
    }
}
