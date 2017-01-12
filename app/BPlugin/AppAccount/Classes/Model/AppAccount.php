<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 11/26/15
 * Time: 9:02 AM
 */

class AppAccount extends Model{

    //push__app

    //Nama Table
    public $table_name = "push__app";

    //Primary
    public $main_id = 'app_id';

    //Default Coloms for read
    public $default_read_coloms = 'app_id,app_client_id,app_name,app_active,app_icon,app_keywords,app_paket_id,app_contract_end,app_order';

    //allowed colom in CRUD filter
    public $coloumlist = 'app_id,app_client_id,app_name,app_pushname,app_shortdes,app_fulldes,app_keywords,app_icon,app_create_date,app_feat,app_active,app_pulsa,app_token,app_allowed_ip,app_api_access_key,app_type,app_contract_start,app_google_play_link,app_google_version,app_ios_link,app_ios_version,app_category,app_free_data,app_order,app_order_draft,app_theme_id,home_header_style,home_header_inhalt,home_menu_style,home_header_style_draft,home_header_inhalt_draft,home_menu_style_draft,app_theme_id_draft,app_version,app_version_draft,app_force_update';

    var $crud_webservice_allowed = 'app_id,app_client_id,app_name,app_pushname,app_shortdes,app_fulldes,app_keywords,app_icon,app_create_date,app_feat,app_active,app_pulsa,app_token,app_allowed_ip,app_api_access_key,app_type,app_contract_start,app_google_play_link,app_google_version,app_ios_link,app_ios_version,app_category,app_free_data,app_order,app_order_draft,app_theme_id,home_header_style,home_header_inhalt,home_menu_style,home_header_style_draft,home_header_inhalt_draft,home_menu_style_draft,app_theme_id_draft,app_version,app_version_draft,app_force_update';
    public $app_id;
    public $app_client_id;
    public $app_name;
    public $app_active; // 0 , 1 processed , 2 active
    public $app_pulsa;
    public $app_token;
    public $app_allowed_ip;
    public $app_api_access_key;
    public $app_pushname;
    public $app_type;
    public $app_paket_id;


    //baru
    public $app_shortdes;
    public $app_fulldes;
    public $app_keywords;
    public $app_icon;
    public $app_feat;
    public $app_create_date;
    public $app_contract_start;
    public $app_contract_end;

    public $app_google_play_link;
    public $app_google_version;
    public $app_ios_link;
    public $app_ios_version;
    public $app_category;
    public $app_free_data;

    public $app_order;
    public $app_order_draft;


    //home header and menu style
    public $home_header_style; //carousel_update,carousel_custom,none
    public $home_header_inhalt;

    //home menu
    public $home_menu_style; //list,grid_1,grid_2,grid_3

    //theme
    public $app_theme_id;

    //drafts home_header_style_draft,home_header_inhalt_draft,home_menu_style_draft,app_theme_id_draft
    var $home_header_style_draft;
    var $home_header_inhalt_draft;
    var $home_menu_style_draft;
    var $app_theme_id_draft;


    //version app_version,app_version_draft,app_force_update
    var $app_version;
    var $app_version_draft;
    var $app_force_update;


    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);




        $return['app_active'] = new Leap\View\InputSelect($this->arrayYesNO, "app_active", "app_active",
            $this->app_active);


        $acc = new Account();
        $arr1 = $acc->getWhere("admin_type = 1 ORDER BY admin_nama_depan ASC");
        foreach($arr1 as $cc){
            $arrClient[$cc->admin_id] = $cc->admin_nama_depan;
        }
        $return['app_client_id'] = new \Leap\View\InputSelect($arrClient,"app_client_id", "app_client_id", $this->app_client_id);

        $acc = new Paket();
        $arr1 = $acc->getWhere("paket_active = 1 ORDER BY paket_id ASC");

        $arrClient2["0"] = "Belum Punya Paket";
        foreach($arr1 as $cc){
            $arrClient2[$cc->paket_id] = $cc->paket_name;
        }
        $return['app_paket_id'] = new \Leap\View\InputSelect($arrClient2,"app_paket_id", "app_paket_id", $this->app_paket_id);

        $return['app_contract_start'] = new Leap\View\InputText("date","app_contract_start","app_contract_start",$this->app_contract_start);
        $return['app_contract_end'] = new Leap\View\InputText("date","app_contract_end","app_contract_end",$this->app_contract_end);
        return $return;
    }

    public static function getAppID(){
        return $_SESSION['app_id'];
    }

    public static function getActiveAppObject(){

        $app = new AppAccount();
        $app->getByID(self::getAppID());
        return $app;
    }

    public static function getActiveAppObjectFromSession(){
        return $_SESSION['app_active'];
    }

    public static function checkOwnership($app){
//        echo Account::getMyID()."<br>";
//        echo $app->app_client_id;
        if($app->app_client_id != Account::getMyID() && !in_array("master_admin",Account::getMyRoles())){
            die("Not your App");
        }
    }
} 