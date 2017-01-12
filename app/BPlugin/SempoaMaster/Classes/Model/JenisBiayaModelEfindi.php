<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/16
 * Time: 11:33 AM
 */

class JenisBiayaModelEfindi extends Model{

    //put your code here
    var $table_name = "sempoa__setting_biaya_efindi";
    var $main_id = "id_setting_biaya";
    //Default Coloms for read
    public $default_read_coloms = "id_setting_biaya,refID,jenis_biaya,harga_kpo,harga_ibo,harga_tc,jenis_biaya_desc,ak_id,kpo_id,ibo_id,tc_id,hide";
//allowed colom in CRUD filter
    public $coloumlist = "id_setting_biaya,refID,jenis_biaya,harga_kpo,harga_ibo,harga_tc,jenis_biaya_desc,ak_id,kpo_id,ibo_id,tc_id,hide";
    public $id_setting_biaya;
    public $refID;
    public $jenis_biaya;
    public $harga_kpo;
    public $harga_ibo;
    public $harga_tc;
    public $jenis_biaya_desc;
    public $ak_id;
    public $kpo_id;
    public $ibo_id;
    public $tc_id;
    public $hide = '0';

    public function overwriteForm($return, $returnfull) {

        $myOrgID = AccessRight::getMyOrgID();
        $return = parent::overwriteForm($return, $returnfull);


        $return['refID'] = new Leap\View\InputText('hidden', 'refID', 'refID', $this->refID);

        if (AccessRight::getMyOrgType() == KEY::$AK) {

        } elseif (AccessRight::getMyOrgType() == KEY::$KPO) {
            $myParentID = Generic::getMyParentID($myOrgID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $arrIBO = Generic::getAllMyIBO($myOrgID);
            $label = implode(",", $arrIBO);
            $value = implode(",", array_keys($arrIBO));

            $return['ibo_id'] = new Leap\View\InputFieldToken("text", 'ibo_id', 'ibo_id', $value, $label, $this->ibo_id);


            $return['tc_id']->setReadOnly();
            $arrJenisBiaya = Generic::getAllJenisBiaya($myOrgID);
            $return['jenis_biaya'] = new Leap\View\InputSelect($arrJenisBiaya, "jenis_biaya", "jenis_biaya", $this->jenis_biaya);
            $return['harga_ibo']->setReadOnly();
            $return['harga_tc']->setReadOnly();

//            if ($this->refID != '0') {
//                $return['jenis_biaya'] = new Leap\View\InputSelect($arrJenisBiaya, "jenis_biaya", "jenis_biaya", $this->jenis_biaya, "form-control", "disabled");
            $return['ibo_id']->setReadOnly();
//                $return['harga_kpo']->setReadOnly();
            $return['harga_ibo']->setReadOnly();
//                $return['jenis_biaya_desc']->setReadOnly();
//            }
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myParentID);
            if ($this->ibo_id != "") {
                $return['ibo_id'] = new \Leap\View\InputText("text", 'ibo_id', 'ibo_id', $this->ibo_id);
            } else {
                $return['ibo_id'] = new \Leap\View\InputText("text", 'ibo_id', 'ibo_id', $myOrgID);
            }

            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();

            // Ganti group
            $arrGroup = Generic::getGroup($myOrgID, "1");
            $label = implode(",", $arrGroup);
            $value = implode(",", array_keys($arrGroup));
            $return['tc_id'] = new Leap\View\InputFieldToken("text", 'tc_id', 'tc_id', $value, $label, $this->tc_id);
            $arrJenisBiaya = Generic::getAllJenisBiaya($myParentID);
//            $return['jenis_biaya'] =  $this->jenis_biaya;
            $return['harga_kpo']->setReadOnly();
            $return['jenis_biaya_desc']->setReadOnly();


            if ($this->jenis_biaya != "") {
                $return['jenis_biaya'] = new Leap\View\InputText('text', "jenis_biaya", "jenis_biaya", Generic::getTextSettingBiaya($this->jenis_biaya));
                $return['jenis_biaya']->setReadOnly();
            }
            if ($this->jenis_biaya == KEY::$REGISTER) {
                $return['harga_tc'] = new \Leap\View\InputText("text", 'harga_tc', 'harga_tc', $this->harga_ibo);
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$IURANBUKU) {
                $return['harga_tc'] = new \Leap\View\InputText("text", 'harga_tc', 'harga_tc', $this->harga_ibo);
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$BUKU) {
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$PERLENGKAPAN) {
                $return['harga_tc'] = new \Leap\View\InputText("text", 'harga_tc', 'harga_tc', $this->harga_ibo);
                $return['harga_tc']->setReadOnly();
            }
        } elseif (AccessRight::getMyOrgType() == KEY::$TC) {

            $myParentID = Generic::getMyParentID($myOrgID);
            $myGrandParentID = Generic::getMyParentID($myParentID);
            $myGrandGrandParentID = Generic::getMyParentID($myGrandParentID);
            $return['ak_id'] = new \Leap\View\InputText("text", 'ak_id', 'ak_id', $myGrandGrandParentID);
            $return['kpo_id'] = new \Leap\View\InputText("text", 'kpo_id', 'kpo_id', $myGrandParentID);
            $return['ibo_id'] = new \Leap\View\InputText("text", 'ibo_id', 'ibo_id', $myParentID);
            $return['tc_id'] = new \Leap\View\InputText("text", 'tc_id', 'tc_id', $myOrgID);
            $return['ak_id']->setReadOnly();
            $return['kpo_id']->setReadOnly();
            $return['ibo_id']->setReadOnly();
            $return['tc_id']->setReadOnly();
            $arrJenisBiaya = Generic::getAllJenisBiaya($myGrandParentID);
            $return['jenis_biaya'] = new Leap\View\InputSelect($arrJenisBiaya, "jenis_biaya", "jenis_biaya", $this->jenis_biaya, "form-control", "disabled");

            $return['harga_kpo']->setReadOnly();
            $return['harga_ibo']->setReadOnly();
            $return['jenis_biaya_desc']->setReadOnly();

            if ($this->jenis_biaya == KEY::$REGISTER) {
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$IURANBUKU) {
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$BUKU) {
                $return['harga_tc']->setReadOnly();
            } elseif ($this->jenis_biaya == KEY::$PERLENGKAPAN) {
                $return['harga_tc']->setReadOnly();
            }
        }
        $return['hide'] = new \Leap\View\InputText("hidden", 'hide', 'hide', $this->hide);
        return $return;
    }

    public function constraints() {

        $err = array();
        if (!isset($this->jenis_biaya)) {
            $err['jenis_biaya'] = Lang::t('Please provide jenis biaya');
        }

        if (AccessRight::getMyOrgType() == KEY::$AK) {

        } elseif (AccessRight::getMyOrgType() == KEY::$KPO) {
            if ($this->harga_ibo != "") {
                if ($this->harga_ibo < $this->harga_kpo) {

                }
            }
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {


            if ($this->jenis_biaya == KEY::$REGISTER) {
                if ($this->harga_ibo < $this->harga_kpo) {
                    $err['harga_ibo'] = Lang::t('IBO Price is lower as KPO Price');
                }
            } elseif ($this->jenis_biaya == KEY::$BUKU) {

            } elseif ($this->jenis_biaya == KEY::$ROYALTI) {

            } elseif ($this->jenis_biaya == KEY::$IURANBUKU) {

            } elseif ($this->jenis_biaya == KEY::$PERLENGKAPAN) {

            }
            if ($this->harga_ibo < $this->harga_kpo) {
                $err['harga_ibo'] = Lang::t('IBO Price is lower as KPO Price');
            }
        } elseif (AccessRight::getMyOrgType() == KEY::$TC) {

        }
        return $err;
    }

    public function onSaveSuccess($id) {
        parent::onSaveSuccess($id);
        $obj = new JenisBiayaModel();
        $obj->getByID($id);
        $objBaru = new JenisBiayaModel();
        global $db;
        if (AccessRight::getMyOrgType() == KEY::$KPO) {

            $arrIboID = explode(",", $obj->ibo_id);

            for ($i = 0; $i < count($arrIboID); $i++) {
                $ibo = strval($arrIboID[$i]);

                $find = Generic::fCheckMasterRow($id, $obj->jenis_biaya, $obj->ak_id, $obj->kpo_id, $ibo, $obj->table_name);
                if ($find === 0) {
                    if ($obj->refID == 0) {
                        $q = "INSERT INTO {$objBaru->table_name} (refID, ak_id, kpo_id, ibo_id,jenis_biaya,harga_kpo, jenis_biaya_desc) VALUES ('$id', '$obj->ak_id', '$obj->kpo_id', $ibo,'$obj->jenis_biaya', '$obj->harga_kpo','$obj->jenis_biaya_desc')";
                        $db->qid($q);
                    }
                } elseif ($find === 1) {
                    $q = "UPDATE  {$objBaru->table_name}  SET hide='0' WHERE refID='$id'";
                    $db->query($q, 0);
                }
            }


            // Delete
            $a = Generic::removeIBO($obj->id_setting_biaya, $obj->table_name);
            foreach ($a as $key => $valHelp) {
                $find = false;
                for ($i = 0; $i < count($arrIboID); $i++) {
                    $ibo = ($arrIboID[$i]);
                    if ($valHelp == $ibo) {
                        $find = true;
                    }
                }
                if ($find == false) {
                    $removeObj = new JenisBiayaModel();
                    $removeObj->getByID($key);
                    $removeObj->hide = '1';
                    $removeObj->save();
                }
            }


            // Save
            $q = "UPDATE  {$objBaru->table_name}  SET harga_kpo='$obj->harga_kpo' WHERE refID='$id'";
            $db->query($q, 0);
        }

        if (AccessRight::getMyOrgType() == KEY::$IBO) {

            $arrgroupTC = explode(",", $this->tc_id);
            foreach ($arrgroupTC as $val) {
                $groups = Generic::fgetAllGroupMember($val);
                $groupsArr = explode(",", $groups);
                foreach ($groupsArr as $val) {
                    $val = str_replace(' ', '', $val);
                    $find = Generic::fCheckMasterRowTC($id, $obj->jenis_biaya, $obj->ak_id, $obj->kpo_id, $obj->ibo_id, $val, $obj->table_name);
                    if ($find === 0) {
                        $q = "INSERT INTO {$objBaru->table_name} (refID, ak_id, kpo_id, ibo_id, tc_id, jenis_biaya,harga_kpo,harga_ibo,jenis_biaya_desc,hide) VALUES ('$id', '$obj->ak_id', '$obj->kpo_id','$obj->ibo_id', $val,'$obj->jenis_biaya', '$obj->harga_kpo','$obj->harga_ibo','$obj->jenis_biaya_desc','0')";
                        $db->qid($q);
                    } elseif ($find === 1) {
                        $q = "UPDATE  {$objBaru->table_name}  SET hide='0' WHERE refID='$id' AND tc_id='$val'";
                        $db->query($q, 0);
                    }
                }
            }


            // Delete
            $a = Generic::removeTC($this->id_setting_biaya, $this->table_name);
            $groups = $this->tc_id;
            $groupsArr = explode(",", $groups);
            for ($i = 0; $i < count($groupsArr); $i++) {
                $tc_help = $tc_help . "," . Generic::fgetAllGroupMember($groupsArr[$i]);
                if ($valHelp == $tc) {
                    $find = true;
                }
            }
            $arrHelp = explode(",", $tc_help);
            $arrHelp = (array_unique(array_filter(array_map('trim', $arrHelp))));
            foreach ($a as $key => $valHelp) {
                $find = false;
                foreach ($arrHelp as $help) {
                    if ($valHelp == $help) {
//                        pr($valHelp . " - " . $help);
                        $find = true;
                    }
                }
                if ($find == false) {
                    $removeObj = new JenisBiayaModel();
                    $removeObj->getByID($key);
                    $removeObj->hide = '1';
                    $removeObj->save();
                }
            }
        }
    }
} 