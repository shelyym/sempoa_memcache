<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Schoolsetting
 *
 * @author User
 */
class Efiwebsetting extends Model {
    //my table name
    var $table_name = "sp_websetting";
    var $main_id    = "set_id";

    var $default_read_coloms = "set_id,set_value";

    var $set_id;
    //var	$set_name;
    var $set_value;

    //allowed colom in database
    var $coloumlist = "set_value";
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "set_id,set_value";

    public static function getFBPage ()
    {
        return $_SESSION[get_called_class()]['FacebookPageURL'];
    }

    public static function getTwitterPage ()
    {
        return $_SESSION[get_called_class()]['TwitterPageURL'];
    }

    public static function getYoutubePage ()
    {
        return $_SESSION[get_called_class()]['YoutubePageURL'];
    }

    public static function getWebTitle ()
    {
        return $_SESSION[get_called_class()]['Webtitle'];
    }

    public static function getWebMetaKey ()
    {
        return $_SESSION[get_called_class()]['WebMetaKey'];
    }

    public static function getWebMetaDesc ()
    {
        return $_SESSION[get_called_class()]['WebMetaDescription'];
    }

    public static function getEmail ()
    {
        return $_SESSION[get_called_class()]['Email'];
    }

    public static function getAddress ()
    {
        return $_SESSION[get_called_class()]['Address'];
    }

    public function loadToSession ($whereClause = '', $selectedColom = "*")
    {
        //cek apakah sudah ada di session
        //if(count($_SESSION[get_called_class()])<1){
        global $db;
        $where = "";
        if ($whereClause != '') {
            $where = " WHERE " . $whereClause;
        }
        $q = "SELECT {$selectedColom} FROM {$this->table_name} $where";
        $arr = $db->query($q, 2);
        //pr($arr);
        foreach ($arr as $ss) {
            $_SESSION[get_called_class()][$ss->set_id] = $ss->set_value;
        }
        //}
        //pr($_SESSION);die();
    }
    public static function getData($id){
        return $_SESSION[get_called_class()][$id];
    }
    public static function setData($id,$val){
        self::setDataSementara($id, $val);
        $ef = new Efiwebsetting();
        $ef->set_id = $id;
        $ef->set_value = $val;
        return $ef->save();              
    }
    public static function setDataSementara($id,$val){
        $_SESSION[get_called_class()][$id] = $val;
    }
     public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->set_id)) {
                $err['set_id'] = Lang::t('ID cannot be empty');
        }

        
        if (!isset($this->set_value)) {
                $err['set_value'] = Lang::t('Value cannot be empty');
        }

        

        return $err;
    }
}
