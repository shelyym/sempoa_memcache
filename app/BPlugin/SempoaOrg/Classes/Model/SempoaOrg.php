<?php

/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/26/16
 * Time: 5:23 PM
 */
class SempoaOrg extends Model {

    var $table_name = "sempoa__tc";
    var $main_id = "org_id";
    //Default Coloms for read
    public $default_read_coloms = "org_id,org_kode,org_type,org_parent_id,nama,alamat,nomor_telp,tc_no_fax_office,email,propinsi,nama_pemilik,org_catatan,tanggal_lahir,alamat_rmh_priv,telp_priv,hp_priv,email_priv,tgl_kontrak";
//allowed colom in CRUD filter
    public $coloumlist = "org_id,org_kode,org_type,org_parent_id,org_lat,org_lng,nama,alamat,nomor_telp,tc_no_fax_office,email,biaya_perlengkapan,biaya_pendaftaran,biaya_iuran,biaya_buku,gambar,map,last_update,propinsi,kode_pic,nama_pemilik,org_catatan,batas_ruangan,batas_guru,batas_murid,ruangan,tanggal_lahir,alamat_rmh_priv,telp_priv,hp_priv,email_priv,tgl_kontrak,tc_migrasi";
    public $org_id;
    public $org_kode;
    public $org_type;
    public $org_parent_id;
    public $org_lat;
    public $org_lng;
    public $nama;
    public $alamat;
    public $nomor_telp;
    public $tc_no_fax_office;
    public $tc_no_hp_office;
    public $email;
    public $biaya_perlengkapan;
    public $biaya_pendaftaran;
    public $biaya_iuran;
    public $biaya_buku;
    public $gambar;
    public $map;
    public $last_update;
    public $propinsi;
    public $kode_pic;
    public $nama_pemilik;
    public $org_catatan;
    public $batas_ruangan;
    public $batas_guru;
    public $batas_murid;
    public $ruangan;
    public $tanggal_lahir;
    public $alamat_rmh_priv;
    public $telp_priv;
    public $hp_priv;
    public $email_priv;
    public $tc_nama_bank;
    public $tc_cabang_bank;
    public $tc_acc_bank;
    public $tgl_kontrak;
    public $tc_migrasi;

}
