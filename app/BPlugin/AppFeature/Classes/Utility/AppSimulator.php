<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/26/16
 * Time: 10:00 PM
 */

class AppSimulator {

    public static function page(){


$selectedFeature = ZAppFeature::selectedFeature();
$homePage = $selectedFeature[0];

$arrChildren = ZAppFeature::getChildren();
//            pr($arrChildren);

$arrObj = array();
foreach($arrChildren as $child){
    $obj = new $child();

    //kalo tidak aktif continue
    if(!$obj->feat_active)continue;

    if(!isset($arrObj[$obj->feat_rank_tampil]))
        $arrObj[$obj->feat_rank_tampil] = $obj;
    else{
        $arrObj[] = $obj;
    }


}
ksort($arrObj);
?>
<div style="margin-left: -50px">
    <div class="nexus">
        <div id="loadingmobile">
            <div style="float: left;">
                <img src="<?=_SPPATH;?>images/androidspinner2.gif">
            </div>
            <div style="float: left; margin-left: 15px;">
                loading..
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="app_desktop" style="display: none;">
            <?
            $details = ZAppFeature::loadDetails();
            ?>
            <div id="my_app_icon">
                <div id="my_app_icon_img">
                    <img id="my_app_icon_img_src" src="<?=$details['app_icon'];?>">
                </div>
                <div id="my_app_icon_text"><?=$details['app_name'];?></div>
            </div>
            <style>
                #my_app_icon{
                    width: 50px;
                    margin-left: 15px;
                    margin-top: 105px;
                    text-align: center;

                }
                #my_app_icon_img{
                    width: 40px;
                    height: 40px;
/*                    background-image: url(*/<?//=_SPPATH;?>/*images/noimage2.png);*/
/*                    background-repeat: no-repeat;*/
/*                    background-size: 100% auto;*/
                    border-radius: 2px;
                    margin-left: 5px;
                    overflow: hidden;
                }
                #my_app_icon_img_src{
                    width: 40px;
                    height: 40px;

                }
                #my_app_icon_text{
                    font-size: 11px;
                    margin-top: 5px;
                    color: white;
                }
            </style>
        </div>
        <div class="menubatterei"></div>

        <div id="splash_screen" style=" display: none; z-index: 2000;"></div>
        <div class="isiapp" id="isiapp">

            <?
            // print isi apps here
            foreach($arrObj as $obj){
                ?>
                <div class="mpage" id="m_<?=$obj->feat_id;?>" style="display: none;">
                    <?=$obj->appPage();?>
                </div>
            <? } ?>
            <div class="mpage" id="m_more" style="display: none;">
                <div class="mheader" id="mheader_more">
                    <div class="mheadertext" id="mheadertext_more">More</div>
                </div>
                <div class="mcontent" id="mcontent_more">
                    <?
                    $jumlahSelected = count($selectedFeature);
                    $cnt = 0;
                    //manage tab here
                    foreach($selectedFeature as $sel) {
                        foreach ($arrObj as $obj) {

                            if($obj->feat_id == $sel){
                                $cnt++;

                                if($cnt>5){
                                    $valuesNya = FeatureSessionLayer::load($obj->feat_id);
                                    $labelname = isset($valuesNya[$obj->feat_id.'_labelname'])?$valuesNya[$obj->feat_id.'_labelname']:$obj->feat_name;
                                    ?>
                                    <div onclick="manageView('<?=$obj->feat_id;?>');" id="list_<?=$obj->feat_id;?>" class="listview">
                                        <!--                                                      <i class="--><?//=$obj->feat_tab_icon;?><!--"></i> -->
                                        <div class="sim_maskColor" style="float:left;-webkit-mask-box-image: url(<?=$obj->icon_path.$obj->feat_tab_icon;?>);"></div>
                                        &nbsp; <span id="tabname_<?=$obj->feat_id;?>"><?=$labelname;?></span>

                                    </div>

                                <?
                                }
                            }
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <style>
            .listview{
                padding: 5px;
                border-bottom: 1px solid #dedede;
                padding-left: 10px;
                cursor: pointer;
            }
            .mtab{
                float: left;
                width: 54px;
                height: 40x;
                line-height: 40x;
                text-align: center;
                color: white;
                cursor: pointer;
            }
            .mtab-img{
                line-height: 20px;
            }
            .mtab-text{
                line-height: 20px;
                font-size: 10px;
            }
            .mtab-selected{
                background-color: rgba(255,255,255,0.3);

            }
            .mtab-selected-black{
                background-color: rgba(0,0,0,0.3) !important;

            }
        </style>
        <div class="mfooter" id="mfooter">

            <?
            $jumlahSelected = count($selectedFeature);
            $cnt = 0;
            //manage tab here
            foreach($selectedFeature as $sel){
                foreach($arrObj as $obj){

                    if($jumlahSelected>5) {
                        if ($cnt > 3) break;
                    }


                    if($obj->feat_id == $sel){
                        $cnt++;

                        $valuesNya = FeatureSessionLayer::load($obj->feat_id);
                        $labelname = isset($valuesNya[$obj->feat_id.'_labelname'])?$valuesNya[$obj->feat_id.'_labelname']:$obj->feat_name;
//                                        echo $obj->feat_id." ".$cnt;
                        ?>
                        <div onclick="manageView('<?=$obj->feat_id;?>');" class="mtab <? if($cnt == 1){?>mtab-selected<?}?>" id="tab_<?=$obj->feat_id;?>">
                            <div class="mtab-img">
                                <!--                                                <i class="--><?//=$obj->feat_tab_icon;?><!--"></i>-->
                                <div class="sim_maskColor" style="-webkit-mask-box-image: url(<?=$obj->icon_path.$obj->feat_tab_icon;?>);"></div>
                            </div>



                            <div class="mtab-text" id="tabname_<?=$obj->feat_id;?>" ><?=$labelname;?></div>
                        </div>
                        <script>
                            inTabs.push('<?=$obj->feat_id;?>');

                        </script>
                    <?

                    }
                }
            }



            $pembagi = $jumlahSelected;
            if($jumlahSelected>5){
                $pembagi = 5;
            }


            $tabwidth = floor(271/$pembagi);


            if($jumlahSelected>5){
                ?>
                <div class="mtab" onclick="showMore();"  id="tab_more">
                    <div class="mtab-img">
                        <div class="sim_maskColor" style="-webkit-mask-box-image: url(<?=$obj->icon_path;?>ic_more.png);"></div>

                    </div>
                    <div class="mtab-text">more</div>
                </div>
            <? } ?>
            <style>
                .mtab{
                    width: <?=$tabwidth;?>px;
                }
            </style>

        </div>
    </div>
</div>

        <script>
            function showMore(){
                manageView('more');
            }

            function updateShowMore(arr){

                console.log('updateShowmore');
                console.log(arr);

                var more = '';

                for(var x=0;x<arr.length;x++){
                    var attr = arr[x];

                    more += '<div onclick="manageView(\''+attr+'\');" id="list_'+attr+'" class="listview">';
                    more += '<div class="sim_maskColor" style="float:left;-webkit-mask-box-image: url('+arrFeats[attr].icon_path+arrFeats[attr].feat_tab_icon+');"></div> &nbsp; <span id="tabname_'+attr+'">'+ arrFeats[attr].label_name+'</span>';
//                    more += 'xxs<i class="'+arrFeats[attr].feat_tab_icon+'"></i> &nbsp;  <span id="tabname_'+attr+'">'+ arrFeats[attr].label_name+'</span>';

                    more += '</div>';
                }

                $('#mcontent_more').html(more);
            }
        </script>


        <style>
            .header_besar{
                font-family: "Helvetica Neue Light", "Arial", sans-serif;
                font-size: 19px;
            }
            #your_business_fields label{
                font-family: "Helvetica Neue Light", "Arial", sans-serif;
                padding-top: 10px;
                padding-bottom: 5px;
            }
            .feature_list_heading_information{
                padding-bottom: 10px;
                font-family: "Helvetica Neue Light", "Arial", sans-serif;
                margin-top: -10px;
                font-size: 13px;
            }
            .feat{
                /*float: left;*/
                width: 60px;
                height: 100px;
                cursor: pointer;
                /*margin-right: 13px;*/
                /*margin-left: 13px;*/
            }

            .feat-img{


                background-color: #dedede;
                width: 60px;
                height: 60px;
                border-radius: 60px;
                text-align: center;
                font-size: 30px;
                margin-top: 12px;
                /*padding: 5px;*/
                color: #999;
                /*border: 1px solid #dedede;*/
            }
            .feat-img-icon{
                width: 30px;
                height: 30px;
                margin-left: 15px;
                margin-top: 15px;
                position: absolute;
            }
            .feat-selected .feat-img{
                background-color: #73879C;
                color: white;
            }


            .feat-text{
                font-size: 12px;
                padding-top: 5px;
                font-family: "Helvetica Neue Light", "Arial", sans-serif;
                text-align: center;
                color: #555555;
            }

            .begin{
                /*margin-top: 28px;*/
                /*padding-right: 20px;*/
                /*padding-left: 20px;*/
            }
            .navbar-default{
                background-color: rgba(255,255,255,0.5);
            }
            .nexus{
                width: 422px;
                height: 612px;
                background: url(<?=_SPPATH;?>images/nexus5.png);
                background-size: 422px 612px;
                background-repeat: no-repeat;

                font-family: 'Roboto', sans-serif;
            }
            .menubatterei{
                /*background-color: blue;*/
                width: 271px;
                height: 16px;
                position: relative;
                top: 57px;
                left: 75px;
                overflow: hidden;
                background: url(<?=_SPPATH;?>images/atasbar.png);
                background-size: 271px 16px;
                background-repeat: no-repeat;
                /*display: none;*/
            }

            #mslogantext{
                font-size: 13px;
            }
            .isiapp{
                background-color: white;
                position: relative;
                top: 57px;
                left: 75px;
                width: 271px;
                height: 425px;
                /*overflow-x: auto;*/
                overflow: hidden;
                /*display: none;*/
            }
            #splash_screen{
                top: 57px;
                left: 75px;
                width: 271px;
                height: 466px;
                overflow: hidden;
                position: relative;
            }
            #app_desktop{
                top: 57px;
                left: 75px;
                width: 271px;
                height: 482px;
                overflow: hidden;
                position: relative;
                background-image: url('<?=_SPPATH;?>images/emptyandroid.jpg');
                background-repeat: no-repeat;
                background-size: 100% auto;
                z-index: 1005;
            }
            #mfooter{
                width: 271px;
                height: 41px;
                line-height: 41px;
                background-color: black;
                position: relative;
                top: 57px;
                left: 75px;
                overflow: hidden;
                /*display: none;*/
            }




            #loadingmobile{
                position: absolute;
                width: 150px;
                padding: 15px;
                margin-left:130px;
                margin-top: 240px;
                z-index: 1008;
                background-color: #FFFFFF;
                border: 1px solid #dedede;
            }
            #loadingmobile img{
                /*width: 100%;*/
                height: 30px;
            }
            #loadingmobile div{
                line-height: 30px;
            }


            .hiddenform::-webkit-scrollbar {
                width: 2px;
            }
            .hiddenform::-webkit-scrollbar-button {
                width: 2px;
                height:5px;
            }
            .hiddenform::-webkit-scrollbar-track {
                background:#eee;
                border: thin solid lightgray;
                box-shadow: 0px 0px 3px #dfdfdf inset;
                border-radius:10px;
            }
            .hiddenform::-webkit-scrollbar-thumb {
                background:#999;
                border: thin solid gray;
                border-radius:10px;
            }
            .hiddenform::-webkit-scrollbar-thumb:hover {
                background:#7d7d7d;
            }

            #mcontent_more{
                background-color: #222222;
                color: white;
            }
        </style>

        <style>
            .mcontent{
                width: 271px;
                height: 385px;
                overflow-x: hidden;
                overflow-y: auto;
                background-color: white;
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
            .mheadertext{
                padding-left: 10px;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
            }

        </style>

        <script>

            var homePage = '<?=$homePage;?>';
            var listOfFeat = [<?=explode(",",$selectedFeature);?>];

            $( document ).ready(function() {
//                console.log(homePage);
                // Handler for .ready() called.
                $(".mpage").hide();
                $('#m_'+homePage).show();

//                listOfFeat.push("mobile");
                updateSelectedAppAndSimulator();
            });


            function closeBlur(){
                $('.list_item_form').hide();
                $('.bgblur').hide();
            }

        </script>
    <?
    }
} 