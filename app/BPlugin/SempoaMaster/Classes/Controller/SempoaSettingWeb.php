<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SempoaSettingWeb
 *
 * @author efindiongso
 */
class SempoaSettingWeb extends WebService {

    //put your code here
//           [SempoaSettingWeb] => Array
//                        (
//                            [0] => get_my_royalti_ibo
//                            [1] => create_royalti_all_tc
//                            [2] => read_royalti_all_tc
//                            [3] => update_royalti_all_tc
//                            [4] => delete_royalti_all_tc
//                        )
    // IBO
    public function get_my_royalti_ibo() {

        SettingWeb2Helper::table_harga_anak2();

    }

    public function create_royalti_all_tc() {
        echo "create_royalti_all_tc";
    }

    public function read_royalti_all_tc() {
        echo "read_royalti_all_tc";
    }

    public function update_royalti_all_tc() {
        echo "update_royalti_all_tc";
    }

    public function delete_royalti_all_tc() {
        echo "delete_royalti_all_tc";
    }

    // IBO 
    public function create_royalti_all_ibo() {
        echo "get_my_royalti_ibo";
    }

    public function read_royalti_all_ibo() {
        SettingWeb2Helper::table_harga_anak2();
    }

    public function delete_royalti_all_ibo() {
        echo "get_my_royalti_ibo";
    }

    public function update_royalti_all_ibo() {
        echo "get_my_royalti_ibo";
    }

}
