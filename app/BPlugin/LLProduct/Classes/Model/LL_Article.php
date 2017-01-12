<?php

/**
 * Description of LL_Article
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Article extends Model{
    //Nama Table
    public $table_name = " ll__article";  
    
    //Primary
    public $main_id = 'ArticleID';
    
    //Default Coloms for read
public $default_read_coloms = "ArticleID,VariantID,ArticleNameINA,ArticleNameENG,VariantNameINA,VariantNameENG,INACode,HowToUseINA,HowToUseENG,ArticleInfoINA,ArticleInfoENG,IngredientINA,IngredientENG,ArticlePrice,ArticleWeght,ArticleWeightUnit";

//allowed colom in CRUD filter
public $coloumlist = "ArticleID,VariantID,ArticleNameINA,ArticleNameENG,VariantNameINA,VariantNameENG,INACode,HowToUseINA,HowToUseENG,ArticleInfoINA,ArticleInfoENG,IngredientINA,IngredientENG,ArticlePrice,ArticleWeght,ArticleWeightUnit";
public $ArticleID; 
public $VariantID; 
public $ArticleNameINA; 
public $ArticleNameENG; 
public $VariantNameINA; 
public $VariantNameENG; 
public $INACode; 
public $HowToUseINA; 
public $HowToUseENG; 
public $ArticleInfoINA; 
public $ArticleInfoENG; 
public $IngredientINA; 
public $IngredientENG; 
public $ArticlePrice; 
public $ArticleWeght; 
public $ArticleWeightUnit; 

public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "ArticleID,VariantID,ArticleNameINA,ArticleNameENG,VariantNameINA,VariantNameENG,INACode,HowToUseINA,HowToUseENG,ArticleInfoINA,ArticleInfoENG,IngredientINA,IngredientENG,ArticlePrice,ArticleWeght,ArticleWeightUnit";
    
}
