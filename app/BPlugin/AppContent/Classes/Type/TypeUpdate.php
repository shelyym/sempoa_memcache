<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/20/16
 * Time: 10:11 AM
 */

class TypeUpdate extends TypeB{
    public $name = "Latest Update";
    public $isSingular = 1;
    public $icon = "ic_news.png";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){
        echo "this is for create form";
    }
} 