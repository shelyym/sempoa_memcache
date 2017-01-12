<?php

/**
 * Description of RoleLevel
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class RoleLevel extends Model {

    //Nama Table
    public $table_name = "sp_role__level_master";
    //Primary
    public $main_id = 'level_id';
    //Default Coloms for read
    public $default_read_coloms = 'level_id,level_tingkatan,level_name,level_active';
    //allowed colom in CRUD filter
    public $coloumlist = 'level_tingkatan,level_name,level_active';
    public $level_tingkatan;
    public $level_name;

    public $level_id;
    public $level_active;

    public static function getMy ()
    {
        return $_SESSION['account']->RoleLevelObj;
    }
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
        
        
        $return['level_tingkatan'] = new \Leap\View\InputText("number","level_tingkatan", "level_tingkatan", $this->level_tingkatan);
        $return['level_active'] = new Leap\View\InputSelect($this->arrayYesNO, "level_active", "level_active",
            $this->level_active);
        
        
        return $return;
    } 
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->level_name)) {
                $err['level_name'] = Lang::t('Name cannot be empty');
        }

        if (!isset($this->level_tingkatan)) {
                $err['level_tingkatan'] = Lang::t('Please provide Level');
                
        }
        if ((int)$this->level_tingkatan<1) {
                $err['level_tingkatan'] = Lang::t('Please insert Level bigger than 1');
                
        }
        

        return $err;
    }
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->level_active)) {
                $obj->level_active = $this->arrayYesNO[$obj->level_active];
            }
        }
        return $return;
    }
}
