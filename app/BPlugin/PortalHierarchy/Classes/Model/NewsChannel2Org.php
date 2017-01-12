<?php

/**
 * Description of NewsChannel2Org
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class NewsChannel2Org extends Model{
    //Nama Table
    public $table_name = "sp_websetting__channel2departmentlevel";  
    
    //Primary
    public $main_id = 'c2d_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'c2d_id,c2d_org_id,c2d_level_id,c2d_channel_id';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'c2d_org_id,c2d_level_id,c2d_channel_id';
    
    public $c2d_id;
    public $c2d_org_id;
    public $c2d_level_id;
    public $c2d_channel_id;
    
    function insertOnDuplicate(){
        global $db;
        $q = "INSERT INTO {$this->table_name} SET c2d_id = '{$this->c2d_id}',"
        . "c2d_org_id = '{$this->c2d_org_id}',c2d_level_id = '{$this->c2d_level_id}',c2d_channel_id = '{$this->c2d_channel_id}' "
        . " ON DUPLICATE KEY UPDATE c2d_level_id = '{$this->c2d_level_id}'";
        echo $q;
        return $db->query($q,0);
    }
}
