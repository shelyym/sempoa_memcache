<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 10:43 AM
 */

class APIFilter {

    static function filter($arrObject){

        $json = array();

        foreach($arrObject as $o){

            $exp = explode(",", $o->crud_webservice_allowed);

            //tmbh untuk add photo url
            $arrPicsToAddPhotoUrl = $o->crud_add_photourl;


            $sem = array();
            foreach($exp as $attr){
                $attr = trim(rtrim($attr));

                if(in_array($attr, $arrPicsToAddPhotoUrl)){
                    $sem[$attr] = _BPATH._PHOTOURL.$o->$attr;
                }
                else
                    $sem[$attr] = stripslashes ($o->$attr);
            }
            $json[] = $sem;
        }
        return $json;
    }
} 