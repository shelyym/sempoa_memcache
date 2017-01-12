<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RuanganModel
 *
 * @author efindiongso
 */
class RuanganModel extends Model {

    //put your code here
    //put your code here
    var $table_name = "sempoa__ruangan";
    var $main_id = "id_ruangan";
//Default Coloms for read
    public $default_read_coloms = "id_ruangan,tc_id,nama_ruangan,ruangan_desc";
//allowed colom in CRUD filter
    public $coloumlist = "id_ruangan,tc_id,nama_ruangan,ruangan_desc";
    public $id_ruangan;
    public $tc_id;
    public $nama_ruangan;
    public $ruangan_desc;

}
