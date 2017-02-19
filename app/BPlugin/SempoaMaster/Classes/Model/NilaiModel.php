<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NilaiModel
 *
 * @author efindiongso
 */
class NilaiModel extends Model {

    //put your code here
    var $table_name = "sempoa__nilai";
    var $main_id = "nilai_id";
    //Default Coloms for read
    public $default_read_coloms = "nilai_id,nilai_murid_id,nilai_level,nilai_result,nilai_create_date,nilai_org_id,nilai_delete";
//allowed colom in CRUD filter
    public $coloumlist = "nilai_id,nilai_murid_id,nilai_level,nilai_result,nilai_create_date,nilai_org_id,nilai_delete";
    public $nilai_id;
    public $nilai_murid_id;
    public $nilai_level;
    public $nilai_result;
    public $nilai_create_date;
    public $nilai_org_id;
    public $nilai_delete;

}
