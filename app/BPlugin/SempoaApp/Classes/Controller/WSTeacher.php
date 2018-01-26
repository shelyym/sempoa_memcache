<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 1/24/18
 * Time: 3:11 PM
 */
class WSTeacher extends WebService
{

    public function loginTeacher()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kode_guru = addslashes($_POST['kode_guru']);
        Generic::checkFieldKosong($kode_guru, KEYAPP::$GURU_ID_KOSONG);
        $teache_pwd = addslashes($_POST['teache_pwd']);
        Generic::checkFieldKosong($teache_pwd, KEYAPP::$PASSWORD_SALAH);

        $objGuru = new SempoaGuruModel();
        $objGuru->getWhereOne("kode_guru='$kode_guru' AND guru_app_pwd='$teache_pwd'");

        if (is_null($objGuru->guru_id)) {
            Generic::errorMsg(KEYAPP::$TEACHER_TDK_BS_LOGIN);
        }

        $json = array();
        $json['status_code'] = 1;
        $json['status_message'] = KEYAPP::$LOGIN_BERHASIL;
        echo json_encode($json);
        die();
        // nama
        // kode
        // nama tc
        // kelas
        // add Murid

    }

    public function homeTeacher()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kode_guru = addslashes($_POST['kode_guru']);
        Generic::checkFieldKosong($kode_guru, KEYAPP::$GURU_ID_KOSONG);

        $objGuru = new SempoaGuruModel();
        $objGuru->getWhereOne("kode_guru='$kode_guru'");

        if (is_null($objGuru->guru_id)) {
            Generic::errorMsg(KEYAPP::$TEACHER_TDK_BS_LOGIN);
        }

        $arrGuruWS = explode(",", $objGuru->APPWS);
        $jsonGuru = array();
        foreach ($arrGuruWS as $val) {
            $jsonGuru[$val] = $objGuru->$val;
        }
        $jsonGuru['TC'] = Generic::getTCNamebyID($objGuru->guru_tc_id);
        $json = array();
        $json['status_code'] = 1;

        $date = new DateTime('today');
        $hari = $date->format("w");

        $kls = new KelasWebModel();
        $arrKelas = $kls->getGuruKelasByDay($jsonGuru['guru_id'], $hari);
        $arrKelasWS = explode(",", $kls->APPWS);
        $arrKelasHelp = array();
        $jsonKelas = array();

//        $jsonKelas['Date'] = $date->format("d M Y");
        foreach ($arrKelas as $kls) {
            unset($arrKelasHelp);
            foreach ($arrKelasWS as $val) {
                $arrKelasHelp[$val] = $kls->$val;
            }
            $jsonKelas[] = $arrKelasHelp;
        }

        $json['result']['Guru'] = $jsonGuru;
        $json['result']['Date'] = $date->format("d M Y");
        $json['result']['Kelas'] = $jsonKelas;
        $json['status_message'] = KEYAPP::$SUCCESS;
        echo json_encode($json);
        die();
    }


    public function getMuridsByKelasID()
    {

        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kelas_id = addslashes($_POST['kelas_id']);
        Generic::checkFieldKosong($kelas_id, "Kelas ID Kosong");
        $objKelasMatrix = new MuridKelasMatrix();
        $arrMurids = $objKelasMatrix->getAllMuridAktivByKelas($kelas_id);

        $arrKelasWS = explode(",", $objKelasMatrix->crud_webservice_allowed);
        $arrMurid = array();
        $jsonMurid = array();
        foreach ($arrMurids as $murid) {
            unset($arrMurid);
            foreach ($arrKelasWS as $val) {
                if ($val == "murid_id") {
                    $arrMurid["nama_murid"] = Generic::getMuridNamebyID($murid->$val);
                }
                if ($val == "level_murid") {
                    $arrMurid["Level"] = Generic::getLevelNameByID($murid->$val);
                }

                $arrMurid[$val] = $murid->$val;
            }
            $jsonMurid[] = $arrMurid;
        }

        $json['result']['Murids'] = $jsonMurid;
        $json['status_message'] = KEYAPP::$SUCCESS;
        echo json_encode($json);
        die();
    }


    function getListStudentygblmadakelas()
    {
        $kelas_id = addslashes($_POST['kelas_id']);
        Generic::checkFieldKosong($kelas_id, KEYAPP::$PARENT_ID_KOSONG);
        $guru_id = addslashes($_POST['guru_id']);
        Generic::checkFieldKosong($kelas_id, KEYAPP::$GURU_ID_KOSONG_LOGOUT);

        $tc_id = addslashes($_POST['tc_id']);
        Generic::checkFieldKosong($tc_id, KEYAPP::$PARENT_ID_KOSONG);
        // Cek, guru ini ngajar di kelas id ini atau tidak
        $kelas = new KelasWebModel();
        $kelas->getWhereOne("id_kelas='$kelas_id' AND guru_id='$guru_id'");

        if (is_null($kelas->id_kelas)) {
            Generic::errorMsg(KEYAPP::$GURU_TDK_NGAJAR_DIKELAS_INI);
        }



        $kelas = new KelasWebModel();
        $kelas->getByID($kelas_id);


        $mk = new MuridKelasMatrix();
        $arrMuriddiKelas = $mk->getWhere(" kelas_id = '$kelas_id' AND active_status = 1");

        $ids = array();
        foreach ($arrMuriddiKelas as $mur) {
            $ids[] = "id_murid != '" . $mur->murid_id . "'";
        }
        $imp = implode(" AND ", $ids);
        if (count($ids) > 0)
            $imp = $imp . " AND ";

        $mur = new MuridModel();
        $arrMuridYangBlomKursus = $mur->getWhere($imp . " id_level_sekarang <= '{$kelas->level}' AND murid_tc_id = '$tc_id' AND status=1 ORDER BY nama_siswa ASC");


        $arrWS = explode(",", $mur->APPWS);
        $arrMurid = array();
        $jsonMurid = array();
        foreach ($arrMuridYangBlomKursus as $murid) {

            unset($arrMurid);
            foreach ($arrWS as $val) {
                $arrMurid[$val]  = $murid->$val;
                if($val == "id_level_sekarang"){
                    $arrMurid["Level"] = Generic::getLevelNameByID($murid->$val);
                }
                if($val == "nama_siswa"){
                    $arrMurid["Huruf_pertama"] = strtoupper(substr($murid->$val,0,1));
                }
            }
            $jsonMurid[] = $arrMurid;
        }

        $json = array();
        $json['status_code'] = 1;
        $json['result'] = $jsonMurid;
        $json['status_message'] = KEYAPP::$SUCCESS;
        echo json_encode($json);
        die();

    }


    function addStudentdiKelasByIDKls()
    {

        $id_murid = addslashes($_POST['id_murid']);
        Generic::checkFieldKosong($id_murid, KEYAPP::$ADD_MURID_ID_KOSONG);
        $kelas_id = addslashes($_POST['kelas_id']);
        Generic::checkFieldKosong($kelas_id, KEYAPP::$PARENT_ID_KOSONG);
        $guru_id = addslashes($_POST['guru_id']);
        Generic::checkFieldKosong($kelas_id, KEYAPP::$GURU_ID_KOSONG_LOGOUT);

        // Cek, guru ini ngajar di kelas id ini atau tidak
        $kelas = new KelasWebModel();
        $kelas->getWhereOne("id_kelas='$kelas_id' AND guru_id='$guru_id'");
//pr($kelas);
        if (is_null($kelas->id_kelas)) {
            Generic::errorMsg(KEYAPP::$GURU_TDK_NGAJAR_DIKELAS_INI);
        }

        // cek murid sdh di add
        $mk = new MuridKelasMatrix();
        $mk->getWhereOne("murid_id='$id_murid' AND kelas_id='$kelas_id' AND active_status=1");


        if(!is_null($mk->mk_id)){
            Generic::errorMsg(KEYAPP::$MURID_SUDAH_DI_ADD_DALAM_KELAS);
        }

        $objMurid = new MuridModel();
        $objMurid->getByID($id_murid);
        $mk = new MuridKelasMatrix();
        $mk->kelas_id = $kelas_id;
        $mk->murid_id = $id_murid;
        $mk->active_status = 1;
        $mk->tc_id = AccessRight::getMyOrgID();
        $mk->active_date = leap_mysqldate();
        $mk->guru_id = $guru_id;
        $mk->nama_guru = Generic::getGuruNamebyID($guru_id);
        $mk->level_kelas = $kelas->level;
        $mk->level_murid = $objMurid->id_level_sekarang;

        if($mk->save()){
            $json = array();
            $json['status_code'] = 1;
            $json['result'] = "";
            $json['status_message'] = KEYAPP::$SUCCESS;
            echo json_encode($json);
        }
        else{
            Generic::errorMsg(KEYAPP::$MURID_GAGAL_DIMASUKAN_KELAS);
        }
    }


    // Notification
    // Guru dan Murid, KODE GURU
    public function getNotificationByID()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kode_guru = addslashes($_POST['kode_guru']);
        Generic::checkFieldKosong($kode_guru, KEYAPP::$PARENT_ID_KOSONG);

        $objNotif = new SempoaNotification();

        $arrNotif = $objNotif->getMyNotif($kode_guru);
        $json = array();

        $arrWS = explode(",", $objNotif->crud_webservice_allowed);
        $arrNotifAll = array();
        foreach ($arrNotif as $notif) {
            $arrNotifHlp = array();
            foreach ($arrWS as $val) {
                $arrNotifHlp[$val] = $notif->$val;
            }
            $arrNotifAll[] = $arrNotifHlp;
        }

        $json['status_code'] = 1;
        $json['result'] = $arrNotifAll;
        $json['status_message'] = "!";
        echo json_encode($json);
        die();

    }
}