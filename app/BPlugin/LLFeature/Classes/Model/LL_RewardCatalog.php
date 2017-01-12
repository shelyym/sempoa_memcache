<?php

/**
 * Description of LL_RewardCatalog
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_RewardCatalog extends Model{
    //Nama Table
    public $table_name = "ll__rewardcatalog";  
    
    //Primary
    public $main_id = 'rew_id';
    
    //Default Coloms for read
    public $default_read_coloms = "rew_id,rew_pic,rew_start,rew_end,rew_point,rew_status"; 

    //allowed colom in CRUD filter
    public $coloumlist = "rew_id,rew_pic,rew_start,rew_end,rew_point,rew_status,rew_create_date";
    public $rew_id; 
    public $rew_pic; 
    public $rew_active; 
    public $rew_point; 
    public $rew_status; 
    public $rew_start;
    public $rew_end;
    public $rew_create_date;
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = "rew_id,rew_pic,rew_active,rew_point,rew_status,rew_start,rew_end";
    
    public $crud_add_photourl = array("rew_pic");
    
//    public $arrStatus = array(0=>"stampcard",1=>"lyb_club",2=>"lyb_fan");
    public $arrStatus = array(0=>"STC",1=>"LYB Club",2=>"LYB Fan");
    
    //alat bantu 
    public $rew_problem;
    
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
        $return['rew_point'] = new \Leap\View\InputText("number","rew_point", "rew_point", $this->rew_point);        
        $return['rew_pic'] = new \Leap\View\InputFoto("foto", "rew_pic", $this->rew_pic);
        $return['rew_start'] = new Leap\View\InputText("date", "rew_start", "rew_start",
            $this->rew_start);
        $return['rew_end'] = new Leap\View\InputText("date", "rew_end", "rew_end",
            $this->rew_end);        
        $return['rew_status'] = new Leap\View\InputSelect($this->arrStatus, "rew_status", "rew_status",
            $this->rew_status);
        $return['rew_active'] = new Leap\View\InputSelect($this->arrayYesNO, "rew_active", "rew_active",
            $this->rew_active);
        if(!isset($this->rew_create_date))$this->rew_create_date = leap_mysqldate();
        $return['rew_create_date'] = new Leap\View\InputText("hidden", "rew_create_date", "rew_create_date",
            $this->rew_create_date);

        return $return;
    } 
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->rew_pic)) {
                $obj->rew_pic = \Leap\View\InputFoto::getAndMakeFoto($obj->rew_pic, "rew_image_" . $obj->rew_pic);
            }
            
            if (isset($obj->rew_active)) {
                $obj->rew_active = $this->arrayYesNO[$obj->rew_active];
            }
            if (isset($obj->rew_status)) {
                $obj->rew_status = $this->arrStatus[$obj->rew_status];
            }
        }
        return $return;
    }
    public function overwriteReadExcel ($return)
    {
//        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
//            if (isset($obj->rew_pic)) {
//                $obj->rew_pic = \Leap\View\InputFoto::getAndMakeFoto($obj->rew_pic, "rew_image_" . $obj->rew_pic);
//            }

            if (isset($obj->rew_active)) {
                $obj->rew_active = $this->arrayYesNO[$obj->rew_active];
            }
            if (isset($obj->rew_status)) {
                $obj->rew_status = $this->arrStatus[$obj->rew_status];
            }
        }
        return $return;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->rew_point)) {
                $err['rew_point'] = Lang::t('Program points cannot be empty');
        }

        
        
        if (!isset($this->rew_pic)) {
                $err['rew_pic'] = Lang::t('Please provide Reward photo');
                
        }

        if(!isset($this->rew_create_date)){
            $this->rew_create_date = leap_mysqldate();
        }
        

        return $err;
    }
}
