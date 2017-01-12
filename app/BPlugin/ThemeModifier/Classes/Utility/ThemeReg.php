<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ThemeReg
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class ThemeReg {
    
    public static function mod($id,$default_value = "",$type="text"){
        global $themepath;
        
        
        
        $tm = new ThemeMod();
        
        //cek apakah sudah exist di database
        $arr = $tm->getWhere("set_theme_id = '{$themepath}' AND set_name = '$id' LIMIT 0,1");
        if(count($arr)>0){
            //sudah ada.. pakai yang ada di db
            if($type == "image"){
                if($arr[0]->set_active){
                    if(strstr($arr[0]->set_image,"/")){
                        return $arr[0]->set_image;
                    }
                    else{
                        $gw = new InputFileModel();
                        return _SPPATH.$gw->upload_url.$arr[0]->set_image;
                    }
                }else {
                    return $default_value;
                }
            }
            else{
               if($arr[0]->set_active)
                    return $arr[0]->set_value; 
                else {
                    return $default_value;
                }
            }            
        }
        
        //kalau belum ada..
        $tm->set_theme_id = $themepath;
        $tm->set_name = $id;
        $tm->set_type = $type;
        
        if($type == "image"){
            $tm->set_image = $default_value;
        }
        else{
            $tm->set_value = $default_value;
        }
        $tm->set_active = 1;
        $tm->save();
        //awal2 do nothing 
        return $default_value;
    }
}
