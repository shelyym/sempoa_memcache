<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 8/23/17
 * Time: 2:11 PM
 */
class AccountHelper extends WebService
{

    public function logoutMember(){
        AuthSempoa::logoutSempoa();
        $json['status_code'] = 1;
        $json['status_message'] = "Berhasil logout";

        echo json_encode($json);
        die();
    }
    public function loginMember_tmp()
    {

        AuthSempoa::logoutSempoa();
        $json['status_code'] = 1;
        $json['status_message'] = "Berhasil logout";

        echo json_encode($json);
        die();
    }

    public function loginMember()
    {

        $userid = addslashes($_POST['user_id']);
        $acc = new SempoaAccount();
        $acc->getByID($userid);
        $row = array();
        $json = array();
        foreach ($acc as $key => $value) {
            $row[$key] = $value;
        }

        AuthSempoa::loginSempoaIBO($row);

        if (Auth::isLogged()) {
            $json['status_code'] = 1;
            $json['status_message'] = "Berhasil login " . Generic::getAdminUsernameByID($userid);
        } else {
            $json['status_code'] = 0;
            $json['status_message'] = "Gagal!";

        }

        echo json_encode($json);
        die();
    }
}