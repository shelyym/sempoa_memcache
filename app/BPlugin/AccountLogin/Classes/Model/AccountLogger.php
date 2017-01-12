<?php

/**
 * Description of AccountLogger
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class AccountLogger extends Model {

    //Nama Table
    public $table_name = "sp_admin_account__logger";
    //Primary
    public $main_id = 'log_id';
    //Default Coloms for read
    public $default_read_coloms = 'account_id,login_time,login_datetime_local';
    //allowed colom in CRUD filter
    public $coloumlist = 'account_id,login_time,login_datetime_local';

    public $log_id;
    public $login_time;
    public $account_id;
    public $login_datetime_local;

    public function process_log ($id)
    {
        $this->account_id = $id;
        $this->login_datetime_local = leap_mysqldate();
        $this->save();
    }

}
