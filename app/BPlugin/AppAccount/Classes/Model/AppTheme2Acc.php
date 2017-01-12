<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/20/16
 * Time: 11:23 AM
 */

class AppTheme2Acc extends Model{

    //push__app2account
    //push__transaksi_pulsa
    public $table_name = "push__apptheme2acc";

    //Primary
    public $main_id = 'ac_id';

    //Default Coloms for read
    public $default_read_coloms = 'ac_id,ac_theme_id,ac_admin_id';

    //allowed colom in CRUD filter
    public $coloumlist = 'ac_id,ac_theme_id,ac_admin_id';

    public $ac_app_id;
    public $ac_admin_id;
    public $ac_id;

    var $crud_webservice_allowed = 'ac_id,ac_theme_id,ac_admin_id';

} 