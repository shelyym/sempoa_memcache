<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LaporanWeb2
 *
 * @author efindiongso
 */
class LaporanWeb2 extends WebService {

    //put your code here
    public function get_laporan_penerimaan_training_guru() {
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$DEBET_TRAINING_GURU_IBO, "Penerimaan Training Guru");
    }

    public function get_laporan_pembayaran_training_trainer() {
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_TRAINING_TRAINER_IBO, "Pembayaran Training Trainer");
    }

    function get_laporan_pembayaran_training_guru() {
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_TRAINING_GURU_TC, "Training Guru");
    }

    function get_laporan_penjualan_barang_ibo() {
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$DEBET_BARANG_IBO, "Penjualan Barang IBO ke TC");
    }

    function get_laporan_pembelian_barang_ibo() {
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_BARANG_IBO, "Pembelian Barang IBO ke KPO");
    }

    function get_laporan_penerimaan_training_trainer() {
         $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$DEBET_TRAINING_TRAINER_KPO, "Penerimaan Training Trainer");
    }

    function get_laporan_pembelian_barang_tc(){
         $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_BARANG_TC, "Pembelian Barang");
    }
    function get_laporan_penjualan_barang_kpo(){
        $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$DEBET_BARANG_KPO, "Penjualan Barang KPO");
    }
    
    function get_laporan_pembelian_perlengkapan_tc(){
         $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_PERLENGKAPAN_TC, "Pembelian Perlengkapan TC");
    }
    
    function get_laporan_penjualan_perlengkapan_ibo(){
         $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$DEBET_PERLENGKAPAN_IBO, "Penjualan Perlengkapan IBO");
    }
    
    function get_laporan_pembelian_perlengkapan_ibo(){
         $help = new LaporanWeb();
        $help->get_laporan_tc(KEY::$KREDIT_PERLENGKAPAN_IBO, "Pembelian Perlengkapan IBO");
    }
}