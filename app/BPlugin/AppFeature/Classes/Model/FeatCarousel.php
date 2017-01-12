<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 11:01 PM
 */

class FeatCarousel extends ZAppFeatureListRTE{

    public $feat_name = "Catalog";
    public $feat_id = "catalogue";
    public $feat_icon = "ic_product.png";

    public $feat_tab_icon = "ic_product.png";
    public $feat_rank_tampil = 15;

    public $feat_active = 1;

    public $feat_element_name = "Product";

    public function overwriteModal(){
        global $modalReg;
        $modalReg->addAboveBGBlur(array("FeatCarousel","addForm")); //harus dioverwrite
    }
} 