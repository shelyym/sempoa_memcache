<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LeapYoutube
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LeapYoutube {

	const API_KEY              = "AIzaSyBLXb0bt8rpKTBVApTCG_XnISelxK9Xeyw";
	const TBS_CHANNEL_ID       = "UCwxCKuT6rZwPj9t7hTa4luA";
	const TBS_UPLOADS_ID       = "UUwxCKuT6rZwPj9t7hTa4luA";
	const YOUTUBE_URL_PLAYLIST = "https://www.googleapis.com/youtube/v3/playlistItems";
	const YOUTUBE_URL_CHANNEL  = "https://www.googleapis.com/youtube/v3/channels?";
	const YOUTUBE_URL_VIDEO    = "https://www.youtube.com/watch?v=";
	const YOUTUBE_DISPLAY_NAME = "thebodyshopindo";


    public static function getPostswID ($userID)
    {
        $url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=".$userID."&key=".self::API_KEY;

        $ch = curl_init();

        // define options
        $optArray = array (
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true
        );

        // apply those options
        curl_setopt_array($ch, $optArray);

        // execute request and get response
        $result = curl_exec($ch);



        $playlist = json_decode($result);
//        pr($playlist);
//        die();
        $playlistID = $playlist->items[0]->contentDetails->relatedPlaylists->uploads;
//        [0].contentDetails.relatedPlaylists.uploads;




        if(isset($playlistID)){
            return self::getUploads($playlistID);
        }
        else{
            $json['bool'] = 0;
            return json_encode($json['bool']);

        }
    }

    public static function getUploads($playlistID){

        $url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$playlistID."&key=".self::API_KEY;

        $ch = curl_init();

        // define options
        $optArray = array (
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true
        );

        // apply those options
        curl_setopt_array($ch, $optArray);

        // execute request and get response
        $result = curl_exec($ch);

        return $result;
    }


	public function getPosts ()
	{
		$url = LeapYoutube::YOUTUBE_URL_PLAYLIST . "?part=snippet&playlistId="
			. LeapYoutube::TBS_UPLOADS_ID . "&key="
			. LeapYoutube::API_KEY;

		$ch = curl_init();

		// define options
		$optArray = array (
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true
		);

		// apply those options
		curl_setopt_array($ch, $optArray);

		// execute request and get response
		$result = curl_exec($ch);

		return $result;
	}

	public function getProfile ()
	{
		$url = LeapYoutube::YOUTUBE_URL_CHANNEL . "part=snippet&id="
			. LeapYoutube::TBS_CHANNEL_ID . "&key="
			. LeapYoutube::API_KEY;

		$ch = curl_init();

		// define options
		$optArray = array (
			CURLOPT_URL            => $url,
			CURLOPT_RETURNTRANSFER => true
		);

		// apply those options
		curl_setopt_array($ch, $optArray);

		// execute request and get response
		$result = curl_exec($ch);

		return $result;
	}

	public function youtubeFeed ()
	{
		$socmed = new Socmed();
		$feeds = $socmed->getFeed(Socmed::TYPE_YOUTUBE);
		$profile = $socmed->getFeed(Socmed::TYPE_YOUTUBE_PROFILE);
		?>
		<style>
			#youtubecarousel {
				height           : 70px;
				overflow         : hidden;
				/* margin-bottom : 30 px;*/
				background-color : #ffcccd;
			}

			#youtubecarousel .carousel-inner .item img {
				width  : 100%;
				height : 100%;
			}

			#youtubecarousel .item .thumbnail {
				margin-bottom : 0;
			}

			#youtubecarousel .carousel-control.left, .carousel-control.right {
				background-image : none !important;
			}

			#youtubecarousel .carousel-control {
				/*background:	#ddd;
				color:#999;
				padding: 4px 0;
				width:26px;
				top:auto;
				left:auto;
				bottom:0;
				opacity:1;
				text-shadow:none;*/
			}

			#youtubecarousel .carousel-control.right {
				/* right : 10 px;*/
				color : #002c33;
			}

			#youtubecarousel .carousel-control.left {
				/* right : 40 px;*/
				color : #002c33;
			}

			profile
			.youtubeprofile2 {
				float   : left;
				padding : 10px;
			}

			.youtubeprofile img {
				width  : 50px;
				height : 50px;
			}

			.youtubeprofile img {
				width  : 50px;
				height : 50px;
			}

			#youtubecarousel .item {
				font-weight : bold;
				color       : #0882b7;
				font-size   : 12px;
			}

			.youtubenametext a {
				font-weight     : bold;
				color           : #0882b7;
				text-decoration : underline;
			}
		</style>
		<div id="youtubecarousel">
			<div style="position:absolute; width: 20px; height: 20px; z-index: 1; margin-top: -2px;">
				<img src="<?= _SPPATH; ?>images/youtube1.png"
				     width="100%">
			</div>

			<div style="float:left; width: 35%; word-wrap: break-word;">
				<div id="youtubeprofile"
				     class="youtubeprofile2"
				     style="padding:10px;float: left;">
					<img id="youtubeprofilepic"
					     style="height: 50px; width: 50px;"
					     src="<?= $profile[0]->socmed_img_url; ?>">
				</div>
				<div class="youtubename"
				     style="margin-left: 70px; padding-top: 10px; font-size: 12px;">
					<div class="youtubenametext">
						<a target="_blank"
						   href="https://www.youtube.com/user/thebodyshopindo"><?= LeapYoutube::YOUTUBE_DISPLAY_NAME; ?></a>
					</div>
					<div style="padding-top:10px;">
						<div style="float:left;">
							<a href="#youtubeCarousel"
							   data-slide="prev"><i style="color:#002c33;"
							                        class="glyphicon glyphicon-chevron-left"></i></a>
						</div>
						<div style="float:left;">
							<a href="#youtubeCarousel"
							   data-slide="next"><i style="color:#002c33;"
							                        class="glyphicon glyphicon-chevron-right"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div style="float:left; width: 65%;">

				<div style="padding-top: 10px;">
					<!-- Carousel
							================================================== -->
					<div id="youtubeCarousel"
					     class="carousel slide"
					     data-ride="carousel">
						<!-- Indicators -->
						<div id="youtubecarouselInner"
						     class="carousel-inner">

							<?
							for ($i = 0; $i < count($feeds); $i++) {
								$feed = $feeds[$i];
								$class = "item";
								if ($i == 0) {
									$class .= " active";
								}
								?>

								<div style="cursor: pointer;"
								     class="<?= $class ?>">
									<a target="_blank"
									   href="<?= $feed->socmed_url ?>">
										<div id="youtubeprofile"
										     class="youtubeprofile2"
										     style="width: 50px; height: 50px; margin-right: 10px; float:left">
											<img id="youtubeimage"
											     style="width: 100%;"
											     src="<?= $feed->socmed_img_url; ?>">
										</div><?= setMaxChar($feed->socmed_title); ?></a></div>
							<?
							}
							?>
						</div>
					</div>
					<!-- End Carousel -->
				</div>

			</div>
			<!-- col md 8-->

			<div class="clearfix"></div>
		</div>
	<?
	}

}
