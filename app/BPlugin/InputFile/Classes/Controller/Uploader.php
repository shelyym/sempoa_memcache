<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploader
 *
 * @author User
 */
class Uploader extends WebService {
    
    /*
     *  handle uploads
     */
    function uploadres ()
    {
        //apakah ada file
        $adafile = (isset($_GET['adafile'])?$_GET['adafile']:'');
        
        //cek if ada file
        if($adafile)
        {
            if(file_exists(_PHOTOPATH . $adafile))
            {
            //delete old file
                if(unlink(_PHOTOPATH . $adafile))
                {
//                    unlink(_PHOTOPATH."thumbnail/" . $adafile);
                    //delete from log
                    PortalFileLogger::deleteFileLog (_PHOTOPATH . $adafile);


                    if(file_exists(_PHOTOPATH."thumbnail/" . $adafile))
                    {
                        chmod(_PHOTOPATH."thumbnail/" . $adafile, 0777);
                        //delete old thumb file
                        unlink(_PHOTOPATH."thumbnail/" . $adafile);
                    }
                }
                
            }
            
        }
        
        //get extendsion
        $ext = (isset($_GET['ext'])?$_GET['ext']:'jpg');
        
      //  if($ext != "png" && $ext !="gif"){
        
            

            // Read RAW data
            $data = file_get_contents('php://input');

            // Read string as an image file
            $image = file_get_contents('data://' . substr($data, 5));
      /*  }
        else{
            $fileName = $_FILES['afile']['name'];
            $fileType = $_FILES['afile']['type'];
            $fileContent = file_get_contents($_FILES['afile']['tmp_name']);
            $dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
            $image = file_get_contents($_FILES['afile']['tmp_name']);
        }*/
        
        // Generate filename
        $filename = md5(mt_rand()) . '.'.$ext;
            
        // Save to disk
        if (!file_put_contents(_PHOTOPATH . $filename, $image)) {
            header('HTTP/1.1 503 Service Unavailable');
            exit();
        }

        //diresize spy bisa jadi kecilan
//        $src = _PHOTOPATH.$filename;
//        $dest = _PHOTOPATH."medium_".$filename;
//        $this->make_thumb($src, $dest, 600);



        $src = _PHOTOPATH.$filename;
        $dest = _PHOTOPATH.'thumbnail/'.$filename;
        $this->make_thumb($src, $dest, 800);


        $dest2 = _PHOTOPATH."medium/".$filename;
        $params = array(
            'constraint' => array('width' => 400, 'height' => 800)
        );
        $this->img_resize($src, $dest2, $params);

        // Clean up memory
        unset($data);
        unset($image);

        if(isset($_SESSION['target_id']['obj']))
            $target = get_class($_SESSION['target_id']['obj']);
        else
            $target = "unknown";

        $namaasli = $_GET['fname'];
        PortalFileLogger::save2log(_PHOTOPATH . $filename,$target,$namaasli);

        // Return file URL
        echo $filename;
        //exit();

    }
    public function uploadres_ext(){
        
        //apakah ada file
        $adafile = (isset($_GET['adafile'])?$_GET['adafile']:'');
        
        //cek if ada file
        if($adafile)
        {
            $if = new InputFileModel();
            $uploadpath = _PHOTOPATH;
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
                    if(file_exists(_PHOTOPATH.'thumbnail/' . $adafile))
                    {
                        //delete old thumb file
                        unlink(_PHOTOPATH.'thumbnail/' . $adafile);
                    }
                }
                
            }
            
        }
        
        $data = array();
        //$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));
        $data['files'] = $_GET['files'];
        $data['bool'] = 0;
        $dc = new InputFileModel();
        
        if(isset($_GET['files']))
        {  
                
                
                    $error = false;
                    $files = array();
                    $uploaddir = _PHOTOPATH;
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
                                // if pdf
                                
                                if(move_uploaded_file($file['tmp_name'], $uploaddir .$f->file_filename))
                                {
                                        $files[] = $uploaddir .$file['name'];
                                        $f->file_size = filesize($uploaddir .$f->file_filename);
                                        
                                        
                                        $f->load = 1;
                                        $data['bool'] = $f->save();
                                        $data['isImage'] = Leap\View\InputFile::isImage($f->file_filename);
                                        $data['filename'] = $f->file_filename;
                                        
                                        $src2 = _PHOTOPATH.$f->file_filename;
//                                        $dest2 = _PHOTOPATH.'thumbnail/'.$f->file_filename;
//                                        $this->make_thumb($src2, $dest2, 800);

                                        $dest2 = _PHOTOPATH."medium/".$f->file_filename;
                                        $params = array(
                                            'constraint' => array('width' => 800, 'height' => 800)
                                        );
                                        if($this->img_resize($src2, $dest2, $params)){
                                            rename($dest2,$src2);
                                        }

        
                                        if(isset($_SESSION['target_id']['obj']))
                                            $target = get_class($_SESSION['target_id']['obj']);
                                        else
                                            $target = "inputfile_unknown";

                                        PortalFileLogger::save2log($uploaddir .$f->file_filename,$target,$f->file_url);
        
                                        die(json_encode($data));
                                }
                                else
                                {
                                    $error = true;
                                }
                            }
                    }
                $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        }
        else
        {
                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        echo json_encode($data);
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
            if(imagejpeg($virtual_image, $dest)){
                if(unlink($src)){
                    copy($dest, $src);
                }
            }
        }
	
        
    }
    
    public function uploadfiles(){
        
        //apakah ada file
        $adafile = (isset($_GET['adafile'])?$_GET['adafile']:'');
        
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
                    /*if(file_exists(_PHOTOPATH.'thumbnail/' . $adafile))
                    {
                        //delete old thumb file
                        unlink(_PHOTOPATH.'thumbnail/' . $adafile);
                    }*/
                }
                
            }
            
        }
        
        $data = array();
        //$tid = (isset($_GET['tid'])?addslashes($_GET['tid']):die('no ID'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));
        $data['files'] = $_GET['files'];
        $data['bool'] = 0;
        $dc = new InputFileModel();
        
        if(isset($_GET['files']))
        {  
                
                
                    $error = false;
                    $files = array();
                    $uploaddir = $dc->upload_location;
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
                                // if pdf
                                
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
                                        
                                        $f->load = 1;
                                        $data['bool'] = $f->save();
                                        $data['isImage'] = Leap\View\InputFile::isImage($f->file_filename);
                                        $data['filename'] = $f->file_filename;
                                        
                                        if(isset($_SESSION['target_id']['obj']))
                                            $target = get_class($_SESSION['target_id']['obj']);
                                        else
                                            $target = "inputfile_unknown";

                                        PortalFileLogger::save2log($uploaddir .$f->file_filename,$target,$f->file_url);
        
                                        die(json_encode($data));
                                }
                                else
                                {
                                    $error = true;
                                }
                            }
                    }
                $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files);
        }
        else
        {
                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        echo json_encode($data);
    }


    /**
     * Images scaling
     * @param string  $ini_path Path to initial image.
     * @param string $dest_path Path to save new image.
     * @param array $params [optional] Must be an associative array of params
     * $params['width'] int New image width.
     * $params['height'] int New image height.
     * $params['constraint'] array.$params['constraint']['width'], $params['constraint'][height]
     * If specified the $width and $height params will be ignored.
     * New image will be resized to specified value either by width or height.
     * $params['aspect_ratio'] bool If false new image will be stretched to specified values.
     * If true aspect ratio will be preserved an empty space filled with color $params['rgb']
     * It has no sense for $params['constraint'].
     * $params['crop'] bool If true new image will be cropped to fit specified dimensions. It has no sense for $params['constraint'].
     * $params['rgb'] Hex code of background color. Default 0xFFFFFF.
     * $params['quality'] int New image quality (0 - 100). Default 100.
     * @return bool True on success.
     */

    function img_resize($ini_path, $dest_path, $params = array()) {
        $width = !empty($params['width']) ? $params['width'] : null;
        $height = !empty($params['height']) ? $params['height'] : null;
        $constraint = !empty($params['constraint']) ? $params['constraint'] : false;
        $rgb = !empty($params['rgb']) ?  $params['rgb'] : 0xFFFFFF;
        $quality = !empty($params['quality']) ?  $params['quality'] : 100;
        $aspect_ratio = isset($params['aspect_ratio']) ?  $params['aspect_ratio'] : true;
        $crop = isset($params['crop']) ?  $params['crop'] : true;

        if (!file_exists($ini_path)) return false;


        if (!is_dir($dir=dirname($dest_path))) mkdir($dir);

        $img_info = getimagesize($ini_path);
        if ($img_info === false) return false;

        $ini_p = $img_info[0]/$img_info[1];
        if ( $constraint ) {
            $con_p = $constraint['width']/$constraint['height'];
            $calc_p = $constraint['width']/$img_info[0];

            if ( $ini_p < $con_p ) {
                $height = $constraint['height'];
                $width = $height*$ini_p;
            } else {
                $width = $constraint['width'];
                $height = $img_info[1]*$calc_p;
            }
        } else {
            if ( !$width && $height ) {
                $width = ($height*$img_info[0])/$img_info[1];
            } else if ( !$height && $width ) {
                $height = ($width*$img_info[1])/$img_info[0];
            } else if ( !$height && !$width ) {
                $width = $img_info[0];
                $height = $img_info[1];
            }
        }

        preg_match('/\.([^\.]+)$/i',basename($dest_path), $match);
        $ext = $match[1];
        $output_format = ($ext == 'jpg') ? 'jpeg' : $ext;

        $format = strtolower(substr($img_info['mime'], strpos($img_info['mime'], '/')+1));
        $icfunc = "imagecreatefrom" . $format;

        $iresfunc = "image" . $output_format;

        if (!function_exists($icfunc)) return false;

        $dst_x = $dst_y = 0;
        $src_x = $src_y = 0;
        $res_p = $width/$height;
        if ( $crop && !$constraint ) {
            $dst_w  = $width;
            $dst_h = $height;
            if ( $ini_p > $res_p ) {
                $src_h = $img_info[1];
                $src_w = $img_info[1]*$res_p;
                $src_x = ($img_info[0] >= $src_w) ? floor(($img_info[0] - $src_w) / 2) : $src_w;
            } else {
                $src_w = $img_info[0];
                $src_h = $img_info[0]/$res_p;
                $src_y    = ($img_info[1] >= $src_h) ? floor(($img_info[1] - $src_h) / 2) : $src_h;
            }
        } else {
            if ( $ini_p > $res_p ) {
                $dst_w = $width;
                $dst_h = $aspect_ratio ? floor($dst_w/$img_info[0]*$img_info[1]) : $height;
                $dst_y = $aspect_ratio ? floor(($height-$dst_h)/2) : 0;
            } else {
                $dst_h = $height;
                $dst_w = $aspect_ratio ? floor($dst_h/$img_info[1]*$img_info[0]) : $width;
                $dst_x = $aspect_ratio ? floor(($width-$dst_w)/2) : 0;
            }
            $src_w = $img_info[0];
            $src_h = $img_info[1];
        }

        $isrc = $icfunc($ini_path);
        $idest = imagecreatetruecolor($width, $height);
        if ( ($format == 'png' || $format == 'gif') && $output_format == $format ) {
            imagealphablending($idest, false);
            imagesavealpha($idest,true);
            imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
            imagealphablending($isrc, true);
            $quality = 0;
        } else {
            imagefill($idest, 0, 0, $rgb);
        }
        imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        $res = $iresfunc($idest, $dest_path, $quality);

        imagedestroy($isrc);
        imagedestroy($idest);

        return $res;
    }
}
