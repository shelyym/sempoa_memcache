<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/2/15
 * Time: 7:52 PM
 */

class UploaderCrop extends WebService{

    function upload(){

        $fname = addslashes($_GET['fname']);
        $extension = addslashes($_GET['ext']);

        $src = _PHOTOPATH.$fname;

        $del = self::deleteSource($src);


//        $fname = basename($src);


        $ext = explode(".", $fname);

        $usedfname = $ext[0];

        self::saveImageComplex($_POST['croppedImage'],$usedfname);

        echo $usedfname.".".$extension;
//        pr($_POST['croppedImage']);
//        pr($_FILES);

        //delete oldfiles


        die();
    }
    static function deleteSource($src){

        $ganti = 0;


        list($iWidth,$iHeight,$type)    = getimagesize($src);

        if(strtolower(image_type_to_mime_type($type))!='image/jpeg')
        {
            $ganti = 1;

        }

        unlink($src);

        return $ganti;
    }

    static function saveImageComplex($base64img,$fname){

        $extension = addslashes($_GET['ext']);
        if($extension == "jpg"){
            $tipe_ext = "jpeg";
        }
        else{
            $tipe_ext = $extension;
        }
//        define('UPLOAD_DIR', '../uploads/');
        $base64img = str_replace('data:image/'.$tipe_ext.';base64,', '', $base64img);
        $data = base64_decode($base64img);
        $file = _PHOTOPATH . $fname . '.'.$extension;
        file_put_contents($file, $data);


        $dest = _PHOTOPATH.'thumbnail/'.$fname . '.'.$extension;
        $uploader = new Uploader();

        $params = array(
            'constraint' => array('width' => 200, 'height' => 200)
        );
        $uploader->img_resize($file, $dest ,$params);
    }


    static function saveImage($base64img){



//        define('UPLOAD_DIR', '../uploads/');
        $base64img = str_replace('data:image/jpeg;base64,', '', $base64img);
        $data = base64_decode($base64img);
        $file = _PHOTOPATH . uniqid() . '.jpg';
        file_put_contents($file, $data);
    }
} 