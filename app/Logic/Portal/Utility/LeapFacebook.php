<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facebook
 *
 * @author User
 */
class LeapFacebook {

	function getPosts ()
	{
		$pageID = "TheBodyShopIndonesia";

		$ch = curl_init();

		// define options
		$optArray = array (
			CURLOPT_URL            => 'https://graph.facebook.com/' . $pageID .
				'/posts?access_token=813358842042407|e6UwfhiTH90YUrhDnJqOp2owgfE',
			CURLOPT_RETURNTRANSFER => true
		);

		// apply those options
		curl_setopt_array($ch, $optArray);

		// bypass SSL cert
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		// execute request and get response
		$result = curl_exec($ch);

		return $result;
	}

    public static function getPostswID ($pageID = "takeprize")
    {
//        $pageID = "TheBodyShopIndonesia";

        $ch = curl_init();

        // define options
        $optArray = array (
            CURLOPT_URL            => 'https://graph.facebook.com/' . $pageID .
                '/posts?fields=full_picture,name&access_token=813358842042407|e6UwfhiTH90YUrhDnJqOp2owgfE',
            CURLOPT_RETURNTRANSFER => true
        );

        // apply those options
        curl_setopt_array($ch, $optArray);

        // bypass SSL cert
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // execute request and get response
        $result = curl_exec($ch);

        return $result;
    }

	public function getFacebookProfile ()
	{
		$pageID = "TheBodyShopIndonesia";

		return "https://graph.facebook.com/$pageID/picture?access_token=813358842042407|e6UwfhiTH90YUrhDnJqOp2owgfE";
	}

	function facebookfeed ()
	{

		$pageID = "TheBodyShopIndonesia";

		$socmed = new Socmed();
		$feeds = $socmed->getFeed(Socmed::TYPE_FACEBOOK);
		$profile = $socmed->getFeed(Socmed::TYPE_FACEBOOK_PROFILE);
		?>

		<style>
			#fbcarousel {
				height           : 70px;
				overflow         : hidden;
				/*margin-bottom : 30 px;*/
				background-color : #dfe3ee;
			}

			#fbcarousel .carousel-inner .item img {
				width  : 100%;
				height : 100%;
			}

			#fbcarousel .item .thumbnail {
				margin-bottom : 0;
			}

			#fbcarousel .carousel-control.left, .carousel-control.right {
				background-image : none !important;
			}

			#fbcarousel .carousel-control {
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

			#fbcarousel .carousel-control.right {
				/*right : 10 px;8?
				color : #002c33;
			}

			#fbcarousel .carousel-control.left {
				/*right : 40px;*/
				color : #002c33;
			}

			profile .fbprofile2 {
				float   : left;
				padding : 10px;
				width   : 50px;
				height  : 50px;
			}

			.fbprofile img {
				width  : 50px;
				height : 50px;
			}

			#fbcarousel .item {
				font-weight : bold;
				color       : #3b5998;
				font-size   : 12px;
			}

			.fbnametext a {
				font-weight     : bold;
				color           : #3b5998;
				text-decoration : underline;
			}
		</style>
		<div id="fbcarousel">
			<div style="position:absolute; width: 20px; height: 20px; z-index: 1; margin-top: -2px;">
				<img src="<?= _SPPATH; ?>images/fb1.png"
				     width="100%">
			</div>
			<div style="float:left; width: 40%; word-wrap: break-word;">
				<div id="fbprofile"
				     class="fbprofile2"
				     style="padding:10px;float: left;">
					<img id="fbprofilepic"
					     width="50px"
					     height="50px"
					     src="<?= $profile[0]->socmed_img_url; ?>">
				</div>
				<div class="fbname"
				     style="margin-left: 70px; padding-top: 10px; font-size: 12px;">
					<div class="fbnametext">
						<a target="_blank"
						   href="http://www.facebook.com/<?= $pageID; ?>"><?= $pageID; ?></a>
					</div>
					<div style="padding-top:10px;">
						<div style="float:left;">
							<a href="#myCarousel"
							   data-slide="prev"><i style="color:#002c33;"
							                        class="glyphicon glyphicon-chevron-left"></i></a>
						</div>
						<div style="float:left;">
							<a href="#myCarousel"
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
					<div id="myCarousel"
					     class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<div id="fbCarouselInner"
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

	function fetchUrl ($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		// You may need to add the line below
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

		$retData = curl_exec($ch);
		curl_close($ch);

		return $retData;
	}
}
