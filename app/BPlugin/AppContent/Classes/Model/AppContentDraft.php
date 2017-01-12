<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/19/16
 * Time: 2:55 PM
 */

class AppContentDraft extends Model{

    //

    var $table_name = "push__app_content_draft";
    var $main_id = "content_id";

    var $content_id;
    var $content_name;
    var $content_icon;
    var $content_type;
    var $content_app_id;

    //Default Coloms
    var $default_read_coloms = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $coloumlist = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $crud_webservice_allowed = "content_id,content_name,content_icon,content_type,content_app_id,content_inhalt,content_hide";

    var $content_inhalt;
    var $content_hide;



    public static function createDefaultContent($app_id){


        $types = AppContentTemplate::getObjectOfSubclassesOf();
        foreach($types as $type){

            if($type->isSingular) {

                $appContent = new AppContentDraft();
                $appContent->content_app_id = $app_id;
                $appContent->content_name = $type->name;
                $appContent->content_type = get_class($type);
                $appContent->content_inhalt = "";

                if(is_subclass_of($type,"TypeA")){

                    $content_id = $appContent->save();

                    $a = new TypeAModelDraft();
                    $a->a_content_id = $content_id;
                    $a->a_update_date = leap_mysqldate();
                    $a->a_posting_date = leap_mysqldate();
                    $a_id = $a->save();

                    $ids[] = $content_id;
                }else {

                    $ids[] = $appContent->save();
                }
            }
        }

        //create default content

//        //Update
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Latest Update";
//        $appContent->content_type = "TypeUpdate";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Promotion
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Promotions";
//        $appContent->content_type = "TypePromo";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Products
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Product List";
//        $appContent->content_type = "TypeProduct";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();


//        //Update
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Latest Update";
//        $appContent->content_type = "TypeUpdate";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Promotion
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Promotions";
//        $appContent->content_type = "TypePromo";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Products
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Product List";
//        $appContent->content_type = "TypeProduct";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//
//        //pricelist
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Price List";
//        $appContent->content_type = "TypePricelist";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//        //FAQ
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "FAQ";
//        $appContent->content_type = "TypeFAQ";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //ABOUT
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "About Us";
//        $appContent->content_type = "TypeAbout";
//        $appContent->content_inhalt = "";
//        $content_id = $appContent->save();
//
//        $a = new TypeAModelDraft();
//        $a->a_content_id = $content_id;
//        $a->a_update_date = leap_mysqldate();
//        $a->a_posting_date = leap_mysqldate();
//        $a_id = $a->save();
////        $json['a_id'] = $a_id;
//
//        $ids[] = $content_id;
//
//        //Contact With Us
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Contact Us";
//        $appContent->content_type = "TypeContact";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Contact With Us
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Stores";
//        $appContent->content_type = "TypeStoreLocator";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//        //Contact With Us
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Connect with us";
//        $appContent->content_type = "TypeConnect";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();
//
//
//
//        //INBOX
//        $appContent = new AppContentDraft();
//        $appContent->content_app_id = $app_id;
//        $appContent->content_name = "Inbox";
//        $appContent->content_type = "TypeInbox";
//        $appContent->content_inhalt = "";
//        $ids[] = $appContent->save();



        return implode(",",$ids);
    }
} 