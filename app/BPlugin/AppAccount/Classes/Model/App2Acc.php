<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 10:53 AM
 */

class App2Acc extends Model{

    //push__app2account
    //push__transaksi_pulsa
    public $table_name = "push__app2account";

    //Primary
    public $main_id = 'ac_id';

    //Default Coloms for read
    public $default_read_coloms = 'ac_id,ac_app_id,ac_admin_id';

    //allowed colom in CRUD filter
    public $coloumlist = 'ac_id,ac_app_id,ac_admin_id';

    public $ac_app_id;
    public $ac_admin_id;
    public $ac_id;

    var $crud_webservice_allowed = 'app_id,app_client_id,app_name,app_pushname,app_shortdes,app_fulldes,app_keywords,app_icon,app_create_date,app_feat,app_active,app_pulsa,app_token,app_allowed_ip,app_api_access_key,app_type,app_contract_start,app_google_play_link,app_google_version,app_ios_link,app_ios_version,app_category,app_free_data,app_order';

} 