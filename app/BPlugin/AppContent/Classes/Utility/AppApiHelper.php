<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/13/16
 * Time: 2:20 PM
 */

class AppApiHelper {

    static $perpage = 10;

    public static function edit_typeA(){

        /*
         *  PARAMETERS all using POST
         *
         *  1.content_id
         *  2.a_id //bisa = '' atau = 0 kalau tidak ada
         *  3.articlename =  nama typeA nya, e.g about us
         *  4.tabsdata = //ini cuman id1,id2,id3,usw , id = local id
         *
         *  5.Masing2 tabs akan mempunyai
         *  'tabtitle-'+idx
         *  'contenttitle-'+idx
         *  'contenttext-'+idx
         *
         *  6.carouseldata //ini cuman id1,id2,id3
         *
         *  7.masing2 carousel akan mempunyai
         *  'carousel-'+idx
         *
         *  8.callbutton_active
         *  9.callbutton_text
         *  10.callbutton_number
         *
         *  11.emailbutton_active
         *  12.emailbutton_text
         *  13.emailbutton_mail
         *
         *  14.sharebutton_active
         *  15.sharebutton_text
         *
         *  16.price_active
         *  17.price
         *
         *  18.cat //kalau dia type C
         */

//        IMBAuth::checkOAuth();

        $headertype = addslashes($_POST['header_type']);



        if($headertype == "carousel") {
            /*$carouseldata = addslashes($_POST['carouseldata']);

            $exp = explode(",", $carouseldata);
            $array_pic = array();
            foreach ($exp as $e) {
                if ($e == "") continue;

                $array_pic[] = Crud::savePic($_POST['carousel-' . $e]);

            }
            $_POST['carouselorder'] = implode(",",$array_pic);
            $_POST['inhalt'] = json_encode(array("header_type"=>$headertype));*/
            $_POST['inhalt'] = json_encode(array("header_type"=>$headertype,"content"=>$_POST['carousel']));
        }
        if($headertype == "video") {
            $_POST['inhalt'] = json_encode(array("header_type"=>$headertype,"content"=>$_POST['video']));
//            $_POST['video'] = $_POST['videodata'];
        }
        if($headertype == "map"){
            $exp = explode(",",$_POST['map']);

//            $lat = addslashes($_POST['lat']);
//            $lng = addslashes($_POST['lng']);
//            $arrln = array("lat"=>$lat,"lng"=>$lng);
            $_POST['inhalt'] = json_encode(array("header_type"=>$headertype,"content"=>$exp));
//            $_POST['map'] = $lat.",".$lng;
        }



        $appws = new AppContentWS();
        $content_id = $appws->editTypeA(1);

        if($content_id>0) {
            $json['status_code'] = 1;
            $json['a_id'] = $content_id;
            $json['status_message'] = "Success";
            $appapi = new AppAPI();
            $appapi->edit_default_content();

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed on Saving";
        }
        echo json_encode($json);
        die();
    }

    public static function getMyTypeAFromB(){
        /*
         * PARAMETERS
         *
         * content_id
         *
         */

//        IMBAuth::checkOAuth();

        $content_id = addslashes($_POST['content_id']);

        $obj = new AppContentDraft();
        $obj->getByID($content_id);

        $cleanObj = Crud::clean2printEinzeln($obj);

//        if($obj->content_type == "TypeB"){
        // pagination
        $page = addslashes($_REQUEST['page']);
        if($page == "" || $page<1)$page = 1;

        $perpage = self::$perpage;
        $begin = ($page-1)*$perpage;


        $ta = new TypeAModelDraft();

        $total = $ta->getJumlah("a_content_id = '$content_id'");

        $arr = $ta->getWhere("a_content_id = '$content_id' ORDER BY a_order DESC,a_update_date DESC LIMIT $begin,$perpage");

        $new = array();


        foreach($arr as $aid){

            $sem = Crud::clean2printEinzeln($aid);
            $sem = $aid->cleanIsi($sem);

            $new[] = $sem;
        }
        $cleanObj['typeA'] = $new;

        $json['status_code'] = 1;

        $json['status_message'] = "Success";
        $json['page'] = $page;
        $json['total_items'] = $total;
        $json['results'] = $cleanObj;
//        }else{
//            $json['status_code'] = 0;
//
//            $json['status_message'] = "Wrong Type";
//
//        }

        echo json_encode($json);
        die();
    }

    function editTypeB(){

        /*
         * PARAMETERS
         *
         * content_id
         * articlename
         * inhalt *optional, nanti cuman untuk SocMed
         *
         * order_typeA
         *
         */
        IMBAuth::checkOAuth();

        $this->edit_default_content();

//        $appws = new AppContentWS();
//        $succ = $appws->editTypeB(1);
//
//        $json['status_code'] = $succ;
//        $json['status_message'] = "Success";
//
//        if(!$succ)$json['status_message'] = "Failed";
//
//        echo json_encode($json);
//        die();
    }


    public static function getTypeAFromTypeCCat(){

        //categoy_id


//        IMBAuth::checkOAuth();


        $category_id = addslashes($_POST['category_id']);
        if($category_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "Category ID empty";
            echo json_encode($json);
            die();
        }

        $cat = new TypeCCategoryModelDraft();
        $cat->getByID($category_id);

        if(!isset($cat->cat_id)){
            $json['status_code'] = 0;
            $json['status_message'] = "Category not found";
            echo json_encode($json);
            die();
        }

        // pagination
        $page = addslashes($_REQUEST['page']);
        if($page == "" || $page<1)$page = 1;

        $perpage = self::$perpage;
        $begin = ($page-1)*$perpage;

        //get total
        $rel = new TypeCCatRelDraft();
        $total = $rel->getJumlah("rel_cat_id = '$category_id'");

        $arr = $rel->getWhereFromMultipleTable("a_id = rel_a_id AND rel_cat_id = '$category_id' ORDER BY a_order DESC,a_update_date DESC LIMIT $begin,$perpage",array("TypeAModelDraft"));



        //blom diurutkan

//        pr($arr);
//        echo "a_category = '$category_id'";

        $isinya = array();
        $isinya['name'] = $cat->cat_name;
        $isinya['id'] = $cat->cat_id;
        $isinya['content_id'] = $cat->cat_content_id;
        $isinya['total_items'] = $total; //new
        $isinya['page'] = $page; //new

        if($cat->cat_pic != "")
            $isinya['pic'] = _BPATH._PHOTOURL.$cat->cat_pic;
        else $isinya['pic'] = "";

        $newarr = array();
        foreach ($arr as $aid) {

            //masukan
            $sem = Crud::clean2printEinzeln($aid);
            $typeA = new TypeAModelDraft();
            $typeA->fill($sem);
            $sem = $typeA->cleanIsi($sem);
            $newarr[] = $sem;


        }

        $isinya['typeA'] = $newarr;



        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = $isinya;


        echo json_encode($json);
        die();

    }

    public static function getCategoryAndTypeAFromTypeC(){

        /*
         * PARAMETERS
         *
         * content_id
         *
         */
//        IMBAuth::checkOAuth();

        $content_id = addslashes($_POST['content_id']);

        $obj = new AppContentDraft();
        $obj->getByID($content_id);

        $cleanObj = Crud::clean2printEinzeln($obj);

//        if($obj->content_type == "TypeC"){

        $rel = new TypeCCatRelDraft();
        $arr = $rel->getWhereFromMultipleTable("a_id = rel_a_id AND rel_content_id = '$content_id'",array("TypeAModelDraft"));

        //ambil catnya
        $cat = new TypeCCategoryModelDraft();
        $arrCats = $cat->getWhere("cat_content_id = '$content_id' ORDER BY cat_order ASC");

        $newCats = array();
        foreach($arrCats as $c) {
            $isinya = array();
            $isinya['name'] = $c->cat_name;
            $isinya['id'] = $c->cat_id;
            $isinya['hide'] = $c->cat_hide;
            if($c->cat_pic != "")
                $isinya['pic'] = _BPATH._PHOTOURL.$c->cat_pic;
            else $isinya['pic'] = "";

            $newarr = array();
            foreach ($arr as $aid) {
                if ($aid->rel_cat_id == $c->cat_id) {
                    //masukan
                    $sem = Crud::clean2printEinzeln($aid);
                    $typeA = new TypeAModelDraft();
                    $typeA->fill($sem);
                    $sem = $typeA->cleanIsi($sem);
                    $newarr[] = $sem;

                }
            }
            $isinya['typeA'] = $newarr;
            $newCats[] = $isinya;
        }
        $cleanObj['categories'] = $newCats;
        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = $cleanObj;

//        }else{
//            $json['status_code'] = 0;
//            $json['status_message'] = "Wrong Type";
//            $cleanObj['categories'] = array();
//        }

//        pr($cleanObj);





        echo json_encode($json);
        die();
    }

    function editTypeC(){

        $this->editTypeB();

        //yg aatas hrs dihilangkan die nya
        $this->updateTypeCCatOrder();
    }

    public static function addTypeCCat(){

//        IMBAuth::checkOAuth();

        $content_id = addslashes($_POST['content_id']);
        $cat_name = addslashes($_POST['cat_name']);
        $content_app_id = addslashes($_POST['content_app_id']);

        $appws = new AppContentWS();
        $cat_id = $appws->addTypeCCat(1);

        if($cat_id) {
            $json['status_code'] = 1;
            $json['category_id'] = $cat_id;
            $json['status_message'] = "Success";
        }
        else {
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }

        echo json_encode($json);
        die();
    }


    public static function updateTypeCCatOrder($echo = 1){

//        IMBAuth::checkOAuth();


        $content_id = addslashes($_POST['content_id']);
        $order_ids = addslashes($_POST['order_ids']);

        $appws = new AppContentWS();
        $succ = $appws->updateTypeCCatOrder(1);

        $json['status_code'] = $succ;
        $json['status_message'] = "Success";

        if(!$succ)$json['status_message'] = "Failed";

        if($echo) {
            echo json_encode($json);
            die();
        }else{
            return $json;
        }
    }

    public static function deleteTypeCCat(){

//        IMBAuth::checkOAuth();

        $content_id = addslashes($_POST['content_id']);
        $cat_id = addslashes($_POST['cat_id']);

        $appws = new AppContentWS();
        $succ = $appws->deleteTypeCCat(1);

        if($succ) {
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
        }

        if(!$succ){
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }

        echo json_encode($json);
        die();
    }
} 