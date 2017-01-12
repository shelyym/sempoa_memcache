<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 1:15 PM
 */

class ModalRegistor {

    var $modals = array();
    var $croppermodals = array();

    var $aboveBGBlur = array();

    public function regCropper($id,$modal_title,$InputToUpdate,$value,$ratio = "0:0",$imgIDToBeUpdated = array() ,$onSuccessJS = '' ){
            //is not good ..but enough for now

        $cp = new Cropper($id,$modal_title,$InputToUpdate,$value,$ratio,$imgIDToBeUpdated,$onSuccessJS);
        $this->croppermodals[] = $cp;
    }

    public function printCropperModal(){
        foreach($this->croppermodals as $cp){

            Cropper::createModal($cp->id,$cp->modal_title,$cp->InputToUpdate,$cp->value,$cp->ratio,$cp->imgIDToBeUpdated,$cp->onSuccessJS);
        }
    }

    public function addAboveBGBlur($arr){

        $this->aboveBGBlur[] = $arr;
    }

    public function printAboveBGBlur(){


        foreach($this->aboveBGBlur as $arrClass){
            $cname = $arrClass[0];
            $fname = $arrClass[1];

            $new = new $cname();
            $new->$fname();

        }

    }
} 