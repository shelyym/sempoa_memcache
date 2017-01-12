<?php

/**
 * Description of LL_Testimonial
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Testimonial extends Model{
    //Nama Table
    public $table_name = "ll__testimonial";  
    
    //Primary
    public $main_id = 'testi_id';
    
//Default Coloms for read
public $default_read_coloms = "testi_id,testi_acc_id,testi_text,testi_status,testi_product_id,testi_date,testi_createdate"; 

//allowed colom in CRUD filter
public $coloumlist = "testi_id,testi_acc_id,testi_text,testi_date,testi_status,testi_product_id,testi_createdate";
public $testi_id; 
public $testi_acc_id; 
public $testi_text; 
public $testi_date; 
public $testi_status; 
public $testi_product_id;
public $testi_createdate;

public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "testi_id,testi_acc_id,testi_text,testi_date,testi_status,testi_product_id,testi_createdate";

    public $arrStatus = array(0=>"not yet reviewed",1=>"ok",2=>"no show");

    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);    
        //$return['testi_date'] = new \Leap\View\InputText("datetime","testi_date", "testi_date", $this->testi_date);        
        $return['testi_text'] = new \Leap\View\InputTextArea("testi_text", "testi_text", $this->testi_text);
        
        $return['testi_createdate'] = new \Leap\View\InputText("datetime","testi_createdate", "testi_createdate", $this->testi_createdate);        
                
        $return['testi_status'] = new Leap\View\InputSelect($this->arrStatus, "testi_status", "testi_status",
            $this->testi_status);
        return $return;
    } 
    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);
        
        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->testi_acc_id)) {
                $acc = new LL_Account();
                $acc->getByID($obj->testi_acc_id);
                $obj->testi_acc_id = $acc->macc_first_name." ".$acc->macc_last_name;
            }
            if (isset($obj->testi_product_id)) {
                $acc = new LL_Article_WImage();
                $acc->getByID($obj->testi_product_id);
                $obj->testi_product_id = $acc->BaseArticleNameENG;
            }
            //
            if (isset($obj->testi_status)) {
                $obj->testi_status = $this->arrStatus[$obj->testi_status];
            }
        }
        return $return;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->testi_acc_id)) {
                $err['testi_acc_id'] = Lang::t('LL Account cannot be empty');
        }

        
        
        if (!isset($this->testi_text)) {
                $err['testi_text'] = Lang::t('Please provide Text');
                
        }
        if (!isset($this->testi_createdate)) {
                $this->testi_createdate = leap_mysqldate();
               // $this->testi_date = leap_mysqldate();
        }
        if (!isset($this->testi_date)) {
               // $this->testi_createdate = leap_mysqldate();
                $this->testi_date = leap_mysqldate();
        }

        return $err;
    }
}
