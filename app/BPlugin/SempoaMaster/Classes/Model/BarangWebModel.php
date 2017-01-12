<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BarangWebModel
 *
 * @author efindiongso
 */
class BarangWebModel extends SempoaModel {

    //put your code here
    var $table_name = "sempoa__barang_harga";
    var $main_id = "id_barang_harga";
//Default Coloms for read
    public $default_read_coloms = "id_barang_harga,kode_barang,nama_barang,jenis_biaya,level,foto_barang,barang_desc,ak_id,kpo_id,ak_rule,kpo_rule,ibo_rule,tc_rule";
//allowed colom in CRUD filter
    public $coloumlist = "id_barang_harga,kode_barang,nama_barang,jenis_biaya,level,foto_barang,barang_desc,ak_id,kpo_id,ak_rule,kpo_rule,ibo_rule,tc_rule";
    public $id_barang_harga;
    public $kode_barang;
    public $nama_barang;
    public $jenis_biaya;
    public $level;
    public $foto_barang;
    public $barang_desc;
    public $ak_id;
    public $kpo_id;
    public $ak_rule;
    public $kpo_rule;
    public $ibo_rule;
    public $tc_rule;
   public $hideColoums = array("ak_id", "kpo_id");
   
    public function overwriteForm($return, $returnfull) {
        $return = parent::overwriteForm($return, $returnfull);

        if ($this->foto_barang == "") {
            $this->foto_barang = "noimageperson.png";
        }
        $return['jenis_biaya'] = new Leap\View\InputSelect(Generic::getJenisBiaya(), "jenis_biaya", "jenis_biaya", $this->jenis_biaya);
        $return['level'] = new Leap\View\InputSelect(Generic::getAllLevel(), "level", "level", $this->level);

        $return['foto_barang'] = new \Leap\View\InputFoto("foto", "foto_barang", $this->foto_barang);

        $return['ak_id'] = new \Leap\View\InputText("hidden", "ak_id", "ak_id", Generic::getMyParentID(AccessRight::getMyOrgID()));
        $return['kpo_id'] = new \Leap\View\InputText("hidden", "kpo_id", "kpo_id", AccessRight::getMyOrgID());

        return $return;
    }

    public function overwriteRead($return) {
        $objs = $return['objs'];
        $arrJenisBarang =  Generic::getJenisBarang();
        $arrLevel = Generic::getAllLevel();
        foreach ($objs as $obj) {
            if (isset($obj->foto_barang)) {

                if ($obj->foto_barang == "") {
                    $obj->foto_barang = "noimageperson.png";
                }
                $obj->foto_barang = \Leap\View\InputFoto::getAndMakeFoto($obj->foto_barang, "car_image_" . $obj->foto_barang);
            }
            if (isset($obj->jenis_biaya)) {
                $obj->jenis_biaya = $arrJenisBarang[ $obj->jenis_biaya];
            }
            if (isset($obj->level)) {
                $obj->level = $arrLevel[ $obj->level];
            }
            
        }
        return $return;
    }

    public function getPerlengkapanJunior($kpo_id){
        $this->getWhereOne("kpo_id=$kpo_id AND jenis_biaya = 2 AND level=1");
        return $this->id_barang_harga;
    }
    
       public function getPerlengkapanFoundation($kpo_id){
        $this->getWhereOne("kpo_id=$kpo_id AND jenis_biaya = 2 AND level=3");
        return $this->id_barang_harga;
    }
}
