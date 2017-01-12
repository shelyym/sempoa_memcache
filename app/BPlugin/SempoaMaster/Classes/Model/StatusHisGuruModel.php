<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusHisGuruModel
 *
 * @author efindiongso
 */
class StatusHisGuruModel extends Model{
    //put your code here
    public $table_name = "sempoa__history_status_guru";
    var $main_id = "status_id";
    //put your code here
    //Default Coloms for read
    public $default_read_coloms = "status_id,status_guru_id,status,status_level_guru,status_tanggal_mulai,status_tanggal_akhir";
//allowed colom in CRUD filter
    public $coloumlist = "status_id,status_guru_id,status,status_level_guru,status_tanggal_mulai,status_tanggal_akhir";
    public $status_id;
    public $status_guru_id;
    public $status;
    public $status_level_guru;
    public $status_tanggal_mulai;
    public $status_tanggal_akhir;
}
