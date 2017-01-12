<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/8/15
 * Time: 10:29 AM
 */

class APICampaign {

    static function getHome(){
        /*
         * Carousel, ratio 16:10
Campaigns, ratio 16:10
Categories
category id, name, image
Drawer
Login, Wishlist, Payment, Transactions, Logout - Static
About Us, Contact Us - Dynamic
Nembak ke URL
Additional pages dynamic, semua masuk ke sebelum logout
Application Settings
Actionbar Color - Hex code “#dedede"
Actionbar Icon Color - Black / White
Search Product
         */

        //check ada POST ga ?
        $app_id = addslashes($_POST['app_id']);

        //ambil main banner
        $camp = new MCampaignModel();
        //TODO masih harus dilimit sesuai paket yg dibeli
        $arrCarousel = $camp->getWhere("camp_app_id = '$app_id' AND camp_active = 1 AND camp_type = 'carousel' AND camp_begin <= CURDATE() AND camp_end >= CURDATE() ORDER BY camp_begin DESC ");
        //TODO masih harus dilimit sesuai paket yg dibeli
        $arrBanner = $camp->getWhere("camp_app_id = '$app_id' AND camp_active = 1 AND camp_type = 'campaign' AND camp_begin <= CURDATE() AND camp_end >= CURDATE() ORDER BY camp_begin DESC ");

        $cat = new MProdCat();
        $arrCat = $cat->getWhere("cat_app_id = '$app_id' AND cat_parent_id = 0 ORDER BY cat_name ASC");

        $json['status_code'] = 1;
        $json['status_message'] = "OK";
        $json['results']['carousel'] = APIFilter::filter($arrCarousel);
        $json['results']['campaign'] = APIFilter::filter($arrBanner);
        $json['results']['maincategories'] = APIFilter::filter($arrCat);
        $json['results']['drawer'] = array();
        $json['results']['setting'] = array();

        echo json_encode($json);
        die();
    }
} 