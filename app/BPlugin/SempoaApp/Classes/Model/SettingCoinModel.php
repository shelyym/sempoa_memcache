<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/23/18
 * Time: 3:39 PM
 */
class SettingCoinModel extends Model
{
    var $table_name = "sempoa__app_setting_coin";
    var $main_id = "setting_coin_id";

//Default Coloms for read
    public $default_read_coloms = "setting_coin_id,setting_jumlah_coin,setting_keterangan,setting_created,setting_updated,setting_active";

//allowed colom in CRUD filter
    public $coloumlist = "setting_coin_id,setting_jumlah_coin,setting_keterangan,setting_created,setting_updated,setting_active";
    public $setting_coin_id;
    public $setting_jumlah_coin;
    public $setting_keterangan;
    public $setting_created;
    public $setting_updated;
    public $setting_active;

    public $crud_webservice_allowed = "setting_coin_id,setting_jumlah_coin,setting_keterangan";

}