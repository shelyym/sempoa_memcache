<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Page2ContainerWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class Page2ContainerWeb extends WebService{
    /*
     * nama fungsi dan nama kelas harus sama spy crudnya bs jalan
     * untuk mengisi calendar
     */
    public function page(){
        //create the model object
        $cal = new Page();
        //send the webclass 
        $webClass = __CLASS__;
        
        //by pass the form
        $cmd = (isset($_GET['cmd'])?addslashes($_GET['cmd']):'read');
        if($cmd == "edit"){  
          //Crud::createForm($obj,$webClass);
          //die('edit');
            $id = (isset($_GET['id'])?addslashes($_GET['id']):0);
            if($id){
                $cal->getByID($id);
            }
            $mps['id'] = $id;
            $mps['obj'] = $cal;
            Mold::plugin("Page","pageForm",$mps);  
            exit();
        }
        $cid = addslashes($_GET['cid']);
        if($cid != ""){
            
            $_SESSION['pageConID'] = $cid;
        }
        else{
            //unset($_SESSION['pageConID']);
        }
        $cal->read_filter_array = array("post_gallery_id"=>$_SESSION['pageConID']);
        //echo $cid;
        //pr($cal);
        //run the crud utility
        Crud::run($cal,$webClass);
                 
        //pr($mps);
    }
}
