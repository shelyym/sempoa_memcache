<?php

/**
 * Description of Role2Menu
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Role2Menu extends Model {
    //Nama Table
    public $table_name = "sp_role__role2menu";

    //Primary
    public $main_id = 'menu_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'role_id,menu_id';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'role_id,menu_id';
    
    public $role_id;
    public $menu_id;
    
    
    public static function getRoleForMenu($menuname){
        global $db;
        $n = new Role2Menu();
        $q = "SELECT role_id FROM {$n->table_name} WHERE menu_id = '$menuname'";
        $obj = $db->query($q,1);
        if(!isset($obj->role_id))return "admin";
        return $obj->role_id;        
    }
}
