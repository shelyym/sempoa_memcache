<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PembayaranWeb2Model
 *
 * @author efindiongso
 */
class PembayaranWeb2Model extends Model {

    //put your code here
    var $table_name = "sempoa__cara_pembayaran";
    var $main_id = "id_jenis_pembayaran";
    //Default Coloms for read
    public $default_read_coloms = "id_jenis_pembayaran,jenis_pembayaran,jenis_pembayaran_desc";
//allowed colom in CRUD filter
    public $coloumlist = "id_jenis_pembayaran,jenis_pembayaran,jenis_pembayaran_desc";
    public $id_jenis_pembayaran;
    public $jenis_pembayaran;
    public $jenis_pembayaran_desc;
    
    
    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);
        return $return;
    }

    
    public function constraints() {
        //err id => err msg
        $err = array();
        if (!isset($this->jenis_pembayaran)) {
            $err['jenis_pembayaran'] = Lang::t('Please provide enis_pembayaran');
        }
        return $err;
    }

}
