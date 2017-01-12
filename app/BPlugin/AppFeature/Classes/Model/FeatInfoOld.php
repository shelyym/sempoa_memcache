<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:48 PM
 */

class FeatInfoOld extends ZAppFeature{


    public $feat_name = "Contact";
    public $feat_id = "info";
    public $feat_icon = "glyphicon glyphicon-info-sign";

    public $feat_tab_icon = "glyphicon glyphicon-info-sign";
    public $feat_rank_tampil = 1;

    public $feat_active = 0;


    public $fields = array(

        "phone2"=>array(
            "icon"=>"glyphicon glyphicon-phone-alt",
            "type"=>"text",
            "limit_min"=> 5,
            "limit_max"=>15,
            "form_question"=>"Your Phone Number?",
            "optional"=> 1,
            "placeholder"=>"Phone number",
            "default_value" => "phone"
            ),
        "email2"=>array(
            "icon"=>"glyphicon glyphicon-envelope",
            "type"=>"textarea",
            "limit_min"=> 5,
            "limit_max"=>15,
            "form_question"=>"Your email?",
            "optional"=> 1,
            "placeholder"=>"email",
            "default_value" => "email"
            )
        );




//    public function formPembuatan(){
//
//
//    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

//        $info_bname = isset($valuesNya['info_bname'])?$valuesNya['info_bname']:"Business Name";
        $info_slogan = isset($valuesNya['info_slogan'])?$valuesNya['info_slogan']:"slogan";
//        $info_profilepic = isset($valuesNya['info_profilepic'])?$valuesNya['info_profilepic']:_BPATH."images/noimage.jpg";
        $info_banner = isset($valuesNya['info_banner'])?$valuesNya['info_banner']:_BPATH."images/iphone.jpg";

//        $info_phone = $valuesNya['info_phone'];
//        $info_email = $valuesNya['info_email'];
//        $info_website = $valuesNya['info_website'];
//        $info_address = $valuesNya['info_address'];
//        $info_additional = $valuesNya['info_additional'];


        $field = array();


        ?>


            <div class="mbanner" id="mbanner">
                <div class="bgBanner">
                    <img id="mbannerImg" src="<?=$info_banner;?>" >
                </div>



            </div>

            <div class="mslogan" id="mslogan"><div id="mslogantext"><?=$info_slogan;?></div></div>
<!--            <div class="mlogo" id="mlogo">-->
<!--                <img class="mlogoImg" src="--><?//=$info_profilepic;?><!--" id="mlogoImg">-->
<!--            </div>-->

            <div class="mslist" id="mlist">
                <?
                //load from fields
                foreach($this->fields as $field_name=>$details){
                    $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
                    ?>
                    <!-- phone -->
                    <div id="sim_<?=$this->feat_id;?>_<?=$field_name;?>" class="mlist-item" <? if($field[$field_name] == ""){?>style="display: none;"<?}?>>
                        <i class="<?=$details['icon'];?>"></i> &nbsp; <div id="sim_<?=$this->feat_id;?>_<?=$field_name;?>_text" class="mlist-text"><?=$field[$field_name];?></div>
                        <div class="clearfix"></div>
                    </div>
                    <?

                }

                ?>
<!--                <!-- phone -->-->
<!--                <div id="ninfo_phone" class="mlist-item" --><?// if($info_phone == ""){?><!--style="display: none;"--><?//}?><!-->-->
<!--                    <i class="glyphicon glyphicon-phone-alt"></i> &nbsp; <div class="mlist-text">--><?//=$info_phone;?><!--</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!---->
<!--                <!-- $info_email -->-->
<!--                <div id="ninfo_email" class="mlist-item" --><?// if($info_email == ""){?><!--style="display: none;"--><?//}?><!-->-->
<!--                    <i class="glyphicon glyphicon-envelope"></i> &nbsp; <div class="mlist-text">--><?//=$info_email;?><!--</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!---->
<!--                <!-- $info_website -->-->
<!--                <div id="ninfo_website" class="mlist-item" --><?// if($info_website == ""){?><!--style="display: none;"--><?//}?><!-->-->
<!--                    <i class="glyphicon glyphicon-globe"></i> &nbsp; <div class="mlist-text">--><?//=$info_website;?><!--</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!---->
<!--                <!-- $info_address -->-->
<!--                <div id="ninfo_address" class="mlist-item" --><?// if($info_address == ""){?><!--style="display: none;"--><?//}?><!-->-->
<!--                    <i class="glyphicon glyphicon-map-marker"></i> &nbsp; <div class="mlist-text">--><?//=$info_address;?><!--</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!---->
<!--                <!-- $info_additional -->-->
<!--                <div id="ninfo_additional" class="mlist-item" --><?// if($info_additional == ""){?><!--style="display: none;"--><?//}?><!-->-->
<!--                    <i class="glyphicon glyphicon-list-alt"></i> &nbsp; <div class="mlist-text">--><?//=$info_additional;?><!--</div>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->


            </div>

        <style>

            #mslogantext{
                padding-left: 10px;
                font-size: 14px;
                font-family: 'Roboto', sans-serif;
            }

            .mbanner{
                width: 100%;
                height: 200px;
/*                background-color: orange;*/
/*                background: url(*/<?//=_SPPATH;?>/*images/iphone.jpg);*/
/*                background-size: 100% auto;*/
/*                background-repeat: repeat;*/
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
            .mlogo{
                position: relative;
                width: 80px;
                height: 80px;
                border: 3px solid #dedede;
                background-color: white;

                overflow: hidden;
                margin-top: -90px;
                padding-bottom: 20px;
                margin-left: 180px;
            }
            .mlogoImg{
                width: 80px;

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
                padding-top: 10px;
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

//        $info_bname = isset($valuesNya['info_bname'])?$valuesNya['info_bname']:"Business Name";
        $info_slogan = isset($valuesNya['info_slogan'])?$valuesNya['info_slogan']:"slogan";
//        $info_profilepic = isset($valuesNya['info_profilepic'])?$valuesNya['info_profilepic']:_BPATH."images/noimage.jpg";
        $info_banner = isset($valuesNya['info_banner'])?$valuesNya['info_banner']:_BPATH."images/iphone.jpg";


//        $info_phone = $valuesNya['info_phone'];
//        $info_email = $valuesNya['info_email'];
//        $info_website = $valuesNya['info_website'];
//        $info_address = $valuesNya['info_address'];
//        $info_additional = $valuesNya['info_additional'];


        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;">Info</h1>
        <p style="color: #666666; font-size: 12px;">Please complete one or more fields below. <em>All fields are optional.</em></p>

        <div class="form-group">
            <label for="info_slogan">What is your slogan? </label>
            <input type="text" class="form-control" id="info_slogan" placeholder="Slogan" value="<?=$info_slogan;?>">
        </div>

        <div class="form-group">

            <? $bannerModalID = "logoID";?>

<!--            <div class="col-md-3" style="margin-left: -15px;">-->
<!--                <label for="info_profilepic">Profile picture </label>-->
<!--                <div class="previewImg">-->
<!--                    <img style="cursor:pointer;"  data-toggle="modal" data-target="#--><?//=$bannerModalID;?><!--" id="--><?//=$bannerModalID;?><!--_prev" src="--><?//=$info_profilepic;?><!--">-->
<!--                </div>-->
<!--            </div>-->
            <?
            global $modalReg;

            $modalReg->regCropper("bannID","Banner","info_banner",$info_banner,"542:400",array("mbannerImg","bannID_prev"));
//            $modalReg->regCropper("logoID","Profile Picture","info_profilepic",$info_profilepic,"400:400",array("mlogoImg","logoID_prev"));

            ?>

            <? $bannerModalID = "bannID";?>
<!--            <div class="col-md-6" >-->
                <label for="info_banner" >Main Banner </label>
                <div class="previewImg">
                    <img style="cursor:pointer;" data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$info_banner;?>">
                </div>
<!--            </div>-->

            <div class="clearfix"></div>

            <input type="hidden"  id="info_banner" name="info_banner" value="<?=$info_banner;?>" >
            <input type="hidden"  id="info_profilepic" name="info_profilepic" value="<?=$info_profilepic;?>" >

        </div>




        <div class="form-group">

            <?
            //load from fields
            foreach($this->fields as $field_name=>$details){
//                $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
                ?>
                <label for="<?=$this->feat_id;?>_<?=$field_name;?>"><?=$details['form_question'];?> <?if($details['optional']){?><span class="optional">Optional</span><?}?></label>
                <?
                if($details['type'] == "text") {
                    TextLimiter::inputText("text", $this->feat_id."_".$field_name, $this->feat_id."_".$field_name, $details['placeholder'], $field[$field_name], $details['limit_max'], $details['limit_min'], "sim_".$this->feat_id."_".$field_name." .mlist-text");
                }
                else{

                    TextLimiter::inputTextArea("text",$this->feat_id."_".$field_name,$this->feat_id."_".$field_name,$details['placeholder'],$field[$field_name],$details['limit_max'],$details['limit_min'],"sim_".$this->feat_id."_".$field_name."_text");


                }
                ?>
                <script>
                    $("#<?=$this->feat_id;?>_<?=$field_name;?>").keyup(function(){

                        var name = "<?="sim_".$this->feat_id."_".$field_name;?>";
                        var slc = $("#<?=$this->feat_id;?>_<?=$field_name;?>").val();

                        autoUpdateOnKeyup(name,slc);
                    });
                </script>
                <?
            }

            ?>
            <label for="info_phone">Your phone number <span class="optional">Optional</span></label>
            <?
            TextLimiter::inputText("text","info_phone","info_phone","Page Name",$info_phone,15,5,"ninfo_phone .mlist-text");
            ?>
<!--            <input type="text" class="form-control" id="info_phone" placeholder="Phone Number" value="--><?//=$info_phone;?><!--" >-->
        </div>

<!--        <div class="form-group">-->
<!--            <label for="info_email">Your email address <span class="optional">Optional</span></label>-->
<!--            <input type="email" class="form-control" id="info_email" placeholder="Email Address" value="--><?//=$info_email;?><!--"  >-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="info_website">Your website URL <span class="optional">Optional</span></label>-->
<!--            <input type="url" class="form-control" id="info_website" placeholder="Website URL" value="--><?//=$info_website;?><!--"  >-->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="info_address">Your address <span class="optional">Optional</span></label>-->
<!--            <textarea id="info_address" class="form-control" rows="4" maxlength="800" placeholder="Address">--><?//=$info_address;?><!--</textarea>-->
<!---->
<!--        </div>-->
<!---->
<!--        <div class="form-group">-->
<!--            <label for="info_additional">Additional information  <span class="optional">Optional</span></label>-->
<!--            <textarea id="info_additional" class="form-control" rows="10" maxlength="800" placeholder="Example: Opening Hours">--><?//=$info_additional;?><!--</textarea>-->
<!---->
<!--        </div>-->


        <script>
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
//                var info_bname = $('#info_bname').val();
                var info_slogan = $('#info_slogan').val();

//                var info_phone = $('#info_phone').val();
//                var info_email = $('#info_email').val();
//                var info_website = $('#info_website').val();
//                var info_address = $('#info_address').val();
//                var info_additional = $('#info_additional').val();

                var info_banner = $('#info_banner').val();

//                var info_profilepic = $('#info_profilepic').val();

        <?
    //load from fields
    foreach($this->fields as $field_name=>$details){
        $field[$field_name] = isset($valuesNya[$field_name])?$valuesNya[$field_name]:$details['default_value'];
        if($details['type'] == "text"){
            ?>
                var vr_<?=$this->feat_id;?>_<?=$field_name;?> = $('#<?=$this->feat_id;?>_<?=$field_name;?>').val();
                <?
                }
                else{
                ?>
                var vr_<?=$this->feat_id;?>_<?=$field_name;?> = $('#<?=$this->feat_id;?>_<?=$field_name;?>').html();
                <?
                }

                $imp[] = $field_name.": vr_".$this->feat_id."_".$field_name;
        }

    ?>

        var label_name = $('#<?=$this->feat_id;?>_labelname').val();

        //harus selalu ada ini..
        var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
//                var label_name = $('#<?//=$this->feat_id;?>//_labelname').val();


                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    <?=$this->feat_id;?>_pname : contact_pname,
//                    info_bname : info_bname,
//                    info_slogan : info_slogan,
//                    info_phone : info_phone,
//                    info_email : info_email,
//                    info_website : info_website,
//                    info_address : info_address,
//                    info_additional : info_additional,
                    info_banner : info_banner
//                    info_profilepic : info_profilepic
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
//            $("#info_bname").keyup(function(){
//
//                console.log("in1");
//                var slc = $("#info_bname").val();
//                $("#mheadertext_<?//=$this->feat_id;?>//").html(slc);
//                console.log("in2");
//            });
//            $("#info_slogan").keyup(function(){
//
//                console.log("in1");
//                var slc = $("#info_slogan").val();
//                $("#mslogantext").html(slc);
//                console.log("in2");
//            });
//
//            $("#info_phone").keyup(function(){
//                var name = "ninfo_phone";
//                var slc = $("#info_phone").val();
//
//                autoUpdateOnKeyup(name,slc);
//
////                if(slc.length == 0){
////                    $("#" + name).remove();
////                }
////                else {
////                    if ($("#" + name).length == 0) {
////                        //it doesn't exist
////                        var texthtml = '<div id="' + name + '" class="mlist-item">' +
////                            '<i class="glyphicon glyphicon-phone-alt"></i> &nbsp; <div class="mlist-text">' + slc + '</div>' +
////                            '<div class="clearfix"></div></div>';
////
////                        $("#mlist").append(texthtml);
////                    } else {
////                        $("#" + name + " div.mlist-text").html(slc);
////                    }
////                }
//            });
//
//            $("#info_email").keyup(function(){
//                var name = "ninfo_email";
//                var slc = $("#info_email").val();
//
//                autoUpdateOnKeyup(name,slc);
//            });
//
//            $("#info_website").keyup(function(){
//                var name = "ninfo_website";
//                var slc = $("#info_website").val();
//
//                autoUpdateOnKeyup(name,slc);
//            });
//
//            $("#info_address").keyup(function(){
//                var name = "ninfo_address";
//                var slc = $("#info_address").val();
//
//                autoUpdateOnKeyup(name,slc);
//            });
//
//            $("#info_additional").keyup(function(){
//                var name = "ninfo_additional";
//                var slc = $("#info_additional").val();
//
//                autoUpdateOnKeyup(name,slc);
//
//            });

            function autoUpdateOnKeyup(name,slc){
                if(slc.length == 0){
                    $("#" + name).hide();
                }
                else {
                    $("#" + name).show();
                    $("#"+name+" .mlist-text").html(slc);
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