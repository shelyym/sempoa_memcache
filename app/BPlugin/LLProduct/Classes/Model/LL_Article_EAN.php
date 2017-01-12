<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/14/15
 * Time: 5:57 PM
 */

class LL_Article_EAN extends Model{

    //Nama Table
    public $table_name = "ll__article_ean";

    //Primary
    public $main_id = 'ean_id';

    //Default Coloms for read
    public $default_read_coloms = "ean_id,var_id";


    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = "ean_id,var_id";

    public $ean_id;
    public $var_id;

} 