<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/8/16
 * Time: 1:59 PM
 */

class AgentMe extends WebService{

    public function getSetting(){

        //no param
        IMBAuth::checkOAuth();

        echo file_get_contents(_BPATH."SettingWeb/Efiwebsetting?cmd=ws&mws=getall");
        die();
    }

    public function saveDevice(){

        //POST
        //device_id
        //type

        //GET
        //lat
        //lng

        //POST
        //acc_id *if any
        PushAgentUtil::save_device();
    }

    public function registerMe(){

        //POST
        //uname
        //name
        //email
        //phone
        //pwd
        //pwd2
        //marketer

        IMBAuth::checkOAuth();
        AppearRegister::processRegister("app");
    }

    public function forgotPassword(){

        //POST
        //uname  username / email
        //nanti dikirim email balesane

        $username = addslashes($_POST["uname"]);

        $acc = new Account();

        global $db;
        $sql = "SELECT * FROM {$acc->table_name} WHERE (admin_username = '$username' OR admin_email = '$username') AND admin_aktiv = 1 ";
        $obj = $db->query($sql, 1);

        if($obj->admin_id>0) {

            $email = $obj->admin_email;
            $uname = $obj->admin_username;
            $hash = Account::updateHash($obj->admin_id);
            $link = _BPATH."resetPassword?hkd=$hash&rdid=".$obj->admin_id."&ptt=".md5(rand(0,1000).time());

            $dapatEmail = new DataEmail();
            if ($dapatEmail->forgotPassword($email, $uname, $link)) {
                $json['status_code'] = 1;
                $json['status_message'] = "Check your email to reset password";
                echo json_encode($json);
                die();
            }
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "We cannot find Account with this username/email.";
            echo json_encode($json);
            die();
        }

    }

    public function loginMe(){

        //POST
        //uname  ( username / email )
        //pwd
        IMBAuth::checkOAuth();
        //dapat hash..hash dikirim tiap request

        $username = addslashes($_POST["uname"]);
        $password = addslashes($_POST["pwd"]);


        //checksyarat
        if (!isset($username) || $username == "" ) {
            $json['status_code'] = 0;
            $json['status_message'] = "Username/Email Empty";
            echo json_encode($json);
            die();
        }

        if (!isset($password)|| $password == "") {
            $json['status_code'] = 0;
            $json['status_message'] = "Password Empty";
            echo json_encode($json);
            die();
        }

        $acc = new Account();

        $sel = "admin_id,admin_username,admin_hash,admin_aktiv,admin_email,admin_nama_depan,admin_password,admin_isAgent,admin_phone,admin_marketer,admin_npwp,admin_ktp,admin_total_paid_sales,admin_total_free_sales";
        //load from db
        global $db;
        $sql = "SELECT $sel FROM {$acc->table_name} WHERE (admin_username = '$username' OR admin_email = '$username') AND admin_aktiv = 1 ";
        $obj = $db->query($sql, 1);
        $row = toRow($obj);
        $acc->fill($row);


        if (hash_equals($obj->admin_password, crypt($password, $obj->admin_password))) {
            $json['status_code'] = 1;

            //unset uneeded data
            unset($obj->admin_password);

            $newhash = Account::updateHash($obj->admin_id);

            $obj->admin_hash = $newhash;

            //Update setlastlogin
            Account::setLastUpdate($obj->admin_id);
            $json['status_message'] = "Login Success";
            $json['acc'] = $obj;

            echo json_encode($json);
            die();
        }

        $json['status_code'] = 0;
        $json['status_message'] = "Username/Email and Password Mismatched";
        echo json_encode($json);
        die();

    }

    public function getMyDashboard(){

        //POST
        //acc_id
        //hash
        //mon *optional
        //y *optional

        $id = addslashes($_POST['acc_id']);
        $acc = new Account();
        $acc->getByID($id);

        if($acc->admin_hash != $_POST['hash']){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid Token";
            echo json_encode($json);
            die();
        }

        $_GET['mon'] = $_POST['mon'];
        $_GET['y'] = $_POST['y'];

        MyDashboard::dashboardWebService($acc);
    }

    public function getEarningDetail(){

        //acc_id
        //hash
        //mon *optional
        //y *optional

        $id = addslashes($_POST['acc_id']);
        $acc = new Account();
        $acc->getByID($id);

        if($acc->admin_hash != $_POST['hash']){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid Token";
            echo json_encode($json);
            die();
        }

        $_GET['mon'] = $_POST['mon'];
        $_GET['y'] = $_POST['y'];

        MyDashboard::earningWS($acc);
    }
    public function getPayoutsDetails(){

        //acc_id
        //hash
        //mon *optional
        //y *optional
        $id = addslashes($_POST['acc_id']);
        $acc = new Account();
        $acc->getByID($id);

        if($acc->admin_hash != $_POST['hash']){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid Token";
            echo json_encode($json);
            die();
        }

        $_GET['mon'] = $_POST['mon'];
        $_GET['y'] = $_POST['y'];

        MyDashboard::payoutWS($acc);
    }

    public function getFreeDetail(){

        //acc_id
        //hash
        //mon *optional
        //y *optional
        $id = addslashes($_POST['acc_id']);
        $acc = new Account();
        $acc->getByID($id);

        if($acc->admin_hash != $_POST['hash']){
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid Token";
            echo json_encode($json);
            die();
        }

        $_GET['mon'] = $_POST['mon'];
        $_GET['y'] = $_POST['y'];

        MyDashboard::freebiesWS($acc);
    }

    public function sendAgentForm(){

        //ktp image
        //npwp image *optional
        //bank_name
        //account_nr
        //account_name
        //branch_name

        IMBAuth::checkOAuth();
        AppearForm::processAgent("app");
    }


} 