<?php

/**
 * Description of PageContainer
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class PageContainer extends Model{
    //Nama Table
    public $table_name = "sp_content__container";  
    
    //Primary
    public $main_id = 'container_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'container_id,container_name,container_active,container_parent_id';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'container_id,container_name,container_active,container_parent_id';
    
    public $container_id;
    public $container_name;
    public $container_active;
    public $container_parent_id;
    
    public static function getActive(){
        $gal2 = new PageContainer();
        $arrGal = $gal2->getWhere("container_parent_id = 0 AND container_active =1 ORDER BY container_name ASC");

        $_SESSION['pageContainer'] = $arrGal;
        return $arrGal;
    }
    public static function processActiveAsAdminMenu($arrGal){
        foreach($arrGal as $con){
            $safe = str_replace(" ","_" , $con->container_name);
            Registor::registerAdminMenu("PageCategories", $safe, "Page2ContainerWeb/page?cid=".$con->container_id);
            //set yang bisa lihat menu
            Registor::setDomainAndRoleMenu($safe);
        }
    }
    public static function getActiveSession(){
        return $_SESSION['pageContainer'];
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->container_name)) {
                $err['container_name'] = Lang::t('Name cannot be empty');
        }

        

        return $err;
    }
    public function overwriteForm ($return, $returnfull)
    {
        $gal2 = new PageContainer();
        $arrGal = $gal2->getWhere("container_active =1 ORDER BY container_name ASC");
        $arrNew[0] = Lang::t("No Parent");
        foreach($arrGal as $c){
            $arrNew[$c->container_id] = $c->container_name;
        }
        $return['container_parent_id'] = new Leap\View\InputSelect($arrNew, "container_parent_id", "container_parent_id",
            $this->container_parent_id);
        $return['container_active'] = new Leap\View\InputSelect($this->arrayYesNO, "container_active", "container_active",
            $this->container_active);
       return $return;
    }
     public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            
            if (isset($obj->container_active)) {
                $obj->container_active = $this->arrayYesNO[$obj->container_active];
            }
            if (isset($obj->container_parent_id)) {
                $pc = new PageContainer();
                if($obj->container_parent_id >0){
                    $pc->getByID($obj->container_parent_id);
                    $txt = $pc->container_name;
                }else{
                    $txt = Lang::t("No Parent");
                }
                $obj->container_parent_id = $txt;
            }
        }
        return $return;
    }
}
