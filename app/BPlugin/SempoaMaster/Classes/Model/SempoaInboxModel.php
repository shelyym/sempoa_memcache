<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/16
 * Time: 2:55 PM
 */

class SempoaInboxModel extends Model{

    var $table_name = "sempoa__inbox";
    var $main_id = "inbox_id";

    //Default Coloms for read
    public $default_read_coloms = "inbox_id,inbox_org_id,inbox_title,inbox_msg,inbox_sender_id,inbox_read,inbox_date";

//allowed colom in CRUD filter
    public $coloumlist = "inbox_id,inbox_org_id,inbox_title,inbox_msg,inbox_sender_id,inbox_read,inbox_date";
    public $inbox_id;
    public $inbox_org_id;
    public $inbox_title;
    public $inbox_msg;
    public $inbox_sender_id;
    public $inbox_read;
    public $inbox_date;

    public static function sendMsg($penerima_id,$pengirim_id,$title,$msg){

        $in = new SempoaInboxModel();
        $in->inbox_org_id = $penerima_id;
        $in->inbox_sender_id = $pengirim_id;
        $in->inbox_title = $title;
        $in->inbox_msg = $msg;
        $in->inbox_date = leap_mysqldate();
        $in->save();
    }
} 