<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/25/16
 * Time: 2:20 PM
 * Ini adalah webservice appear dan bridge
 * Appear hanya pakai 2 fungsi : register_device dan app_real
 */

class AppAPI extends WebService{

    /*
     * DEVICES
     */
    function register_device_bridge(){
        /*
         * Params
         * device_id
         * type
         * lng
         * lat
         *

         */
        IMBAuth::checkOAuth();

        $pnw = new PushNotWeb();
        $pnw->save_capsule();
    }

    function register_device(){
        /*
         * Params
         * device_id
         * type
         * lng
         * lat
         * app_id
         * app_token
         * acc_id

         */
        IMBAuth::checkOAuth();

        $pnw = new PushNotWeb();
        $pnw->save();
    }

    // max user 1000
    //max jark 1000 km
    function get_nearby(){

        IMBAuth::checkOAuth();
        //limit 1000
        $app_id = addslashes($_POST['app_id']);
        $lat_awal = addslashes($_POST['lat_awal']);
        $lng_awal = addslashes($_POST['lng_awal']);


        $begin = 0;
        $limit = 1000;

        $dev = new DeviceModel();
        global $db;

        $q = "SELECT did,dev_lng,dev_lat,SQRT(POW(69.1 * (dev_lat - $lat_awal), 2) + POW(69.1 * ($lng_awal - dev_lng) * COS(dev_lat / 57.3), 2)) AS distance
FROM {$dev->table_name} WHERE dev_app_id = '$app_id'
 HAVING distance < 1000000 ORDER by DISTANCE ASC  LIMIT $begin,$limit";
//        echo $q;

//        echo $q;
        $arr = $db->query($q,2);
//        pr($arr);

        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = Crud::clean2print($dev,$arr);
        echo json_encode($json);
        die();
    }

    /*
     * ACCOUNTS
     */

    function login_me($return = 0){

//        pr($_POST);

        //nanti dijadikan post
        $username = addslashes($_POST['usrname']);
        $password = addslashes($_POST['pswd']);

        IMBAuth::checkOAuth();

        //checksyarat
        if (!isset($username) || !isset($password)) {
            $json['status_code'] = 0;
            $json['status_message'] = "Invalid Credentials";

            if($return){
                return $json;
            }else {
                echo json_encode($json);
                die();
            }
        }

//        pr($_REQUEST);

        //load from db
        global $db;
        $acc = new Account();
        $sql =
            "SELECT * FROM {$acc->table_name} WHERE (admin_username = '$username' OR admin_email = '$username') AND admin_aktiv = 1 ";
//        echo "SQL ".$sql;

        $obj = $db->query($sql, 1);

//        pr($obj);

        $row = toRow($obj);

        $acc->fill($row);

//        pr($acc);
//        echo "hasilnya ".crypt($password, $acc->admin_password);


        if (hash_equals($acc->admin_password, crypt($password, $acc->admin_password))) {
//            $_SESSION["admin_session"] = 1;
//            $_SESSION["account"] = $obj;

//            pr($acc);
            //Update setlastlogin
            Account::setLastUpdate($acc->admin_id);

            $json['status_code'] = 1;
            $json['status_message'] = "OK";

            $json['acc']['id'] = $acc->admin_id;
            $json['acc']['username'] = $acc->admin_username;
            $json['acc']['email']= $acc->admin_email;
            $json['acc']['hash'] = $acc::updateHash($acc->admin_id);

            //get all apps

            $app2acc = new App2Acc();
            //AND app_active = 1
            $apps = $app2acc->getWhereFromMultipleTable("ac_admin_id = '".$acc->admin_id."' AND ac_app_id = app_id ORDER BY app_create_date DESC",array("AppAccount"));

//            pr($apps);
            $app = new AppAccount();
            $json['apps'] = Crud::clean2print($app,$apps);

            //get agents
            $_GET['id'] = $acc->admin_id;
            $json['agent'] = $this->got_agent();

            if($return){
                return $json;
            }else {
                echo json_encode($json);
                die();
            }

        } else {
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Password";

            if($return){
                return $json;
            }else {

                echo json_encode($json);
                die();
            }
        }

    }

    function register_me(){

        /*
         * PARAMS
         *
         * email
         * pwd
         * pwd2
         * name
         * phone
         *
         * uname if any *ignore on not web
         * marketer if any
         */
        IMBAuth::checkOAuth();

        AppearRegister::processRegister("app");
    }

    function forgot_password(){

        /*
         * PARAMS
         *
         * email
         */
        IMBAuth::checkOAuth();

        $email = addslashes($_POST['email']);

        if($email == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No Value For Email";
            echo json_encode($json);
            die();
        }
        global $db;
        $acc = new Account();
        $arr = $acc->getWhere("admin_email = '$email'");

        if(count($arr)>0){
            $sel = $arr[0];
            $hash = $acc::updateHash($sel->admin_id);



            $uname = $sel->admin_nama_depan;
            $ngawur = base64_encode(time().rand(0,100));

            $link = _BPATH."resetPassword?mx=".$ngawur."&id=".$sel->admin_id."&hk=".$hash;

            $dataEmail = new DataEmail();
            $succEmail = $dataEmail->forgotPassword($email,$uname,$link);

            if($succEmail){
                $json['status_code'] = 1;
                $json['status_message'] = "Please Check Your Email To Reset The Password";
            }else{
                $json['status_code'] = 0;
                $json['status_message'] = "Error on sending email, please try again";
            }

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Account with this email not found";

        }


        echo json_encode($json);
        die();
    }

    function edit_account(){

        IMBAuth::checkOAuth();

        $acc_id = addslashes($_POST['acc_id']);
        $password = addslashes($_POST['pswd']); //harus isi password untuk ganti account

        $email = addslashes($_POST['email']);

        $webpasswd = addslashes($_POST['webpasswd']);
        $webpasswd2 = addslashes($_POST['webpasswd2']);

        $newpass = addslashes($_POST['newpasswd']);
        $newpass2 = addslashes($_POST['newpasswd2']);

        if($email!="") {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $json['status_code'] = 0;
                $json['status_message'] = "Wrong Email Format";
                echo json_encode($json);
                die();
            }
        }
        $passwd_min = 5;
        $passwd_max = 15;

        if($webpasswd!=""){
            if(strlen($webpasswd)<$passwd_min || strlen($webpasswd)>$passwd_max){
                $json['status_code'] = 0;
                $json['status_message'] = "The web password is the wrong length. Min $passwd_min Max $passwd_max Characters.";
                echo json_encode($json);
                die();
            }
            if($webpasswd!=$webpasswd2){
                $json['status_code'] = 0;
                $json['status_message'] = "Web Password Mismatched.";
                echo json_encode($json);
                die();
            }
        }
        if($newpass!=""){
            if(strlen($newpass)<$passwd_min || strlen($newpass)>$passwd_max){
                $json['status_code'] = 0;
                $json['status_message'] = "The password is the wrong length. Min $passwd_min Max $passwd_max Characters.";
                echo json_encode($json);
                die();
            }
            if($newpass!=$newpass2){
                $json['status_code'] = 0;
                $json['status_message'] = "Password Mismatched.";
                echo json_encode($json);
                die();
            }
        }

        //check password lama
        $acc = new Account();
        $acc->getByID($acc_id);

        if (hash_equals($acc->admin_password, crypt($password, $acc->admin_password))) {
            //betul passnya
            if($email!="")$acc->admin_email = $email;
            if($webpasswd!="")$acc->admin_webpassword = Account::cryptPassword($webpasswd);
            if($newpass!="")$acc->admin_password = Account::cryptPassword($newpass);

            $succ = $acc->save();
            if($succ){
                $json['status_code'] = 1;
                $json['status_message'] = "Success";
                echo json_encode($json);
                die();
            }else{
                $json['status_code'] = 0;
                $json['status_message'] = "Email is already being used.";
                echo json_encode($json);
                die();
            }

        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Password";
            echo json_encode($json);
            die();
        }

    }
    /*
     * TENTANG APP
     */

    //add hide or not flag for content and content type
    function app_draft($return = 0){

        IMBAuth::checkOAuth();

        $id = addslashes($_GET['id']);
        $json = array();

        $appAcc = new AppAccount();
        $appAcc->getByID($id);

        $order = $appAcc->app_order_draft;
        $orderArr = explode(",",$order);

//        pr($appAcc);

        $appContent = new AppContentDraft();
        $arrContent = $appContent->getWhere("content_app_id = '$id'");


        if(count($orderArr)>1) {
            $baru = array();
            foreach ($orderArr as $nourut) {
                foreach ($arrContent as $cont) {
                    if ($nourut == $cont->content_id) {
                        $baru[] = $cont;
                    }
                }
            }
            $arrContent = $baru;
        }



//        pr($arrContent);

        $types = AppContentTemplate::getObjectOfSubclassesOf();


        $typeSudah = array();
        foreach($arrContent as $obj){

            if($obj->content_hide)continue;

            $arrayCon = array();
            $cleanObj = Crud::clean2printEinzeln($obj);

            $content_id = $obj->content_id;
            //if content_type
            if($obj->content_type == "TypeA" || $obj->content_type == "TypeAbout"){
                //ambil isinya
                $typeA = new TypeAModelDraft();
                $typeA->loadOneWithContentID($obj->content_id);
                $sem = Crud::clean2printEinzeln($typeA);
                $sem = $typeA->cleanIsi($sem);

                $cleanObj['typeA'] = $sem;
            }

            if($obj->content_type == "TypeB" || $obj->content_type == "TypePromo" || $obj->content_type == "TypeUpdate"){

                // pagination !!!
                $perpage = AppApiHelper::$perpage;

                $ta = new TypeAModelDraft();
                $arr = $ta->getWhere(" a_content_id = '".$obj->content_id."' AND a_hide = 0 ORDER BY a_order DESC,a_update_date DESC LIMIT 0,$perpage");
                $newarr = array();
                foreach($arr as $typeA){
//                    $typeA->loadOneWithContentID($obj->content_id);
                    $sem = Crud::clean2printEinzeln($typeA);
                    $sem = $typeA->cleanIsi($sem);
                    $newarr[] = $sem;
                }
                $cleanObj['typeA'] = $newarr;
            }

            if($obj->content_type == "TypeC" || $obj->content_type == "TypeProduct"){

                // pagination !!!
//                $rel = new TypeCCatRelDraft();
//                $arr = $rel->getWhereFromMultipleTable("a_id = rel_a_id AND a_hide = 0 AND rel_content_id = '$content_id'",array("TypeAModelDraft"));

                //ambil catnya //semua ?
                $cat = new TypeCCategoryModelDraft();
                $arrCats = $cat->getWhere("cat_content_id = '$content_id' AND cat_hide = 0 ORDER BY cat_order ASC");

                $newCats = array();
                foreach($arrCats as $c) {
                    $isinya = array();
                    $isinya['name'] = $c->cat_name;
                    $isinya['id'] = $c->cat_id;
                    if($c->cat_pic!="")
                    $isinya['pic'] = _BPATH._PHOTOURL.$c->cat_pic;
                    else $isinya['pic'] = "";

                    $newarr = array();
                    /*
                     //Turn off karena panggilan pagination
                    foreach ($arr as $aid) {
                        if ($aid->rel_cat_id == $c->cat_id) {
                            //masukan
                            $sem = Crud::clean2printEinzeln($aid);
                            $typeA = new TypeAModelDraft();
                            $typeA->fill($sem);
                            $sem = $typeA->cleanIsi($sem);
                            $newarr[] = $sem;

                        }
                    }*/
                    $isinya['typeA_message'] = "please use load satuan (get_content_typeB)";
                    $isinya['typeA'] = $newarr;
                    $newCats[] = $isinya;
                }
                $cleanObj['categories'] = $newCats;
            }

            if($obj->content_type == "TypeStoreLocator"){

                $sto = new CustStoreModel();




                $arrSto = $sto->getWhere("store_content_id = '$content_id' ORDER BY store_name ASC");

                $cleanObj['stores'] = Crud::clean2print($sto,$arrSto);
            }

//            if($obj->content_type == "TypeConnect")
            if($obj->content_inhalt!="")
                $cleanObj['content_inhalt'] = json_decode(stripslashes($obj->content_inhalt));

//            $arrayCon['content_object']

            $typeSudah[] = $cleanObj;



        }

        $json['status_code'] = 1;
        $json['content'] = $typeSudah;

        //get theme //set default theme
        if($appAcc->app_theme_id_draft == "" || $appAcc->app_theme_id_draft<1)$appAcc->app_theme_id_draft = 1;
        $theme = new AppThemeModel();
        $theme->getByID($appAcc->app_theme_id_draft);

        $json['theme'] = Crud::clean2printEinzeln($theme);

//        $cleanApp = Crud::clean2printEinzeln($appAcc);
//
//        if($appAcc->home_header_style_draft == "carousel_update" || $appAcc->home_header_style_draft == "") {
//
//            //bikin carousel depan
//            $typeA = new TypeAModelDraft();
//            $arrTypeA = $typeA->getWhere("a_app_id = '$id' ORDER BY a_update_date DESC LIMIT 0,6");
//            $newarr = array();
//            foreach ($arrTypeA as $typeA) {
////                    $typeA->loadOneWithContentID($obj->content_id);
//                $sem = Crud::clean2printEinzeln($typeA);
//                $sem = $typeA->cleanIsi($sem);
//                $newarr[] = $sem;
//            }
//            $json['carousel'] = $newarr;
//        }
//        if($appAcc->home_header_style_draft == "carousel_custom"){
//            $exp = explode(",",trim(rtrim($appAcc->home_header_inhalt_draft)));
//            foreach($exp as $a){
//                if($a!="")
//                    $carousel[] = _BPATH._PHOTOURL.$a;
//            }
//            $cleanApp['carousel_custom'] = $carousel;
//        }

        $cleanApp = Crud::clean2printEinzeln($appAcc);
        $carousel_array = $this->loadAllCarousel($appAcc);
        $cleanApp['carousel_custom'] = $carousel_array['carousel_custom'];
        $json['carousel_update'] = $carousel_array['carousel_update'];
        $json['app'] = $cleanApp;

        //app setting / version dll

        //inbox, store locator load di depan


        if($return)return $json;

        echo json_encode($json);
        die();
    }

    //internal function
    function loadAllCarousel($app){

//        $cleanApp = Crud::clean2printEinzeln($app);
//        if($app->home_header_style_draft == "carousel_custom"){
            $exp = explode(",",trim(rtrim($app->home_header_inhalt_draft)));
            $carousel = array();
            foreach($exp as $a){
                if($a!="")
                    $carousel[] = _BPATH._PHOTOURL.$a;
            }
//            $cleanApp['carousel_custom'] = $carousel;
//        }

//        if($app->home_header_style_draft == "carousel_update" || $app->home_header_style_draft == "") {

            //bikin carousel depan
            $typeA = new TypeAModelDraft();
            $arrTypeA = $typeA->getWhere("a_app_id = '{$app->app_id}' ORDER BY a_update_date DESC LIMIT 0,6");
            $newarr = array();
            foreach ($arrTypeA as $typeA) {
//                    $typeA->loadOneWithContentID($obj->content_id);
                $sem = Crud::clean2printEinzeln($typeA);
                $sem = $typeA->cleanIsi($sem);
                $newarr[] = $sem;
            }
//            $json['carousel'] = $newarr;
//        }
        return array("carousel_custom"=>$carousel,"carousel_update"=>$newarr);
    }

    //utk load semua apps dr user id x, if needed
    function get_user_apps(){

        IMBAuth::checkOAuth();

        $acc_id = addslashes($_POST['acc_id']);
        //get all apps

        $app2acc = new App2Acc();
        //AND app_active = 1
        $apps = $app2acc->getWhereFromMultipleTable("ac_admin_id = '".$acc_id."' AND ac_app_id = app_id ORDER BY app_create_date DESC",array("AppAccount"));

//            pr($apps);
        $app = new AppAccount();
        $json['apps'] = Crud::clean2print($app,$apps);
        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        echo json_encode($json);
        die();
    }

    function get_app(){
        $app_id = addslashes($_POST['app_id']);
        IMBAuth::checkOAuth();

        $app = new AppAccount();
        $app->getByID($app_id);

        $json['status_code'] = 1;
        $json['status_message'] = "Success";

//
//
//        $cleanApp = Crud::clean2printEinzeln($app);
//        if($app->home_header_style_draft == "carousel_custom"){
//            $exp = explode(",",trim(rtrim($app->home_header_inhalt_draft)));
//            foreach($exp as $a){
//                if($a!="")
//                    $carousel[] = _BPATH._PHOTOURL.$a;
//            }
//            $cleanApp['carousel'] = $carousel;
//        }

        $cleanApp = Crud::clean2printEinzeln($app);
        $carousel_array = $this->loadAllCarousel($app);
        $cleanApp['carousel_custom'] = $carousel_array['carousel_custom'];
        $json['carousel_update'] = $carousel_array['carousel_update'];
//        $json['app'] = $cleanApp;

        $json['app'] = $cleanApp;
        echo json_encode($json);
        die();
    }

    function add_app(){

        IMBAuth::checkOAuth();
        //apptitle
        $apptitle = addslashes($_POST['apptitle']);
        if($apptitle == ""){
            $err['apptitle'] = "App Title must be filled";
        }

        //apptitle
        $app_acc = addslashes($_POST['app_acc']);
        if($app_acc == ""){
            $err['app_acc'] = "App Account must be filled";
        }


        if(count($err)>0){
            $json['status_code'] = 0;
            $json['status_message'] = implode("\n",$err);
        }
        else {
            //add app
            $app = new AppAccount();
            $app->app_name = $apptitle;


            $app->app_create_date = leap_mysqldate();
            $app->app_active = 0;
            $app->app_client_id = $app_acc;
            $app->app_token = md5($apptitle . time());
            $app->app_pulsa = 1000;
            $app->app_paket_id = 1;

            $app->app_theme_id = 1; //white
            $app->home_header_style = "carousel_update";
            $app->home_menu_style = "list";

            $app->app_theme_id_draft = 1; //white
            $app->home_header_style_draft = "carousel_update";
            $app->home_menu_style_draft = "list";

            $app->app_version = Efiwebsetting::getData("App_Current_Version");
            $app->app_version_draft = Efiwebsetting::getData("App_Current_Version");

            $app_id = $app->save();

            if($app_id) {
                //add app2acc
                $app2acc = new App2Acc();
                $app2acc->ac_admin_id = $app_acc;
                $app2acc->ac_app_id = $app_id;
                $succ = $app2acc->save();
                if($succ) {



                    $order = AppContentDraft::createDefaultContent($app_id);

                    $app->app_order = $order;
                    $app->app_order_draft = $order;
                    $app->app_id = $app_id;
                    $app->save(1);

                    $json['status_code'] = 1;
                    $json['status_message'] = "Success";
                    $json['app_id'] = $app_id;
                    $json['app'] = Crud::clean2printEinzeln($app);

                }else{
                    $json['status_code'] = 0;
                    $json['status_message'] = "Saving Role Error";
                }
            }else{
                $json['status_code'] = 0;
                $json['status_message'] = "Saving App Error";
            }
        }

        echo json_encode($json);
        die();
    }

    function edit_app_descr(){

        //app_id
        //app_acc
        //apptitle
        //appshort
        //appfull
        //appkey
        //appicon
        //appfeat
        //apppaket

        IMBAuth::checkOAuth();

        $err = array();
        $json['bool'] = 0;
//       $json['err'] = array("apptitle"=>"harus diisi");

        $app_id = addslashes($_POST['app_id']);
        if($app_id == ""){
            $err['app_id'] = "App ID must be filled";
        }

        $app_acc = addslashes($_POST['app_acc']);
        if($app_acc == ""){
            $err['app_acc'] = "App Acc must be filled";
        }

        $apptitle = addslashes($_POST['apptitle']);
        if($apptitle == ""){
            $err['apptitle'] = "App Title must be filled";
        }
        if(strlen($apptitle) > 30){
            $err['apptitle'] = "Max 30 Chars";
        }

        $appshort = addslashes($_POST['appshort']);
        if($appshort == ""){
            $err['appshort'] = "Short Description must be filled";
        }
        if(strlen($appshort) > 80){
            $err['appshort'] = "Max 80 Chars";
        }

        $appfull = addslashes($_POST['appfull']);
        if($appfull == ""){
            $err['appfull'] = "Full Description must be filled";
        }
        if(strlen($appfull) > 4000){
            $err['appfull'] = "Max 4000 Chars";
        }

        $appkey = addslashes($_POST['appkey']);
        if($appkey == ""){
            $err['appkey'] = "Keywords must be filled";
        }

        $appicon = addslashes($_POST['appicon']);
//        if($appicon == ""){
//            $err['appicon'] = "Please insert Icon";
//        }


        $appfeat = addslashes($_POST['appfeat']);
//        if($appfeat == ""){
//            $err['appfeat'] = "Please insert Feature Graphics";
//        }

        $apppaket = addslashes($_POST['apppaket']);
//        if($apppaket == ""){
//            $err['apppaket'] = "Please select Package";
//        }

        $app = new AppAccount();
        $app->getByID($app_id);

        if($app->app_client_id  != $app_acc ){
            $err['app_client_id'] = "Client ID mismatched";
        }


        if(count($err)>0){
            $json['status_code'] = 0;
            $json['status_message'] = implode("\n",$err);
        }
        else{
            //save here
            //add app
            $app->app_name = $apptitle;
            $app->app_shortdes = $appshort;
            $app->app_fulldes = $appfull;

            if($appicon!="")
            $app->app_icon = Crud::savePic($appicon);

            if($appfeat!="")
            $app->app_feat = Crud::savePic($appfeat);

            $app->app_keywords = $appkey;

            $app->app_create_date = leap_mysqldate();
            $app->app_active = 0;
            $app->app_client_id = $app_acc;
            $app->app_token = md5($apptitle.time());
//            $app->app_pulsa = 1000;

            if($apppaket!="")
            $app->app_paket_id = $apppaket;

            $bool = $app->save();

            if($bool) {

                    $json['status_code'] = 1;
                    $json['status_message'] = "Success";
                    $json['app_id'] = $app_id;
                    $json['app'] = Crud::clean2printEinzeln($app);

            }else{
                $json['status_code'] = 0;
                $json['status_message'] = "Saving App Error";
            }
        }

        echo json_encode($json);
        die();
    }

    function change_selected_theme(){

        //app_id
        //theme_id
        //acc_id
        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        //acc_id
        $acc_id = addslashes($_POST['acc_id']);

        $pp = new AppAccount();
        $pp = AppContentHelper::checkApp($app_id,$acc_id);


        //app_id
        $theme_id = addslashes($_POST['theme_id']);
        if($theme_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }



        $theme2acc = new AppTheme2Acc();
        $arr2acc = $theme2acc->getWhere("ac_admin_id = '$acc_id'");
        $imp = array();
        foreach($arr2acc as $ac){
            $imp[] = $ac->ac_theme_id;
        }

        $theme = new AppThemeModel();
        $theme->getByID($theme_id);


        if($theme->apptheme_isfree || in_array($theme_id,$imp)) {
            $pp->app_theme_id_draft = $theme_id;
            $json['status_code'] = $pp->save();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Please Buy the theme first";
            echo json_encode($json);
            die();
        }

        if($json['status_code'])
            $json['status_message'] = "Success";
        else{
            $json['status_message'] = "Failed";
        }
        echo json_encode($json);
        die();
    }

    function get_themes(){

        IMBAuth::checkOAuth();

        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        //app_id
        $app_id = addslashes($_POST['app_id']);
        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $themes = new AppThemeModel();
        $arr = $themes->getWhere("apptheme_active = 1 ORDER BY apptheme_group ASC,apptheme_order DESC");

//        pr($arr);

        $theme2acc = new AppTheme2Acc();
        $arr2acc = $theme2acc->getWhere("ac_admin_id = '$acc_id'");
        $imp = array();
        foreach($arr2acc as $ac){
            $imp[] = $ac->ac_theme_id;
        }

//        pr($arr2acc);
        $res = array();
        foreach($arr as $them){
            $saved = Crud::clean2printEinzeln($them);
            if(in_array($them->apptheme_id,$imp)){
                //sudah dibeli
                $saved['bought'] = 1;
            }else{
                $saved['bought'] = 0;
            }

//            if($them->apptheme_isfree){
//                $saved['bought'] = 1;
//            }

            if($pp->app_theme_id_draft == $them->apptheme_id){
                $saved['equiped'] = 1;
            }else{
                $saved['equiped'] = 0;
            }
            $res[] = $saved;
        }

        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['themes'] = $res;
        $json['bought'] = $imp;

        echo json_encode($json);
        die();

        //return semua themes , kalau sdh punya di flag khusus...

    }

    function set_home_header(){

        //app_id
        //acc_id
        //header_style  //carousel_update,carousel_custom,none
        //carousel_order, only if carousel_custom
        //POST carousel_x, dimana x, explode dari carousel_order

        //app_token for later security use
        IMBAuth::checkOAuth();
        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        //app_id
        $app_id = addslashes($_POST['app_id']);
        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $header_style = addslashes($_POST['header_style']);
        if($header_style==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Home Style";
            echo json_encode($json);
            die();
        }

//        if($header_style == "carousel_custom"){
//            //
//            $carousel_order = addslashes($_POST['carousel_order']);
//            $exp = explode(",",$carousel_order);
//
//            $pp->home_header_style_draft = $header_style;
//
//            $imp = array();
//            foreach($exp as $e){
//                $URL = addslashes($_POST['carousel_'.$e]);
//
//                if(strpos($URL, "http://") !== false){
//                    //berarti dia ada isi yang lama
//                    //ambil filenamenya
//                    $filename = basename($URL);
//                    $imp[] = $filename;
//                }else{
//                    $imp[] = Crud::savePic($URL);
//                }
//            }
//            $pp->home_header_inhalt_draft = implode(",",$imp);
//
//        }
        if($header_style == "carousel_custom"){
            $carousel_order = addslashes($_POST['carousel_order']);


            $exp_new = explode(",",$carousel_order);
            $exp_old = explode(",",$pp->home_header_inhalt_draft);
            if(count($exp_new)<$exp_old){
                //delete mismatched files
                foreach($exp_old as $c_old){
                    if(!in_array($c_old,$exp_new)){
                        //delete
                        unlink(_PHOTOPATH.$c_old);
                    }
                }
            }
            $pp->home_header_style_draft = $header_style;
            $pp->home_header_inhalt_draft = $carousel_order;

        }else{
            $pp->home_header_style_draft = $header_style;
        }

        $json['status_code'] = $pp->save();
        if($json['status_code']) {
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }
        echo json_encode($json);
        die();
    }

    function save_home_carousel(){
        IMBAuth::checkOAuth();

        $carousel = addslashes($_POST['carouseldata']);

        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        //app_id
        $app_id = addslashes($_POST['app_id']);
        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        $newcar = Crud::savePic($carousel);

        if(trim(rtrim($pp->home_header_inhalt_draft))!="")
        $exp = explode(",",$pp->home_header_inhalt_draft);

        $exp[] = $newcar;

        $pp->home_header_inhalt_draft = implode(",",$exp);

        $bool = $pp->save();

        if($bool && $newcar!=""){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['carousel_asli'] = $pp->home_header_inhalt_draft;
            $carousel = array();
            $exp = explode(",",trim(rtrim($pp->home_header_inhalt_draft)));
            foreach($exp as $a){
                if($a!="")
                    $carousel[] = _BPATH._PHOTOURL.$a;
            }
            $json['carousel'] = $carousel;

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Save failed";
            echo json_encode($json);
            die();
        }
    }

    function delete_home_carousel(){

        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        //app_id
        $app_id = addslashes($_POST['app_id']);
        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        $carousel_id = addslashes($_POST['carousel_id']);
        $carousel_order = addslashes($_POST['carousel_order']);


        $exp = explode(",",$pp->home_header_inhalt_draft);
        $save= array();
        foreach($exp as $a){
            if($a == $carousel_id){
                unlink(_PHOTOPATH.$a);
            }else{
                $save[] = $a;
            }
        }
        if($carousel_order=="") {
            $pp->home_header_inhalt_draft = implode(",", $save);
        }else{
            $pp->home_header_inhalt_draft = $carousel_order;
        }
        $bool = $pp->save();
        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['carousel_asli'] = $pp->home_header_inhalt_draft;
            $carousel = array();
            $exp = explode(",",trim(rtrim($pp->home_header_inhalt_draft)));
            foreach($exp as $a){
                if($a!="")
                    $carousel[] = _BPATH._PHOTOURL.$a;
            }
            $json['carousel'] = $carousel;

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Save failed";
            echo json_encode($json);
            die();
        }
    }

    function set_home_menu_style(){

        //app_id
        //acc_id
        //menu_style  //list,grid_1,grid_2,grid_3

        //app_token for later security use
        IMBAuth::checkOAuth();

        //acc_id
        $acc_id = addslashes($_POST['acc_id']);
        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        //app_id
        $app_id = addslashes($_POST['app_id']);
        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $menu_style = addslashes($_POST['menu_style']);

        $pp->home_menu_style_draft = $menu_style;


        $json['status_code'] = $pp->save();

        if($json['status_code'])
        $json['status_message'] = "Success";
        else{
        $json['status_message'] = "Failed";
        }
        echo json_encode($json);
        die();
    }


    function publish_from_draft(){
        //app_id
        //acc_id
        IMBAuth::checkOAuth();
        //list yg hrs di takecare
        //app_order
        //app_theme_id_draft
        //home_header_style_draft
        //home_menu_style_draft

        //AppContentDraft copy ke AppContent
        //TypeCCatRelDraft
        //TypeAModelDraft
        //TypeCCategoryModelDraft
        //CustStoreModel draft
        $app_id = addslashes($_POST['app_id']);
        $acc_id = addslashes($_POST['acc_id']);

        AppContentHelper::checkApp($app_id,$acc_id);

        //save pakai file .json saja spy lebih oke..

        $_POST['id'] = $app_id;

        $ret = $this->app_draft(1);
        //override json file dengan app_id.json
        $status = AppContentHelper::createJSON($app_id,$ret);
        if($status){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            //TODO pindah typeA model draftnya ke published..utk pagination
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }
        echo json_encode($json);
        die();
    }

    /*
     * TENTANG CONTENT
     */

    //fungsi get content
    function get_content(){
        //ambil semua content dari app id
        $app_id = addslashes($_REQUEST['app_id']);

        IMBAuth::checkOAuth();

        if($app_id == "" || $app_id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Value For Application ID";
            echo json_encode($json);
            die();
        }

        $appAcc = new AppAccount();
        $appAcc->getByID($app_id);

        $order = $appAcc->app_order_draft;
        $orderArr = explode(",",$order);

//        pr($appAcc);


        $appContent = new AppContentDraft();
        $arrContent = $appContent->getWhere("content_app_id = '$app_id'");

//        pr($arrContent);



            //benarkan urutan dulu
            $baru = array();
            $sudah = array();

        while(count($orderArr)>0){
            $pop = array_shift($orderArr);

            foreach ($arrContent as $num=>$cont) {
                if($cont->content_id == $pop){
                    $baru[] = $cont;
                    unset($arrContent[$num]);
                }
            }
        }
        $arrContent2 = array_merge($baru,$arrContent);

        foreach($arrContent2 as $cont){
            $cleanObj = Crud::clean2printEinzeln($cont);

            if($cont->content_inhalt!="")
                $cleanObj['content_inhalt'] = json_decode(stripslashes($cont->content_inhalt));

            else $cleanObj['content_inhalt'] = "";

            $sudah[] = $cleanObj;

        }



        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['order'] = $appAcc->app_order_draft;
        $json['content'] = $sudah;

        echo json_encode($json);
        die();

    }

    //fungsi add content
    function add_content(){

        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $content_type = addslashes($_POST['content_type']); //TypeA,TypeB,TypeC,TypeConnect,TypeInbox,TypeStoreLocator
        $articlename = addslashes($_POST['articlename']); //optional


        //TypeA,TypeB,TypeC,TypeConnect,TypeInbox,TypeStoreLocator
//        TypeAbout,TypeContact,TypeFAQ,TypePricelist,TypeProduct,
//TypePromo,TypeUpdate

        if($app_id == "" || $app_id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Value For Application ID";
            echo json_encode($json);
            die();
        }

        $appws = new AppContentWS();
        $content_id = $appws->add(1);

        if($content_id>0) {
            $json['status_code'] = 1;
            $json['content_id'] = $content_id;
            $json['status_message'] = "Success";

            if($content_type == "TypeA" || $content_type == "TypeAbout"){
                $a = new TypeAModelDraft();
                $a->a_content_id = $content_id;
                $a->a_update_date = leap_mysqldate();
                $a->a_posting_date = leap_mysqldate();
                $a_id = $a->save();
                $json['a_id'] = $a_id;
            }
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed on Saving";
        }
        echo json_encode($json);
        die();

    }

    //fungsi save urutan
    function save_urutan(){

        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $order = addslashes($_POST['order']); //content_id1,content_id2,...

        if($app_id == "" || $app_id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Value For Application ID";
            echo json_encode($json);
            die();
        }

        $appws = new AppContentWS();
        $succ = $appws->editOrder(1);


        $json['status_code'] = $succ;
        $json['status_message'] = "Success";

        if(!$json['status_code'])
        $json['status_message'] = "Failed";

        echo json_encode($json);
        die();
    }

    //fungsi delete content
    function del_content(){

        IMBAuth::checkOAuth();

        $app_id = addslashes($_POST['app_id']);
        $content_id = addslashes($_POST['content_id']);

        if($app_id == "" || $app_id <1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Value For Application ID";
            echo json_encode($json);
            die();
        }

        $appws = new AppContentWS();
        $succ = $appws->del(1);

        if($succ>0) {
            $json['status_code'] = 1;
            $json['content_id'] = $content_id;
            $json['status_message'] = "Success Delete";
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed on Deleting";
        }
        echo json_encode($json);
        die();

    }


    function get_content_byid(){

        $cid = addslashes($_POST['content_id']);
        $appContent = new AppContentDraft();

        if($cid == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No Content ID";
            echo json_encode($json);
            die();
        }

        $appContent->getByID($cid);

        if($appContent->content_type == "TypeA"){
            $this->get_content_typeA();
        }
        if($appContent->content_type == "TypeB"){
            $this->get_content_typeB();
        }
        if($appContent->content_type == "TypeC"){
            $this->get_content_typeC();
        }
        if($appContent->content_type == "TypeStoreLocator"){
            $this->reloadStore();
        }


        $cleanObj = Crud::clean2printEinzeln($appContent);

        if($appContent->content_inhalt!="")
        $cleanObj['content_inhalt'] = json_decode(stripslashes($appContent->content_inhalt));

        else $cleanObj['content_inhalt'] = "";

        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = $cleanObj;
        echo json_encode($json);
        die();

    }

    function edit_default_content($echo = 1){
        //content_id
        //articlename
        //content_icon
        IMBAuth::checkOAuth();
        $content_id = addslashes($_POST['content_id']);
        $articlename = addslashes($_POST['articlename']);
        $content_icon = addslashes($_POST['content_icon']);


        if($content_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        $appContent->content_name = $articlename;
        $sem = "";
        if($content_icon!="") {
            //tempat simpan image sementara
            $sem = $appContent->content_icon;
            if(addslashes($_POST['api_lokal'])){
                $appContent->content_icon = $content_icon;
            }else {
                $appContent->content_icon = Crud::savePic($content_icon);
            }
        }
        $bool = $appContent->save();

        $json['status_code'] = $bool;
        if($bool) {
            $json['status_message'] = "Success";
            if($sem!="" && $sem != $appContent->content_icon){
                //add unlink image
                unlink(_PHOTOPATH.$sem);
            }
        }else
            $json['status_message'] = "Failed";



        if($echo || is_array($echo)) {
            echo json_encode($json);
            die();
        }else{
            return $json;
        }
    }

    function hide_content(){
        $cid = addslashes($_POST['content_id']);
        $appContent = new AppContentDraft();

        if($cid == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No Content ID";
            echo json_encode($json);
            die();
        }

        $appContent->getByID($cid);
        $appContent->content_hide = 1;
        $bool = $appContent->save();

        if($bool) {

            // tangani hide yang rekursive
            $typeA = new TypeAModelDraft();
            global $db;
            $q = "UPDATE {$typeA->table_name} SET a_hide = 1 WHERE a_content_id = '$cid'";
            $bool = $db->query($q,0);

            $typeCCat = new TypeCCategoryModelDraft();
            $q = "UPDATE {$typeCCat->table_name} SET cat_hide = 1 WHERE cat_content_id = '$cid'";
            $bool2 = $db->query($q,0);


            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
            echo json_encode($json);
            die();
        }

    }

    function unhide_content(){
        $cid = addslashes($_POST['content_id']);
        $appContent = new AppContentDraft();

        if($cid == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No Content ID";
            echo json_encode($json);
            die();
        }

        $appContent->getByID($cid);
        $appContent->content_hide = 0;
        $bool = $appContent->save();

        if($bool) {

            // tangani hide yang rekursive
            $typeA = new TypeAModelDraft();
            global $db;
            $q = "UPDATE {$typeA->table_name} SET a_hide = 0 WHERE a_content_id = '$cid'";
            $bool = $db->query($q,0);

            $typeCCat = new TypeCCategoryModelDraft();
            $q = "UPDATE {$typeCCat->table_name} SET cat_hide = 0 WHERE cat_content_id = '$cid'";
            $bool2 = $db->query($q,0);


            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
            echo json_encode($json);
            die();
        }

    }
    /*
     * CONTENT TYPE A, B , C versi 2
     */

    //TYPE A
    function get_content_typeA(){

        //content_id || a_id (please use a_id if not from home) *prioritas pakai a_id
        //return content, dan typeA object

        $a_id = addslashes($_POST['a_id']);
        $content_id = addslashes($_POST['content_id']);
        IMBAuth::checkOAuth();

        if($a_id != ""){
            //load using $a_id
            $aa = new TypeAModelDraft();
            $aa->getByID($a_id);

            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $sem = Crud::clean2printEinzeln($aa);
            $sem = $aa->cleanIsi($sem);
            $json['results'] = $sem;

        }else{
            //load using content id
            $appContent = new AppContentDraft();
            $appContent->getByID($content_id);

            $cleanObj = Crud::clean2printEinzeln($appContent);

            $typeA = new TypeAModelDraft();
            $typeA->loadOneWithContentID($appContent->content_id);
            $sem = Crud::clean2printEinzeln($typeA);
            $sem = $typeA->cleanIsi($sem);
            if($appContent->content_inhalt!="")
            $cleanObj['content_inhalt'] = json_decode(stripslashes($appContent->content_inhalt));
            $cleanObj['typeA'] = $sem;
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['results'] = $cleanObj;
        }
        echo json_encode($json);
        die();
    }
    function set_content_typeA(){

        //edit TypeA
        //dipakai dari dalam typeA contentnya..
        //articlename
        //content_icon
        IMBAuth::checkOAuth();

        $_POST['cat'] = $_POST['category_id'];
        AppApiHelper::edit_typeA(); //id akan di create setelah dikirim datanya
    }
    function delete_content_typeA(){

        //delete typeA dipakai dari B
        //a_id
        IMBAuth::checkOAuth();
        $a_id = addslashes($_POST['a_id']);


        if($a_id != ""){

            $aa = new TypeAModelDraft();
            $bool = $aa->delete($a_id);

        }else{
            //load using content id
            //need app_id
            $this->del_content();
        }




        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
        }
        else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
        }
        echo json_encode($json);
        die();

    }
    function save_carousel_typeA(){

        IMBAuth::checkOAuth();

        $a_id = addslashes($_POST['a_id']);
        $carousel = addslashes($_POST['carouseldata']);

        if($a_id == "" || $carousel == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No A ID";
            echo json_encode($json);
            die();
        }

        $typeA = new TypeAModelDraft();
        $typeA->getByID($a_id);

        $newcar = Crud::savePic($carousel);

        if(trim(rtrim($typeA->a_carousel))!="")
        $exp = explode(",",$typeA->a_carousel);

        $exp[] = $newcar;

        $typeA->a_carousel = implode(",",$exp);
        $bool = $typeA->save();
        if($bool && $newcar!=""){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['carousel_asli'] = $typeA->a_carousel;
            $carousel = array();
            $exp = explode(",",trim(rtrim($typeA->a_carousel)));
            foreach($exp as $a){
                if($a!="")
                    $carousel[] = _BPATH._PHOTOURL.$a;
            }
            $json['carousel'] = $carousel;

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Save failed";
            echo json_encode($json);
            die();
        }

    }
    function remove_carousel_typeA(){
        $a_id = addslashes($_POST['a_id']);
        $carousel_id = addslashes($_POST['carousel_id']);
        $carousel_order = addslashes($_POST['carousel_order']);
        if($a_id == "" || $carousel_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No A ID";
            echo json_encode($json);
            die();
        }
        $typeA = new TypeAModelDraft();
        $typeA->getByID($a_id);
        $exp = explode(",",$typeA->a_carousel);
        $save= array();
        foreach($exp as $a){
            if($a == $carousel_id){
                unlink(_PHOTOPATH.$a);
            }else{
                $save[] = $a;
            }
        }
        if($carousel_order=="") {
            $typeA->a_carousel = implode(",", $save);
        }else{
            $typeA->a_carousel = $carousel_order;
        }
        $bool = $typeA->save();
        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['carousel_asli'] = $typeA->a_carousel;
            $carousel = array();
            $exp = explode(",",trim(rtrim($typeA->a_carousel)));
            foreach($exp as $a){
                if($a!="")
                    $carousel[] = _BPATH._PHOTOURL.$a;
            }
            $json['carousel'] = $carousel;

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Save failed";
            echo json_encode($json);
            die();
        }
    }

    //TYPE B
    // pagination : bisa dipakai untuk load per page nya...
    function get_content_typeB(){

        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //return content, dan array of typeA object

        $cat_id = addslashes($_POST['category_id']);
        IMBAuth::checkOAuth();

        if($cat_id != ""){
            //load using category_id
            AppApiHelper::getTypeAFromTypeCCat();

        }else{
            //load using content id
            AppApiHelper::getMyTypeAFromB();
        }

    }
    function set_content_typeB(){

        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //articlename
        //content_icon
        //typeA_order
        //category_name \\if using category_id

        $cat_id = addslashes($_POST['category_id']);
        $content_id = addslashes($_POST['content_id']);
        $typeA_order = addslashes($_POST['typeA_order']);
        $typeA_hidden = addslashes($_POST['typeA_hidden']);

        IMBAuth::checkOAuth();
        //order disave diaman yaaaa ??? di contentnya ? atau langsung di category nya ?
        //ohhh di type A nya saja..jd bisa dipakai buat both


        $exp = explode(",",$typeA_order);
        $vis = explode(",",$typeA_hidden);
        $total = count($exp);
        $bool = 0;

        foreach($exp as $num=>$a_id){
            $aa = new TypeAModelDraft();
            $aa->getByID($a_id);
            $aa->a_order = $total-$num;


            //visibility di benarkan
            if(isset($vis[$num]))
                $aa->a_hide = $vis[$num];
            else
                $aa->a_hide = 0;

            $bool = $aa->save();
        }

        if($cat_id != ""){
            //set using category_id
            $cat_name = addslashes($_POST['category_name']);
            $cat = new TypeCCategoryModelDraft();
            $cat->getByID($cat_id);
            $cat->cat_name = $cat_name;
            $json['status_code'] = $cat->save();
            if($json['status_code']){
                $json['status_message'] = "Success";
            }
            else{
                $json['status_message'] = "Failed";
            }

        }else{
            //load using content id
            $json = $this->edit_default_content(0);
        }


        $json['updateTypeAOrderStatus'] = $bool;

        echo json_encode($json);
        die();

    }
    function delete_content_typeB(){

        //dipakai dari TypeC
        //ini adalah delete category atau delete content
        //content_id || category_id
        //utk del content need app_id

        $cat_id = addslashes($_POST['category_id']);
        IMBAuth::checkOAuth();

        if($cat_id != ""){
            //load using category_id
            $_POST['cat_id'] = $_POST['category_id'];
            AppApiHelper::deleteTypeCCat();

        }else{
            //load using content id
            //need app_id
            $this->del_content();
        }
    }
    function add_content_typeA(){

        //dipakai dari TypeB
        //a_id dan category_id
        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //dipakai kalau dari luar saja yaa... typeB saja dan TypeB nya TypeC

        IMBAuth::checkOAuth();

        $_POST['cat'] = $_POST['category_id'];
        $_POST['dari_luar'] = 1;

        //check kalau pakai content_id harus typeB
        $content_id = addslashes($_POST['content_id']);
        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($_POST['category_id']!=""){
//            if($appContent->content_type == "TypeC"){
//                $this->edit_typeA();
            AppApiHelper::edit_typeA();
//            }else{
//                $json['status_code'] = 0;
//                $json['status_message'] = "Wrong Type, Remove category_id to used as TypeB content";
//                echo json_encode($json);
//            }
        }else{
//            if($appContent->content_type == "TypeB"){
//                $this->edit_typeA();
            AppApiHelper::edit_typeA();
//            }else{
//                $json['status_code'] = 0;
//                $json['status_message'] = "Wrong Type";
//                echo json_encode($json);
//            }
        }

        //id akan di create setelah dikirim datanya
    }


    //TYPE C
    function get_content_typeC(){

        //content_id
        //return content, dan array of category with array typeA object

        AppApiHelper::getCategoryAndTypeAFromTypeC();

    }
    function set_content_typeC(){

        //articlename
        //content_icon
        //typeB_order ==> use updateTypeCCatOrder
        //typeB_hidden

//        $content_id = addslashes($_POST['content_id']);
//        $articlename = addslashes($_POST['articlename']);
//        $content_icon = addslashes($_POST['content_icon']);



        $json = $this->edit_default_content(0);

        $_POST['order_ids'] = $_POST['typeB_order'];
        $json['updateCategoryOrderStatus'] = AppApiHelper::updateTypeCCatOrder(0);

        echo json_encode($json);
        die();


    }
    function delete_content_typeC(){
        //delete content sekalian
        //app_id
        //content_id
        $this->del_content();
    }
    function add_content_typeB(){

        //dipakai dari TypeC
        //cat_name
        //app_id
        //content_id
        $_POST['cat_name'] = $_POST['category_name'];
        $_POST['content_app_id'] = $_POST['app_id'];
        AppApiHelper::addTypeCCat();

        //return
    }




    /*
     *  STORE
     */

    function addStore(){

        IMBAuth::checkOAuth();

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


        $appws = new AppContentWS();
        $succ = $appws->addStore(1);

        if($succ)
        $json['status_code'] = 1;
        else
            $json['status_code'] = 0;

        $json['status_message'] = "Success";

        if($store_id == "")
            $json['store_id'] = $succ;
        else{
            $json['store_id'] = $store_id;
        }

        if(!$succ)$json['status_message'] = "Failed";

        echo json_encode($json);
        die();



    }

    function reloadStore(){

        IMBAuth::checkOAuth();

        $content_id = addslashes($_REQUEST['content_id']);

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_type == "TypeStoreLocator") {

            $cleanObj = Crud::clean2printEinzeln($appContent);
            if ($appContent->content_inhalt != "")
                $cleanObj['content_inhalt'] = json_decode(stripslashes($appContent->content_inhalt));

            else $cleanObj['content_inhalt'] = "";


            $sto = new CustStoreModel();


            $arrSto = $sto->getWhere("store_content_id = '$content_id' ORDER BY store_name ASC");

            $stores = Crud::clean2print($sto, $arrSto);

            $cleanObj['stores'] = $stores;

            $json['status_code'] = 1;
            $json['status_message'] = "Success";

            $json['results'] = $cleanObj;

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "type mismatched";
            echo json_encode($json);
            die();
        }
    }

    function openStore(){

        IMBAuth::checkOAuth();

        $store_id = addslashes($_POST['store_id']);

        if($store_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }

        $sto = new CustStoreModel();
        $sto->getByID($store_id);


        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = Crud::clean2printEinzeln($sto);

        echo json_encode($json);
        die();
    }
    function deleteStore(){

        IMBAuth::checkOAuth();

        $store_id = addslashes($_POST['store_id']);
        $store_content_id = addslashes($_POST['content_id']);

        if($store_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No ID";
            echo json_encode($json);
            die();
        }

        $sto = new CustStoreModel();
        $sto->getByID($store_id);

        if($sto->store_content_id == $store_content_id){
            $bool = $sto->delete($store_id);

            if($bool){
                $json['status_code'] = 1;
                $json['status_message'] = "Success";
            }
            else{
                $json['status_code'] = 0;
                $json['status_message'] = "Failed";
            }
        }
        else{
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched Content ID";
        }




        echo json_encode($json);
        die();

    }
    function editStore(){}


    /*
     *  CONNECT WITH US
     */

    function save_socmed(){

        $fb_id = addslashes($_POST['fb_id']);
        $instagram_id = addslashes($_POST['instagram_id']);
        $twitter_id = addslashes($_POST['twitter_id']);
        $youtube_id = addslashes($_POST['youtube_id']);

        $content_id = addslashes($_POST['content_id']);

        //need verifications
        IMBAuth::checkOAuth();

        if($content_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_type == "TypeConnect"){
            $arr = array();
            if($fb_id!=""){
                $arr['fb_id'] = $fb_id;
            }
            if($instagram_id!=""){
                $arr['instagram_id'] = $instagram_id;
            }
            if($twitter_id!=""){
                $arr['twitter_id'] = $twitter_id;
            }
            if($youtube_id!=""){
                $arr['youtube_id'] = $youtube_id;
            }

            $appContent->content_inhalt = json_encode($arr);
            $bool = $appContent->save();

            $json['status_code'] = $bool;
            $json['status_message'] = "Success";

            //default contentnya jg bisa diganti
            if($bool)$this->edit_default_content();

            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Type";
            echo json_encode($json);
            die();
        }
    }

    /*
     *  Carousel
     */




    /*
     *  COntact
     */

    function editContact(){
        //custom

        $telp = addslashes($_POST['telp']);
        $email = addslashes($_POST['email']);
        $address = addslashes($_POST['address']);
        $additional = addslashes($_POST['additional']);
        $lat = addslashes($_POST['lat']);
        $lng = addslashes($_POST['lng']);

        $content_id = addslashes($_POST['content_id']);

        //need verifications
        IMBAuth::checkOAuth();

        if($content_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_type == "TypeContact"){
            $arr = array();
            if($telp!=""){
                $arr['telp'] = $telp;
            }
            if($email!=""){
                $arr['email'] = $email;
            }
            if($address!=""){
                $arr['address'] = $address;
            }
            if($additional!=""){
                $arr['additional'] = $additional;
            }

            if($lat!=""){
                $arr['lat'] = $lat;
            }
            if($lng!=""){
                $arr['lng'] = $lng;
            }

            if(count($arr)>0)
                $appContent->content_inhalt = json_encode($arr);
            else{
                $appContent->content_inhalt = "";
            }
            $bool = $appContent->save();

            if($bool)$this->edit_default_content();

            $json['status_code'] = $bool;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Type";
            echo json_encode($json);
            die();
        }
    }

    /*
     * FAQ
     */

    function editFAQ(){
        //custom

        $judul = addslashes($_POST['judul']);
        $text = addslashes($_POST['text']);

        $content_id = addslashes($_POST['content_id']);

        //need verifications
        IMBAuth::checkOAuth();

        if($content_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_type == "TypeFAQ"){
            $arr = array();
            if($judul!=""){
                $arr['judul'] = $judul;
            }
            if($text!=""){
                $arr['text'] = $text;
            }


            if(count($arr)>0)
                $appContent->content_inhalt = json_encode($arr);
            else{
                $appContent->content_inhalt = "";
            }
            $bool = $appContent->save();

            if($bool)$this->edit_default_content();

            $json['status_code'] = $bool;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Type";
            echo json_encode($json);
            die();
        }
    }

    /*
     * edit Pricelist()
     */

    function editPricelist(){
        //custom

        $judul = addslashes($_POST['judul']);
        $text = addslashes($_POST['text']);
        $table = addslashes($_POST['table']);

        $content_id = addslashes($_POST['content_id']);

        //need verifications
        IMBAuth::checkOAuth();

        if($content_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }

        $appContent = new AppContentDraft();
        $appContent->getByID($content_id);

        if($appContent->content_type == "TypePricelist"){
            $arr = array();
            if($judul!=""){
                $arr['judul'] = $judul;
            }
            if($text!=""){
                $arr['text'] = $text;
            }
            if($table!=""){
                $arr['table'] = $table;
            }


            if(count($arr)>0)
                $appContent->content_inhalt = json_encode($arr);
            else{
                $appContent->content_inhalt = "";
            }

            $bool = $appContent->save();

            if($bool)$this->edit_default_content();

            $json['status_code'] = $bool;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Wrong Type";
            echo json_encode($json);
            die();
        }
    }


    /*
     *  Transactions
     */
    //TODO pagination
    function get_transactions(){

        $acc_id = addslashes($_POST['acc_id']);
        IMBAuth::checkOAuth();
        if($acc_id == ""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for Content ID";
            echo json_encode($json);
            die();
        }


        $orders = new VpTransaction();
        $arrOrder = $orders->getWhere("order_acc_id = '".$acc_id."' ORDER BY order_date DESC");
        $res = array();
        if(count($arrOrder)>0) {


            foreach ($arrOrder as $num => $orders) {

                $app = new AppAccount();
                $app->getByID($orders->order_app_id);

                $paket = new Paket();
                $paket->getByID($orders->order_paket_id);

                $clean = array();
                $clean['order_id'] = $orders->order_id;
                $clean['order_date'] = $orders->order_date;
                $clean['app_name'] = $app->app_name;
                $clean['paket_name'] = $paket->paket_name;
                $clean['order_value'] = $orders->order_value;
                $clean['order_status'] = $orders->order_status;
                $res[] = $clean;

            }


        }
        $json['status_code'] = 1;
        $json['status_message'] = "Success";
        $json['results'] = $res;
        echo json_encode($json);
        die();
    }
    //TODO lengkapi transactions

    /*
     * PUSH Notifications
     */

    function register_push_notif(){

        IMBAuth::checkOAuth();

        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }


        $now = addslashes($_POST['push_now']);
        $date = addslashes($_POST['push_date']);
        $time = addslashes($_POST['push_time']);
        $title = addslashes($_POST['push_title']);
        $content = addslashes($_POST['push_content']);
        $pic = addslashes($_POST['push_pic']);

        $dev_mode_ids = addslashes($_POST['dev_mode_ids']); //lastlogged, notloggedlama, mapselector
        $dev_ids = addslashes($_POST['dev_ids']);
        //if push_date == now, maka beda approach..diregister trus langsung di push


        //process action
        $action = array();
        //call
        if($_POST['callbutton_active']){
            $action['call']['callbutton_text'] = addslashes($_POST['callbutton_text']);
            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
            $action['call']['callbutton_active']= addslashes($_POST['callbutton_active']);
        }

        //url
        if($_POST['urlbutton_active']){
            $action['url']['urlbutton_text'] = addslashes($_POST['urlbutton_text']);
            $action['url']['urlbutton_url'] = addslashes($_POST['urlbutton_url']);
            $action['url']['urlbutton_active']= addslashes($_POST['urlbutton_active']);
        }

        //email
        if($_POST['emailbutton_active']){
            $action['email']['emailbutton_text'] = addslashes($_POST['emailbutton_text']);
            $action['email']['emailbutton_mail'] = addslashes($_POST['emailbutton_mail']);
            $action['email']['emailbutton_active'] = addslashes($_POST['emailbutton_active']);
        }

        //call
        if($_POST['sharebutton_active']){
            $action['share']['value'] = 1;
            $action['share']['sharebutton_active'] = addslashes($_POST['sharebutton_active']);
            $action['share']['sharebutton_text'] = addslashes($_POST['sharebutton_text']); //new..blom di frontend 13 june
        }

        $pns = new PushNotCamp();
        $pns->camp_client_id = $acc_id;
        $pns->camp_app_id = $app_id;
        $pns->camp_title = $title;
        $pns->camp_msg = $content;
        $pns->camp_start = $date;
        $pns->camp_hour = $title;
        $pns->camp_active = 1;
        $pns->camp_create_by = $acc_id;
        $pns->camp_name = $title;
        $pns->camp_acc_ids = $dev_mode_ids;
        $pns->camp_dev_ids = $dev_ids;
        $pns->camp_img = Crud::savePic($pic);
        $pns->camp_url = serialize($action);
        $bool = $pns->save();

        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Succes";
            $json['push_object'] = Crud::clean2printEinzeln($pns);
            if($now){

                $res = $pns->push_now($bool);
                $json['push_results'] = $res;
            }


        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed on save";
        }
        echo json_encode($json);
        die();

    }


    function edit_push_notif(){

        IMBAuth::checkOAuth();

        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }


        $now = addslashes($_POST['push_now']);
        $date = addslashes($_POST['push_date']);
        $time = addslashes($_POST['push_time']);
        $title = addslashes($_POST['push_title']);
        $content = addslashes($_POST['push_content']);
        $pic = addslashes($_POST['push_pic']);

        $dev_mode_ids = addslashes($_POST['dev_mode_ids']); //lastlogged, notloggedlama, mapselector
        $dev_ids = addslashes($_POST['dev_ids']);
        //if push_date == now, maka beda approach..diregister trus langsung di push


        //process action
        $action = array();
        //call
        if($_POST['callbutton_active']){
            $action['call']['callbutton_text'] = addslashes($_POST['callbutton_text']);
            $action['call']['callbutton_number'] = addslashes($_POST['callbutton_number']);
            $action['call']['callbutton_active']= addslashes($_POST['callbutton_active']);
        }

        //url
        if($_POST['urlbutton_active']){
            $action['url']['urlbutton_text'] = addslashes($_POST['urlbutton_text']);
            $action['url']['urlbutton_url'] = addslashes($_POST['urlbutton_url']);
            $action['url']['urlbutton_active']= addslashes($_POST['urlbutton_active']);
        }

        //email
        if($_POST['emailbutton_active']){
            $action['email']['emailbutton_text'] = addslashes($_POST['emailbutton_text']);
            $action['email']['emailbutton_mail'] = addslashes($_POST['emailbutton_mail']);
            $action['email']['emailbutton_active'] = addslashes($_POST['emailbutton_active']);
        }

        //call
        if($_POST['sharebutton_active']){
            $action['share']['value'] = 1;
            $action['share']['sharebutton_active'] = addslashes($_POST['sharebutton_active']);
            $action['share']['sharebutton_text'] = addslashes($_POST['sharebutton_text']); //new..blom di frontend 13 june
        }

        $camp_id = addslashes($_POST['camp_id']);
        $pns = new PushNotCamp();
        $pns->getByID($camp_id);

        if($pns->camp_client_id != $acc_id || $pns->camp_app_id != $app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

//        $pns->camp_client_id = $acc_id;
//        $pns->camp_app_id = $app_id;
        $pns->camp_title = $title;
        $pns->camp_msg = $content;
        $pns->camp_start = $date;
        $pns->camp_hour = $title;
        $pns->camp_active = 1;
        $pns->camp_create_by = $acc_id;
        $pns->camp_name = $title;
        $pns->camp_acc_ids = $dev_mode_ids;
        $pns->camp_dev_ids = $dev_ids;
        $pns->camp_img = Crud::savePic($pic);
        $pns->camp_url = serialize($action);
        $bool = $pns->save();

        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            $json['push_object'] = Crud::clean2printEinzeln($pns);
            if($now){

                $res = $pns->push_now($bool);
                $json['push_results'] = $res;
            }
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed on save";
        }
        echo json_encode($json);
        die();

    }

    //TODO selesaikan ini
    function get_push_results(){

        IMBAuth::checkOAuth();

        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $camp_id = addslashes($_POST['camp_id']);
        $pns = new PushNotCamp();
        $pns->getByID($camp_id);

        if($pns->camp_client_id != $acc_id || $pns->camp_app_id != $app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

    }

    function test_push(){
        //ke bridge loh sampainya
        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }
        $pns = new PushNotCamp();
        $pns->getByID($camp_id);

        if($pns->camp_client_id != $acc_id || $pns->camp_app_id != $app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $api_key = $pp->app_api_access_key;
        $res = $pns->test_push($acc_id,$pp->app_name,$api_key);

        $json['status_code'] = 1;
        $json['status_message'] = "Pushed";
        $json['push_status'] = $res;
        echo json_encode($json);
        die();
    }

    function delete_push(){
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }
        $pns = new PushNotCamp();
        $pns->getByID($camp_id);

        if($pns->camp_client_id != $acc_id || $pns->camp_app_id != $app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $bool = $pns->delete($camp_id);
        if($bool){
            $json['status_code'] = 1;
            $json['status_message'] = "Success";
            echo json_encode($json);
            die();
        }else{
            $json['status_code'] = 0;
            $json['status_message'] = "Failed";
            echo json_encode($json);
            die();
        }
    }

    //TODO pagination
    function get_push(){

        IMBAuth::checkOAuth();

        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        $pns = new PushNotCamp();
        $arr = $pns->getWhere("camp_app_id = $app_id ORDER BY camp_start DESC"); //nanti status yang dipush hilang ??
        $json['status_code'] = 1;
        $json['status_message'] = "Succes";
        $json['results'] = Crud::clean2print($pns,$arr);
        echo json_encode($json);
        die();
    }

    function get_push_byid(){
        IMBAuth::checkOAuth();

        //pakai yang capsule
        $acc_id = addslashes($_POST['push_acc_id']);
        $app_id = addslashes($_POST['push_app_id']);
        $camp_id = addslashes($_POST['camp_id']);

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }
        $pns = new PushNotCamp();
        $pns->getByID($camp_id);

        if($pns->camp_client_id != $acc_id || $pns->camp_app_id != $app_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }
        $json['status_code'] = 1;
        $json['status_message'] = "Succes";
        $clean = Crud::clean2printEinzeln($pns);
        $clean['camp_url'] = unserialize($pns->camp_url);
        $json['results'] = $clean;
        echo json_encode($json);
        die();

    }

    //TODO
    function inbox_bridge(){

    }
    //TODO
    function inbox_appear(){

    }

    /*
     * AGENT separate Apps
     *
     */
    //TODO bikin agent project
    //sementara tulis sini
    //Product ...crud ada appear with product id (disini app_id), dll
    //agent .. crud, login, register, nearby, add product to agent, payment dari product ke agent, dashboard dll
    //jeruk .. crud, login , nearby, list of agent, dashboard dll

//    var $agent_url = "http://localhost:8888/appearagent/agentapi/";
    var $agent_url = "http://agent.appear.tech/agentapi/";
    var $merchant_id = "1"; //appear
    var $product_code_name = "AppearB2B";

    function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    function got_agent(){
        //cust_id
        //product_id
        //merchant_id

        //call got_agent webservice disana
        $macc_id = addslashes($_GET['id']);
        $merchant_id = $this->merchant_id;
        $codename = $this->product_code_name;

        $url = $this->agent_url."got_agent?acc_id=".$macc_id."&merchant_id=".$merchant_id."&product_id=".$codename;

        $homepage = @file_get_contents($url);
        if($_GET['test']){
            pr($homepage);
            pr($http_response_header);
        }
//        global $http_response_header;
//        pr($http_response_header);
        $kode = substr($http_response_header[0], 9, 3);

        if($kode != "200"){
            $json['status_code'] = 0;
            $json['status_message'] = "Connection Error";
            return $json;
        }else{
            return json_decode($homepage);
        }
//
//        if($this->get_http_response_code($url) != "200"){
//            $json['status_code'] = 0;
//            $json['status_message'] = "Connection Error";
//            return $json;
//        }else{
//            $homepage = file_get_contents($url);
//            return json_decode($homepage);
//        }



    }

    function agent_dapat_customer(){
        //agent_uname
        //cust_id
        //merchant_id

        $macc_id = addslashes($_REQUEST['id']);
        $merchant_id = $this->merchant_id;
        $agent_uname = addslashes($_REQUEST['agent_uname']);

        $url = $this->agent_url."agent_dapat_customer?acc_id=".$macc_id."&merchant_id=".$merchant_id."&agent_uname=".$agent_uname;

        $homepage = @file_get_contents($url);
//        global $http_response_header;
//        pr($http_response_header);
        $kode = substr($http_response_header[0], 9, 3);

        if($kode != "200"){
            $json['status_code'] = 0;
            $json['status_message'] = "Connection Error";
            echo json_encode($json);
        }else{
            echo $homepage;
        }
    }

    function agent_convert_product(){
        //agent_uname
        //cust_id
        //merchant_id
        //product_id //hitung komisi
        //transaction_id
    }
    function agent_list(){
        //merchant_id
    }
    function get_product_byCodeName(){
        //product_code_name
        //merchant_id
        //call got_agent webservice disana

        $codename = $this->product_code_name;

        $url = $this->agent_url."get_product_byCodeName?product_id=".$codename;

        $homepage = @file_get_contents($url);
//        global $http_response_header;
//        pr($http_response_header);
        $kode = substr($http_response_header[0], 9, 3);
        if($kode != "200"){
            $json['status_code'] = 0;
            $json['status_message'] = "Connection Error";
            echo json_encode($json);
        }else{
            echo $homepage;
        }
    }
    function agent_rating(){
        //agent_uname
        //id //acc_id
        //rating_star //confirm budi bentuknya apa...
        //rating_sifat
        //transaction_id
    }
    function agent_help_list(){
        //agent_uname
        //id //acc_id

    }
    function agent_send_help(){
        //agent_uname
        //id //acc_id
        //help_id
        //help_text
    }

    /*
     *  PUBLISHED
     */

    //TODO published content
    function get_content_typeB_published(){

        //content_id || category_id (please use category_id if not from home) *prioritas pakai category_id
        //return content, dan array of typeA object

        $cat_id = addslashes($_POST['category_id']);
        IMBAuth::checkOAuth();

        if($cat_id != ""){
            //load using category_id
            AppApiHelper::getTypeAFromTypeCCat();

        }else{
            //load using content id
            AppApiHelper::getMyTypeAFromB();
        }

    }

} 