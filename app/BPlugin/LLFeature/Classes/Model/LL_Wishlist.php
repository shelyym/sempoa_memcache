<?php

/**
 * Description of LL_Wishlist
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Wishlist extends Model{
    //Nama Table
    public $table_name = "ll__wishlist";  
    
    //Primary
    public $main_id = 'wl_id';
    
    //Default Coloms for read
    public $default_read_coloms = 'wl_id,wl_acc_id,wl_articlenr';
    
    //allowed colom in CRUD filter
    public $coloumlist = 'wl_id,wl_acc_id,wl_articlenr';
    
    public $wl_id;
    public $wl_acc_id;
    public $wl_articlenr;
    
    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
    public $crud_webservice_allowed = 'wl_id,wl_acc_id,wl_articlenr';
    
    //fungsi untuk menggabungkan 2 
    public $crud_read_gabungan = array(
        "LL_Account"=>array("macc_first_name","macc_last_name","macc_gender","macc_email","macc_phone","macc_phone_home"),
        "LL_Article_WImage"=>array("BaseArticleNameENG")
    );
    public $crud_read_link = array(
        "LL_Account"=>array("wl_acc_id","macc_id"),
        "LL_Article_WImage"=>array("wl_articlenr","VariantID")
    );
    
    
}
