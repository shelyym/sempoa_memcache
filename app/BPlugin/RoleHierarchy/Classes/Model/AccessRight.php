<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/20/16
 * Time: 10:59 PM
 */

class AccessRight extends Model{

    var $table_name = "sp_accessright";
    var $main_id = "ar_id";
    //Default Coloms for read
    public $default_read_coloms = "ar_id,ar_name,ar_folder_name,ar_display_name,ar_cname,ar_description,ar_level,ar_symbol,ar_order,ar_show,ar_folder_order";

//allowed colom in CRUD filter
    public $coloumlist = "ar_id,ar_name,ar_folder_name,ar_display_name,ar_cname,ar_description,ar_level,ar_symbol,ar_order,ar_show,ar_folder_order";
    public $ar_id;
    public $ar_name;
    public $ar_folder_name;
    public $ar_display_name;
    public $ar_cname;
    public $ar_description;
    public $ar_level;
    public $ar_symbol;
    public $ar_order;
    public $ar_show;
    public $ar_folder_order;

    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>1,"webservice"=>1);
    //yg boleh diganti lewat import command
    public $crud_import_allowed = array("ar_name","ar_folder_name","ar_display_name","ar_cname","ar_description","ar_level","ar_symbol","ar_order","ar_show","ar_folder_order");

    //allowed colom in CRUD filter
    public $exportList = "ar_id,ar_name,ar_folder_name,ar_display_name,ar_cname,ar_description,ar_level,ar_symbol,ar_order,ar_show,ar_folder_order";


    public static function getMyAR($role){

        $ar2role = new AccessRight();
        $arr = $ar2role->getWhereFromMultipleTable("mat_role_id = '$role' AND mat_ar_id = ar_id AND mat_active=1 AND ar_show = 1 ORDER BY ar_folder_order DESC,ar_folder_name ASC,ar_order DESC",array("AccessRight2Role"));

        return $arr;

//        $ar2role = new AccessRight2Role();
//        $arr = $ar2role->getWhereFromMultipleTable("mat_role_id = '$role' AND mat_ar_id = ar_id",array("AccessRight"));
//
//        return $arr;
    }

    public static function getMyAR_All($role){

        $ar2role = new AccessRight();
        $arr = $ar2role->getWhereFromMultipleTable("mat_role_id = '$role' AND mat_ar_id = ar_id AND mat_active=1  ORDER BY ar_folder_order DESC,ar_folder_name ASC,ar_order DESC",array("AccessRight2Role"));

        return $arr;

//        $ar2role = new AccessRight2Role();
//        $arr = $ar2role->getWhereFromMultipleTable("mat_role_id = '$role' AND mat_ar_id = ar_id",array("AccessRight"));
//
//        return $arr;
    }

    public function loadAccessRight(){

        $ar2role = new AccessRight();
        $arr2 = $ar2role->getAll();
        foreach($arr2 as $ar){
            if(!in_array($ar->ar_cname,$_SESSION['Registor']['access_cname'])){
                $_SESSION['Registor']['access_cname'][] = $ar->ar_cname;
            }
        }

        $arr = AccessRight::getMyAR_All(Account::getMyRole());
        //$_SESSION['listOfRoles'] = $arr;
        foreach ($arr as $ar) {
            $_SESSION['Registor']['access_right'][$ar->ar_cname][] = $ar->ar_name;
            $_SESSION['Registor']['access_right_list'][] = $ar->ar_name;
            $_SESSION['Registor']['access_right_by_name'][$ar->ar_name] = $ar;
            if($ar->ar_show){
                $_SESSION['Registor']['access_right_show_by_name'][$ar->ar_name] = $ar;
            }
        }
    }

    public static function hasRight($ar_name){
        return in_array($ar_name,$_SESSION['Registor']['access_right_list']);
    }
    public static function getRightObject($ar_name){
        if(isset($_SESSION['Registor']['access_right_by_name'][$ar_name]))
            return $_SESSION['Registor']['access_right_by_name'][$ar_name];
        else
            return null;
    }
    public static function getRightURL($ar_name){
        $obj = self::getRightObject($ar_name);
        if($obj!= null){
            $url = _SPPATH.$obj->ar_cname."/".$obj->ar_name;
            return $url;
        }else
            return "";
    }
    public static function getRightObjectShow($ar_name){
        if(isset($_SESSION['Registor']['access_right_show_by_name'][$ar_name]))
            return $_SESSION['Registor']['access_right_show_by_name'][$ar_name];
        else
            return null;
    }
    public static function getRightURLShow($ar_name){
        $obj = self::getRightObjectShow($ar_name);
        if($obj!= null){
            $url = _SPPATH.$obj->ar_cname."/".$obj->ar_name;
            return $url;
        }else
            return "";
    }
    public static function getRightShowList(){
        return $_SESSION['Registor']['access_right_show_by_name'];
    }

    public static function getMyOrgID(){
        return $_SESSION['account']->admin_org_id;
    }

    public static function getMyOrgType(){
        return $_SESSION['account']->admin_org_type;
    }
    
}