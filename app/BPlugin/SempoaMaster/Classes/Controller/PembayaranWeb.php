<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PembayaranWeb
 *
 * @author efindiongso
 */
class PembayaranWeb extends WebService{
    //put your code here
    
    function get_laporan_pembayaran_biaya_pendaftaran_tc(){
        LaporanWeb::get_laporan_tc(KEY::$DEBET_REGISTRASI_TC, "Registrasi");
    }
    
    function get_laporan_pembayaran_biaya_perlengkapan_tc(){
         LaporanWeb::get_laporan_tc(KEY::$DEBET_PERLENGKAPAN_TC, "Perlengkapan");
    }
}
