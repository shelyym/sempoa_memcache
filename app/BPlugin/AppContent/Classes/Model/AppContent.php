<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:02 PM
 */

class AppContent extends Model{

    var $table_name = "push__app_content";
    var $main_id = "content_id";

    var $content_id;
    var $content_name;
    var $content_icon;
    var $content_type;
    var $content_app_id;

    //Default Coloms
    var $default_read_coloms = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $coloumlist = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $crud_webservice_allowed = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $content_inhalt;
    var $content_hide;
} 