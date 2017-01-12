<?php

/**
 * Description of ProdModel
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class MProdModel extends Model{
    //Nama Table
    public $table_name = "ecommultiple__product";

    //Primary
    public $main_id = 'prod_id';
    //Default Coloms for read
    public $default_read_coloms = "prod_id,prod_kode,prod_pic,prod_name,prod_des,prod_price,prod_price_diskon,prod_cat_id,prod_active,prod_stock,prod_attribute_array,prod_app_id";

//allowed colom in CRUD filter
    public $coloumlist = "prod_id,prod_kode,prod_pic,prod_name,prod_des,prod_price,prod_price_diskon,prod_cat_id,prod_active,prod_stock,prod_attribute_array,prod_app_id";
    public $prod_id;
    public $prod_name;
    public $prod_pic;
//    public $prod_date;
    public $prod_des;
    public $prod_kode;

    public $prod_price;
    public $prod_price_diskon;
    public $prod_cat_id;
    public $prod_active;
    public $prod_stock;
    public $prod_attribute_array;

    public $prod_app_id;

    public $hideColoums = array("prod_app_id","prod_id");

    public $crud_setting = array("add"=>1,"search"=>1,"viewall"=>0,"export"=>0,"toggle"=>1,"import"=>0,"webservice"=>0);

    var $crud_webservice_allowed = "prod_id,prod_kode,prod_pic,prod_name,prod_des,prod_price,prod_price_diskon,prod_cat_id,prod_active,prod_stock,prod_attribute_array,prod_app_id";
    //untuk app
//    public $multi_user = 1;
//    public $multi_user_field = "camp_app_id";

    public function __construct(){
//        echo AppAccount::getAppID();
        $arrs = array("prod_app_id"=>AppAccount::getAppID());
        $this->read_filter_array = $arrs;
//        pr($this->read_filter_array);
    }



    public function overwriteForm ($return, $returnfull)
    {
        $t = time();
        $return  = parent::overwriteForm($return, $returnfull);

        $return['prod_attribute_array'] = new Leap\View\InputAttribute("prod_stock_".$t,"prod_attribute_array", "prod_attribute_array", $this->prod_attribute_array);
        $return['prod_pic'] = new Leap\View\InputGallery("prod_pic", "prod_pic", $this->prod_pic);
        $return['prod_active'] = new Leap\View\InputSelect($this->arrayYesNO, "prod_active", "prod_active",
            $this->prod_active);
        // $return['news_text'] = new Leap\View\InputTextArea("news_text", "news_text", $this->news_text);
        $return['prod_des'] = new Leap\View\InputTextArea("prod_des", "prod_des", $this->prod_des);
        $return['prod_stock'] = new Leap\View\InputText("hidden","prod_stock_".$t, "prod_stock", $this->prod_stock);
        $return['prod_app_id'] = new Leap\View\InputText("hidden","prod_app_id".$t, "prod_app_id", $this->prod_app_id);
        $return['prod_price'] = new Leap\View\InputPrice("prod_price", "prod_price", $this->prod_price);
        $return['prod_price_diskon'] = new Leap\View\InputPrice("prod_price_diskon", "prod_price_diskon", $this->prod_price_diskon);

        $p = new MProdCat();

        if(count($p->tree_multi_user_constraint)>0){
            $where = array();
            foreach($p->tree_multi_user_constraint as $attr=>$val){
                $where[] = $attr." = '".$val."'";
            }
            $impWhere = implode(" AND ",$where);
            $arrPage = $p->getWhere($impWhere);
        }else {
            $arrPage = $p->getAll();
        }

//        $arrPage = $p->getAll();
        //category harus sesuai tree structurenya.....
        $arrNe = array();
        foreach($arrPage as $pp){
            $arrNe[$pp->cat_id] = $pp->cat_name;
        }

        $return['prod_cat_id'] = new Leap\View\InputSelect($arrNe, "prod_cat_id", "prod_cat_id",
            $this->prod_cat_id);


        return $return;
    }

    public function overwriteRead ($return)
    {
        $return = parent::overwriteRead($return);

        $objs = $return['objs'];
        foreach ($objs as $obj) {

            if (isset($obj->prod_pic)) {
                $obj->prod_pic = \Leap\View\InputGallery::printMainPic($obj->prod_pic, "prod_pic-" . $obj->prod_id);
            }

            if (isset($obj->prod_active)) {
                $obj->prod_active = $this->arrayYesNO[$obj->prod_active];
            }
            if (isset($obj->prod_cat_id)) {

                $cat = new MProdCat();
                $cat->getByID($obj->prod_cat_id);

                $obj->prod_cat_id = $cat->cat_name;
            }
        }
        return $return;
    }
    public function constraints ()
    {
        //err id => err msg
        $err = array ();

        if (!isset($this->prod_pic)) {
            $err['prod_pic'] = Lang::t('Picture must be provided');
        }
        else{
//            $src = _PHOTOPATH.$this->camp_pic;
//            list($iWidth,$iHeight,$type)    = getimagesize($src);
//            if(round($iWidth/$iHeight,1) != round($this->ratio_weight/$this->ratio_height,1)){
//                $err['camp_pic'] = Lang::t('Proportion is not right, please crop using our tool');
//            }
        }



        if (!isset($this->prod_name)) {
            $err['prod_name'] = Lang::t('Please provide Name');

        }

        if (!isset($this->prod_des)) {
            $err['prod_des'] = Lang::t('Description cannot be empty');
        }

        if (!isset($this->prod_price)) {
            $err['prod_price'] = Lang::t('Price cannot be empty');
        }

        if (!isset($this->prod_cat_id)) {
            $err['prod_cat_id'] = Lang::t('Category cannot be empty');
        }
        if (!isset($this->prod_stock)) {
            $err['prod_stock'] = Lang::t('Stock cannot be empty');
        }
        if(!isset($this->prod_attribute_array)){
            $err['prod_attribute_array'] = Lang::t('Attribute cannot be empty');
        }


        $this->prod_app_id = AppAccount::getAppID();




        //cek apakah paket sesuai dengan yg diperbolehkan
        $app = AppAccount::getActiveAppObject();

        //carousel 1_5
        $carousel_id = $app->app_paket_id."_8";


        $mm = new PaketMatrix();

        $mm->getByID($carousel_id);


        $limit = $mm->ps_isi;

        //get all campaign dengan app_id dan type yg diperbolehkan
        $nr = $this->getJumlah("prod_app_id = '{$this->prod_app_id}' AND prod_active = 1");

        if($this->prod_active)
        if($nr>=$limit){
            $err['prod_active'] = Lang::t('Too many products active!! Please deactivate the others. Limit is '.$limit);
        }
//        $err['prod_active'] = Lang::t($nr.' Too many products active!! Please deactivate the others. Limit is '.$limit);


//        $this->camp_updatedate = leap_mysqldate();
        return $err;
    }
}
