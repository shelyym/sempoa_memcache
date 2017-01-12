<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 11:45 AM
 */

class PaketSyarat extends Model{
//Nama Table
    public $table_name = "ecommultiple__paketsyarat";

    //Primary
    public $main_id = 'syarat_id';

    //Default Coloms for read
    public $default_read_coloms = "syarat_id,syarat_name,syarat_des,syarat_active,syarat_rumus";

//allowed colom in CRUD filter
    public $coloumlist = "syarat_id,syarat_name,syarat_des,syarat_active,syarat_rumus";
    public $syarat_id;
    public $syarat_name;
    public $syarat_des;
    public $syarat_active;
    public $syarat_rumus;
} 