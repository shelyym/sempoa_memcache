<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 12/21/17
 * Time: 3:37 PM
 */
class SempoaLogDelete extends Model
{

    var $table_name = "sempoa__delete_log";
    var $main_id = "delete_log_id";
    //Default Coloms for read
    //Default Coloms for read
    public $default_read_coloms = "delete_log_id,delete_table,delete_data,delete_siapa,delete_tgl";

//allowed colom in CRUD filter
    public $coloumlist = "delete_log_id,delete_table,delete_data,delete_siapa,delete_tgl";
    public $delete_log_id;
    public $delete_table;
    public $delete_data;
    public $delete_siapa;
    public $delete_tgl;
}