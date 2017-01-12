<?php

/**
 * Description of Account
 * Account manages user login account
 *
 * @author Elroy Hardoyo
 */
class Account extends Model {

	//Nama Table
	public $table_name = "sp_admin_account";

	//Primary
	var $main_id = 'admin_id';

	//Default Coloms
	var $default_read_coloms = 'admin_id,admin_username,admin_nama_depan,admin_role,admin_aktiv,admin_type';

	var $rememberme;
	var $role2role_table = "sp_role2role";
	var $role2acc_table  = "sp_role2account";

	/*
	 *  Colom di Database
	 */
	var $admin_id;
	var $admin_username;
	var $admin_password;
	var $admin_lastupdate;
	var $admin_ip;
	var $admin_aktiv;
	var $admin_email;
	var $admin_inbox;
	var $admin_nama_depan;
	var $admin_nama_belakang;
	var $admin_foto;
	var $admin_role;

    var $admin_org_type;
    var $admin_org_id;

//	var $admin_inbox_update;
//	var $admin_inbox_timestamp;
	var $admin_type;
//	var $admin_ldap;
    var $admin_reg_date;

    var $admin_hash;

//    var $admin_creditcardID;
//    var $admin_marketer;
//
//    var $admin_phone;
//    var $admin_isAgent;
//    var $admin_npwp;
//    var $admin_ktp;
//
//    var $admin_bank;
//    var $admin_bank_acc;
//    var $admin_bank_kcu;
//
//    var $admin_total_paid_sales;
//    var $admin_total_free_sales;
//
//    var $admin_bank_acc_name;
    var $admin_webpassword;


	/*
	 * Role Based Access Control
	 */
	var $roles = array ();

	//allowed colom in database
	var $coloumlist = "admin_username,admin_password,admin_lastupdate,admin_reg_date,admin_aktiv,admin_allowed_ip,admin_email,admin_role,admin_type,admin_hash,admin_marketer,admin_phone,admin_isAgent,admin_npwp,admin_ktp,admin_bank,admin_bank_acc,admin_bank_kcu,admin_total_paid_sales,admin_total_free_sales,admin_bank_acc_name,admin_webpassword,admin_org_type,admin_org_id";

    var $crud_webservice_allowed = "admin_username,admin_password,admin_lastupdate,admin_reg_date,admin_aktiv,admin_allowed_ip,admin_email,admin_role,admin_type,admin_hash,admin_marketer,admin_phone,admin_isAgent,admin_npwp,admin_ktp,admin_bank,admin_bank_acc,admin_bank_kcu,admin_total_paid_sales,admin_total_free_sales,admin_bank_acc_name,admin_webpassword";
	public $save_hook = array ();

	public function save ($onDuplicateKey = 0)
	{
		$var = parent::save($onDuplicateKey);
                //pr($this);
		if ($var) {
			$acc = new Account();
                        
                        $load = (isset($this->load) ? addslashes($this->load) : 0);
                        if(!$load)
                            $acc->getByID($var);
                        else {
                            $mainValue = $this->admin_id;
                            $acc = $this;
                        }
                        
			$role2Acc = new Role2Account();
                        $arr = $role2Acc->getWhere("role_admin_id = '{$acc->admin_id}'");
                        //pr($arr);
                        if(count($arr)>0){
                            //sudah ada role2acc nya
                            $role2Acc = $arr[0];
                            $role2Acc->load = 1;
                            //$role2Acc->role_admin_id = $var;
                            $role2Acc->role_id = $acc->admin_role;
                            //$role2Acc->account_username = $acc->admin_username;
                        }else{
                            //belum ada role2acc nya
                            //$role2Acc = $arr[0];
                            //$role2Acc->load = 1;
                            $role2Acc->role_admin_id = $var;
                            $role2Acc->role_id = $acc->admin_role;
                            $role2Acc->account_username = $acc->admin_username;
                        }
                        

			//process Hook just in case
			Hook::processHook($this->save_hook);

			return $role2Acc->save();
		}
	}

	public static function getMyName ()
	{
		$name =
			(isset($_SESSION['account']->admin_nama_depan) ? $_SESSION['account']->admin_nama_depan : "Please Login");

		return $name;
	}

	public static function getMyRole ()
	{
		$name = (isset($_SESSION['account']->admin_role) ? $_SESSION['account']->admin_role : "No");

		return $name;
	}

	public static function getMyRoles ()
	{
		return $_SESSION['roles'];
	}

	public static function getMyUsername ()
	{
		$name = (isset($_SESSION['account']->admin_username) ? $_SESSION['account']->admin_username : 0);

		return $name;
	}

	public static function getMyPassword ()
	{
		$name = (isset($_SESSION['account']->admin_password) ? $_SESSION['account']->admin_password : 0);

		return $name;
	}

	public static function getMyIDwithCheck ()
	{
		$name = self::getMyID();
		if ($name == 0) {
			die('Login First');
		}

		return $name;
	}

	public static function getMyID ()
	{
		$name = (isset($_SESSION['account']->admin_id) ? $_SESSION['account']->admin_id : 0);

		return $name;
	}

	public static function getMyLastUpdate ()
	{
		$name =
			(isset($_SESSION['account']->admin_lastupdate) ? $_SESSION['account']->admin_lastupdate : "long time ago");

		return $name;
	}

	public static function getMyKelas ($ta)
	{
		$kelas = (isset($_SESSION['myKelas' . $ta]->kelas_id) ? $_SESSION['myKelas' . $ta] : 'no');
		if ($kelas == 'no') {
			//kalau belum punya kelas
			$murid = new Murid();
			$murid->default_read_coloms = "murid_id,nama_depan,foto";
			$murid->getByAccountID(Account::getMyID());
			$kelas = $murid->getMyKelas($ta);
			$_SESSION['myKelas' . $ta] = $kelas;
		}

		return $kelas;
	}

	public static function setRedirection ()
	{
		/*$account = $_SESSION['account'];
		switch ($_SESSION['account']->admin_role) {
			case "admin":
				//loadData
				$accountRole = new Admin();
				$accountRole->getByAccountID($account->admin_id);
				break;
			case "supervisor":
				$accountRole = new Supervisor();
				$accountRole->getByAccountID($account->admin_id);

				break;
			case "tatausaha":
				$accountRole = new Tatausaha();
				$accountRole->getByAccountID($account->admin_id);

				break;
			case "guru":
				$accountRole = new Guru();
				$accountRole->getByAccountID($account->admin_id);

				break;
			default:
				$accountRole = new Murid();
				$accountRole->getByAccountID($account->admin_id);
		}
		//fill the data of the Role
		$accountRole->fill(toRow($account));
		//$account->admin_role;
		$_SESSION['account'] = $accountRole;*/
		//setRedirection
		Redirect::firstPage();

	}

	/*
	 * get name
	 */

	public static function makeMyFoto ($size = 45)
	{
		$src = Account::getMyFoto();
		Account::printFoto($src, $size);
	}

	public static function makeMyFoto100percent ($src = "")
	{
		if ($src == "") {
			$src = Account::getMyFoto();
		}
		?>
		<img src="<?= $src; ?>"
		     style="width: 100%;"><?
	}

	public static function getMyFoto ()
	{
		$name = (isset($_SESSION['account']->admin_foto) ? $_SESSION['account']->admin_foto : "");
		if ($name == "foto" || $name == "") {
			return "images/noimage.jpg";
		}

		return _PHOTOURL . $name;
	}

	public static function getMyFotoAcc ($src)
	{
		//$name = (isset($_SESSION['account']->admin_foto) ? $_SESSION['account']->admin_foto : "");
		if ($src == "foto" || $src == "") {
			return "images/noimage.jpg";
		}

		return _PHOTOURL . $src;
	}

	/*
	 * Update lastupdate
	 */

	public static function makeFotoIterator ($src, $size = 45)
	{
		$acc = new Account();
		$src2 = $acc->getFoto($src);
		Account::printFoto($src2, $size);
	}

	/*
	 * insert New Role get called in modelaccount
	 */

	public function getName ()
	{
		return $this->admin_nama_depan;
	}

	/*
	 * delete role
	 */

	public function loadByUserLogin ()
	{
		//get parameters
		$username = $this->admin_username;
//		$password = $this->admin_password;
        $password = $this->admin_password;
		$rememberme = $this->rememberme;
		$ldap = $this->admin_ldap;

		//checksyarat
		if (!isset($username) || !isset($password)) {
			Redirect::loginFailed();
		}

		//load from db
		global $db;
		if (!$ldap) {
			$sql =
				"SELECT * FROM {$this->table_name} WHERE (admin_username = '$username' OR admin_email = '$username') AND admin_aktiv = 1 ";
		} else {
			$sql =
				"SELECT * FROM {$this->table_name} WHERE (admin_username = '$username' OR admin_email = '$username') AND admin_aktiv = 1 ";
		}

		$obj = $db->query($sql, 1);

		$row = toRow($obj);

		$this->fill($row);





		if (hash_equals($this->admin_webpassword, crypt($password, $this->admin_webpassword))) {
			$_SESSION["admin_session"] = 1;
			$_SESSION["account"] = $obj;

			//Update setlastlogin
			return self::setLastUpdate($_SESSION["account"]->admin_id);
		} else {
			return 0;
		}
	}

	/*
	 * Load role, called in auth
	 */

	public static function setLastUpdate ($id)
	{
		if (!isset($id)) {
			die('Id empty setLastLogin');
		}

		//insert Logger
		$logger = new AccountLogger();
		$logger->process_log($id);

		global $db;
		$acc = new Account();
		$sql = "UPDATE {$acc->table_name} SET admin_lastupdate =now(),admin_ip = '" . $_SERVER["REMOTE_ADDR"] .
			"' WHERE admin_id = '{$id}'";

		return $db->query($sql, 0);
	}


	public function insertNewRole ()
	{
		global $db;
		$q = "INSERT INTO {$this->role2acc_table} SET "
			. "role_admin_id = '{$this->admin_id}', "
			. "role_id = '{$this->admin_role}', "
			. "account_username = '{$this->admin_username}'";

		return $db->query($q, 0);
	}

	/*
	 * getFoto
	 */

	public function deleteRole ($id)
	{
		if (!isset($id)) {
			return 0;
		} else {
			if ($id < 0) {
				return 0;
			}
			if ($id == '') {
				return 0;
			}
		}
		global $db;
		$q = "DELETE FROM {$this->role2acc_table} WHERE role_admin_id = '$id'";

		//echo $q;
		return $db->query($q, 0);
	}

	/*
	 * printFoto
	 */

	public function loadRole ()
	{

		global $db;

		//getRoles
		$r2a = new Role2Account();
		$role2acc = $r2a->getRoles($this->admin_id);

		$_SESSION["roles"] = array ();
		foreach ($role2acc as $x) {
			$role = $x->role_id;

			if (!in_array($role, $_SESSION["roles"]) && isset($role)) {
				$_SESSION["roles"][] = $role;
			}
		}

		/*
		 * LOAD smaller roles
		 */
		$r2r = new Role2Role();

		$udahdi = array ();
		$sem = (sizeof($_SESSION['roles']) ? $_SESSION["roles"] : array ());
		while (sizeof($sem) > 0) {
			$r = array_pop($sem);
			if (!in_array($r, $udahdi)) {

				$role2role = $r2r->getSmallerRoles($r);
				foreach ($role2role as $ri) {
					if (!in_array($ri->role_small, $_SESSION["roles"]) && $ri->role_small != "") {
						$_SESSION["roles"][] = $ri->role_small;
						$sem[] = $ri->role_small;
					}
				}
				$udahdi[] = $r;
			}
		}
		$this->roles = $_SESSION['roles'];

	}

	/*
	 * makeMyFoto
	 */

	public function makeFoto ($size = 45)
	{
		$src = $this->getFoto();
		Account::printFoto($src, $size);
	}

	/*
	 * printFoto
	 */

	public function getFoto ($src = "")
	{
		if ($src == "") {
			$src = $this->admin_foto;
		}

		return Leap\View\InputFoto::getFoto($src);
	}

	/*
	 * printFotoIterator
	 */

	public static function printFoto ($src, $size)
	{
		$classname = "img-rounded";
		if ($size == "responsive") {
			$classname = "img-responsive";
		}
		if ($size == "responsive") {
			?>
			<div class="foto<?= $size; ?>">
				<img src="<?= _SPPATH . $src; ?>"
				     class="<?= $classname; ?>"
				     style="width: 100%;">
			</div>
		<?
		} else {
			?>
			<style type="text/css">
				.foto <?=$size;?> {
					width    : <?=$size;?>px;
					height   : <?=$size;?>px;
					overflow : hidden;
				}

				.foto <?=$size;?> img {
				}
			</style>
			<div class="foto<?= $size; ?>">
				<img src="<?= _SPPATH . $src; ?>"
				     class="<?= $classname; ?>"
				     onload="OnImageLoad(event,<?= $size; ?>);">
			</div>
		<?
		}
	}

	/*
	 * fungsi untuk ezeugt select/checkbox
	 *
	 */

	public function overwriteForm ($return, $returnfull)
	{
		$return['admin_ip'] = new Leap\View\InputText("hidden", "admin_ip", "admin_ip", $this->admin_ip);
		$return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);
		$return['admin_nama_depan'] = new Leap\View\InputText("text", "admin_nama_depan", "admin_nama_depan",
			$this->admin_nama_depan);
		$return['admin_nama_belakang'] = new Leap\View\InputText("hidden", "admin_nama_belakang", "admin_nama_belakang",
			$this->admin_nama_belakang);
		$return['admin_lastupdate'] = new Leap\View\InputText("hidden", "admin_lastupdate", "admin_lastupdate",
			$this->admin_lastupdate);
		$return['admin_email'] = new Leap\View\InputText("email", "admin_email", "admin_email",
			$this->admin_email);
		$return['admin_aktiv'] = new Leap\View\InputSelect($this->arrayYesNO, "admin_aktiv", "admin_aktiv",
			$this->admin_aktiv);

		$return['admin_foto'] = new Leap\View\InputText("hidden", "admin_foto", "admin_foto", $this->admin_foto);
		$return['admin_inbox'] = new Leap\View\InputText("hidden", "admin_inbox", "admin_inbox", $this->admin_inbox);
		$role = new Role();
		$arrroles = $role->getWhere("role_active =1");
		foreach ($arrroles as $rr) {
			$arrRole[$rr->role_id] = Lang::t($rr->role_id);
		}
		$return['admin_role'] = new Leap\View\InputSelect($arrRole, "admin_role", "admin_role", $this->admin_role);
		$return['admin_inbox_update'] = new Leap\View\InputText("hidden", "admin_inbox_update", "admin_inbox_update",
			$this->admin_inbox_update);
		$return['admin_inbox_timestamp'] = new Leap\View\InputText("hidden", "admin_inbox_timestamp",
			"admin_inbox_timestamp", $this->admin_inbox_timestamp);
		$arrType = ['admin', 'user', 'store'];
		$return['admin_type'] = new Leap\View\InputSelect($arrType, "admin_type", "admin_type", $this->admin_type);

		return $return;
	}

	/*
	 * waktu read alias diganti objectnya/namanya
	 */
	public function overwriteRead ($return)
	{
		$objs = $return['objs'];
		foreach ($objs as $obj) {
			if (isset($obj->admin_aktiv)) {
				$obj->admin_aktiv = $this->arrayYesNO[$obj->admin_aktiv];
			}

			$arrType = ['admin', 'user', 'store'];
			$obj->admin_type = $arrType[$obj->admin_type];

		}

		//pr($return);
		return $return;
	}

	/*
	 * batasin wktu sebelum save
	 */
	public function constraints ()
	{
		//err id => err msg
		$err = array ();

		if (!isset($this->admin_username)) {
			$err['admin_username'] = Lang::t('err admin_username empty');
		}
		if (!isset($this->admin_password)) {
			$err['admin_password'] = Lang::t('err admin_password empty');
		}

		/*if (!isset($this->admin_id)) {
			$err['admin_username'] = Lang::t('Create New User Not Allowed');
		}*/

		return $err;
	}

	/*
	 * ganti pic, kalau punya dia juga ganti yang di session
	 */
	public function changePic ()
	{
		$id = (isset($_GET['uid']) ? addslashes($_GET['uid']) : 'no');
		$file = (isset($_GET['file']) ? addslashes($_GET['file']) : 'foto');

		if ($id == "no") {
			die("No UID");
		}
		if (Account::getMyID() == $id) {
			//punya sendiri
			$_SESSION['account']->admin_foto = $file;
		}

		$acc = new Account();
		$acc->getByID($id);
		$acc->admin_foto = $file;
		$acc->load = 1;
		$acc->save();
	}

	/*
	 * mychannels
	 */
	public static function getMyChannels ()
	{
		if (class_exists("NewsChannel")) {
			return NewsChannel::myChannels();
		} else {
			return array ();
		}
	}

    public static function getMyPulsa ()
    {
        $name = (isset($_SESSION['account']->admin_pulsa) ? $_SESSION['account']->admin_pulsa : 0);

        return $name;
    }

    public static function getAccountObject ()
    {
        $name = (isset($_SESSION['account']) ? $_SESSION['account'] : 0);

        return $name;
    }

    public function getByUsername ($username, $readcoloums = "*")
    {
        global $db;
        $q = "SELECT $readcoloums FROM {$this->table_name} WHERE admin_username = '$username'";
        $obj = $db->query($q, 1);
        $row = toRow($obj);
        $this->fill($row);
        $this->load = 1;
    }

    public static function cryptPassword($password){

        // A higher "cost" is more secure but consumes more processing power
        $cost = 10;

// Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

// Prefix information about the hash so PHP knows how to verify it later.
// "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $cost) . $salt;

// Value:
// $2a$10$eImiTXuWVxfM37uY4JANjQ==

// Hash the password with the salt
        $hash = crypt($password, $salt);

        return $hash;
    }

    public static function updateHash ($id)
    {
        if (!isset($id)) {
            die('Id empty setLastLogin');
        }

        $salt = rand(0,1000);
        $hash = md5(time().$id.$salt);

        global $db;
        $acc = new Account();
        $sql = "UPDATE {$acc->table_name} SET admin_hash = '$hash' WHERE admin_id = '{$id}'";

        if($db->query($sql, 0))
            return $hash;
        else
            return 0;
    }
}