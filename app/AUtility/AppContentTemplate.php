<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:18 PM
 */

class AppContentTemplate {

    public $name;
    public $isSingular;
    public $min_version = 1;
    public $icon;

    public function p(){
        echo "this is for print";
    }
    public function createForm(){
        echo "this is for create form";
    }

    public static function getSubclassesOf() {
        $parent = get_called_class();
        $result = array();
        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, $parent))
                $result[] = $class;
        }
        return $result;
    }

    public static function getObjectOfSubclassesOf(){
        $arr = self::getSubclassesOf();
        $objs = array();
        foreach($arr as $type){
            $cname = $type;
            if (class_exists($cname)) {
                //echo "exist".$nsClassname;
                $code = "\$new = new " . $cname . "();";
                eval($code);

                $objs[] = $new;
            }
        }
        return $objs;
    }
} 