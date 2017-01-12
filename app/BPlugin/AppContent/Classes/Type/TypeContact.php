<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/20/16
 * Time: 10:12 AM
 */

class TypeContact extends AppContentTemplate{
    public $name = "Contact Us";
    public $isSingular = 1;
    public $icon = "ic_contactus.png";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){
        echo "this is for create form";
    }
} 