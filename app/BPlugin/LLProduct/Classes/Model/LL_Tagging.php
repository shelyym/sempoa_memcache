<?php

/**
 * Description of LL_Tagging
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Tagging extends Model{
    //Nama Table
    public $table_name = "ll__tagging_base";  
    
    //Primary
    public $main_id = 'reltag_id';
    
    //Default Coloms for read
public $default_read_coloms = "reltag_id,TaggingLevel1ID,TaggingLevel1Name,TaggingLevel1Order,TaggingLevel2ID,TaggingLevel2Name,TaggingLevel2Order,TaggingLevel3ID,TaggingLevel3Name,TaggingLevel3Order";

//allowed colom in CRUD filter
public $coloumlist = "reltag_id,TaggingLevel1ID,TaggingLevel1Name,TaggingLevel1Order,TaggingLevel2ID,TaggingLevel2Name,TaggingLevel2Order,TaggingLevel3ID,TaggingLevel3Name,TaggingLevel3Order";
public $TaggingLevel1ID; 
public $TaggingLevel1Name; 
public $TaggingLevel2ID; 
public $TaggingLevel2Name; 
public $TaggingLevel3ID; 
public $TaggingLevel3Name; 

public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "reltag_id,TaggingLevel1ID,TaggingLevel1Name,TaggingLevel1Order,TaggingLevel2ID,TaggingLevel2Name,TaggingLevel2Order,TaggingLevel3ID,TaggingLevel3Name,TaggingLevel3Order";
public $reltag_id;

    public $TaggingLevel1Order;
    public $TaggingLevel2Order;
    public $TaggingLevel3Order;
 
}
