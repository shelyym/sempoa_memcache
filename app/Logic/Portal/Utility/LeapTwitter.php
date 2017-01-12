<?php

/**
 * Created by PhpStorm.
 * User: MarcelSantoso
 * Date: 11/13/14
 * Time: 9:54 AM
 */
class LeapTwitter {

	const API_KEY              = 'odZA0VZjAmI979P0BkR0D1zSD';
	const API_SECRET           = 'BycRhYZI8QAd62BAD8ewtl5QNi2X42G67uCeEnaLexCFKMaI4A';
	const ACCESS_TOKEN         = '426602306-ed5dNZPMXl6H0nb9qzAmJdUftIRZhMHuPEuR9yoK';
	const ACCESS_TOKEN_SECRET  = 'Q8hYUHEKe5CCOEYkDGTsmheTdorlKePu9Z3oWogDLRAS3';
	const TWITTER_TIMELINE     = "https://api.twitter.com/1.1/statuses/user_timeline.json?";
	const TWITTER_IMG          = "https://api.twitter.com/1.1/users/show.json?";
	const TWITTER_DISPLAY_NAME = "thebodyshopindo";
	const TWITTER_COUNT        = 10;

	public function initTweets ()
	{
		$twitter = new TwitterOAuth(LeapTwitter::API_KEY,
			LeapTwitter::API_SECRET,
			LeapTwitter::ACCESS_TOKEN,
			LeapTwitter::ACCESS_TOKEN_SECRET);

		$url = LeapTwitter::TWITTER_TIMELINE . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME . "&count=" .
			LeapTwitter::TWITTER_COUNT;
		$urlImg = LeapTwitter::TWITTER_IMG . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME;
	}

	public function getTweets ()
	{
		$twitter = new TwitterOAuth(LeapTwitter::API_KEY,
			LeapTwitter::API_SECRET,
			LeapTwitter::ACCESS_TOKEN,
			LeapTwitter::ACCESS_TOKEN_SECRET);

		$url = LeapTwitter::TWITTER_TIMELINE . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME . "&count=" .
			LeapTwitter::TWITTER_COUNT;
		$urlImg = LeapTwitter::TWITTER_IMG . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME;

		return json_encode($twitter->get($url));
	}

    public static function getTweetswID ($pageID = 'thebodyshopindo')
    {
        $twitter = new TwitterOAuth(LeapTwitter::API_KEY,
            LeapTwitter::API_SECRET,
            LeapTwitter::ACCESS_TOKEN,
            LeapTwitter::ACCESS_TOKEN_SECRET);

        $url = LeapTwitter::TWITTER_TIMELINE . "screen_name=" . $pageID . "&count=" .
            LeapTwitter::TWITTER_COUNT;
        $urlImg = LeapTwitter::TWITTER_IMG . "screen_name=" . $pageID;

        return json_encode($twitter->get($url));
    }

	public function getProfile ()
	{
		$twitter = new TwitterOAuth(LeapTwitter::API_KEY,
			LeapTwitter::API_SECRET,
			LeapTwitter::ACCESS_TOKEN,
			LeapTwitter::ACCESS_TOKEN_SECRET);

		$url = LeapTwitter::TWITTER_TIMELINE . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME . "&count=" .
			LeapTwitter::TWITTER_COUNT;
		$urlImg = LeapTwitter::TWITTER_IMG . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME;

		return json_encode($twitter->get($urlImg));
	}

	function twitterFeed ()
	{
		$twitter = new TwitterOAuth(LeapTwitter::API_KEY,
			LeapTwitter::API_SECRET,
			LeapTwitter::ACCESS_TOKEN,
			LeapTwitter::ACCESS_TOKEN_SECRET);

		$url = LeapTwitter::TWITTER_TIMELINE . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME . "&count=" .
			LeapTwitter::TWITTER_COUNT;
		$urlImg = LeapTwitter::TWITTER_IMG . "screen_name=" . LeapTwitter::TWITTER_DISPLAY_NAME;

		$socmed = new Socmed();
		$feeds = $socmed->getFeed(Socmed::TYPE_TWITTER);
		$profile = $socmed->getFeed(Socmed::TYPE_TWITTER_PROFILE);
		?>
		<style>
			#twittercarousel {
				height           : 70px;
				overflow         : hidden;
			/ / margin-bottom : 30 px;
				background-color : #deeef8;
			}

			#twittercarousel .carousel-inner .item img {
				width  : 100%;
				height : 100%;
			}

			#twittercarousel .item .thumbnail {
				margin-bottom : 0;
			}

			#twittercarousel .carousel-control.left, .carousel-control.right {
				background-image : none !important;
			}

			#twittercarousel .carousel-control {
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

			#twittercarousel .carousel-control.right {
			/ / right : 10 px;
				color : #002c33;
			}

			#twittercarousel .carousel-control.left {
			/ / right : 40 px;
				color : #002c33;
			}

			profile
			.twitterprofile2 {
				float   : left;
				padding : 10px;
			}

			.twitterprofile img {
				width  : 50px;
				height : 50px;
			}

			.twitterprofile img {
				width  : 50px;
				height : 50px;
			}

			#twittercarousel .item {
				font-weight : bold;
				color       : #0882b7;
				font-size   : 12px;
			}

			.twitternametext a {
				font-weight     : bold;
				color           : #0882b7;
				text-decoration : underline;
			}
		</style>
		<div id="twittercarousel">
			<div style="position:absolute; width: 20px; height: 20px; z-index: 1; margin-top: -2px;">
				<img src="<?= _SPPATH; ?>images/twitter1.png"
				     width="100%">
			</div>
			<div style="float:left; width: 40%; word-wrap: break-word;">
				<div id="twitterprofile"
				     class="twitterprofile2"
				     style="padding:10px;float: left;">
					<img id="twitterprofilepic"
					     style="height: 50px; width: 50px;"
					     src="<?= $profile[0]->socmed_img_url; ?>">
				</div>
				<div class="twittername"
				     style="margin-left: 70px; padding-top: 10px; font-size: 12px;">
					<div class="twitternametext">
						<a target="_blank"
						   href="https://twitter.com/thebodyshopindo">@<?= LeapTwitter::TWITTER_DISPLAY_NAME; ?></a>
					</div>
					<div style="padding-top:10px;">
						<div style="float:left;">
							<a href="#twCarousel"
							   data-slide="prev"><i style="color:#002c33;"
							                        class="glyphicon glyphicon-chevron-left"></i></a>
						</div>
						<div style="float:left;">
							<a href="#twCarousel"
							   data-slide="next"><i style="color:#002c33;"
							                        class="glyphicon glyphicon-chevron-right"></i></a>
						</div>
					</div>
				</div>
			</div>

			<div style="float:left; width: 60%;">

				<div style="padding: 10px;">
					<!-- Carousel
							================================================== -->
					<div id="twCarousel"
					     class="carousel slide"
					     data-ride="carousel">
						<!-- Indicators -->
						<div id="twittercarouselInner"
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
									<a target="_blank" href="<?= $feed->socmed_url ?>"><?= setMaxChar($feed->socmed_title); ?></a></div>
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