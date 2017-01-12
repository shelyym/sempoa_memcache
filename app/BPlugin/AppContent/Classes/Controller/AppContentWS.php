<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/19/16
 * Time: 3:51 PM
 */

class AppContentWS extends WebService{

    function editOrder($return = 0){
        $app_id = addslashes($_POST['app_id']);
        $order = addslashes($_POST['order']);

        $app = new AppAccount();
        $app->getByID($app_id);
        $app->app_order_draft = $order;

        if($return)
            return $app->save();
        else
            echo $app->save();

    }

    function add($return = 0){
        $app_id = addslashes($_POST['app_id']);
        $type = addslashes($_POST['content_type']);
        $articlename = addslashes($_POST['articlename']);

        if($articlename!="")$articlenamesave = $articlename;
        else $articlenamesave = $type;

        $appContent = new AppContentDraft();
        $appContent->content_type = $type;
        $appContent->content_app_id = $app_id;
        $appContent->content_name = $articlenamesave;
        $id = $appContent->save();

        if($return)
            return $id;
        else {
            $json['id'] = $id;
            echo json_encode($json);
            die();
        }
    }

    function del($return = 0){
        $app_id = addslashes($_POST['app_id']);
        $content_id = addslashes($_POST['content_id']);

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_app_id == $app_id){
            $bool = $appContent->delete($content_id);
        }
        else{
            $bool = 0;
        }

        if($return){
            return $bool;
        }else {
            $json['bool'] = $bool;
            echo json_encode($json);
            die();
        }
    }


    function openURL(){
        $content_id = addslashes($_GET['id']);

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        $classname = $appContent->content_type;
        $bar=new $classname();
        $bar->content = $appContent;
        ?>
        <div id="wadah_item" class="animated fadeInUp">

        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px; background-color: white;">
            <?

            $bar->createForm();

//            pr($appContent);
            ?>

        </div>
        <div class="clearfix"></div>
        <style>

            .edu_item_descr{
                height: 325px;
                overflow: auto;
                padding: 20px;
            }
            .edu_like{
                border-top:1px solid #e1e1e1;
                margin-left: 10px;
                margin-right: 10px;
                line-height: 39px;
                font-size: 20px;
            }
            .like{
                color: #b0d237;
                font-size: 15px;
                line-height: 30px;
                margin-left: 10px;
            }
            #edu_links{
                min-width: 125px;
                position:absolute;
                margin-top: -90px;
                margin-left: -100px;
                background-color: #b0d237;
                padding: 5px;
                padding-left: 10px;
            }
            #edu_links a{
                color: white;
                text-decoration: none;

            }
            @media (max-width: 768px) {
                .monly {
                    display: block;
                }

                .donly {
                    display: none;
                }
                .edu_item_descr{
                    min-height: auto;
                    height: auto;
                    overflow: auto;
                    padding: 10px;
                }
            }

        </style>
        </div>


<?
    }

    function editTypeA($return = 0){


//        pr($_POST);

        /*
         *
     [articlename] => TypeA
    [carousel] =>
    [tabsdata] => 2,1,3
        content_id
        a_id
    [tabtitle] =>
    [contenttitle] =>
    [contenttext] =>
    [tabtitle-1] =>
    [contenttitle-1] =>
    [contenttext-1] =>
    [tabtitle-2] =>
    [contenttitle-2] =>
    [contenttext-2] =>
    [tabtitle-3] =>
    [contenttitle-3] =>
    [contenttext-3] =>
    [callbutton_text] =>
    [callbutton_number] =>
    [callbutton_active] => on
    [emailbutton_text] =>
    [emailbutton_mail] =>
    [emailbutton_active] => on
    [sharebutton_active] => on
    [price] =>
    [price_active] => on

     [urlbutton_text] =>
    [urlbutton_url] =>
    [urlbutton_active] => on
)

        OK lets save this
         */
        $content_id = addslashes($_POST['content_id']);
        $a_id = addslashes($_POST['a_id']);

        /*if($content_id!="" && !$_POST['dari_luar']) {
            $content = new AppContentDraft();
            $content->getByID($content_id);

            if (isset($_POST['articlename']) && $_POST['articlename'] != "") {
                $content->content_name = addslashes($_POST['articlename']);

            }
            $content_icon = addslashes($_POST['content_icon']);
            $sem = "";
            if ($content_icon != "") {
                $sem = $content->content_icon;
                if(addslashes($_POST['api_lokal'])){
                    $content->content_icon = addslashes($_POST['content_icon']);
                }else {
                    //tempat simpan image sementara
                    $content->content_icon = Crud::savePic($content_icon);
                }
            }

            $content_inhalt = addslashes($_POST['inhalt']);
            $content->content_inhalt = $content_inhalt;

            if ($content->save()) {
                if ($sem != "") {
                    //remove old picture
                    unlink(_PHOTOPATH . $sem);
                }
            }
        }*/

        //process msg
        $msg = array();
        $msg['tabsdata'] = addslashes($_POST['tabsdata']);

        $tabsdata_active = explode(",",addslashes($_POST['tabsdata_active']));

        $exp = explode(",",$msg['tabsdata']);
        foreach($exp as $e){
//            if($e == "" || $e <1 )continue;
            if($e == "" )continue;
            $obj = array();
            $obj['id'] = $e;
            $obj['tabtitle'] = addslashes($_POST['tabtitle-'.$e]);
            $obj['contenttitle'] = addslashes($_POST['contenttitle-'.$e]);
            $obj['contenttext'] = addslashes($_POST['contenttext-'.$e]);

            if(count($tabsdata_active)>0)
            if(in_array($e,$tabsdata_active)){
                $obj['is_active'] = 1;
            }else{
                $obj['is_active'] = 0;
            }

            $msg['content'][$e] = $obj;
        }

        //process action
        $action = array();
        //call
//        if($_POST['callbutton_active']){
            $action['call']['callbutton_text'] = addslashes($_POST['callbutton_text']);
            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
            $action['call']['callbutton_active']= addslashes($_POST['callbutton_active']);
//        }

        //url
//        if($_POST['urlbutton_active']){
            $action['url']['urlbutton_text'] = addslashes($_POST['urlbutton_text']);
            $action['url']['urlbutton_url'] = addslashes($_POST['urlbutton_url']);
            $action['url']['urlbutton_active']= addslashes($_POST['urlbutton_active']);
//        }

        //email
//        if($_POST['emailbutton_active']){
            $action['email']['emailbutton_text'] = addslashes($_POST['emailbutton_text']);
            $action['email']['emailbutton_mail'] = addslashes($_POST['emailbutton_mail']);
            $action['email']['emailbutton_active'] = addslashes($_POST['emailbutton_active']);
//        }

        //call
//        if($_POST['sharebutton_active']){
            $action['share']['value'] = 1;
            $action['share']['sharebutton_active'] = addslashes($_POST['sharebutton_active']);
            $action['share']['sharebutton_text'] = addslashes($_POST['sharebutton_text']);
            $action['share']['sharebutton_url'] = addslashes($_POST['sharebutton_url']);
            //new..blom di frontend 13 june
//        }

        //price
//        if($_POST['price_active']){
            $action['price']['value'] = addslashes($_POST['price']);
            $action['price']['price_active'] = addslashes($_POST['price_active']);
//            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
//        }


//        pr($action);
//        pr($msg);

        $typeA = new TypeAModelDraft();

        //cek apa reload
        if($a_id!=""&&$a_id>0) {
            $typeA->a_id = $a_id;
            $typeA->getByID($a_id);
        }

//        if($_POST['header_type']=="carousel") {
////            echo "<br>carouselorder".$_POST['carouselorder'];
//            $typeA->a_carousel = addslashes($_POST['carouselorder']);
//        }else{
//            if($a_id!=""&&$a_id>0){
//                $typeA->getByID($a_id);
//            }
//        }
        $exp_new = explode(",",addslashes($_POST['carousel']));
        $exp_old = explode(",",$typeA->a_carousel);
        if(count($exp_new)<$exp_old){
            //delete mismatched files
            foreach($exp_old as $c_old){
                if(!in_array($c_old,$exp_new)){
                    //delete
                    unlink(_PHOTOPATH.$c_old);
                }
            }
        }

        $typeA->a_carousel = addslashes($_POST['carousel']);

//        if($_POST['video']!="")
        $typeA->a_video = addslashes($_POST['video']);
//        if($_POST['map']!="")
        $typeA->a_map = addslashes($_POST['map']);


        $typeA->a_content_id = $content_id;
        $typeA->a_update_date = leap_mysqldate();
        $typeA->a_posting_date = leap_mysqldate();
        $typeA->a_action = serialize($action);
        $typeA->a_msg = serialize($msg);
        $typeA->a_price = addslashes($_POST['price']);
        $typeA->a_app_id = $content->content_app_id;
        $typeA->a_header_type = addslashes($_POST['header_type']);
        $typeA->a_category = addslashes($_POST['cat']);


//        pr($typeA);

        $json['bool'] = $typeA->save(1);


        if(isset($_POST['cat'])&& $_POST['cat'] != "" && $_POST['cat']>0) {
            //category
            $typec = new TypeCCatRelDraft();

            if ($a_id != "" && $a_id > 0) {
                $typec->rel_a_id = $a_id;
            } else {
                $typec->rel_a_id = $json['bool'];
            }

            $typec->rel_content_id = $content_id;
            $typec->rel_cat_id = $typeA->a_category;
            $typec->rel_id = $typec->rel_a_id . "_" . $typec->rel_cat_id;
            $typec->save(1);
        }


        if($return){
            return $json['bool'];
        }else {
            echo json_encode($json);
            die();
        }

//        pr($_POST);


    }


    function createTypeA(){

        $id = addslashes($_GET['id']);

        $cont = new AppContentDraft();
        $cont->getByID($id);
        $dariLuar = 1;

        $classname = $cont->content_type;
        $bar=new $classname();
        $bar->content = $cont;

        $onSuccessJS = $bar->onSuccessJS;
        $onFailedJS = $bar->onFailedJS;

        $ta = new TypeAModelDraft();
        $ta->a_title = $bar->name;
        $ta->printForm($bar->content,0,$onSuccessJS,$onFailedJS,$dariLuar);
    }

    function editTypeAFromOutside(){

        $id = addslashes($_GET['id']);
        $content_id = addslashes($_GET['content_id']);
        $dariLuar = 1;

        $cont = new AppContentDraft();
        $cont->getByID($content_id);

        $classname = $cont->content_type;
        $bar=new $classname();
        $bar->content = $cont;

        $onSuccessJS = $bar->onSuccessJS;
        $onFailedJS = $bar->onFailedJS;

        $ta = new TypeAModelDraft();
        $ta->a_title = $bar->name;
        $ta->printForm($bar->content,$id,$onSuccessJS,$onFailedJS,$dariLuar);
    }

    function getMyTypeAFromB(){

        $content_id = addslashes($_GET['content_id']);
        $ta = new TypeAModelDraft();
        $arr = $ta->selectAllIDs($content_id);

        ?>

<? foreach($arr as $aid){
    $msg = unserialize($aid->a_msg);
    ?>
    <div class="col-md-2" >
        <div style="background-color: #dedede; margin: 10px; padding: 10px;" class="name" onclick="loadPopUp2('<?=_SPPATH;?>AppContentWS/editTypeAFromOutside?content_id=<?=$content_id;?>&id=<?=$aid->a_id;?>','typea_<?=$aid->a_id;?>','typeb_edit_typea');"><?=$aid->a_id;?></div>
    </div>
<?
} ?>
<?
    }

    function editTypeB($return = 0){


        $content_id = addslashes($_POST['content_id']);


        $content = new AppContentDraft();
        $content->getByID($content_id);

        if(isset($_POST['articlename']) && $_POST['articlename'] != "") {
            $content->content_name = addslashes($_POST['articlename']);
        }

        if(isset($_POST['inhalt']) && $_POST['inhalt'] != "") {
            $content->content_inhalt = addslashes($_POST['inhalt']);
        }

        $succ = $content->save();


        if($return){
            return $succ;
        }else {
            echo $succ;
            die();
        }
    }

    function addTypeCCat($return = 0){
        $content_id = addslashes($_POST['content_id']);
        $cat_name = addslashes($_POST['cat_name']);
        $content_app_id = addslashes($_POST['content_app_id']);

        $content = new AppContentDraft();
        $content->getByID($content_id);

        if($content->content_app_id != $content_app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong App";

            echo json_encode($json);
            die();
        }

        $cat =new TypeCCategoryModelDraft();
        $cat->cat_name = $cat_name;
        $cat->cat_content_id = $content_id;
        $cat->cat_app_id = $content_app_id;
        $json['bool'] = $cat->save();

        if($return){
            return $json['bool'];
        }else {
            echo json_encode($json);
            die();
        }


    }


    function updateTypeCCatOrder($return = 0){
        $content_id = addslashes($_POST['content_id']);
        $order_ids = addslashes($_POST['order_ids']);

        $typeB_hidden = addslashes($_POST['typeB_hidden']);

        $exp = explode(",",$order_ids);
        $vis = explode(",",$typeB_hidden);

        foreach($exp as $num=>$e){
            $cat =new TypeCCategoryModelDraft();
            $cat->getByID($e);
            $cat->cat_order = $num;
            if(isset($vis[$num])){
                $cat->cat_hide  = $vis[$num];
            }
            else $cat->cat_hide = 0;

            $suc = $cat->save();
        }

        if($return){
            return $suc;
        }else {
            echo $suc;
            die();
        }
    }

    function deleteTypeCCat($return = 0){
        $content_id = addslashes($_POST['content_id']);
        $cat_id = addslashes($_POST['cat_id']);

        $cat =new TypeCCategoryModelDraft();
        $json['bool'] = $cat->delete($cat_id);

        //nanti juga hapus dll



        if($return){
            return $json['bool'];
        }else {
            echo json_encode($json);
            die();
        }

    }

    function addStore($return = 0){
        $store_name = addslashes($_POST['store_name']);
        $store_descr = addslashes($_POST['store_descr']);
        $store_phone = addslashes($_POST['store_phone']);
        $store_email = addslashes($_POST['store_email']);
        $opening_hour = addslashes($_POST['opening_hour']);
        $store_address = addslashes($_POST['store_address']);
        $store_id = addslashes($_POST['store_id']);

        $lat = addslashes($_POST['lat']);
        $lng = addslashes($_POST['lng']);
        $app_id = addslashes($_POST['app_id']);

        $content_id = addslashes($_POST['content_id']);



        $sto = new CustStoreModel();
        $sto->store_descr = $store_descr;
        $sto->store_name = $store_name;
        $sto->phone = $store_phone;
        $sto->email = $store_email;
        $sto->address = $store_address;
        $sto->opening_hour = $opening_hour;
        $sto->latitude = $lat;
        $sto->longitude = $lng;
        $sto->store_app_id = $app_id;
        $sto->store_content_id = $content_id;
        $sto->store_aktif = 1;

        if($store_id!=''&&$store_id>0){
            $sto->store_id = $store_id;
        }


        $json['bool'] = $sto->save(1);

        if($return){
            return $json['bool'];
        }else {
            echo json_encode($json);
            die();
        }


    }

    function reloadStore(){
        $sto = new CustStoreModel();

        $app_id = addslashes($_REQUEST['app_id']);
        $content_id = addslashes($_REQUEST['content_id']);


        $arrSto = $sto->getWhere("store_content_id = '$content_id' ORDER BY store_name ASC");

        foreach($arrSto as $sto){

            ?>
            <div class="store_item">
                <div onclick="openStore('<?=$sto->store_id;?>');" class="store_item_name"><?=$sto->store_name;?></div>
            </div>
            <?

        }
    }

    function openStore($return = 0){
        $store_id = addslashes($_POST['store_id']);

        $sto = new CustStoreModel();
        $sto->getByID($store_id);

        $json = Crud::clean2printEinzeln($sto);
        $json['bool'] = 1;

//        echo json_encode($json);
//        die();

        if($return){
            return $json['bool'];
        }else {
            echo json_encode($json);
            die();
        }
    }
} 