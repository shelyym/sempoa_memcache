<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:24 PM
 */

class TypeInbox extends AppContentTemplate{

    public $name = "Inbox";
    public $isSingular = 1;
    public $icon = "ic_inbox.png";
    public function p(){
        echo "this is for print";
    }
    public function createForm(){
        echo "this is for create form";
    }

} 