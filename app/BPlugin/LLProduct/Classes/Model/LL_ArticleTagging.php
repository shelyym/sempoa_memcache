<?php

/**
 * Description of ArticleTagging
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_ArticleTagging extends Model{
    //Nama Table
    public $table_name = " ll__articletagging";  
    
    //Primary
    public $main_id = 'rel_id';
    
    //Default Coloms for read
public $default_read_coloms = "rel_id,TaggingLevel3ID,ArticleID"; 

//allowed colom in CRUD filter
public $coloumlist = "rel_id,TaggingLevel3ID,ArticleID";
public $rel_id; 
public $TaggingLevel3ID; 
public $ArticleID;

public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "rel_id,TaggingLevel3ID,ArticleID";
 
}
