<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/20/16
 * Time: 10:10 AM
 */

class TypeAbout extends TypeA{

    public $name = "About Us";
    public $isSingular = 1;
    public $icon = "ic_about.png";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){
        echo "this is for create form";
    }
} 