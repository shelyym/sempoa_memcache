<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of videoFeedWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Socmed extends WebService {

	const TYPE_FACEBOOK         = 1;
	const TYPE_TWITTER          = 2;
	const TYPE_YOUTUBE          = 3;
	const TYPE_FACEBOOK_PROFILE = 4;
	const TYPE_TWITTER_PROFILE  = 5;
	const TYPE_YOUTUBE_PROFILE  = 6;
	const CHANNEL_ID            = 1;
	const FB_POST_IMG           = "tbs_fb_img";

	/*
	 * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
	 * untuk mengisi calendar
	 */
	public function SocmedPortal ()
	{
		//create the model object
		$cal = new SocmedPortal();

		//send the webclass
		$webClass = __CLASS__;

		//run the crud utility
		Crud::run($cal, $webClass);
	}

	public function getSocmedFeed ()
	{
		$fbFeed = $this->getFeed(self::TYPE_FACEBOOK);
		$twFeed = $this->getFeed(self::TYPE_TWITTER);
		$youtubeFeed = $this->getFeed(self::TYPE_YOUTUBE);
		if($youtubeFeed){
			$youtubeFeed = array_reverse($youtubeFeed);
		}

		$arrResult = array ();
		$arrResult['facebook_feed'] = $fbFeed;
		$arrResult['twitter_feed'] = $twFeed;
		$arrResult['youtube_feed'] = $youtubeFeed;

		print_r($arrResult);
	}

	public function getFeed ($socmedType)
	{
		$ch = new NewsChannel();
		$ch->getDefaultChannel();
		$cat = (isset($_GET['cat']) ? addslashes($_GET['cat']) : $ch->channel_id);

		$limit = 10;

		$np = new SocmedPortal();
		$arrEv = $np->getByChannel($cat,
			" and socmed_type = $socmedType ORDER BY socmed_id DESC LIMIT 0,$limit");


		return $arrEv;
	}

	public function updateFeed ()
	{
		// Update facebook
		$fb = new LeapFacebook();
		$fbFeeds = $fb->getPosts();
		$fbFeeds = $this->parseFacebookResponse($fbFeeds);
		$fbProfile = $fb->getFacebookProfile();
		$fbProfile = $this->parseFacebookProfile($fbProfile);

		// Update twitter
		$tw = new LeapTwitter();
		$twFeeds = $tw->getTweets();
		$twFeeds = $this->parseTwitterResponse($twFeeds);

		$twProfile = $tw->getProfile();
		$twProfile = $this->parseTwitterProfile($twProfile);

		// Update youtube
		$youtube = new LeapYoutube();
		$youtubeFeeds = $youtube->getPosts();
		$youtubeFeeds = $this->parseYoutubeResponse($youtubeFeeds);

		$youtubeProfile = $youtube->getProfile();
		$youtubeProfile = $this->parseYoutubeProfile($youtubeProfile);

		$arr = array ();
		$arr["facebook"] = empty($fbFeeds) ? "fail" : "success";
		$arr["facebook_profile"] = empty($fbProfile) ? "fail" : "success";
		$arr["twitter"] = empty($twFeeds) ? "fail" : "success";
		$arr["twitter_profile"] = empty($twProfile) ? "fail" : "success";
		$arr["youtube"] = empty($youtubeFeeds) ? "fail" : "success";
		$arr["youtube_profile"] = empty($youtubeProfile) ? "fail" : "success";

		print_r(json_encode($arr));
	}

	public function parseFacebookResponse ($response)
	{
		$arr = array ();

		$obj = json_decode($response);

		foreach ($obj->data as $item) {
			$i = new SocmedPortal();
			$i->socmed_post_id = substr($item->id, strpos($item->id, "_") + 1, strlen($item->id));

			if (count($i->getWhere('socmed_post_id like "' . $i->socmed_post_id . '"')) == 0) {
				$i->socmed_title = $this->setMaxChar($item->message);
				$i->socmed_url = "https://www.facebook.com/TheBodyShopIndonesia/posts/" . $i->socmed_post_id;
				$i->socmed_type = Socmed::TYPE_FACEBOOK;
				$i->news_channel_id = Socmed::CHANNEL_ID;

				if ($i->socmed_title) {
					$arr[] = $i;
					$i->save();
				}
			}
		}

		return $arr;
	}

	public function parseFacebookProfile ($response)
	{
		$i = new SocmedPortal();
		$arr = $i->getWhere('socmed_post_id like "' . Socmed::FB_POST_IMG . '"');
		if (count($arr) > 0) {
			$i = $arr[0];
		} else {
			$i = new SocmedPortal();
		}

		$i->socmed_img_url = $response;
		$i->socmed_post_id = Socmed::FB_POST_IMG;
		$i->socmed_type = Socmed::TYPE_FACEBOOK_PROFILE;
		$i->news_channel_id = Socmed::CHANNEL_ID;

		$i->save();

		return $i;
	}

	public function parseTwitterResponse ($response)
	{
		$arr = array ();

		$obj = json_decode($response);

		foreach ($obj as $item) {
			$i = new SocmedPortal();
			if (count($i->getWhere('socmed_post_id like "' . $item->id . '"')) == 0) {
				$i->socmed_post_id = $item->id;
				$i->socmed_title = $this->setMaxChar($item->text);
				$i->socmed_url = "https://twitter.com/" . $item->user->screen_name . "/status/" . $i->socmed_post_id;
				$i->socmed_type = Socmed::TYPE_TWITTER;
				$i->news_channel_id = Socmed::CHANNEL_ID;

				$arr[] = $i;
				$i->save();
			}
		}

		return $arr;
	}

	public function parseTwitterProfile ($response)
	{
		$obj = json_decode($response);
		$i = new SocmedPortal();
		if (count($i->getWhere('socmed_post_id like "' . $obj->id . '"')) == 0) {
			$i->socmed_post_id = $obj->id;
			$i->socmed_title = $obj->screen_name;
			$i->socmed_url = $obj->url;
			$i->socmed_img_url = $obj->profile_image_url;
			$i->socmed_type = Socmed::TYPE_TWITTER_PROFILE;
			$i->news_channel_id = Socmed::CHANNEL_ID;

			$i->save();
		}

		return $i;
	}

	public function parseYoutubeResponse ($response)
	{
		$arr = array ();

		$obj = json_decode($response);

		foreach ($obj->items as $item) {
			$i = new SocmedPortal();
			if (count($i->getWhere('socmed_post_id like "' . $item->id . '"')) == 0) {
				$i->socmed_post_id = $item->id;

				$post = $item->snippet;
				$i->socmed_title = $this->setMaxChar($post->title);
				$i->socmed_text = $this->setMaxChar($post->description);
				$i->socmed_img_url = $post->thumbnails->default->url;
				$i->socmed_url = "https://www.youtube.com/watch?v=" . $post->resourceId->videoId;
				$i->socmed_type = Socmed::TYPE_YOUTUBE;
				$i->news_channel_id = Socmed::CHANNEL_ID;

				$arr[] = $i;
				$i->save();
			}
		}

		return $arr;
	}

	public function parseYoutubeProfile ($response)
	{
		$obj = json_decode($response);

		foreach ($obj->items as $item) {
			$i = new SocmedPortal();
			if (count($i->getWhere('socmed_post_id like "' . $item->id . '"')) == 0) {
				$i->socmed_post_id = $item->id;

				$snippet = $item->snippet;
				$i->socmed_title = $snippet->title;
				$i->socmed_img_url = $snippet->thumbnails->default->url;
				$i->socmed_type = Socmed::TYPE_YOUTUBE_PROFILE;
				$i->news_channel_id = Socmed::CHANNEL_ID;

				$i->save();
			}

			return $i;
		}
	}

	public function setMaxChar ($text)
	{
		// Jangan di potong di sini
//		$maxChar = 150;
//		$text = str_replace("'", "\\'", $text);
//
//		if (strlen($text) > $maxChar) {
//			return substr($text, 0, $maxChar - 1) . '...';
//		}

		return $text;
	}
}
