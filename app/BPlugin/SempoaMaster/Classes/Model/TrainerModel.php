<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TrainerModel
 *
 * @author efindiongso
 */
class TrainerModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__trainer";
    var $main_id = "id_trainer";
    //Default Coloms for read
    public $default_read_coloms = "id_trainer,kode_trainer,nama_trainer,id_level_trainer,email";
//allowed colom in CRUD filter
    public $coloumlist = "id_trainer,kode_trainer,tanggal_masuk,nama_trainer,nama_panggilan,jenis_kelamin,alamat,tempat_lahir,agama,tanggal_lahir,nomor_hp,pendidikan_terakhir,email,status,id_level_trainer,gambar,tr_ak_id,tr_kpo_id,tr_ibo_id";
    public $id_trainer;
    public $kode_trainer;
    public $tanggal_masuk;
    public $nama_trainer;
    public $nama_panggilan;
    public $jenis_kelamin;
    public $alamat;
    public $tempat_lahir;
    public $agama;
    public $tanggal_lahir;
    public $nomor_hp;
    public $pendidikan_terakhir;
    public $email;
    public $status;
    public $id_level_trainer;
    public $gambar;
    public $tr_ak_id;
    public $tr_kpo_id;
    public $tr_ibo_id;
    public $hideColoums = array("tr_ak_id","tr_kpo_id");
    public $crud_setting = array("add" => 0, "search" => 1, "viewall" => 0, "export" => 1, "toggle" => 1, "import" => 0, "webservice" => 0);


    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);
        $arrAgama = Generic::getAllAgama();

        $arrLevelTrainer = Generic::getAllLevel();
        $arrStatusGuru = Generic::getAllStatusGuru();

        if (AccessRight::getMyOrgType() == KEY::$KPO) {

            $arrMyIBO = array();

            $arrMyIBO = Generic::getAllMyIBO(AccessRight::getMyOrgID());
            $arrMyIBO[0] = "KPO";

            ksort($arrMyIBO);
            $return['tr_ibo_id'] = new Leap\View\InputSelect($arrMyIBO, "tr_ibo_id", "tr_ibo_id", $this->tr_ibo_id);
            $return['tr_ak_id'] = new Leap\View\InputText("hidden", "tr_ak_id", "tr_ak_id", Generic::getMyParentID(AccessRight::getMyOrgID()));
            $return['tr_kpo_id'] = new Leap\View\InputText("hidden", "tr_kpo_id", "tr_kpo_id", AccessRight::getMyOrgID());

            // Punya IBO
            if ($this->tr_ibo_id != 0) {

            } elseif ($this->tr_kpo_id == 0) {

            }
        } elseif (AccessRight::getMyOrgType() == KEY::$IBO) {

            $return['kode_trainer'] = new Leap\View\InputText("text", "kode_trainer", "kode_trainer", Generic::fCreateKode(KEY::$TRAINER, AccessRight::getMyOrgID()));
            // Punya KPO
            if ($this->tr_kpo_id != 0) {

            }
            // Punya IBO
//            elseif ($this->tr_ibo_id == "") {
             $return['tr_kpo_id'] = new Leap\View\InputText("hidden", "tr_kpo_id", "tr_kpo_id", Generic::getMyParentID(AccessRight::getMyOrgID()));

                $return['tr_ak_id'] = new Leap\View\InputText("hidden", "tr_ak_id", "tr_ak_id", Generic::getMyParentID(Generic::getMyParentID(AccessRight::getMyOrgID())));
//            $return['tr_kpo_id'] = new Leap\View\InputText("hidden", "tr_kpo_id", "tr_kpo_id", Generic::getMyParentID(AccessRight::getMyOrgID()));
                $return['tr_ibo_id'] = new Leap\View\InputText("hidden", "tr_ibo_id", "tr_ibo_id", AccessRight::getMyOrgID());
//            }
        }
        $return['status'] = new Leap\View\InputSelect($arrStatusGuru, "status", "status", $this->status);
        $return['agama'] = new Leap\View\InputSelect($arrAgama, "agama", "agama", $this->agama);
        $return['nomor_hp'] = new Leap\View\InputText("text", "nomor_hp", "nomor_hp", $this->nomor_hp);
        $return['gambar'] = new Leap\View\InputFoto("gambar", "gambar", $this->gambar);
//        $return['guru_kpo_id'] = new Leap\View\InputText("hidden", "guru_kpo_id", "guru_kpo_id", $this->guru_kpo_id);
        $return['jenis_kelamin'] = new Leap\View\InputSelect(array("m" => "Male", "f" => "Female"), "jenis_kelamin", "jenis_kelamin", $this->jenis_kelamin);
        $return['agama'] = new Leap\View\InputSelect($arrAgama, "agama", "agama", $this->agama);
        $return['tanggal_lahir'] = new Leap\View\InputText("date", "tanggal_lahir", "tanggal_lahir", $this->tanggal_lahir);
        $return['tanggal_masuk'] = new Leap\View\InputText("date", "tanggal_masuk", "tanggal_masuk", $this->tanggal_masuk);
        $return['id_level_trainer'] = new Leap\View\InputSelect($arrLevelTrainer, "id_level_trainer", "id_level_trainer", $this->id_level_trainer);

//        if ($this->kode_trainer == "") {
//            $return['kode_trainer'] = new Leap\View\InputText("text", "kode_trainer", "kode_trainer", Generic::fCreateKode(KEY::$TRAINER, AccessRight::getMyOrgID()));
//        } else {
//            $return['kode_trainer'] = new Leap\View\InputText("text", "kode_trainer", "kode_trainer", $this->kode_trainer);
//        }
        $return['kode_trainer']->setReadOnly();
        $return['nama_trainer']=new Leap\View\InputTextPattern("text","nama_trainer","nama_trainer",$this->nama_trainer,KEY::$PATTERN_NAME);

        return $return;
    }

    public function overwriteRead($return) {
        $return = parent::overwriteRead($return);
        $arrStatusGuru = Generic::getAllStatusGuru();
        $arrLevel = Generic::getAllLevel();
        $arrAgama = Generic::getAllAgama();

        $objs = $return['objs'];
        foreach ($objs as $obj) {
            if (isset($obj->id_level_trainer)) {
                $obj->id_level_trainer = $obj->id_level_traine;
            }
            if (isset($obj->status)) {
                $obj->status = $arrStatusGuru[$obj->status];
            }
            if (isset($obj->jenis_kelamin)) {
                if ($obj->jenis_kelamin == 'm') {
                    $obj->jenis_kelamin = "Male";
                } elseif ($obj->jenis_kelamin == 'f') {
                    $obj->jenis_kelamin = "Female";
                } else {
                    $obj->jenis_kelamin = "";
                }
            }
            if (isset($obj->agama)) {
                $obj->agama = $arrAgama[$obj->agama];
            }
            if (isset($obj->tr_ibo_id)) {
                $obj->tr_ibo_id = Generic::getTCNamebyID($obj->tr_ibo_id);
            }
        }
        return $return;
    }
//
     public function constraints() {
        $err = array();

        if (AccessRight::getMyOrgType() == KEY::$KPO) {
            $myOrg = AccessRight::getMyOrgID();
            if (!isset($this->kode_trainer)) {
                if (isset($this->tr_ibo_id)) {
                    $this->kode_trainer = Generic::fCreateKode(KEY::$TRAINER, $this->tr_ibo_id);
                }

            }
        }
        else if (AccessRight::getMyOrgType() == KEY::$IBO){
             if (!isset($this->kode_trainer)) {
                  $this->kode_trainer = Generic::fCreateKode(KEY::$TRAINER, AccessRight::getMyOrgID());
             }
        }


         if (!isset($this->tanggal_masuk)) {
             $err['tanggal_masuk'] = Lang::t('Masukan tanggal masuk!');
         }


         if (!isset($this->nama_trainer)) {
             $err['nama_trainer'] = Lang::t('Masukan Nama Trainer!');
         }

         if (!isset($this->alamat)) {
             $err['alamat'] = Lang::t('Masukan Alamat Trainer!');
         }
//
         if (!isset($this->tanggal_lahir)) {
             $err['tanggal_lahir'] = Lang::t('Masukan Tanggal Lahir Trainer!');
         }
         if (!isset($this->nomor_hp)) {
             $err['nomor_hp'] = Lang::t('Masukan Nomor HP Trainer!');
         }

         if (!isset($this->email)) {
             $err['email'] = Lang::t('Masukan Email Trainer!');
         }


         return $err;
    }


    public function overwriteReadExcel($return)

    {
        $objs = $return['objs'];

        $jumlah = 0;

        $arrLevel = Generic::getAllLevel();
        $arrStatus = Generic::getAllStatusGuru();
        $arrAgama = Generic::getAllAgama();

        foreach ($objs as $obj) {

            if (isset($obj->jenis_kelamin)) {
                if ($obj->jenis_kelamin == 'm') {
                    $obj->jenis_kelamin = "Male";
                } elseif ($obj->jenis_kelamin == 'f') {
                    $obj->jenis_kelamin = "Female";
                } else {
                    $obj->jenis_kelamin = "";
                }
            }

            if (isset($obj->id_level_trainer)) {
                $obj->id_level_trainer = $arrLevel[$obj->id_level_trainer];
            }


            if (isset($obj->status)) {
                $obj->status = $arrStatus[$obj->status];
            }
            if (isset($obj->agama)) {
                $obj->agama = $arrAgama[$obj->agama];
            }

            if (isset($obj->tr_ibo_id)) {
                $obj->tr_ibo_id = Generic::getTCNamebyID($obj->tr_ibo_id);
            }
        }
        return $return;
    }
}
