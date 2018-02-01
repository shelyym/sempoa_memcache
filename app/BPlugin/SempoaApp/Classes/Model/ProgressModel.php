<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/29/18
 * Time: 9:25 AM
 */
class ProgressModel extends Model
{
    var $table_name = "sempoa__app_log_progress";
    var $main_id = "log_progress_id";


    //Default Coloms for read
    public $default_read_coloms = "log_progress_id,log_progress_kode_siswa,log_progess_guru_id,log_progess_level_murid,log_progress_hal_buku_1,log_progress_hal_buku_2,log_progress_hal_buku_3,log_progress_hal_buku_4,log_progress_total_hal_buku_1,log_progress_total_hal_buku_2,log_progress_total_hal_buku_3,log_progress_total_hal_buku_4,log_progress_created,log_progress_updated,log_progress_active";

//allowed colom in CRUD filter
    public $coloumlist = "log_progress_id,log_progress_kode_siswa,log_progess_guru_id,log_progess_level_murid,log_progress_hal_buku_1,log_progress_hal_buku_2,log_progress_hal_buku_3,log_progress_hal_buku_4,log_progress_total_hal_buku_1,log_progress_total_hal_buku_2,log_progress_total_hal_buku_3,log_progress_total_hal_buku_4,log_progress_created,log_progress_updated,log_progress_active";
    public $log_progress_id;
    public $log_progress_kode_siswa;
    public $log_progess_guru_id;
    public $log_progess_level_murid;
    public $log_progress_hal_buku_1;
    public $log_progress_hal_buku_2;
    public $log_progress_hal_buku_3;
    public $log_progress_hal_buku_4;
    public $log_progress_total_hal_buku_1;
    public $log_progress_total_hal_buku_2;
    public $log_progress_total_hal_buku_3;
    public $log_progress_total_hal_buku_4;
    public $log_progress_created;
    public $log_progress_updated;
    public $log_progress_active;



}