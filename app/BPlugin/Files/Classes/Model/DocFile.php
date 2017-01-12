<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DocFile
 *
 * @author User
 */
class DocFile extends Model {
    public $table_name = "sp_docfile";
    public $main_id    = "file_id";

    public $default_read_coloms = "file_id,file_filename";

    public $file_id;
    public $file_target_id;
    public $file_description;
    public $file_filename;
    public $file_date;
    public $file_size;
    public $file_extendsion;
    public $file_owner_id;
}
