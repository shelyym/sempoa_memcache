<?php

/**
 * Description of BLogger
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class BLogger extends Model {

	//Nama Table
	public $table_name = "behaviour_log";

	//Primary
	public $main_id = 'b_log_id';

	//Default Coloms for read
	public $default_read_coloms = 'b_log_id,b_log_userid,b_log_ip,b_log_url,b_log_time,b_log_action,b_timestamp,b_log_username,b_log_keterangan,b_log_userrole,b_log_user_agent,log_user_level,log_user_org';

	//allowed colom in CRUD filter
	public $coloumlist = 'b_log_userrole,b_log_user_agent,log_user_level,log_user_org,b_log_id,b_log_userid,b_log_ip,b_log_url,b_log_time,b_log_action,b_log_username,b_timestamp,b_log_keterangan';

	public $b_log_id;
	public $b_log_userid;
	public $b_log_ip;
	public $b_log_url;
	public $b_log_time;
	public $b_log_action;
	public $b_log_username;
	public $b_log_keterangan;
	public $b_timestamp;
	public $b_log_user_agent;
	public $b_log_userrole;
        public $log_user_level;
        public $log_user_org;
        

	public static function dumpSQL ()
	{
		global $db;

		$dbhost = $db->getServerPath();
		$dbuser = $db->getUsername();
		$dbpass = $db->getPassword();
		$dbname = $db->getDBName();

		$bl = new BLogger();
		$tn = $bl->table_name;
		$fname = date("Y-m-d") . ".sql";
		$backup_file = _PHOTOPATH . "logs/" . $fname;
		$pathwindows = '/opt/lampp/bin/mysqldump';
		$exec = $pathwindows .
			" --opt --no-create-info --skip-triggers -h $dbhost -u $dbuser --password=$dbpass $dbname $tn > $backup_file";
		//echo $exec;
		exec($exec);

		//"mysqldump --opt -h $dbhost -u $dbuser -p $dbpass $tn | gzip > $backup_file"
	}

	public static function dumpDataJSON ()
	{
		$bl = new BLogger();
		$arr = $bl->getAll();

		$arr2 = array ();
		foreach ($arr as $bl) {
			$new = array ();
			$new['log_id'] = $bl->b_log_id;
			$new['log_time'] = $bl->b_log_time;
			$new['log_timestamp'] = $bl->b_timestamp;
			$new['user_id'] = $bl->b_log_userid;
			$new['user_name'] = $bl->b_log_username;
			$new['user_role'] = $bl->b_log_userrole;
			$new['user_ip'] = $bl->b_log_ip;
			$new['user_url'] = $bl->b_log_url;
			$new['user_device'] = $bl->b_log_user_agent;
			$new['user_action'] = $bl->b_log_action;
			$new['user_action_note'] = $bl->b_log_keterangan;
			$arr2[] = $new;
		}
		$text = json_encode($arr2);

		$fname = date("Y-m-d") . ".json";
		$backup_file = _PHOTOPATH . "logs/" . $fname;

		$myfile = fopen($backup_file, "w") or die("Unable to open file!");

		fwrite($myfile, $text);

		fclose($myfile);
	}

	public static function dumpDataCSV ()
	{
		$bl = new BLogger();
		$arr = $bl->getAll();

		$arr2 = array ();
		$text = '';
		foreach ($arr as $bl) {
			$new = array ();
			$new['log_id'] = $bl->b_log_id;
			$new['log_time'] = $bl->b_log_time;
			$new['log_timestamp'] = $bl->b_timestamp;
			$new['user_id'] = $bl->b_log_userid;
			$new['user_name'] = $bl->b_log_username;
			$new['user_role'] = $bl->b_log_userrole;
			$new['user_ip'] = $bl->b_log_ip;
			$new['user_url'] = $bl->b_log_url;
                        $exp = explode("(", $bl->b_log_user_agent);
			$new['user_device'] = $exp[0];
			$new['user_action'] = $bl->b_log_action;
			$new['user_action_note'] = $bl->b_log_keterangan;
			$arr2[] = implode(';', $new);
		}

		$fname = date("Y-m-d") . ".csv";
		$file = fopen(_PHOTOPATH . "logs/" . $fname, "w");

		foreach ($arr2 as $line) {
			fputcsv($file, explode(';', $line));
		}

		fclose($file);
	}

	public static function addLog ($ket = "", $action = 'browse')
	{
		$bl = new BLogger();
		$bl->b_log_ip = $_SERVER['REMOTE_ADDR'];
		$bl->b_log_userid = Account::getMyID();
		$bl->b_log_time = leap_mysqldate();
		$uri = $_SERVER['REQUEST_URI'];
		$pos = strpos($uri, 'DMWeb');
		if ($pos !== false) {
			$uri = 'DMWeb';
		}
		$bl->b_log_url = $uri;
		$bl->b_log_action = $action;
		$bl->b_log_username = Account::getMyUsername();
		$bl->b_log_keterangan = $ket;
		$bl->b_timestamp = time();
		$bl->b_log_userrole = Account::getMyRole();
		$md = new \Leap\Utility\MobileDetect();
		$isMobile = $md->isMobile();
		$isTablet = $md->isTablet();
		$userAgent = $md->getUserAgent();
		$txt = "";
		if ($isMobile) {
			$txt .= "Mobile";
		} elseif ($isTablet) {
			$txt .= "Tablet";
		} else {
			$txt .= "Desktop";
		}
		$bl->b_log_user_agent = $txt . " | $userAgent";
                $bl->log_user_org = PortalHierarchy::getMyOrganization();
                $bl->log_user_level = PortalHierarchy::getMyLevel();
		$bl->save();
	}

	public static function addLogAdmin ($ket = "", $action = 'browse_admin')
	{
		$bl = new BLogger();
		$bl->b_log_ip = $_SERVER['REMOTE_ADDR'];
		$bl->b_log_userid = Account::getMyID();
		$bl->b_log_time = leap_mysqldate();
		$uri = $_SERVER['REQUEST_URI'];
		$pos = strpos($uri, 'DMWeb');
		if ($pos !== false) {
			$uri = 'DMWeb';
		}
		$bl->b_log_url = $uri;

		$bl->b_log_action = $action;
		$bl->b_log_username = Account::getMyUsername();
		$bl->b_log_keterangan = $ket;
		$bl->b_timestamp = time();

		$md = new \Leap\Utility\MobileDetect();
		$isMobile = $md->isMobile();
		$isTablet = $md->isTablet();
		$userAgent = $md->getUserAgent();
		$txt = "";
		if ($isMobile) {
			$txt .= "Mobile";
		} elseif ($isTablet) {
			$txt .= "Tablet";
		} else {
			$txt .= "Desktop";
		}
		$bl->b_log_user_agent = $txt . " | userAgent = $userAgent";
                $bl->log_user_org = PortalHierarchy::getMyOrganization();
                $bl->log_user_level = PortalHierarchy::getMyLevel();
		$bl->save();
	}

	public static function getUserOnlineLastXMinutes ($min = 10)
	{
		$newtime = time() - ($min * 60);
		$bl = new BLogger();
		$arrp = $bl->getWhere("b_timestamp > $newtime ORDER BY b_timestamp DESC");

		$arrSudah = array ();
		$dipakai = array ();
		foreach ($arrp as $log) {
			if (!in_array($log->b_log_userid, $arrSudah)) {
				$arrSudah[] = $log->b_log_userid;
				$dipakai[] = $log;
			}
		}
		$return['nr'] = count($dipakai);
		$return['unique'] = $dipakai;
		$return['all'] = $arrp;

		return $return;
	}
}
