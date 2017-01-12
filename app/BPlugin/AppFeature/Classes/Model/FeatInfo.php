<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:48 PM
 */

class FeatInfo extends ZAppFeature{


    public $feat_name = "Contact";
    public $feat_id = "info";
    public $feat_icon = "ic_phone.png";

    public $feat_tab_icon = "ic_phone.png";
    public $feat_rank_tampil = 1;

    public $feat_active = 1;

    public $feat_noimage;



    public $fields = array(

        "phone"=>array(
            "icon"=>"ic_phone.png",
            "type"=>"text",
            "limit_min"=> 5,
            "limit_max"=>15,
            "form_question"=>"Phone Number",
            "optional"=> 1,
            "placeholder"=>"081888888123",
            "default_value" => ""
            ),
        "email"=>array(
            "icon"=>"ic_email.png",
            "type"=>"text",
            "limit_min"=> 5,
            "limit_max"=>30,
            "form_question"=>"Email",
            "optional"=> 1,
            "placeholder"=>"youremail@domain.com",
            "default_value" => ""
            ),
        "website"=>array(
            "icon"=>"ic_web.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>50,
            "form_question"=>"Website",
            "optional"=> 1,
            "placeholder"=>"www.yourwebsite.com",
            "default_value" => ""
        ),
        "address"=>array(
            "icon"=>"ic_location.png",
            "type"=>"textarea",
            "limit_min"=> 5,
            "limit_max"=>300,
            "form_question"=>"Address",
            "optional"=> 1,
            "placeholder"=>"Jl. Jend. Sudirman no 81 \nJakarta",
            "default_value" => ""
        ),
        "addition"=>array(
            "icon"=>"ic_info.png",
            "type"=>"textarea",
            "limit_min"=> 5,
            "limit_max"=>500,
            "form_question"=>"Additional Info",
            "optional"=> 1,
            "placeholder"=>"Opening Hours, Customer Values, etc",
            "default_value" => ""
        ),
        "ic_whatsapp"=>array(
            "icon"=>"ic_whatsapp.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>50,
            "form_question"=>"Whatsapps",
            "optional"=> 1,
            "placeholder"=>"081888888123",
            "default_value" => ""
        ),
        "ic_bbm"=>array(
            "icon"=>"ic_bbm.png",
            "type"=>"text",
            "limit_min"=> 5,
            "limit_max"=>8,
            "form_question"=>"BBM",
            "optional"=> 1,
            "placeholder"=>"DE1234",
            "default_value" => ""
        ),
        "ic_line"=>array(
            "icon"=>"ic_line.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>50,
            "form_question"=>"Line",
            "optional"=> 1,
            "placeholder"=>"LineID",
            "default_value" => ""
        ),
        "ic_facebook"=>array(
            "icon"=>"ic_facebook.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>200,
            "form_question"=>"Facebook",
            "optional"=> 1,
            "placeholder"=>"FacebookPageID",
            "default_value" => ""
        ),
        "ic_instagram"=>array(
            "icon"=>"ic_instagram.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>100,
            "form_question"=>"Instagram",
            "optional"=> 1,
            "placeholder"=>"InstagramID",
            "default_value" => ""
        ),
        "ic_twitter"=>array(
            "icon"=>"ic_twitter.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>100,
            "form_question"=>"Twitter",
            "optional"=> 1,
            "placeholder"=>"TwitterID",
            "default_value" => ""
        ),
        "ic_youtube"=>array(
            "icon"=>"ic_youtube.png",
            "type"=>"text",
            "limit_min"=> 1,
            "limit_max"=>200,
            "form_question"=>"Youtube",
            "optional"=> 1,
            "placeholder"=>"youTubeID",
            "default_value" => ""
        )
        );






    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $info_slogan = isset($valuesNya['info_slogan'])?$valuesNya['info_slogan']:"slogan";

        $info_banner = isset($valuesNya['info_banner'])?$valuesNya['info_banner']:$this->feat_noimage;



        $field = array();


        ?>


            <div class="mbanner" id="mbanner">
                <div class="bgBanner">
                    <img id="mbannerImg" src="<?=$info_banner;?>" >
                </div>



            </div>

            <div class="mslogan" id="mslogan"><div id="mslogantext"><?=$info_slogan;?></div></div>


            <div class="mslist" id="mlist">
                <?
                //load from fields
                foreach($this->fields as $field_name=>$details){
                    $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
                    ?>
                    <!-- phone -->
                    <div id="sim_<?=$this->feat_id;?>_<?=$field_name;?>" class="mlist-item" <? if($field[$field_name] == ""){?>style="display: none;"<?}?>>
                        <img class="icons ic_left" src="<?=$this->icon_path.$details['icon'];?>"> &nbsp; <div id="sim_<?=$this->feat_id;?>_<?=$field_name;?>_text" class="mlist-text"><?=$field[$field_name];?></div>
                        <div class="clearfix"></div>
                    </div>
                    <?

                }

                ?>


            </div>

        <style>

            .icons{
                width: 20px;
                height: 20px;
            }
            .ic_left{
                float: left;
            }
            #mslogantext{
                padding-left: 10px;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
            }

            .mbanner{
                width: 100%;
                height: 200px;

                overflow: hidden;
            }
            .bgBanner{
                width: 100%;
                height: 100%;
                /*position: absolute;*/
                overflow: hidden;
            }
            #mbannerImg{
                width: 100%;

            }

            .mslogan{
                position: relative;

                width: 100%;
                height: 40px;
                line-height: 40px;
                background-color: rgba(0,0,0,0.5);
                color: white;
                margin-top: -40px;
            }
            .mslist{
                /*padding-top: 5px;*/
                /*padding-bottom: 5px;*/
            }
            .mlist-item{
                /*height: 50px;*/
                line-height: 20px;
                padding: 10px;
                border-bottom: 1px solid #dedede;
                background-color: white;
            }
            .mlist-item i{
                float: left;
                width: 20px;
                height: 20px;
            }
            .mlist-item .mlist-text{
                float: left;
                width: 210px;
                margin-left: 10px;
            }
        </style>


    <?
    }

    public function formCustom(){
        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);


        $info_slogan = isset($valuesNya['info_slogan'])?$valuesNya['info_slogan']:"slogan";
        $info_banner = isset($valuesNya['info_banner'])?$valuesNya['info_banner']:$this->feat_noimage;



        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;">Info</h1>
        <p style="color: #666666; font-size: 12px;">Please complete one or more fields below. <em>All fields are optional.</em></p>

        <div class="form-group">
            <label for="info_slogan">What is your slogan? </label>
            <?
            TextLimiter::inputText("text", "info_slogan","info_slogan", "slogan", $info_slogan, 30, 1, "mslogantext");
            ?>
<!--            <input type="text" class="form-control" id="info_slogan" placeholder="Slogan" value="--><?//=$info_slogan;?><!--">-->
        </div>

        <div class="form-group">

            <?
            global $modalReg;

            $modalReg->regCropper("bannID","Banner","info_banner",$info_banner,"542:400",array("mbannerImg","bannID_prev"));
            ?>

            <? $bannerModalID = "bannID";?>

                <label for="info_banner" >Main Banner </label>
                <div class="previewImg">
                    <img style="cursor:pointer;" data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$info_banner;?>">
                </div>


            <div class="clearfix"></div>

            <input type="hidden"  id="info_banner" name="info_banner" value="<?=$info_banner;?>" >

        </div>






            <?
            //load from fields
            foreach($this->fields as $field_name=>$details){
                $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
                ?>
                <div class="form-group">
                <label for="<?=$this->feat_id;?>_<?=$field_name;?>"><?=$details['form_question'];?> <?if($details['optional']){?><span class="optional">Optional</span><?}?></label>
                <?
                if($details['type'] == "text") {
                    TextLimiter::inputText("text", $this->feat_id."_".$field_name, $this->feat_id."_".$field_name, $details['placeholder'], $field[$field_name], $details['limit_max'], $details['limit_min'], "sim_".$this->feat_id."_".$field_name."_text");
                }
                elseif($details['type'] == "rte") {
                    TextLimiter::inputTextArea("text",$this->feat_id."_".$field_name,$this->feat_id."_".$field_name,$details['placeholder'],$field[$field_name],$details['limit_max'],$details['limit_min'],"sim_".$this->feat_id."_".$field_name."_text");
                }
                else{
                    TextLimiter::inputTextAreaBiasa("text",$this->feat_id."_".$field_name,$this->feat_id."_".$field_name,$details['placeholder'],$field[$field_name],$details['limit_max'],$details['limit_min'],"sim_".$this->feat_id."_".$field_name."_text");
                }
                ?>
                <script>
                    $("#<?=$this->feat_id;?>_<?=$field_name;?>").keyup(function(){


                        var name = "sim_<?=$this->feat_id."_".$field_name;?>";
                        <?if($details['type'] == "rte") {?>
                        var slc = $("#<?=$this->feat_id;?>_<?=$field_name;?>").html();
                        <? }else{?>
                        var slc = $("#<?=$this->feat_id;?>_<?=$field_name;?>").val();
                        <? } ?>

                        autoUpdateOnKeyup(name,slc);
                    });
                </script>
                </div>
                <?
            }

            ?>



        <script>
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var info_slogan = $('#info_slogan').val();
                var info_banner = $('#info_banner').val();



        <?
    //load from fields
    foreach($this->fields as $field_name=>$details){
        $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
        if($details['type'] == "text"){
            ?>
                var vr_<?=$this->feat_id;?>_<?=$field_name;?> = $('#<?=$this->feat_id;?>_<?=$field_name;?>').val();
                <?
                }
                elseif($details['type'] == "rte"){
                ?>
                var vr_<?=$this->feat_id;?>_<?=$field_name;?> = $('#<?=$this->feat_id;?>_<?=$field_name;?>').html();
                <?
                }
                else{
                ?>
                 var vr_<?=$this->feat_id;?>_<?=$field_name;?> = $('#<?=$this->feat_id;?>_<?=$field_name;?>').val();
                <?
                }

                $imp[] = $field_name.": vr_".$this->feat_id."_".$field_name;
        }

    ?>

        var label_name = $('#<?=$this->feat_id;?>_labelname').val();

        //harus selalu ada ini..
        var contact_pname = $('#<?=$this->feat_id;?>_pname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    <?=$this->feat_id;?>_pname : contact_pname,
                    info_slogan : info_slogan,
                    info_banner : info_banner
                    <?
                    if(count($imp)>0){
                        echo ",";
                        echo implode(",",$imp);
                    }
        ?>
                },function(data){
                    console.log(data);
                    if(data){
                        $(".hiddenform").hide();
                        //update Selected App dan Layout di Simulator
                        updateSelectedAppAndSimulator();

                    }
                });

            }


        </script>

        <script>


            function autoUpdateOnKeyup(name,slc){
                if(slc.length == 0){
                    $("#" + name).hide();
                }
                else {
                    $("#" + name).show();
                    $("#"+name+"_text").html(slc);
                }
            }

        </script>
        <style>
            .optional{
                font-size: 12px;
                color: #666666;
            }
            .mlist-item .clearfix{
                padding: 0;
                margin: 0;
            }
            .mlist-text{
                white-space: pre-wrap;
            }
            .previewImg{

                height: 80px;
                overflow: hidden;
            }
            .previewImg img{
                height: 100%;

            }
        </style>


    <?
    }
} 