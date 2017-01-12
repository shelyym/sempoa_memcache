<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:42 PM
 */

class Apps extends WebApps{

    var $access_make = "normal_user";
    function make(){

        //cek ID
        if(isset($_GET['id'])) {
            $id = addslashes($_GET['id']);
            $appAcc = new AppAccount();
            $appAcc->getByID($id);

            if ($appAcc->app_client_id != Account::getMyID()&& !in_array("master_admin",Account::getMyRoles())) {
                die("Owner's ID Mismatch");
            }
//            else {
//                ZAppFeature::clearSession();
//                //load
//                FeatureSessionLayer::loadJSON($appAcc->app_keywords);
//                session_id($appAcc->app_keywords);


//            }
        }
//        else{
//            session_regenerate_id();

            //disini harus ada step-step
//            $app = new AppFeatureSimulator();
//            $app->make();
//        }

        $app = new AppFeatureSimulator();
        $app->make();
    }
    var $access_edit = "normal_user";
    function edit(){

        //cek ID
        if(isset($_GET['id'])) {
            $id = addslashes($_GET['id']);
            $appAcc = new AppAccount();
            $appAcc->getByID($id);

            if ($appAcc->app_client_id != Account::getMyID()&& !in_array("master_admin",Account::getMyRoles())) {
                die("Owner's ID Mismatch");
            } else {
//                ZAppFeature::clearSession();
                //load
//                session_id($appAcc->app_keywords);
                FeatureSessionLayer::loadJSON($appAcc->app_keywords,$appAcc->app_id);


//                sleep(1);
//                pr($_SESSION);

                header("Location:"._SPPATH."apps/make?id=".$id);
                die();
            }
        }else{
            header("Location:"._SPPATH."apps/makenew");
            die();
        }
    }

    var $access_makenew = "normal_user";
    function makenew(){

        //clear all remaining session
        session_regenerate_id();
        ZAppFeature::clearSession();

        header("Location:"._SPPATH."apps/make");
        die();
    }
    function mobile(){

        ?>
        <div class="mpage" id="m_mobile">
            <div class="mheader" id="mheader">
                <div id="mheadertext">Business Name</div>
            </div>
            <div class="mcontent">
                <div class="mbanner" id="mbanner">


                    <div class="mslogan" id="mslogan"><div id="mslogantext"></div></div>
                    <div class="mlogo" id="mlogo">
                    </div>
                </div>

                <div class="mslist">
                    <? for($x=0;$x<10;$x++){?>
                        <div class="mlist-item">
                            <i class="glyphicon glyphicon-phone"></i> &nbsp; 081298291812
                        </div>
                        <div class="mlist-item">
                            <i class="glyphicon glyphicon-book"></i> &nbsp;  Jl Jenderal Sudirman 81
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
        <style>
            .mcontent{
                width: 271px;
                height: 385px;
                overflow-x: auto;
            }
            .mcontent::-webkit-scrollbar {
                width: 2px;
            }
            .mcontent::-webkit-scrollbar-button {
                width: 2px;
                height:5px;
            }
            .mcontent::-webkit-scrollbar-track {
                background:#eee;
                border: thin solid lightgray;
                box-shadow: 0px 0px 3px #dfdfdf inset;
                border-radius:10px;
            }
            .mcontent::-webkit-scrollbar-thumb {
                background:#999;
                border: thin solid gray;
                border-radius:10px;
            }
            .mcontent::-webkit-scrollbar-thumb:hover {
                background:#7d7d7d;
            }


            .mheader {
                width: 100%;
                height: 40px;
                line-height: 40px;
                background-color: #000000;
                color: white;

                overflow: hidden;
            }
            #mheadertext,#mslogantext{
                padding-left: 10px;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
            }
            .mbanner{
                width: 100%;
                height: 200px;
                /*background-color: orange;*/
                background: url(<?=_SPPATH;?>images/iphone.jpg);
                background-size: 100% auto;
                background-repeat: repeat;
            }

            .mlogo{
                position: relative;
                width: 80px;
                height: 80px;
                border: 3px solid #dedede;
                background-color: white;
                top: 70px;
                left: 180px;
            }
            .mslogan{
                position: relative;
                top: 160px;
                width: 100%;
                height: 40px;
                line-height: 40px;
                background-color: rgba(0,0,0,0.5);
                color: white;
                /*margin-top: -30px;*/
            }
            .mlist-item{
                height: 50px;
                line-height: 50px;
                padding-left: 10px;
                border-bottom: 1px solid #dedede;
                background-color: white;
            }
        </style>
        <?
        die();
    }

    function contact(){

        ?>
        <div class="mpage" id="m_contact">
            <div class="mheader" id="mheadercontact">
                <div id="mheadertextcontact">Contact</div>
            </div>
            <div class="map">
                Peta peta
            </div>
        </div>

        <?
        die();
    }
} 