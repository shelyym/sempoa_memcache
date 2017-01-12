<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 9:35 AM
 */

class AppPulsa extends Model{

    //push__transaksi_pulsa
    public $table_name = "push__transaksi_pulsa";

    //Primary
    public $main_id = 'pulsa_id';

    //Default Coloms for read
    public $default_read_coloms = 'pulsa_id,pulsa_app_id,pulsa_jumlah,pulsa_date,pulsa_acc_id,pulsa_action';

    //allowed colom in CRUD filter
    public $coloumlist = 'pulsa_id,pulsa_app_id,pulsa_jumlah,pulsa_date,pulsa_acc_id,pulsa_action,pulsa_camp_id,pulsa_new,pulsa_old';

    public $pulsa_id;
    public $pulsa_app_id;
    public $pulsa_jumlah;
    public $pulsa_date;
    public $pulsa_acc_id;
    public $pulsa_action;
    public $pulsa_camp_id;
    public $pulsa_old;
    public $pulsa_new;
} 