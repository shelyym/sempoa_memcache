<?php

/**
 * Description of RoleOrganization
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class RoleOrganization extends Model {

    //Nama Table
    public $table_name = "sp_role__organization";
    //Primary
    public $main_id = 'organization_id';
    //Default Coloms for read
    public $default_read_coloms = 'organization_id,organization_name,organization_active,organization_folder_name';
    //allowed colom in CRUD filter
    public $coloumlist = 'organization_name,organization_parent_id,organization_active,organization_folder_name';

    public $organization_id;

    public $organization_name;
    public $organization_parent_id;
    public $organization_active;
    public $organization_folder_name;

    public static function getMy ()
    {
        return $_SESSION['account']->RoleOrganizationObj;
    }
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
        
        $p = new RoleOrganization();
        
        $arrPage = $p->getWhere("organization_active = '1'");
        $arrNe = array();
        foreach($arrPage as $pp){
            $arrNe[$pp->organization_id] = $pp->organization_id." - ".$pp->organization_name;
        }
        
        $return['organization_parent_id'] = new Leap\View\InputSelect($arrNe, "organization_parent_id", "organization_parent_id",
            $this->organization_parent_id);
        $return['organization_active'] = new Leap\View\InputSelect($this->arrayYesNO, "organization_active", "organization_active",
            $this->organization_active);
        
        
        return $return;
    } 
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->organization_name)) {
                $err['organization_name'] = Lang::t('Name cannot be empty');
        }

        if (!isset($this->organization_active)) {
                $err['organization_active'] = Lang::t('Please provide active');
                
        }
        if ((int)$this->organization_parent_id<1) {
                $err['organization_parent_id'] = Lang::t('Please insert Parent ID bigger than 1');
                
        }
        

        return $err;
    }
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->organization_active)) {
                $obj->organization_active = $this->arrayYesNO[$obj->organization_active];
            }
            if (isset($obj->organization_parent_id)) {
                if($obj->organization_parent_id<1){
                    $obj->organization_parent_id = Lang::t('Top Level');
                    continue;
                }
                $r = new RoleOrganization();
                $r->getByID($obj->organization_parent_id);
                $obj->organization_parent_id = $r->organization_name;
            }
        }
        return $return;
    }
}
