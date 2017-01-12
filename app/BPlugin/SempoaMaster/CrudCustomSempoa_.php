<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrudCustomSempoa
 *
 * @author efindiongso
 */
class CrudCustomSempoa22 extends CrudCustom {

    //put your code here


    public function run_custom($obj, $callClass, $callFkt, $whereCustom) {

        if ($obj instanceof Model) {

            $this->callClass = $callClass;
            $this->callFkt = $callFkt;

            $cmd = (isset($_GET['cmd']) ? addslashes($_GET['cmd']) : 'read');
            if ($cmd == "edit") {
                CrudCustom::createForm($obj, $callClass, $callFkt, $this);
                die();
            }
            if ($cmd == "add") {
                //Crud::createForm($obj,$webClass);
                $json = Crud::addPrecon($obj);
                die(json_encode($json));
            }
            if ($cmd == "delete") {
                $json['bool'] = 1;
                $id = (isset($_POST['id']) ? addslashes($_POST['id']) : '');
                $json['bool'] = $obj->delete($id);
                die(json_encode($json));
            }
            if ($cmd == "ws") {
                Crud::workWebService($obj, $callClass);
                die();
            }

            CrudCustomSempoa::readCustomSempoa($obj, $callClass, $callFkt, $this, $whereCustom);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

    public static function readCustomSempoa($obj, $callClass, $callFkt, $crudObj, $whereCustom) {
        if ($obj instanceof Model) {
            $mps = $obj->readMy($whereCustom);
            $mps['webClass'] = $callClass;
            $mps['callFkt'] = $callFkt;
            $mps['crudObj'] = $crudObj;
            $mps = $obj->overwriteRead($mps);
            $mps['activeObj'] = $obj;
            Mold::plugin("CrudCustom", "read", $mps);
        } else {
            die('Crud hanya bisa dipakai dengan object Crud');
        }
    }

}
