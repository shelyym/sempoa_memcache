<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/17/18
 * Time: 3:09 PM
 */
class SoalChallangeModel extends Model
{
    var $table_name = "sempoa__app_soal_challange";
    var $main_id = "soal_challange_id";

    //Default Coloms for read
    public $default_read_coloms = "soal_challange_id,soal_challange_level,soal_challange_soal,soal_challange_jawaban,soal_challange_created_date,soal_challange_update,soal_challange_status";

//allowed colom in CRUD filter
    public $coloumlist = "soal_challange_id,soal_challange_level,soal_challange_soal,soal_challange_jawaban,soal_challange_created_date,soal_challange_update,soal_challange_status";
    public $soal_challange_id;
    public $soal_challange_level;
    public $soal_challange_soal;
    public $soal_challange_jawaban;
    public $soal_challange_created_date;
    public $soal_challange_update;
    public $soal_challange_status;
}