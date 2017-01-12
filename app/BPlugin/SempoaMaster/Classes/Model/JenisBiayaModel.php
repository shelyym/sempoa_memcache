<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JenisBiayaModel
 *
 * @author efindiongso
 */
class JenisBiayaModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__setting_biaya";
    var $main_id = "id_setting_biaya";
    //Default Coloms for read
    public $default_read_coloms = "id_setting_biaya,jenis_biaya,harga,setting_org_id";
//allowed colom in CRUD filter
    public $coloumlist = "id_setting_biaya,jenis_biaya,harga,setting_org_id";
    public $id_setting_biaya;

    public $jenis_biaya;
    public $harga;
    public $setting_org_id;



}
