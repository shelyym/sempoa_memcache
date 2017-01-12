<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputFileWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class InputFileWeb extends WebService {

	public function show ()
	{
		$url = $_GET['gurl'];
		$id = addslashes($_GET['id']);
		if ($id < 0) {
			die("no ID");
		}
                //Log
                BLogger::addLog("file_id = $id", "open_file");
		//echo $url;echo "<br>";
		//echo $id;
                $auth = 1;
		$if = new InputFileModel();
		if ($url == "dm") {
			$if = new DocumentsPortal();
			//cek parent id ada 2 "company policy"
                        /*
			$d = new DMWeb();
			$arrCHild2 = $d->findChildren(2);
			$arrCHild = explode(",", $arrCHild2);
                         * 
                         */
			//pr($arrCHild);
                        //Perbaikan 27 Feb 2015
                        // Cek parents terluarnya apakah dia saveable
                        $if->getByID($id);
                        //grand grand parents- init folder - folder awal
			$InitparentsFolder = $if->findInitParent();
                        
                        //folder simpannya
			$terletakDiFolder = new DocumentsPortalFolder();
                        $terletakDiFolder->getByID($if->file_folder_id);
                        //pr($InitparentsFolder);
                        
                        //cek KMType nya
                        //untuk cek channel
                        /*
                        * LOAD page con, cek apakah bisa ini sub atau main con
                        */
                       $a = NewsChannel::myChannels();
                       //pr($a);
                       /*foreach($a as $chn){
                           $str = " page_channel_id = '$chn' ";
                           $imp[] = $str;
                       }
                       $wherechannel = implode("OR", $imp);
                       $wherechannel = "(".$wherechannel.")";
                       */
                       $kmtype = new KMType();
                       $arrKMTYPE = $kmtype->getWhere("km_folder_id = '{$InitparentsFolder->folder_id}'");
                       //kalau punya channel id nya
                       if(in_array($arrKMTYPE[0]->webapps_channel_id, $a)){
                           //boleh masuk
                       }else{
                           if($_SESSION['DocumentPortal_view_only']<1){
                               
                           }else{
                           //nggak boleh lihat
                           $auth = 0;
                           }
                           //die('Not Authorized To View this Documents');
                       }
		}
                
                if($auth){
                    $if->getByID($id);
                    /*
                     * cek folder if apakah ada di child
                     */
                    //if ($if->file_folder_id == 2 || in_array($if->file_folder_id, $arrCHild)) {
                    if(!$InitparentsFolder->folder_saveable){
                            $if->bolehsave = "reg"; //nosave
                    } else {
                            $if->bolehsave = "als"; //save
                    }
                    //pr($if);
                    $path = _SPPATH . $if->upload_url;
                    $fil = $if->file_filename;
                    $inp = new \Leap\View\InputFile();

                    if (in_array($if->file_ext, $inp->arrImgExt)) {
                            $this->showImage($if);
                    } elseif (in_array($if->file_ext, $inp->arrVideoExt)) {
                            $this->showVideo($if);
                    } elseif ($if->file_ext == "pdf") {
                            $this->showPDF($if);
                    } else {
                            $this->showDefault($if);
                    }
                }else{
                    ?>
<h2><?=Lang::t('Not Authorized to view this documents');?></h2>    
                    <?
                    
                } //else auth
	}

	function showDefault ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
                
		?>
		<!--<div class="col-md-8">
			<a href="<?= $path . $fil; ?>"><?= $if->file_url; ?></a>
		</div>
                -->
		<?
		$this->fmenu($if);
	}

	function fmenu ($if)
	{
		$acc = new Account();
		$acc->getByID($if->file_author);
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		?>
		<div class="col-md-4">
			<h3 class="h3pv"
			    style="width: 100%; overflow: hidden;"><?= $if->file_url; ?></h3>

			<div class="metadata"><?=Lang::t('Author');?> : <?= $acc->admin_nama_depan; ?> </div>
			<div class="metadata"><?=Lang::t('Size');?> : <?= formatSizeUnits($if->file_size); ?> </div>
			<div class="metadata"><?=Lang::t('Date');?> : <?= indonesian_date($if->file_date); ?> </div>
			<?
			$inp = new \Leap\View\InputFile();
			if (in_array($if->file_ext, $inp->arrVideoExt)) {
				?>
				<!--				<div class="metadata">Embed Code : <br/>--><?//= '#tbs_video#' . _BPATH . $if->upload_url . $if->file_filename .
//					'#/tbs_video#'
				?><!--</div>-->
				<div class="clone-url open"
				     data-protocol-type="subversion"
				     data-url="/users/set_protocol?protocol_selector=subversion&amp;protocol_type=clone">
					Embed Code :

					<div class="input-group js-zeroclipboard-container">
						<input type="text"
						       class="input-mini input-monospace js-url-field js-zeroclipboard-target"
						       value="<?= '#tbs_video#' . _BPATH . $if->upload_url . $if->file_filename .
						       '#/tbs_video#' ?>"
						       readonly="readonly" />
					</div>
				</div>
			<?
			}
			?>
			<? if ($if->file_ext == "pdf") {
				?>
				<?/*<button style="margin-top: 10px;"
				        onclick="window.open('<?= _SPPATH; ?>js/ViewerJS/leappdf.php?nn=<?= $if->file_url; ?>&dd=<?= $if->bolehsave; ?>#<?= base64_encode($path .
					        $if->file_filename); ?>.pdf','_blank');"
				        class="btn btn-primary"><?= Lang::t('Open'); ?></button>*/?>
			<?
			} else {
				?>
				<button style="margin-top: 10px;"
				        onclick="window.open('<?= $path . $fil; ?>','_blank');"
				        class="btn btn-primary"><?= Lang::t('Open'); ?></button>
			<?
			}
			//pr($if);
			?>
		</div>
	<?
	}

	function showImage ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		$inp = new \Leap\View\InputFile();
		?>
		<div class="col-md-8">

			<div style="padding: 10px; text-align: center;">
				<img src="<?= $path . $fil; ?>"
				     class="img-responsive">
			</div>
		</div>

		<?
		$this->fmenu($if);
	}

	function showVideo ($if)
	{
		$path = _SPPATH . $if->upload_url;
		$fil = $if->file_filename;
		?>
		<div class="col-md-8">
			<div style="padding: 10px;">
				<video width="100%"
				       controls>
					<source src="<?= $path . $fil; ?>"
					        type="video/<?= $if->file_ext; ?>">
				</video>
			</div>
		</div>

		<?
		$this->fmenu($if);
	}

	function showPDF ($if)
	{
            
                $_SESSION['if_files'] = $if;
            
		//check if ada thumb
		$path = _SPPATH . $if->upload_url;
		$tpath = $if->upload_location;
		$thumb = $tpath . "thumbs/" . $if->file_id . ".jpg";
		//echo $thumb;
		if (file_exists($thumb)) {
			$thumburl = $path . "thumbs/" . $if->file_id . ".jpg";
		}
                
                
		?>
		<div class="col-md-8">
                    <!--<embed src="<?=$path .$if->file_filename;?>" width="100%" height="500">-->
                    <embed src="<?=_SPPATH;?>InputFileWeb/printPDF" width="100%" height="500">
                    <!--<?=$path .$if->file_filename;?>-->
			<?/*<div style="padding: 10px; text-align: center;">
				<!--        <img src="--><? //=$thumburl;?><!--" class="img-responsive" >-->
				<!-- <iframe style="width: 100%;" src="<?= $path . $if->file_filename ?>"></iframe>-->
				<iframe src="<?= _SPPATH; ?>js/ViewerJS/leappdf.php?nn=<?= $if->file_url; ?>&dd=<?= $if->bolehsave; ?>#<?= base64_encode($path .
					$if->file_filename); ?>.pdf"
				        width='400'
				        height='300'
				        allowfullscreen
				        webkitallowfullscreen></iframe>
			</div>*/
                        
                        
                        
                        ?>
		</div>

		<?
		$this->fmenu($if);
	}
        
        function printPDF(){
            $if = $_SESSION['if_files'];
            $tpath = $if->upload_location;
            $file = $tpath.$if->file_filename;
            $fp = fopen($file,"r") ;
            header("Content-Type: ".$mimeTypes[$ext]);
           // header('Content-Disposition: attachment; filename="'.$if->file_url.'"');

            // reads file and send the raw code to browser     
            while (! feof($fp)) {
                $buff = fread($fp,4096);
                echo $buff;
            }
            // closes file after whe have finished reading it
            fclose($fp);
            die();    
        }
}
