<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FBUserWeb
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class FBUserWeb extends WebService{
    //put your code here
    public function cekEmail(){
        $email = addslashes($_POST['em']);
        $fb = new FBUser();
        $arr = $fb->getWhere("email = '$email'");
        $json['bool'] = 0;
        if(count($arr)>0){
            $json['bool'] = 1;
        }
        echo json_encode($json);
    }
}
