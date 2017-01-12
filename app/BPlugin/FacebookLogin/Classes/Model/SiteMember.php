<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteMember
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class SiteMember extends Account{
    public $admin_password2;
//    public $game_ranking;
//    public $game_latest_ujian;
//    public $game_userpoints;
    
    var $default_read_coloms = 'admin_id,admin_email,admin_nama_depan,admin_role,admin_aktiv,admin_type';
    
    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);
    
            $return['admin_username'] = new Leap\View\InputText("hidden", "admin_username", "admin_username", $this->admin_username);
            $return['admin_ip'] = new Leap\View\InputText("hidden", "admin_ip", "admin_ip", $this->admin_ip);
            $return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);
            $return['admin_nama_depan'] = new Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan",
                    $this->admin_nama_depan);
            $return['admin_nama_belakang'] = new Leap\View\InputText("text", "admin_nama_belakang", "admin_nama_belakang",
                    $this->admin_nama_belakang);
            $return['admin_lastupdate'] = new Leap\View\InputText("hidden", "admin_lastupdate", "admin_lastupdate",
                    $this->admin_lastupdate);
            $return['admin_email'] = new Leap\View\InputText("email", "admin_email", "admin_email",
                    $this->admin_email);
            $return['admin_aktiv'] = new Leap\View\InputText("hidden", "admin_aktiv", "admin_aktiv",
                    $this->admin_aktiv);

            $return['admin_foto'] = new Leap\View\InputText("hidden", "admin_foto", "admin_foto", $this->admin_foto);
            $return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);
            
            $return['admin_role'] = new Leap\View\InputText("hidden", "admin_role", "admin_role", "normal_user");
            $return['admin_inbox_update'] = new Leap\View\InputText("hidden", "admin_inbox_update", "admin_inbox_update",
                    $this->admin_inbox_update);
            $return['admin_inbox_timestamp'] = new Leap\View\InputText("hidden", "admin_inbox_timestamp",
                    "admin_inbox_timestamp", $this->admin_inbox_timestamp);
            
            $return['admin_type'] = new Leap\View\InputText("hidden","admin_type", "admin_type", $this->admin_type);
            
            $return['admin_name'] = new Leap\View\InputText("hidden", "admin_name", "admin_name",
                    $this->admin_name);
            $return['admin_fb_id'] = new Leap\View\InputText("hidden", "admin_fb_id", "admin_fb_id",
                    $this->admin_fb_id);
            $return['admin_createdate'] = new Leap\View\InputText("hidden", "admin_createdate", "admin_createdate",
 leap_mysqldate());
            $return['admin_password'] = new Leap\View\InputText("password", "admin_password", "admin_password",
                    $this->admin_password);
            return $return;
            
       }
       public function constraints ()
	{
		//err id => err msg
		$err = array ();
                $this->admin_password2 = $_POST['admin_password2'];
		if (!isset($this->admin_email)) {
			$err['admin_email'] = Lang::t('Please Insert Email');
		}
		if (!isset($this->admin_password)) {
			$err['admin_password'] = Lang::t('Please Insert Password');
		}
                if (!isset($this->admin_password2)) {
			$err['admin_password2'] = Lang::t('Please Repeat Password');
		}
                if (!filter_var($this->admin_email, FILTER_VALIDATE_EMAIL)) {
                    $err['admin_email'] = Lang::t('Invalid Email Format');
                }
                else{
                    $ada = $this->getWhere("admin_email = '{$this->admin_email}' LIMIT 0,1");
                    if(count($ada)>0){
                        $err['admin_email'] = Lang::t('Email is already been used');
                    }
                }
		if (!isset($this->admin_nama_depan)) {
			$err['admin_nama_depan'] = Lang::t('Please Insert First Name');
		}
                if (!isset($this->admin_nama_belakang)) {
			$err['admin_nama_belakang'] = Lang::t('Please Insert Last Name');
		}
                if($this->admin_password != $this->admin_password2){
                    $err['admin_password2'] = Lang::t('Password Mismatched');
                    
                }
                if(strlen($this->admin_password)<6){
                    $err['admin_password2'] = Lang::t('Password Length must be greater than 6 words');
                }
                $this->admin_role = "normal_user";
                $this->admin_createdate = leap_mysqldate();
                $this->admin_aktiv = 1;
                $this->admin_name = $this->admin_nama_depan." ".$this->admin_nama_belakang;
                
                //cek for captcha
                  if(isset($_POST['g-recaptcha-response'])){
                    $captcha=$_POST['g-recaptcha-response'];
                  }
                  if(!$captcha){
                    $err['admin_password2'] = Lang::t('Please verify that you are not a robot');
                  }
                  else{
                    $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdkrAMTAAAAAOYusCzIFwCt420t2G8zU1nnLAG-&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
                    if($response.success==false)
                    {
                      $err['admin_password2'] = Lang::t('Please verify that you are not a robot');
                    }
                    else
                    {
                      //echo '<h2>Thanks for posting comment.</h2>';
                        //human
                    }
                  }
		return $err;
	}
        public function onCreateForm($crud_setting_object){
            $crud_setting_object = parent::onCreateForm($crud_setting_object);
            $crud_setting_object['formColoms']['repeat_password'] = new Leap\View\InputText("password", "admin_password2", "admin_password2",
                    "");
            
            return $crud_setting_object;
        }
        public static function getMyName ()
	{
		$name =
			(isset($_SESSION['account']->admin_name) ? $_SESSION['account']->admin_name : "Please Login");

		return $name;
	}
        public function saveFromJS(){
            $user = json_decode($_POST['user']);
            //pr($user);
            $json['user'] = $user;
            $json['bool'] = 0;
            
            $email = $user->email;
            $fbid = $user->id;
            $arr = $this->getWhere("admin_email = '$email' AND admin_fb_id='$fbid' AND admin_aktiv = 1 ");
            $json['aktiv'] = "admin_email = '$email' AND admin_fb_id='$fbid' AND admin_aktiv = 1 ";
            $json['arr'] = $arr;
            if(count($arr)>0){
                $json['bool'] = 1;
                $_SESSION['sementara']['admin_email'] = $email;
                $_SESSION['sementara']['admin_fb_id'] = $fbid;
            }else{
                if($user->email=="" || $user->id == "" || !isset($user->id) || !isset($user->email)){
                    $json['bool'] = 0;
                }else{
                    $fb = new SiteMember();
                    $fb->admin_email = $user->email;
                    $fb->admin_nama_depan = $user->first_name;
                    $fb->admin_nama_belakang = $user->last_name;
                    $fb->admin_fb_id = $user->id;
                    $fb->admin_createdate = leap_mysqldate();
                    $fb->admin_lastupdate = leap_mysqldate();
                    $fb->admin_role = "normal_user";
                    $fb->admin_aktiv = 1;
                    $fb->admin_name = $user->name;
                    //pr($fb);
                    $json['bool'] = $fb->save();
                    $_SESSION['sementara']['admin_email'] = $fb->admin_email;
                    $_SESSION['sementara']['admin_fb_id'] = $fb->admin_fb_id;
                    $_SESSION['sementara']['firsttime'] = 1;
                }
            }
            echo json_encode($json);
            die(); //kalau perlu saja
        }
        public function process_login_fb(){
            $email = $_SESSION['sementara']['admin_email'];
            $fbid = $_SESSION['sementara']['admin_fb_id'];
            if($fbid == "" || $email == "")Redirect::loginFailed();
            $arr = $this->getWhere("admin_email = '$email' AND admin_fb_id='$fbid' AND admin_aktiv = 1 ");
            if(count($arr)>0){
                //load by login ID
                $obj = $arr[0];
                $row = toRow($obj);

		$this->fill($row);

		if (isset($this->admin_id)) {
			$_SESSION["admin_session"] = 1;
			$_SESSION["account"] = $obj;

			//Update setlastlogin
			self::setLastUpdate($_SESSION["account"]->admin_id);
                        
                        //lanjut
                        //loading metadata
                        $meta = new AccountMeta();
                        $meta->getMeta($this->admin_id);

                        //now loading roles
                        $this->loadRole();
                        //set cookie
                        Auth::setCookie($this->rememberme, $this->admin_id, $this->admin_email, $this->admin_password);
                        
                        //kalau sukses
                        if (Auth::isLogged()) {
                                //load school setting
                                // $ss = new Schoolsetting();
                                // $ss->loadToSession();
                                //redirect
                                //Account::setRedirection ();
                                $acl = new AccountLogin();
                                Hook::processHook($acl->login_hook);
                                
                                //login hook doesnt seem to work =>bypass
                                $qp = new QuizPoints();
                                $qp->getPoints();
                                $qp->saveUnsaved();
                                
                                Redirect::firstPage();
                        } else {
                                Redirect::loginFailed();
                        }
                        
		} else {
			return 0;
		}
            }
        }
}
