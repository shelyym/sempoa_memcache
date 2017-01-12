<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 11:45 AM
 */

class PaketMatrix extends Model{

    //Nama Table
    public $table_name = "ecommultiple__paket_matrix";

    //Primary
    public $main_id = 'ps_id';

    //Default Coloms for read
    public $default_read_coloms = "ps_id,ps_paket_id,ps_syarat_id,ps_isi";

//allowed colom in CRUD filter
    public $coloumlist = "ps_id,ps_paket_id,ps_syarat_id,ps_isi";
    public $ps_id;
    public $ps_paket_id;
    public $ps_syarat_id;
    public $ps_isi;
} 