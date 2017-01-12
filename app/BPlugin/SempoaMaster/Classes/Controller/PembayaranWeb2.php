<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PembayaranWeb2
 *
 * @author efindiongso
 */
class PembayaranWeb2 extends WebService {

    //put your code here
//    [PembayaranWeb2] => Array
//                        (
//                            [0] => read_jenis_pembayaran
//                            [1] => create_jenis_pembayaran
//                            [2] => update_jenis_pembayaran
//                            [3] => delete_jenis_pembayaran
//                        )

    public function read_jenis_pembayaran() {
        $obj = new PembayaranWeb2Model();
        $crud = new CrudCustom();
        $crud->ar_add = AccessRight::hasRight("create_jenis_pembayaran");
        $crud->ar_edit = AccessRight::hasRight("update_jenis_pembayaran");
        $crud->ar_delete = AccessRight::hasRight("delete_jenis_pembayaran");
        $crud->run_custom($obj, "PembayaranWeb2", "read_jenis_pembayaran");
    }

    public function create_jenis_pembayaran() {
        
    }

    public function update_jenis_pembayaran() {
        
    }

    public function delete_jenis_pembayaran() {
        
    }

    public function read_jenis_pembayaran_ibo() {
        $obj = new PembayaranWeb2Model();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "PembayaranWeb2", "read_jenis_pembayaran_ibo");
    }

    public function read_jenis_pembayaran_tc() {
        $obj = new PembayaranWeb2Model();
        $crud = new CrudCustom();
        $crud->ar_add = 0;
        $crud->ar_edit = 0;
        $crud->ar_delete = 0;
        $crud->run_custom($obj, "PembayaranWeb2", "read_jenis_pembayaran_tc");
    }

}
