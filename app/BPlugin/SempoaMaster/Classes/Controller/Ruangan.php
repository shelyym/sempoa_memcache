<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ruangan
 *
 * @author efindiongso
 */
class Ruangan extends WebService {

    //put your code here


    public function read_ruangan() {
        $obj = new RuanganModel();
        $obj->printColumlistAsAttributes();
    }

    public function create_ruangan() {
        
    }

    public function update_ruangan() {
        
    }

    public function delete_ruangan() {
        
    }

}
