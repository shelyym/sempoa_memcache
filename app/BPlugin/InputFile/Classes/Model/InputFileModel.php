<?php

/**
 * Description of DocumentsPortal
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class InputFileModel extends Model{
    //Nama Table
    public $table_name = "sp_input_file";  
    
    //Primary
    public $main_id = 'file_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'file_id,file_filename,file_url,file_author';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'file_id,file_filename,file_url,file_author,file_size,file_date,file_downloads,file_folder_id';
    
    public $file_id;
    public $file_filename;
    public $file_url;
    public $file_author;
    public $file_size;
    public $file_date;
    public $file_downloads;
    public $file_folder_id;
    public $file_ext;
    public $file_isi;
    //public $upload_location = './inputfiles/';
    //public $upload_url = "inputfiles/";
    public $upload_location = './plugins/jQuery_File_Upload/server/php/inputfiles/';
    public $upload_url = "plugins/jQuery_File_Upload/server/php/inputfiles/";
    
    function __construct() {
        
        $this->upload_location = _PHOTOPATH."inputfiles/";
        $this->upload_url = _PHOTOURL."inputfiles/";
       
    }
    
    public function deleteFile(){
        unlink($this->upload_location.$this->file_filename);
    }
    
    public function printLink(){
        $path = _SPPATH . $this->upload_url;
        $fil = $this->file_filename;
        $inp = new \Leap\View\InputFile();
        $url = base64_encode($path.$this->file_filename);
        $link = _SPPATH."InputFileWeb/show?gurl=".$url."&id=".$this->file_id;
        $onclick = "onclick=\"openLw('DocViewer','".$link."','fade');\"";
        
        $link = _SPPATH."docviewer?gurl=".$url."&id=".$this->file_id;
        $onclick = "onclick=\"document.location='".$link."';\"";
        if(in_array($this->file_ext, $inp->arrImgExt)){
            return "<div id='file_".$this->file_id."' $onclick class='pl_file_item'><div class='fotoIF'><img onload='OnImageLoad(event, 30);' src='".$path.$fil."'></div><div class='if_text'>".$this->file_url."</div><div class='clearfix'></div></div>";
        }
        if($this->file_ext == "pdf"){
            //check if ada thumb
            $tpath = $this->upload_location;
            $thumb = $tpath."thumbs/".$this->file_id.".jpg";
            //echo $thumb;
            if(file_exists($thumb)){
                $thumburl = $path."thumbs/".$this->file_id.".jpg";
                return "<div id='file_".$this->file_id."' $onclick class='pl_file_item'><div class='fotoIF'><img onload='OnImageLoad(event, 30);' src='".$thumburl."'></div><div class='if_text'>".$this->file_url."</div><div class='clearfix'></div></div>";
      
            }
        }
        return "<div id='file_".$this->file_id."' $onclick class='pl_file_item'>".$this->file_url."</div>";
    }
}
