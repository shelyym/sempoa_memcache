<?php

/**
 * Description of PortalFileLogger
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PortalFileLogger extends Model{
    //Nama Table
    public $table_name = "sp_file";  
    
    //Primary
    public $main_id = 'file_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'file_id,file_target_id,file_description,file_filename,file_date,file_size,file_extendsion,file_owner_id';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'file_id,col2';
    
    public $file_id;
    public $file_target_id;
    public $file_description;
    public $file_filename;
    public $file_date;
    public $file_size;
    public $file_extendsion;
    public $file_owner_id;
    public $file_url;
    
    public static function save2log($full_url,$target = ""){
        
        $f = new PortalFileLogger();
        
        $path_parts = pathinfo($full_url);
        
        
        //echo $path_parts['dirname'], "\n";
        $f->file_filename = $path_parts['basename'];
        $f->file_extendsion = $path_parts['extension'];
        
        $arrImg = array("jpg","jpeg","bmp","gif","png","tiff");
        
        if(in_array($f->file_extendsion, $arrImg)){
            $f->file_description = "image";
        }
        else{
            $f->file_description = "file";
        }
        //$f->file_filename = $path_parts['filename'];
        
        $f->file_owner_id = Account::getMyID();
        $f->file_date = leap_mysqldate();
        $f->file_size = filesize($full_url);
        $f->file_url = $full_url;
        $f->file_target_id = $target;
        $f->save();
    }
    public static function deleteFileLog($full_url){
        $f = new PortalFileLogger();
        global $db;
        $q = "DELETE FROM {$f->table_name} WHERE file_url = '$full_url'";
        return $db->query($q,0);
    }
}
