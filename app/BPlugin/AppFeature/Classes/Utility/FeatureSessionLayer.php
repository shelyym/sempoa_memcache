<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 2:16 PM
 */
/*
 *  Digunakan sebagai layer komunikasi antara Data yang di form, JSON/PHP Object yg di SESSION
 *  dan Database Object
 *
 */


class FeatureSessionLayer extends WebService{

    function save(){

        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $zApp = new ZAppFeature();

        if(isset($_SESSION['FeatureSessionLayer'][$id][$zApp->arrayID])) {
            $sem = $_SESSION['FeatureSessionLayer'][$id][$zApp->arrayID];
            $_POST['item_array'] = $sem;
        }

        $new = array();
        foreach($_POST as $key=>$pos){
            if($key=='item_array'){
                $new[$key] = $pos;
            }else
            $new[$key] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($pos,'<b><i><small><big><br><div>'));
        }

        $_SESSION['FeatureSessionLayer'][$id] = $new;



        ZAppFeature::addFeature($id);

        echo 1;
        die();
    }

    public static function load($id){
        return $_SESSION['FeatureSessionLayer'][$id];
    }

    function getSelectedFeat(){
        $arr = ZAppFeature::selectedFeature();

        echo json_encode($arr);
        die();
    }

    function removeFeat(){

        $id = addslashes($_POST['id']);
        if($id == "")die("no id");

        ZAppFeature::removeFeature($id);


        echo json_encode(ZAppFeature::selectedFeature());

//        echo 1;
        die();
    }

    function updateFeatOrder(){
        $ids = addslashes($_POST['ids']);
        if($ids == "")die("no id");

        $exp = explode(",",str_replace("li___","",$ids));

        ZAppFeature::updateOrder($exp);

        echo json_encode(ZAppFeature::selectedFeature());

        die();
    }


    function addArrayItem(){

        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $arrayID = addslashes($_GET['arrayID']);
        if($arrayID == "")die("no arrayID");

        $cekID = addslashes($_GET['cekID']);
        if($cekID == "")die("no cekID");

        $cekValue = $_POST[$cekID];

        //tidak disimpan
        unset($_POST[$cekID]);

        $new = array();
        foreach($_POST as $key=>$pos){
            $new[$key] = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($pos,'<b><i><small><big><br><div>'));
        }
//        $new = $_POST;

        if($cekValue == "-1") {
            $_SESSION['FeatureSessionLayer'][$id][$arrayID][] = $new;
        }else{
            $_SESSION['FeatureSessionLayer'][$id][$arrayID][$cekValue] = $new;
        }

        $this->getArray();



    }

    function removeArrayItem(){

        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $arrayID = addslashes($_GET['arrayID']);
        if($arrayID == "")die("no arrayID");

        $pos = addslashes($_POST['pos']);

        foreach($_SESSION['FeatureSessionLayer'][$id][$arrayID][$pos] as $key=>$isi){
            if (preg_match("([^\s]+(\.(?i)(jpe?g|png|gif|bmp))$)", $isi)) {
                $exp = explode(_PHOTOURL,$isi);
//                pr($exp);
                unlink(_PHOTOPATH.$exp[1]);
//                echo "in";
            }
        }

        unset( $_SESSION['FeatureSessionLayer'][$id][$arrayID][$pos]);

        $_SESSION['FeatureSessionLayer'][$id][$arrayID] = array_values($_SESSION['FeatureSessionLayer'][$id][$arrayID]);

        $this->getArray();
    }

    function getArray(){
        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $arrayID = addslashes($_GET['arrayID']);
        if($arrayID == "")die("no arrayID");

        echo json_encode($_SESSION['FeatureSessionLayer'][$id][$arrayID]);
//        echo 1;
        die();
    }

    function setArrayOrder(){
        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $arrayID = addslashes($_GET['arrayID']);
        if($arrayID == "")die("no arrayID");

        $ids = addslashes($_POST['ids']);
        if($ids == "")die("no id");

        $exp = explode(",",str_replace($id."_arr_","",$ids));

        $existing = $_SESSION['FeatureSessionLayer'][$id][$arrayID];

        $newArr = array();

        foreach($exp as $oldkey){
            $newArr[] = $existing[$oldkey];
        }
        $_SESSION['FeatureSessionLayer'][$id][$arrayID] = $newArr;

        $this->getArray();
    }

    function saveMap(){

        $id = addslashes($_GET['id']);
        if($id == "")die("no id");

        $lat = addslashes($_GET['lat']);
        if($lat == "")die("lat");


        $lng = addslashes($_GET['lng']);
        if($lng == "")die("no lng");

        $zApp = new ZAppFeature();
        $_SESSION['FeatureSessionLayer'][$id][$zApp->arrayID] = array("lat"=>$lat,"lng"=>$lng);

        echo json_encode(array("bool"=>1));
        die();
    }

    //Themes
    function getTheme(){
        $arr = ZAppFeature::loadColor();

        echo json_encode($arr);
        die();
    }

    function saveColor(){

        ZAppFeature::saveColor($_POST);
        echo 1;
        die();
    }

    // Details
    function getDetails(){
        $arr = ZAppFeature::loadDetails();

        echo json_encode($arr);
        die();
    }

    function saveDetails(){

        ZAppFeature::saveDetails($_POST);
        echo 1;
        die();
    }

    function createJSON(){

        $selected = ZAppFeature::selectedFeature();

        $color = ZAppFeature::loadColor();

        $detail = ZAppFeature::loadDetails();

        $features = $_SESSION['FeatureSessionLayer'];

        $json['id'] = session_id();
        $json['selected'] = $selected;
        $json['color'] = $color;
        $json['detail'] = $detail;
        $json['features'] = $features;

        $app = new AppAccount();

        if(isset($_GET['id']) && $_GET['id']>0) {
            $id = addslashes($_GET['id']);

            $app->getByID($id);
            $app->load = 1;

            if ($app->app_client_id != Account::getMyID()) {
                die("Owner's ID Mismatch");
            }
            else{
                $json['id'] = $app->app_keywords;
            }
        }

        $fp = fopen(_PHOTOPATH.'json/'.$json['id'].'.json', 'w');
        fwrite($fp, json_encode($json));
        fclose($fp);

        echo 1;

        //save ke database dengan ID yang active
        //kalau disini ke save dobel2
//        $this->saveIntoApp();

        die();

    }

    public static function loadJSON($id,$app_id){
        $jsonstr = file_get_contents(_PHOTOPATH.'json/'.$id.'.json');

//        pr(_PHOTOPATH.'json/'.$id.'.json');
        $json = json_decode($jsonstr,true);

        ZAppFeature::setFeature($json['selected']);
        ZAppFeature::saveColor($json['color']);
        ZAppFeature::saveDetails($json['detail']);
        $_SESSION['FeatureSessionLayer'] = $json['features'];
        $_SESSION['ZAppFeature']['app_id'] = $app_id;
//        $arr = ZAppFeature::selectedFeature();
//        pr($arr);

        //disini harus ada step-step
//        $app = new AppFeatureSimulator();
//        $app->make();
    }

    function saveIntoApp(){

        $app = new AppAccount();

        if(isset($_GET['id']) && $_GET['id']>0) {
            $id = addslashes($_GET['id']);

            $app->getByID($id);
            $app->load = 1;

            if ($app->app_client_id != Account::getMyID()) {
                die("Owner's ID Mismatch");
            }
        }


        $detail = ZAppFeature::loadDetails();


        $app->app_client_id = Account::getMyID();
        $app->app_name = $detail['app_name'];

        $app->app_create_date = leap_mysqldate();
        $app->app_api_access_key = Efiwebsetting::getData('GCM_ACCESS_KEY');
        $app->app_token = md5(leap_mysqldate());
        $app->app_icon = $detail['app_icon'];
        $app->app_shortdes = $detail['app_des_short'];
        $app->app_feat = $detail['app_feature_img'];
        $app->app_fulldes = $detail['app_des_long'];


        if(isset($_GET['id']) && $_GET['id']>0) {
            $app->save();
            $appID = $app->app_id;

        }else{
            $app->app_keywords = session_id();
            $app->app_active = 0;
            $appID = $app->save();

            if($appID){
                $app2acc = new App2Acc();
                $app2acc->ac_admin_id = Account::getMyID();
                $app2acc->ac_app_id = $appID;
                $appID2 = $app2acc->save();
            }

        }


        $json['id'] = $appID;
        echo json_encode($json);

//        echo $appID;

        die();

    }
} 