<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/26/16
 * Time: 9:53 PM
 */

class AppPageFeat {

    public static function page(){
        $selectedFeature = ZAppFeature::selectedFeature();

//        pr($selectedFeature);
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
        //            pr($arrObj);
        ?>
        <style>
            .sim_textColor{
                color: white;
            }
            .sim_maskColor{
                /*background-color: white;*/
                width: 15px;
                height: 15px;
                margin: auto;
                margin-top: 5px;
            }
            .bgblur{
                position: fixed;
                width: 100%;
                height: 100%;
                top:0px;
                left: 0px;
                background-color: rgba(0,0,0,0.8);
                z-index: 1031;
            }
            .list_item_form{
                position: fixed;
                top: 50%;
                left: 50%;
                width: auto;
                height: auto;

                -webkit-transform: translateX(-50%) translateY(-50%);
                -moz-transform: translateX(-50%) translateY(-50%);
                -ms-transform: translateX(-50%) translateY(-50%);
                -o-transform: translateX(-50%) translateY(-50%);
                transform: translateX(-50%) translateY(-50%);
                z-index: 1032;
                background-color: white;
                border-radius: 3px;

                max-height: 90%;
                overflow: auto;
            }
            .list_item_form::-webkit-scrollbar {
                width: 2px;
            }
            .list_item_form::-webkit-scrollbar-button {
                width: 2px;
                height:5px;
            }
            .list_item_form::-webkit-scrollbar-track {
                background:#eee;
                border: thin solid lightgray;
                box-shadow: 0px 0px 3px #dfdfdf inset;
                border-radius:10px;
            }
            .list_item_form::-webkit-scrollbar-thumb {
                background:#999;
                border: thin solid gray;
                border-radius:10px;
            }
            .list_item_form::-webkit-scrollbar-thumb:hover {
                background:#7d7d7d;
            }
        </style>

        <script>


            var inTabs = [];
            var selectedTab = '<?=$selectedFeature[0];?>';

            var arrFeats = {};


            function removeAppFeature(id){

                $.post("<?=_SPPATH;?>FeatureSessionLayer/removeFeat",{id:id},function(data){
                    console.log('kiriman feature ');
                    console.log(data);
//                    alert(data);
                    $(".hiddenform").hide();

                    selectedTab = data[0];

                    $(".mpage").hide();
                    $('#m_'+selectedTab).show();

//                    manageView(data[0]);

                    updateSelectedAppAndSimulator();


                    if(data.length <2){
                        $('.jumlahwarning').show();
                    }


                    $("#wadahbutton_"+id+"_1").hide();
                    $("#wadahbutton_"+id+"_2").show();
                },'json');
            }

            function updateSelectedAppAndSimulator(){

                $('.jumlahwarning').hide();

                console.log("selectedTab : "+selectedTab);

                //update warna selected
                $.get("<?=_SPPATH;?>FeatureSessionLayer/getSelectedFeat",function(data){

                    console.log("feats");
                    console.log(data);

                    var jumlahSelected = data.length;

                    var sisaNya = [];

                    var tabs = '';
                    $(".feat").removeClass("feat-selected");


                    for(var x=0;x<data.length;x++){

                        var attr = data[x];
                        //update iconss

                        $("#icon_"+data[x]).addClass("feat-selected");
//                        console.log("update "+data[x]);

                        if(jumlahSelected>5) {
                            if(x>3){
                                sisaNya.push(data[x]);

                            }else{
                                //update tabss
                                tabs += '<div onclick="manageView(\''+data[x]+'\');" class="mtab ';
                                if(data[x] == selectedTab) tabs += 'mtab-selected';
                                tabs += '" id="tab_'+data[x]+'">';
                                tabs += '<div class="mtab-img">' +
                                '<div class="sim_maskColor" style="-webkit-mask-box-image: url('+arrFeats[attr].icon_path+arrFeats[attr].feat_tab_icon+');"></div>' +
                                '</div>';

//                                tabs += '<div class="mtab-img"><i class="'+arrFeats[attr].feat_tab_icon+'"></i></div>';
                                tabs += '<div class="mtab-text" id="tabname_'+data[x]+'">'+arrFeats[attr].label_name+'</div></div>';
                            }
                        }else{
                            //update tabss
                            tabs += '<div onclick="manageView(\''+data[x]+'\');"  class="mtab ';
                            if(data[x] == selectedTab) tabs += 'mtab-selected';
                            tabs += '" id="tab_'+data[x]+'">';
                            tabs += '<div class="mtab-img">' +
                            '<div class="sim_maskColor" style="-webkit-mask-box-image: url('+arrFeats[attr].icon_path+arrFeats[attr].feat_tab_icon+');"></div>' +
                            '</div>';
                            tabs += '<div class="mtab-text" id="tabname_'+data[x]+'">'+arrFeats[attr].label_name+'</div></div>';
                        }


//                        console.log("update tabs"+tabs);

                        //backend
                        inTabs = [];
                        inTabs.push(data[x]);

                        $("#wadahbutton_"+data[x]+"_1").show();
                        $("#wadahbutton_"+data[x]+"_2").hide();
                    }

                    //dari jumlah kita tentukan width
                    var pembagi = jumlahSelected;
                    if(jumlahSelected>5){
                        pembagi = 5;
                    }



                    var tabwidth = Math.floor(271/pembagi);
                    if(jumlahSelected>5){
                        //update tabss
                        tabs += '<div class="mtab ';
                        if(data[x] == selectedTab) tabs += 'mtab-selected';
                        tabs += '" onclick="showMore();" id="tab_more">';
                        tabs += '<div class="mtab-img">' +
                        '<div class="sim_maskColor" style="-webkit-mask-box-image: url('+arrFeats[attr].icon_path+'ic_more.png'+');"></div>' +
                        '</div>';
//                        tabs += '<div class="mtab-img"><i class="glyphicon glyphicon-option-horizontal"></i></div>';
                        tabs += '<div class="mtab-text">more</div></div>';


                        //update isi dari showMore
                        updateShowMore(sisaNya);
                    }


                    tabs += '<style>.mtab{width: '+tabwidth+'px;} </style>';






                    $("#mfooter").html(tabs);

                },'json');
            }

        </script>
        <style>

            .closer{
                cursor: pointer;
                /*float: right;*/
                width: 10px;
                height: 10px;
            }
        </style>
        <?
        foreach($arrObj as $obj){
            $valuesNya = FeatureSessionLayer::load($obj->feat_id);
            $labelname = isset($valuesNya[$obj->feat_id.'_labelname'])?$valuesNya[$obj->feat_id.'_labelname']:$obj->feat_name;


            ?>
            <div class="hiddenform" id="form_<?=$obj->feat_id;?>" style="display: none;">
                <div class="closer"  onclick="$('#form_<?=$obj->feat_id;?>').hide();$('#feature').show();">x</div>

                <? $obj->formPembuatan();?>
            </div>

            <script>
                //sekalian kita buat object javascriptnya untuk masing2 object spy accesible terus nantinya
                var obj_<?=$obj->feat_id;?> = {
                    feat_id : "<?=$obj->feat_id;?>",
                    feat_name : "<?=$obj->feat_name;?>",
                    feat_icon : "<?=$obj->feat_icon;?>",
                    feat_tab_icon : "<?=$obj->feat_tab_icon;?>",
                    label_name : "<?=$labelname;?>",
                    icon_path : "<?=$obj->icon_path;?>"
//                    getInfo: function () {
//                        return this.color + ' ' + this.type + ' apple';
//                    }
                }

                arrFeats.<?=$obj->feat_id;?> = obj_<?=$obj->feat_id;?>;
            </script>
        <? } ?>

<section id="feature">
    <h2 class="header_besar">Which features do you want in your app? </h2>
    <div class="feature_list_heading_information">
        <p style="color: #a2a2a2;">Please choose one or more.</p>
    </div>
    <div class="alert alert-warning jumlahwarning" style="display: none;">
        <strong>Warning!</strong> Minimum one feature must be selected.
    </div>
    <script>
        $(function() {
//                                $( "#sortable" ).sortable();


            $("#sortable").sortable({
                stop: function(event, ui) {

                    var idsInOrder = $("#sortable").sortable("toArray");
                    console.log(idsInOrder);

                    $.post("<?=_SPPATH;?>FeatureSessionLayer/updateFeatOrder",{
                        ids : idsInOrder.join()
                    },function(data){
                        console.log(data);

                        updateSelectedAppAndSimulator();
                    },'json');
//                                        var data = "";
//
//                                        $("#sortable li").each(function(i, el){
//                                            var p = $(el).text().toLowerCase().replace(" ", "_");
//                                            data += p+"="+$(el).index()+",";
//                                        });
//                                        console.log(data);
//
//                                        $("form > [name='new_order']").val(data.slice(0, -1));
//                                        $("form").submit();
                }
            });
            $( "#sortable" ).disableSelection();
        });


    </script>
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
        #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 85px; height: 100px; text-align: center; }


    </style>



    <ul id="sortable">
        <?
        foreach($selectedFeature as $sel) {

            foreach ($arrObj as $obj) {
                if ($obj->feat_id == $sel) {
//                    pr($sel);
                    ?>
                    <li id="li___<?=$obj->feat_id;?>" >
                        <div class="feat <? if(in_array($obj->feat_id,$selectedFeature)){echo "feat-selected";}?>" onclick="manageView('<?=$obj->feat_id;?>');" id="icon_<?=$obj->feat_id;?>">
                            <div class="feat-img">
                                <div class="feat-img-icon"></div>
                                <!--                                        <img class="feat_icon" src="--><?//=$obj->icon_path.$obj->feat_icon;?><!--">-->
                                <!--                                        <i class="--><?//=$obj->feat_icon;?><!--"></i>-->
                            </div>
                            <div class="feat-text"   id="featname_<?=$obj->feat_id;?>">
                                <?=$obj->feat_name;?>
                            </div>
                        </div>
                    </li>
                    <style>
                        #icon_<?=$obj->feat_id;?> .feat-img-icon{
                            background-color: white;
                            -webkit-mask-box-image: url(<?=$obj->icon_path.$obj->feat_icon;?>);
                        }
                    </style>
                <?
                }
            }
        }
        ?>
        <?
        foreach($arrObj as $obj){

            if(!in_array($obj->feat_id,$selectedFeature)){
                ?>
                <li id="li___<?=$obj->feat_id;?>" >
                    <div class="feat <? if(in_array($obj->feat_id,$selectedFeature)){echo "feat-selected";}?>" onclick="manageView('<?=$obj->feat_id;?>');" id="icon_<?=$obj->feat_id;?>">
                        <div class="feat-img">
                            <div class="feat-img-icon"></div>
                            <!--                                <img class="feat_icon" src="--><?//=$obj->icon_path.$obj->feat_icon;?><!--">-->
                            <!--                                <i class="--><?//=$obj->feat_icon;?><!--"></i>-->
                        </div>
                        <div class="feat-text" id="featname_<?=$obj->feat_id;?>">
                            <?=$obj->feat_name;?>
                        </div>
                    </div>

                </li>
                <style>
                    #icon_<?=$obj->feat_id;?> .feat-img-icon{
                        background-color: white;
                        -webkit-mask-box-image: url(<?=$obj->icon_path.$obj->feat_icon;?>);
                    }
                </style>
            <? }} ?>
    </ul>
    <div class="clearfix"></div>
    <div style="text-align: center; margin-top: 20px;">
        <button id="nextpage1" style="width: 50%;" class="btn btn-danger btn-lg">Next</button>
    </div>
    <script>
        $('#nextpage1').click(function(){
            $('.nav-pills a[href="#page_themes"]').tab('show');
        });
        //$(this).toggleClass('feat-selected');
        function manageView(id){

            $( "#loadingmobile" ).show().fadeOut( 300 );

            $('#feature').hide();
            $('.hiddenform').hide();
            $('#form_'+id).show(); //dulunya toggle

            $(".mtab").removeClass("mtab-selected");

            selectedTab = id;
            $("#tab_"+id).addClass("mtab-selected");
            /*
             if(jQuery.inArray( id, inTabs )>-1){
             selectedTab = id;
             $("#tab_"+id).addClass("mtab-selected");
             }*/

            $(".mpage").hide();

            //showloading bentar
            $('#m_'+id).show();



            if(id == "map"){
                kerjakanMap();
            }
        }
    </script>
</section>
<?
    }
} 