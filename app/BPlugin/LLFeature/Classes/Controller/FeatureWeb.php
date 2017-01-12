<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/30/15
 * Time: 7:06 PM
 */

class FeatureWeb extends WebService{

    function getNews(){

        if(Efiwebsetting::getData('checkOAuth')=='yes')
            IMBAuth::checkOAuth();

        $m = addslashes($_GET['mode']);
        if($m == "news"){
            $news = new LL_News();
            $start = "news_start";
            $end = "news_end";
            $active = "news_active";
            $url = "news_url";
            $webview = "news";
            $order = "news_order DESC,news_start DESC";
        }
        elseif($m == "offer"){
            $news = new LL_Program();
            $start = "prog_date_start";
            $end = "prog_date_end";
            $active = "prog_active";
            $url = "prog_url";
            $webview = "offers";
            $order = "prog_date_start DESC";
        }else{
            $news = new CarouselMobile();
            $start = "carousel_start";
            $end = "carousel_end";
            $active = "carousel_active";
            $url = "carousel_url";
            $webview = "carousel";
            $order = "carousel_start DESC";
        }

        $json['status_code'] = 1;


        $obj = $news;

//        $arrn = $news->getWhere('news_active = 1 AND CURDATE() between news_start and news_end ORDER BY news_start DESC');

//        pr($arrn);


        $obj->default_read_coloms = $obj->crud_webservice_allowed;
        $main_id = $obj->main_id;
        $exp = explode(",",$obj->crud_webservice_allowed);
        $arrPicsToAddPhotoUrl = $obj->crud_add_photourl;
//        echo $active.' = 1 AND CURDATE() between '.$start.' and '.$end.' ORDER BY '.$start.' DESC';
        $arr = $obj->getWhere($active.' = 1 AND CURDATE() between '.$start.' and '.$end.' ORDER BY '.$order);
        $json = array();
        $json['status_code'] = 1;
        //filter
        foreach($arr as $o){
            $sem = array();
            foreach($exp as $attr){
                if(in_array($attr, $arrPicsToAddPhotoUrl)){
                    $sem[$attr] = _PHOTOURL.$o->$attr;
                }
                else{
                    if($url != "carousel_url" && $attr == $url && $o->$attr == ""){
                        $sem[$attr] = _BPATH."WebViewer/".$webview."/".$o->$main_id;
                    }else
                    $sem[$attr] = stripslashes ($o->$attr);
                }

            }
            $json["results"][] = $sem;
        }
        if(count($arr)<1){
            $json['status_code'] = 0;
            $json['status_message'] = "No Details Found";
        }

        echo json_encode($json);
        die();
    }

} 