<?php

/**
 * Description of LL_Article_WImage
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class LL_Article_WImage extends Model{
    //Nama Table
    public $table_name = "ll__article_with_image";  
    
    //Primary
    public $main_id = 'VariantID';
    
    //Default Coloms for read
public $default_read_coloms = "BaseArticleID,VariantID,BaseArticleNameINA,BaseArticleNameENG,ArticleType,VariantNameINA,VariantNameENG,VariantINACode";

//allowed colom in CRUD filter
public $coloumlist = "BaseArticleID,VariantID,BaseArticleNameINA,BaseArticleNameENG,ArticleType,VariantNameINA,VariantNameENG,VariantINACode,HowToUseINA,HowToUseENG,ArticleInfoINA,ProductTipsINA,ProductTipsENG,ArticleInfoENG,IngredientINA,IngredientENG,SellingPrice,VariantWeight,VariantWeightUnit,BaseArticleImageFile,VariantImageFile,VariantEAN";
public $BaseArticleID; 
public $VariantID; 
public $BaseArticleNameINA; 
public $BaseArticleNameENG; 
public $ArticleType; 
public $VariantNameINA; 
public $VariantNameENG; 
public $VariantINACode; 
public $HowToUseINA; 
public $HowToUseENG; 
public $ArticleInfoINA; 
public $ProductTipsINA; 
public $ProductTipsENG; 
public $ArticleInfoENG; 
public $IngredientINA; 
public $IngredientENG; 
public $SellingPrice; 
public $VariantWeight; 
public $VariantWeightUnit; 
public $BaseArticleImageFile; 
public $VariantImageFile;
    public $VariantEAN;

public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>1,"export"=>1,"toggle"=>1,"import"=>0,"webservice"=>1);
public $crud_webservice_allowed = "BaseArticleID,VariantID,BaseArticleNameINA,BaseArticleNameENG,ArticleType,VariantNameINA,VariantNameENG,VariantINACode,HowToUseINA,HowToUseENG,ArticleInfoINA,ProductTipsINA,ProductTipsENG,ArticleInfoENG,IngredientINA,IngredientENG,SellingPrice,VariantWeight,VariantWeightUnit,BaseArticleImageFile,VariantImageFile,VariantEAN";


}
