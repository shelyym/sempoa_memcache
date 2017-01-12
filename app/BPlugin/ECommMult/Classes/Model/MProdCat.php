<?php

/**
 * Description of ProdCat
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class MProdCat extends Model{
    //Nama Table
    public $table_name = "ecommultiple__product_category";

    //Primary
    public $main_id = 'cat_id';

    //Default Coloms for read
    public $default_read_coloms = 'cat_id,cat_name,cat_pic,cat_parent_id';

    //allowed colom in CRUD filter
    public $coloumlist = 'cat_name,cat_pic,cat_parent_id,cat_app_id';
    public $cat_name;
    public $cat_parent_id;
    public $cat_id;
//    public $cat_metatitle;
//    public $cat_metadesc;
//    public $cat_metatag;
    public $cat_pic;
    public $cat_app_id;

    public $ratio_weight = 10;
    public $ratio_height = 10;

    //tree limit
    public $tree_multi_user_constraint = array();

    public $crud_webservice_allowed = 'cat_id,cat_name,cat_pic,cat_parent_id';
    public $crud_add_photourl = array();


    public function __construct(){
        $this->tree_multi_user_constraint = array("cat_app_id"=>AppAccount::getAppID());
    }



    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);

        $p = new ProdCat();

        $arrPage = $p->getAll();
        $arrNe = array();
        $arrNe[0] = "Main Category";
        foreach($arrPage as $pp){
            $arrNe[$pp->cat_id] = $pp->cat_id." - ".$pp->cat_name;
        }

        $return['cat_parent_id'] = new Leap\View\InputSelect($arrNe, "cat_parent_id", "cat_parent_id",
            $this->cat_parent_id);

        $return['cat_pic'] = new Leap\View\InputFotoCropper($this->ratio_weight.":".$this->ratio_height,"cat_pic", "cat_pic",
            $this->cat_pic);

        return $return;
    }
    public static function getAllParents($id,$arrParent){
        if($id<1)
            return $arrParent;
        $cat = new ProdCat();
        $cat->getByID($id);
        if($cat->cat_id){
            $arrParent[] = $cat;
            return self::getAllParents($cat->cat_parent_id,$arrParent);
        }
        else {
            return $arrParent;
        }
    }

    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->cat_pic)) {
            $err['cat_pic'] = Lang::t('Picture must be provided');
        }
        else{
            $src = _PHOTOPATH.$this->cat_pic;
            list($iWidth,$iHeight,$type)    = getimagesize($src);
            if(round($iWidth/$iHeight,1) != round($this->ratio_weight/$this->ratio_height,1)){
                $err['cat_pic'] = Lang::t('Proportion is not right, please crop using our tool');
            }
        }





        return $err;
    }


}
