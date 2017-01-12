<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 11:44 AM
 */

class Paket extends Model{

    //Nama Table
    public $table_name = "ecommultiple__paket";

    //Primary
    public $main_id = 'paket_id';

    //Default Coloms for read
    public $default_read_coloms = "paket_id,paket_name,paket_active,paket_price";

//allowed colom in CRUD filter
    public $coloumlist = "paket_id,paket_name,paket_active,paket_price,paket_price_no_agent,paket_recommended,paket_komisi,paket_komisi_satu,paket_komisi_dua";
    public $paket_id;
    public $paket_name;
    public $paket_active;
    public $paket_price;
    public $paket_price_no_agent;
    public $paket_recommended;
    public $paket_komisi;
    public $paket_komisi_satu;
    public $paket_komisi_dua;

} 