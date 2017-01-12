<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BiayaBulananModel
 *
 * @author efindiongso
 */
class BiayaBulananModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__biaya_bulanan";
    var $main_id = "id_biaya_bulanan";
    //Default Coloms for read
    public $default_read_coloms = "id_biaya_bulanan,level,harga_kpo,harga_ibo,harga_tc,biaya_desc,type,ak_id,kpo_id,ibo_id,tc_id";
//allowed colom in CRUD filter
    public $coloumlist = "id_biaya_bulanan,level,harga_kpo,harga_ibo,harga_tc,biaya_desc,type,ak_id,kpo_id,ibo_id,tc_id";
    public $id_biaya_bulanan;
    public $level;
    public $harga_kpo;
    public $harga_ibo;
    public $harga_tc;
    public $biaya_desc;
    public $type;
    public $ak_id;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;

    public function overwriteForm($return, $returnfull) {
        $myOrgID = AccessRight::getMyOrgID();
        $return = parent::overwriteForm($return, $returnfull);
        $test = false;
        $arrLevel = Generic::getAllLevel();
        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $myParentID = Generic::getMyParentID($myOrgID);
            $return['level'] = new \Leap\View\InputSelect($arrLevel, level, level, $this->level);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
            $return['harga_ibo']->setReadOnly();
            $return['harga_tc']->setReadOnly();
            $arrIBO = Generic::getAllMyIBO($myOrgID);
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));
            if ($this->type == "") {

                $return['type'] = new \Leap\View\InputText("hidden", 'type', 'type', 'Master');
            }
            $return['ibo_id'] = new Leap\View\InputFieldToken("text", 'ibo_id', 'ibo_id', $value, $label, $this->ibo_id);

//               for ($i = 1; $i <= 3; $i++) {
//                $test = new BiayaBulananModel();
//                $test->biaya_desc = 'coba';
//                $test->save();
//            }
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myParentID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['biaya_desc']->setReadOnly();
            $return['level'] = new \Leap\View\InputSelect($arrLevel, 'level', 'level', $this->level, 'form-control', 'disabled');
            //Harga
            $return['harga_kpo']->setReadOnly();
            $return['harga_tc']->setReadOnly();

            // Ganti group
            $arrGroup = Generic::getGroup($myOrgID, "1");
            $label = implode(",", $arrGroup);
            $value = implode(",", array_keys($arrGroup));
            $return['tc_id'] = new Leap\View\InputFieldToken("text", 'tc_id', 'tc_id', $value, $label, $this->tc_id);


            if ($this->tc_id == "") {
                if ($this->tc_id != "") {
                    for ($i = 1; $i <= 3; $i++) {
                        $test = new BiayaBulananModel();
                        $test->biaya_desc = 'coba ' . $i;
                        $test->save();
                    }
                }
            }
        } elseif (AccessRight::getMyOrgType() == KEY::$TC) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $myGrandGrandParentID = Generic::getMyParentID($myGrandParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myGrandParentID);

            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();

            // Harga
            $return['harga_kpo']->setReadOnly();
            $return['harga_ibo']->setReadOnly();
            $return['biaya_desc']->setReadOnly();

            $return['level'] = new \Leap\View\InputSelect($arrLevel, 'level', 'level', $this->level, 'form-control', 'disabled');
            if ($this->type == "") {

                $return['type'] = new \Leap\View\InputText("hidden", 'type', 'type', 'slave');
            }
        }

        return $return;
    }

}
