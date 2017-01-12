<?php

/**
 * Description of LL_Program
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Program extends Model{
    //Nama Table
    public $table_name = "ll__programs";  
    
    //Primary
    public $main_id = 'prog_id';
    
//Default Coloms for read
public $default_read_coloms = "prog_id,prog_name,prog_url,prog_pic,prog_active,prog_date_created,prog_date_start,prog_date_end";

//allowed colom in CRUD filter
public $coloumlist = "prog_id,prog_name,prog_url,prog_content,prog_pic,prog_active,prog_date_created,prog_date_start,prog_date_end";
public $prog_id; 
public $prog_name; 
public $prog_url; 
public $prog_content; 
public $prog_pic; 
public $prog_active; 
public $prog_date_created;
    public $prog_date_start;
    public $prog_date_end;


public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "prog_id,prog_name,prog_url,prog_content,prog_pic,prog_active,prog_date_created,prog_date_start,prog_date_end";

public $crud_add_photourl = array("prog_pic");
 /*
    * fungsi untuk ezeugt select/checkbox
    *
    */
    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
        $return['prog_content'] = new \Leap\View\InputTextRTE("prog_content", "prog_content", $this->prog_content);
        $return['prog_pic'] = new \Leap\View\InputFoto("foto", "prog_pic", $this->prog_pic);
        $return['prog_active'] = new Leap\View\InputSelect($this->arrayYesNO, "prog_active", "prog_active",
            $this->prog_active);
        
        if(!isset($this->prog_date_created))
            $dt = leap_mysqldate ();
        else 
            $dt = $this->prog_date_created;
        
        $return['prog_date_created'] = new \Leap\View\InputText("date","prog_date_created", "prog_date_created", $dt);
        $return['prog_date_start'] = new \Leap\View\InputText("date","prog_date_start", "prog_date_start", $this->prog_date_start);
        $return['prog_date_end'] = new \Leap\View\InputText("date","prog_date_end", "prog_date_end", $this->prog_date_end);

        return $return;
    } 
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->prog_pic)) {
                $obj->prog_pic = \Leap\View\InputFoto::getAndMakeFoto($obj->prog_pic, "prog_image_" . $obj->prog_pic);
            }
            
            if (isset($obj->prog_active)) {
                $obj->prog_active = $this->arrayYesNO[$obj->prog_active];
            }
        }
        return $return;
    }
    public function overwriteReadExcel ($return)
    {
//        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
//            if (isset($obj->prog_pic)) {
//                $obj->prog_pic = \Leap\View\InputFoto::getAndMakeFoto($obj->prog_pic, "prog_image_" . $obj->prog_pic);
//            }

            if (isset($obj->prog_active)) {
                $obj->prog_active = $this->arrayYesNO[$obj->prog_active];
            }
        }
        return $return;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->prog_name)) {
                $err['prog_name'] = Lang::t('Program name cannot be empty');
        }

        
        
        if (!isset($this->prog_pic)) {
                $err['prog_pic'] = Lang::t('Please provide program photo');
                
        }

        

        return $err;
    }
}
