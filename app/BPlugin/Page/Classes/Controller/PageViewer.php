<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageViewer
 *
 * @author User
 */
class PageViewer extends WebApps {

	function p ()
	{
		$id = (isset($_GET['id']) ? addslashes($_GET['id']) : 0);
		if ($id) {

			$page = new Page();
			$page->getByID($id);
			if (!isset($page->post_title) || $page->post_title == '') {
				die('Not Found');
			}
                        //add channel feb 2015
//                        $a = NewsChannel::myChannels();
//                        if($page->page_channel_id>0)
//                        if(!in_array($page->page_channel_id, $a)){
//                            echo 'Not Authorize To View';
//                            return "";
//                        }
                        
			$pc = new PageContainer();
			if ($page->post_gallery_id > 0) {
				$pc->getByID($page->post_gallery_id);
			}
			$page->setSEO();
//			$gw = new GalleryWeb();
			?>
            <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">

			<h1 style="padding-bottom: 0; margin-bottom: 0; margin-bottom: 10px;"><?= stripslashes($page->post_title); ?></h1>
<!--			<div class="breadcrumbs">Pages-->
<!--				--><?// if ($page->post_gallery_id > 0) { ?><!--/-->
<!--					<a href="--><?//= _SPPATH; ?><!--pagecontainer?mode=--><?//= $pc->container_id; ?><!--">--><?//= $pc->container_name; ?><!--</a>--><?// } ?>
<!--			</div>-->

<!--			<small style="font-size: 12px;">--><?//= indonesian_date($page->post_modified); ?><!--</small>-->

			<? if ($page->post_image != "") { ?>
				<div class="bigimage"
				     style="padding-bottom: 10px;">
					<img style="width: 100%; padding-top: 20px;"
					     src="<?= _SPPATH . _PHOTOURL. $page->post_image; ?>">
				</div>
			<? } ?>

			<div class="postcontent">
				<?$content = stripslashes($page->post_content);
				$content = str_replace('#tbs_video#',
					'<video id="player_normal" width="100%" controls src="', $content);
				$content = str_replace('#/tbs_video#', '"></video>', $content);

				echo $content;
				?>
			</div>
			<? if ($page->post_files != "") {
				?>
				<div class="clearfix"
				     style="padding:  10px;">

					<h3 class="h3pv"><?= Lang::t('Attachments'); ?></h3>
				</div>
				<div style="">
				<?
				$exp = explode(",", trim(rtrim($page->post_files)));
				$arrNames = array ();
				foreach ($exp as $fil) {
					// echo $fil."<br>";
					if ($fil == "") {
						continue;
					}
					$exp2 = explode(".", $fil);
					$if = new \InputFileModel();

					// echo $exp2[0]."<br>";
					$if->getByID($exp2[0]);
					$arrNames[] = $if;
					$text .= $if->printLink();
				}
				echo $text;
				?></div><?
			}?>
			<?
			if ($page->comment_allowed) {
				?>
				<div class="clearfix"
				     style="padding:  10px;"></div>
				<?
				PageCommentWeb::beginComment($id);
			}
			// pr($page);
			/* $str = '';
			 global $template;
			 if($page->post_gallery_id != 0 || $page->post_event_id != 0){

				 if($page->post_event_id!=0){
					 $event = new Event();
					 $event->getByID($page->post_event_id);
					// pr($event);
					 $str .= '<div class="event-item"><div class="event-name">'.$event->cal_name.'</div></div>';
					 $efi = new EfiHome();
					 $_GET['eid'] = $page->post_event_id;
					 $efi->eventview(1);
				 }
				 if($page->post_gallery_id!=0){
					 $gal = new Gallery();
					 $gal->getByID($page->post_gallery_id);
					 //pr($gal);
					 $str .= '<div class="gallery-item"><div class="gallery-name">'.$gal->gallery_name.'</div></div>';
					 $efi = new EfiHome();
					 $_GET['gid'] = $page->post_gallery_id;
					 $efi->galleryview(1);
				 }
				 //$template->useSidebar = 1;
				 //$template->sideBar = $str;
			 }*/
			/*
			 ?>
			 <div class="fb-comments" data-href="http://developers.facebook.com/docs/plugins/comments/" data-width="100%" data-numposts="5" data-colorscheme="light"></div>
			 <?*/

            ?></div></div><?
		}
	}
}
