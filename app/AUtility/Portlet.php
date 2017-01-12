<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Portlet
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Portlet {
    public $classname;
    public $methodname;
    
    public function __construct($classname,$methodname) {
        $this->classname = $classname;
        $this->methodname = $methodname;
    }
    public function printme(){
        $class = $this->classname;
        $func = $this->methodname;
        if(method_exists($class, $func)) { 
            $new = new $class();
            $new->$func();
             //call_user_func_array(array($class, $func),$args); 
        }else{ 
            throw new Exception(sprintf('The required method "%s" does not exist for %s', $func, get_class($new))); 
            die("Method not exist");
        } 
    }
}
