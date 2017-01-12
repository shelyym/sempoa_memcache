<?php

/**
 * Description of NewsChannel
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class NewsChannel extends Model {

	//Nama Table
	public $table_name = "sp_websetting__channel";

	//Primary
	public $main_id = 'channel_id';

	//Default Coloms for read
	public $default_read_coloms = 'channel_id,channel_name,channel_active,channel_type';

	//allowed colom in CRUD filter
	public $coloumlist         = 'channel_id,channel_name,channel_active,channel_default,channel_type';
	public $channel_id;
	public $channel_name;
	public $channel_active;
	public $channel_default;
	public $channel_type;
	public $channel_type_array = array ("content" => "Content",
	                                    "webapps" => "WebApps");

	/*
	* fungsi untuk ezeugt select/checkbox
	*
	*/
	public function overwriteForm ($return, $returnfull)
	{
		//$return  = parent::overwriteForm($return, $returnfull);

		$return['channel_active'] = new Leap\View\InputSelect($this->arrayYesNO, "channel_active", "channel_active",
			$this->channel_active);
//        $return['channel_default'] = new Leap\View\InputSelect($this->arrayYesNO, "channel_default", "channel_default",
//            $this->channel_default);
		$return['channel_default'] =
			new \Leap\View\InputText("hidden", "channel_default", "channel_default", $this->channel_default);
		$return['channel_type'] = new Leap\View\InputSelect($this->channel_type_array, "channel_type", "channel_type",
			$this->channel_type);

		return $return;
	}

	public function constraints ()
	{
		//err id => err msg
		$err = array ();

		if (!isset($this->channel_name)) {
			$err['channel_name'] = Lang::t('Title cannot be empty');
		}

		if (!isset($this->channel_type)) {
			$err['channel_type'] = Lang::t('channel_type cannot be empty');
		}

		if (!isset($this->channel_active)) {
			$err['channel_active'] = Lang::t('channel_active cannot be empty');
		}

		return $err;
	}

	public function overwriteRead ($return)
	{
		$return = parent::overwriteRead($return);

		$objs = $return['objs'];
		foreach ($objs as $obj) {
			if (isset($obj->channel_active)) {
				$obj->channel_active = $this->arrayYesNO[$obj->channel_active];
			}
			if (isset($obj->channel_default)) {
				$obj->channel_default = $this->arrayYesNO[$obj->channel_default];
			}
		}

		return $return;
	}

	/*
	 * return first channel default
	 */
	public function getDefaultChannel ()
	{
		global $db;
		$q = "SELECT * FROM {$this->table_name} WHERE channel_default = 1 LIMIT 0,1";
		$obj = $db->query($q, 1);
		$this->fill(toRow($obj));
	}

	/*
	 * is subscribe
	 */
	public static function isSubscribe ($cat)
	{
		return in_array($cat, $_SESSION['newsfeed']);
	}

	/*
	 * mychannels
	 */
	public static function myChannels ()
	{
		return $_SESSION['newsfeed'];
	}

	/*
	 * load subscription saat login
	 */
	public function loadSubscription ()
	{
		//get all channels
		$channel = new NewsChannel();
		$arrChannel = $channel->getWhere("channel_active = 1");

		//get my level and org
		$org = RoleOrganization::getMy();
		$lvl = RoleLevel::getMy();

		foreach ($arrChannel as $chn) {

			$id = $chn->channel_id . "_" . $org->organization_id;
			$n = new NewsChannel2Org();
			$n->getByID($id);

			if (isset($n->c2d_level_id) && $lvl->level_id >= $n->c2d_level_id && $n->c2d_level_id) {
				$_SESSION['newsfeed'][] = $chn->channel_id;
			}

		}

	}
}
