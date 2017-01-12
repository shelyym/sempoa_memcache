<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:18 PM
 */

class TypeA extends AppContentTemplate{

    public $name = "Page";
    public $isSingular = 0;
    public $content;
    public $icon = "ic_file.png";


    public function p(){
        echo "this is for print";
    }
    public function createForm(){

        $onSuccessJS = "location.reload();";
        $onFailedJS = "removeBGBlack();";


        //disini cek kalau ada id yang cucok lgs kirim ke printForm


        $ta = new TypeAModelDraft();

        $id = $ta->selectID($this->content->content_id);
        $dariLuar = 0;

        $ta->a_title = $this->name;
        $ta->printForm($this->content,$id,$onSuccessJS,$onFailedJS,$dariLuar);
    }

} 