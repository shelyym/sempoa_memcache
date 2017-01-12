<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LL_Tnc
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Tnc extends Model{
    //put your code here
    
     //Nama Table
    public $table_name = "ll__tnc";

    //Primary
    public $main_id = 'tnc_id';

//Default Coloms for read
    public $default_read_coloms = "tnc_id,tnc_title,tnc_aktif,tnc_rank";

//allowed colom in CRUD filter
    public $coloumlist = "tnc_id,tnc_title,tnc_text,tnc_aktif,tnc_rank";
    public $tnc_id;
    public $tnc_title;
    public $tnc_text;
    public $tnc_aktif;
    public $tnc_rank;
   

    public $crud_setting = array("add" => 1, "search" => 1, "viewall" => 1, "export" => 1, "toggle" => 1, "import" => 0, "webservice" => 1);
    public $crud_webservice_allowed = "tnc_id,tnc_title,tnc_text,tnc_aktif,tnc_rank";

    public function overwriteForm($return, $returnfull)
    {
        $return = parent::overwriteForm($return, $returnfull);
        $return['tnc_text'] = new \Leap\View\InputTextRTE("tnc_text", "tnc_text", $this->tnc_text);
        $return['tnc_rank'] = new \Leap\View\InputText("number","tnc_rank", "tnc_rank", $this->tnc_rank);
        $return['tnc_aktif'] = new Leap\View\InputSelect($this->arrayYesNO, "tnc_aktif", "tnc_aktif",
            $this->tnc_aktif);

       
        return $return;
    }
    public function overwriteRead($return)
    {
        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {
            

            if (isset($obj->tnc_aktif)) {
                $obj->tnc_aktif = $this->arrayYesNO[$obj->tnc_aktif];
            }
        }
        return $return;
    }
    public function overwriteReadExcel($return)
    {
//        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {


            if (isset($obj->tnc_aktif)) {
                $obj->tnc_aktif = $this->arrayYesNO[$obj->tnc_aktif];
            }
        }
        return $return;
    }
    public function constraints()
    {
        //err id => err msg
        $err = array();

        if (!isset($this->tnc_title)) {
            $err['tnc_title'] = Lang::t('Name cannot be empty');
        }


        if (!isset($this->tnc_text)) {
            $err['tnc_text'] = Lang::t('Text cannot be empty');

        }


        return $err;
    }
}
