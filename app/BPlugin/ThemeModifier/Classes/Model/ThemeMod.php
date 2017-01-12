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
class ThemeMod extends Model {
    //my table name
    var $table_name = "sp_theme__meta";
    var $main_id    = "set_id";

    var $default_read_coloms = "set_id,set_name,set_value,set_image,set_active,set_theme_id,set_type";

    var $set_id;
    //var	$set_name;
    var $set_value;
    var $set_image;
    var $set_active;
    var $set_name;
    var $set_theme_id;
    var $set_type;

    //allowed colom in database
    var $coloumlist = "set_id,set_name,set_value,set_image,set_active,set_theme_id,set_type";

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
            $_SESSION[get_called_class()][$ss->set_id]['val'] = $ss->set_value;
            $_SESSION[get_called_class()][$ss->set_id]['img'] = $ss->set_image;
        }
        //}
        //pr($_SESSION);die();
    }
    
    /*
    * fungsi untuk ezeugt select/checkbox
    *
    */
    public function overwriteForm ($return, $returnfull)
    {
        //$return  = parent::overwriteForm($return, $returnfull);    
        
        $return['set_theme_id'] = new \Leap\View\InputText("text", "set_theme_id","set_theme_id", $this->set_theme_id);
        $return['set_name'] = new \Leap\View\InputText("text", "set_name","set_name", $this->set_name);
        //cek apakah image
        if($this->set_type == "image"){
            $return['set_image'] = new \Leap\View\InputFile("set_image", "set_image", $this->set_image);
            $return['set_value'] = new \Leap\View\InputText("hidden", "set_value","set_value", $this->set_value);
           
        }else{
            $return['set_image'] = new \Leap\View\InputText("hidden", "set_image","set_image", $this->set_image);
            if($this->set_type == "text")
                $return['set_value'] = new Leap\View\InputTextArea("set_value", "set_value", $this->set_value);
            else {
                $return['set_value'] =new \Leap\View\InputText($this->set_type, "set_value","set_value", $this->set_value);
            }
        }
        
        $return['set_active'] = new Leap\View\InputSelect($this->arrayYesNO, "set_active", "set_active",
            $this->set_active);
        
        
        
        $return['set_type'] = new \Leap\View\InputText("hidden", "set_type","set_type", $this->set_type);
        
        return $return;
    }

}
