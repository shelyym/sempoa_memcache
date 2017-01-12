<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UploaderMultiples
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class UploaderMultiples extends WebService{

    public function uploadfiles(){
        $data = array();
        //$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));

        $dc = new InputFileModel();

        if(isset($_GET['files']))
        {


            $error = false;
            $files = array();
            $uploaddir = $dc->upload_location;
            $arrSuc = array();
            $arrSucAsli = array();
            foreach($_FILES as $file)
            {
                $f = new InputFileModel();
                $q = "INSERT INTO {$f->table_name} SET file_folder_id = '0',file_author = '".Account::getMyID()."'";
                global $db;
                $fid = $db->qid($q);
                $f->getByID($fid);
                if($fid){
                    $newname  = $fid;
                    $f->file_url = basename($file['name']);
                    $ext = end((explode(".", $file['name'])));
                    $f->file_ext = $ext;
                    $f->file_filename = $fid.".".$ext;
                    $f->file_date = leap_mysqldate();
                    if(move_uploaded_file($file['tmp_name'], $uploaddir .$f->file_filename))
                    {
                        $files[] = $uploaddir .$file['name'];
                        $f->file_size = filesize($uploaddir .$f->file_filename);
                        if($f->file_ext == "pdf"){
                            $a = new PDF2Text();
                            $a->setFilename($uploaddir.$f->file_filename);
                            $a->decodePDF();
                            $f->file_isi = preg_replace( "/\r|\n/", " ", $a->output() );

                            //the path to the PDF file
                            $strPDF = $uploaddir.$f->file_filename;
                            $thumb = $uploaddir."thumbs/".$fid.".jpg";
                            exec("convert \"{$strPDF}[0]\" \"{$thumb}\"");
                        }
                        // if pdf
                        $arrSuc[] = $f->file_filename;
                        $arrSucAsli[] = "<div id='file_".$fid."_{$t}' class='mlt_item'>".$f->file_url." <i onclick=\"deleteFromList_{$t}('".$f->file_filename."');\" class='glyphicon glyphicon-remove'></i></div>";


                        $f->load = 1;
                        $f->save();

                        if(isset($_SESSION['target_id']['obj']))
                            $target = get_class($_SESSION['target_id']['obj']);
                        else
                            $target = "inputfile_unknown";

                        PortalFileLogger::save2log($uploaddir .$f->file_filename,$target,$f->file_url);

                    }
                    else
                    {
                        $error = true;
                    }
                }
            }
            $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files,'ftext'=>implode(",",$arrSuc),'ftextAsli'=>implode(" ",$arrSucAsli));
        }
        else
        {
            $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        echo json_encode($data);
    }

    public function del(){
        //apakah ada file
        $adafile = (isset($_POST['id'])?$_POST['id']:'');

        //cek if ada file
        if($adafile)
        {
            $if = new InputFileModel();
            $uploadpath = $if->upload_location;
            if(file_exists($uploadpath . $adafile))
            {
                //delete old file
                if(unlink($uploadpath . $adafile))
                {
                    $arrf = $if->getWhere("file_filename = '$adafile' LIMIT 0,1");
                    if(count($arrf)>0){
                        $if->delete($arrf[0]->file_id);
                    }
                    //delete from log
                    PortalFileLogger::deleteFileLog ($uploadpath . $adafile);
                    //delete thumbs
                    if(file_exists($uploadpath."thumbs/" . $adafile))
                    {
                        //delete old thumb file
                        unlink($uploadpath."thumbs/" . $adafile);
                    }
                }

            }

        }
    }
    public function uploadfiles_gallery(){
        $data = array();
        //$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));

        $dc = new InputFileModel();

        if(isset($_GET['files']))
        {


            $error = false;
            $files = array();
            $uploaddir = $dc->upload_location;
            $arrSuc = array();
            $arrSucAsli = array();
            foreach($_FILES as $file)
            {
                $f = new InputFileModel();
                $q = "INSERT INTO {$f->table_name} SET file_folder_id = '0',file_author = '".Account::getMyID()."'";
                global $db;
                $fid = $db->qid($q);
                $f->getByID($fid);
                if($fid){
                    $newname  = $fid;
                    $f->file_url = basename($file['name']);
                    $ext = end((explode(".", $file['name'])));
                    $f->file_ext = $ext;
                    $f->file_filename = $fid.".".$ext;
                    $f->file_date = leap_mysqldate();

                    $ifn = new \Leap\View\InputFile();
                    if(in_array($ext, $ifn->arrImgExt)){
                        $isImage = 1;
                    }
                    else{
                        $isImage = 0;
                        $error = true;
                    }


                    if($isImage)
                        if(move_uploaded_file($file['tmp_name'], $uploaddir .$f->file_filename))
                        {
                            $files[] = $uploaddir .$file['name'];
                            $f->file_size = filesize($uploaddir .$f->file_filename);
                            /*
                             * thumbnail
                             */
                            $src = $uploaddir.$f->file_filename;
                            $dest = $uploaddir.'thumbs/'.$f->file_filename;
                            $this->make_thumb($src, $dest, 200);

                            $f->load = 1;
                            $f->save();

                            $arrSuc[] = $f->file_filename;

                            $fil=trim(rtrim($f->file_filename));
                            $fil2 = explode(".",$fil);
                            $fil3 = $fil2[0];

                            $arrSucAsli[] = "<div id='file_".$fid."_{$t}' class='mlt_item_gal'><div id='gal_$fil3' class='foto100gal'><span class='helper'></span><img ondblclick='makeasmainpic_".$t."(\"$fil\");' src='"._SPPATH.$f->upload_url.$f->file_filename."'></div>".$f->file_url." <i onclick=\"deleteFromList_{$t}('".$f->file_filename."');\" class='glyphicon glyphicon-remove'></i></div>";


                            if(isset($_SESSION['target_id']['obj']))
                                $target = get_class($_SESSION['target_id']['obj']);
                            else
                                $target = "inputfile_unknown";

                            PortalFileLogger::save2log($uploaddir .$f->file_filename,$target,$f->file_url);

                        }
                        else
                        {
                            $error = true;
                        }
                }
            }
            $data = ($error) ? array('error' => 'There was an error uploading your files, make sure your file is an image file') : array('files' => $files,'ftext'=>implode(",",$arrSuc),'ftextAsli'=>implode(" ",$arrSucAsli));
        }
        else
        {
            $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        echo json_encode($data);
    }
    public function uploadfiles_gallery_sortable(){
        $data = array();
        //$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));

        $dc = new InputFileModel();

        if(isset($_GET['files']))
        {


            $error = false;
            $files = array();
            $uploaddir = $dc->upload_location;
            $arrSuc = array();
            $arrSucAsli = array();

            $royErrArr = array();

            foreach($_FILES as $file)
            {
                $f = new InputFileModel();
                $q = "INSERT INTO {$f->table_name} SET file_folder_id = '0',file_author = '".Account::getMyID()."'";
                global $db;
                $fid = $db->qid($q);
                $f->getByID($fid);
                if($fid){
                    $newname  = $fid;
                    $f->file_url = basename($file['name']);
                    $ext = end((explode(".", $file['name'])));
                    $f->file_ext = $ext;
                    $f->file_filename = $fid.".".$ext;
                    $f->file_date = leap_mysqldate();

                    $ifn = new \Leap\View\InputFile();
                    if(in_array($ext, $ifn->arrImgExt)){
                        $isImage = 1;

                    }
                    else{
                        $isImage = 0;
                        $error = true;
                    }

                    $royErrArr[$fid]["isImage"] = $isImage;
                    $royErrArr[$fid]['path'] = $file['tmp_name']." to : ". $uploaddir .$f->file_filename;

                    if($isImage)
                        if(move_uploaded_file($file['tmp_name'], $uploaddir .$f->file_filename))
                        {

                            $royErrArr[$fid]['move'] = 1;


                            $files[] = $uploaddir .$file['name'];
                            $f->file_size = filesize($uploaddir .$f->file_filename);
                            /*
                             * thumbnail
                             */
                            $src = $uploaddir.$f->file_filename;
                            $dest = $uploaddir.'thumbs/'.$f->file_filename;
                            $this->make_thumb($src, $dest, 200);

                            $f->load = 1;
                            $f->save();

                            $royErrArr[$fid]['makethumb_n_save'] = 1;

                            $arrSuc[] = $f->file_filename;

                            $fil=trim(rtrim($f->file_filename));
                            $fil2 = explode(".",$fil);
                            $fil3 = $fil2[0];

//                                $arrSucAsli[] = "<div id='file_".$fid."_{$t}' class='mlt_item_gal'><div id='gal_$fil3' class='foto100gal'><span class='helper'></span><img ondblclick='makeasmainpic_".$t."(\"$fil\");' src='"._SPPATH.$f->upload_url.$f->file_filename."'></div>".$f->file_url." <i onclick=\"deleteFromList_{$t}('".$f->file_filename."');\" class='glyphicon glyphicon-remove'></i></div>";
//                            $arrSucAsli[] = "<div id='file_".$fid."_{$t}' class='mlt_item_gal'><div id='gal_$fil3' class='foto100gal'><span class='helper'></span><img ondblclick='makeasmainpic_".$t."(\"$fil\");' src='"._SPPATH.$f->upload_url.$f->file_filename."'></div> <i onclick=\"deleteFromList_{$t}('".$f->file_filename."');\" class='glyphicon glyphicon-remove'></i></div>";
                            $arrSucAsli[] = '<li class="ui-state-default">
                    <img class="gallerysortable" src="'._SPPATH.$f->upload_url.$f->file_filename.'">
</li>';

                            if(isset($_SESSION['target_id']['obj']))
                                $target = get_class($_SESSION['target_id']['obj']);
                            else
                                $target = "inputfile_unknown";

//                            PortalFileLogger::save2log($uploaddir .$f->file_filename,$target,$f->file_url);

                            $royErrArr[$fid]['end'] = 1;
                        }
                        else
                        {
                            $error = true;
                        }
                }
            }
            $data = ($error) ? array('ff'=>$_FILES,'royErrArr'=>$royErrArr,'error' => 'There was an error uploading your files, make sure your file is an image file') : array('files' => $files,'ftext'=>implode(",",$arrSuc),'ftextAsli'=>implode(" ",$arrSucAsli));
        }
        else
        {
            $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        echo json_encode($data);
    }
    function make_thumb_old($src, $dest, $desired_width) {

        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }
    function make_thumb($src, $dest, $desired_width) {

        /*findout the type */
        $fname = basename($src);
        $ext = end((explode(".", $fname)));

        if($ext == "gif"){
            $source_image = imagecreatefromgif($src);
        }
        elseif($ext == "png"){
            $source_image = imagecreatefrompng($src);
        }
        elseif($ext == "bmp"){
            $source_image = imagecreatefromwbmp($src);
        }
        else{
            /* read the source image */
            $source_image = imagecreatefromjpeg($src);
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        if($ext == "gif"){
            imagegif($virtual_image, $dest);
        }
        elseif($ext == "png"){
            imagepng($virtual_image, $dest);
        }
        elseif($ext == "bmp"){
            imagewbmp($virtual_image, $dest);
        }
        else{
            /* read the source image */
            imagejpeg($virtual_image, $dest);
        }


    }
}
