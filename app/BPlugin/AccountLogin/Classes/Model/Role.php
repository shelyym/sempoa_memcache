<?php

/**
 * Description of Role
 *
 * @author Elroy Hardoyo
 */
class Role extends Model {
    public $table_name = "sp_role";

    //Primary
    public $main_id = 'role_id';

    //Default Coloms
    public $default_read_coloms = 'role_id,role_name,role_active,role_level,role_org_id';

    public $role_id;
    public $role_name;
    public $coloumlist = 'role_name,role_active,role_level,role_org_id';
    public $role_level;
    public $role_active;
    public $role_org_id;

    public static function hasRole ($role_name)
    {
        return in_array($role_name, $_SESSION['roles']);
    }

    public function loadRoleToSession ()
    {
        $arr = $this->getAll();
        //$_SESSION['listOfRoles'] = $arr;
        foreach ($arr as $role) {
            Registor::addRole($role);
        }
    }
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
             
        
        $return['role_active'] = new Leap\View\InputSelect($this->arrayYesNO, "role_active", "role_active",
            $this->role_active);
        
        
        return $return;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->role_id)) {
                $err['role_id'] = Lang::t('ID cannot be empty');
        }

        
        if (!isset($this->role_name)) {
                $err['role_name'] = Lang::t('Name cannot be empty');
        }

        if (!isset($this->role_active)) {
                $err['role_active'] = Lang::t('Active cannot be empty');
        }

        return $err;
    }
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->role_active)) {
                $obj->role_active = $this->arrayYesNO[$obj->role_active];
            }
            
        }
        return $return;
    }
}
