<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/16
 * Time: 2:20 PM
 */

class JenisBiayaModelGroup extends Model {

    //put your code here
    var $table_name = "sempoa__setting_biaya_group";
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