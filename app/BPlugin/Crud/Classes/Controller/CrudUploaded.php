<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrudUploaded
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class CrudUploaded extends WebService{
    
    public function uploadfiles(){
        $data = array();
        $c = (isset($_GET['c'])?addslashes($_GET['c']):die('no c'));
        $wc = (isset($_GET['wc'])?addslashes($_GET['wc']):die('no wc'));
        $t = (isset($_GET['t'])?addslashes($_GET['t']):die('no t'));
        
//        $upload_location = _PHOTOPATH."imports/";
        $upload_location = _PHOTOPATH;
        $fname = $wc."__".$c;
        $obj = new $c();
        //cek access right
        if(!$obj->crud_setting['import'])die('not allowed');
        
        if(isset($_GET['files']))
        {

                    $error_size = 0;
                    $error = false;
                    $files = array();
                    $uploaddir = $upload_location;
                    foreach($_FILES as $file)
                    {
                            
                            
                                
                        //$f->file_url = basename($file['name']);
                        $ext = end((explode(".", $file['name'])));
                        //$f->file_ext = $ext;
                        $ffile_filename = $fname.".".$ext;
                        //$f->file_date = leap_mysqldate();
                        // if pdf

                        //cek size
                        $size_awal = $file['size'];
                        $data_location = $uploaddir .$ffile_filename;
                        $excels = array();
                        unlink($data_location);
                        if(move_uploaded_file($file['tmp_name'], $data_location))
                        {
                                $files[] = $uploaddir .$file['name'];
                                $ffile_size = filesize($data_location);

                                //size akhir
                                $size_akhir = $ffile_size;
                                //cek apakah tengah2 gagal
                                if($size_awal != $size_akhir){
                                    //hapus file corrupt
                                    unlink($data_location);
                                    //delete file corrupt di db
                                    //$f->delete($fid);
                                    $error = true;
                                    $error_size = 1;
                                }
                                else{
                                    if($ext == "xls"){
                                        // masukan ke data..
                                        //disini extract excelnya
                                        // ExcelFile($filename, $encoding);
                                        $xls = new Spreadsheet_Excel_Reader();


                                        // Set output Encoding.
                                        $xls->setOutputEncoding('CP1251');
                                        
                                        $xls->read($data_location);
                                        
                                        //ambil main ID
                                        $id_colom = Lang::t($obj->main_id);
                                        
                                        $id_posisi = 0;    
                                        $posisi = array();
                                        for ($i = 1; $i <= $xls->sheets[0]['numRows']; $i++) {
                                                for ($j = 1; $j <= $xls->sheets[0]['numCols']; $j++) {
                                                        //$excels[$i][] = "\"".$xls->sheets[0]['cells'][$i][$j]."\",";
                                                        
                                                        //bagian ID databasenya..mari kita extract pakai Lang
                                                        if($i==1){
                                                            if($xls->sheets[0]['cells'][$i][$j] == $id_colom){
                                                                $id_posisi = $j;
                                                            }
                                                            //simpan semua posisi ke array
                                                            foreach($obj->crud_import_allowed as $ids){
                                                                $lang = Lang::t($ids);
                                                                
                                                                if($xls->sheets[0]['cells'][$i][$j] == $lang){
                                                                   $posisi[$ids] = $j;
                                                                }
                                                            }
                                                        }
                                                        else{
                                                            break;
                                                        }
                                                        //ada tidak ada ID 
                                                        //karena sekarang semua posisi sudah tahu
                                                        //if($id_posisi==0)break;
                                                        
                                                }
                                                //$excels[$i][] = "\n";
                                                if($id_posisi==0)break;
                                                
                                                if($i>1){
                                                    //saving process
                                                    $id_active = $xls->sheets[0]['cells'][$i][$id_posisi];
                                                    $obj->getById($id_active);
                                                    if(!$obj->not_found) {
                                                        foreach ($obj->crud_import_allowed as $ids) {
                                                            $attr_pos = $posisi[$ids];
                                                            $obj->$ids = $xls->sheets[0]['cells'][$i][$attr_pos];
                                                        }
                                                        $obj->load = 1;
                                                        $excels[$id_active] = $obj->save(1);
                                                    }
                                                    else{

                                                        $obj2 = new $c();
                                                        $main = $obj2->main_id;
                                                        $obj2->$main = $id_active;
                                                        foreach ($obj2->crud_import_allowed as $ids) {
                                                            $attr_pos = $posisi[$ids];
                                                            $obj2->$ids = $xls->sheets[0]['cells'][$i][$attr_pos];
                                                        }
                                                        $excels[$id_active] = $obj2->save(1);
                                                    }

                                                }
                                        }
                                    }

                                    //$f->load = 1;
                                    //$f->save();
                                    //log
//                                    BLogger::addLog("classname = $c, webname = ".$wc, "import_data");
                                } //else cek size
                        }
                        else
                        {
                            $error = true;
                            //$f->delete($fid);
                        }
                            
                    }
                $data = ($error) ? array('error' => 'There was an error uploading your files') : array('files' => $files,'excels'=>$excels);
        }
        else
        {
                $data = array('success' => 'Form was submitted', 'formData' => $_POST);
        }
        if($error_size){
            $data['err_size'] = 1;
        }
        //$data['fil'] = $_FILES;
        echo json_encode($data);
    }
}
