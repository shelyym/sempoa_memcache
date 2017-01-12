<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/28/16
 * Time: 9:03 AM
 */

class AppTheme {

    public static function page(){
        ?>
        <section id="themes">
            <?
            $zp = new ZAppFeature();
            $colors = ZAppFeature::loadColor();



            if(!isset($colors['bg_img']) || $colors['bg_img'] == ""){

                $colors['bg_img'] = $zp->feat_noimage;
            }
            ?>
            <h2 class="header_besar">Which colors and themes do you want in your app? <abbr class="required" title="required">*</abbr></h2>

            <div class="form-group">
                <label for="splash_img">Splash Image</label>
                <div class="clearfix"></div>
                <? $bannerModalID = "splash_cropper";?>
                <div style="float: left;">
                    <div class="previewImg">
                        <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$colors['splash_img'];?>">
                    </div>
                </div>
                <div style="float: left; line-height: 80px; margin-left: 20px;">
                    <button onclick="onSuccessSplash();" class="btn btn-default">demo</button>
                </div>
                <?
                global $modalReg;

                $modalReg->regCropper($bannerModalID,"Splash Image","splash_img",$colors['splash_img'],"736:1300",array($bannerModalID."_prev"),"onSuccessSplash();");

                ?>
                <input type="hidden" id="splash_img" value="<?=$colors['splash_img'];?>">
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <label for="panel_color">Panel Color</label>
                <div class="input-group panel_color_con">

                    <input  type="text" id="panel_color" value="<?=$colors['panel_color'];?>" class="form-control"  />
                    <span class="input-group-addon"><i style="background-color: <?=$colors['panel_color'];?>;"></i></span>
                </div>
            </div>

            <div class="form-group">
                <label for="text_color">Text Color</label>
                <div class="input-group text_color_con">

                    <input  type="text" id="text_color" value="<?=$colors['text_color'];?>" class="form-control"  />
                    <span class="input-group-addon"><i style="background-color: <?=$colors['text_color'];?>;"></i></span>
                </div>
            </div>

            <div class="form-group">
                <label for="bg_color">Background Color</label>
                <div class="input-group bg_color_con">

                    <input  type="text" id="bg_color" value="<?=$colors['bg_color'];?>" class="form-control"  />
                    <span class="input-group-addon"><i style="background-color: <?=$colors['bg_color'];?>;"></i></span>
                </div>
            </div>

            <div class="form-group">
                <label for="bg_img">Background Image</label>
                <div class="clearfix"></div>
                <? $bannerModalID = "bg_img_cropper";?>
                <div style="float: left;">
                <div class="previewImg">
                    <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$colors['bg_img'];?>">
                </div>
                </div>
                <div style="float: left; line-height: 80px; margin-left: 20px;">
                    <button id="removeBGImg" class="btn btn-default">remove background image</button>
                </div>
                <?
                global $modalReg;

                $modalReg->regCropper($bannerModalID,"Background Image","bg_img",$colors['bg_img'],"736:1300",array($bannerModalID."_prev"),"onSuccessBG();");

                ?>
                <input type="hidden" id="bg_img" value="<?=$colors['bg_img'];?>">
                <div class="clearfix"></div>
            </div>



            <script>
                function onSuccessSplash(){
                    var slc = $('#splash_img').val();

                    //do splash
                    $('#splash_screen').css('background-image','url('+slc+'?t='+ $.now()+')');
                    $('#splash_screen').fadeIn('slow').delay(1000).fadeOut();
                    $('#isiapp').hide().delay(2000).fadeIn('slow');
                    $('#mfooter').hide().delay(2000).fadeIn('slow');
                }
                function onSuccessBG(){
//                                    console.log('masuk ke bg_img change');
                    var slc = $('#bg_img').val();
                    $('div.mcontent').css('background-image','url('+slc+'?t='+ $.now()+')');
                }

                function updatePanelColor(slc){
                    $('div.mheadertext').css("background-color",slc);
                    $('div#mfooter').css("background-color",slc);
                }

                function updateTextColor(slc){
                    $('div.mheadertext').css("color",slc);
//                    console.log('updateTextColor 2');
                    $('.mtab-text').css("color",slc);
//                    console.log('updateTextColor 3');
                    $('div.sim_maskColor').css("background-color",slc);
//                    console.log('updateTextColor 4');
                    $('.listview span').css("color",slc);
//                    console.log('updateTextColor 5');
                }
                function updateBGColor(slc){
                    $('div.mcontent').css("background-color",slc);
                }

                $('#removeBGImg').click(function(){
                    $('#bg_img').val('<?=$zp->feat_noimage;?>');
                    $('#bg_img_cropper_prev').attr("src","<?=$zp->feat_noimage;?>");
                    $('div.mcontent').css('background-image','none');
                    $('#app_desktop').hide();
                });

                $(function(){

                    $('.panel_color_con').colorpicker().on('changeColor.colorpicker', function(event){
                        var slc = event.color.toHex();
                        updatePanelColor(slc);
                    });

                    $('.text_color_con').colorpicker().on('changeColor.colorpicker', function(event){
                        var slc = event.color.toHex();
                        updateTextColor(slc);
                    });

                    $('.bg_color_con').colorpicker().on('changeColor.colorpicker', function(event){
                        var slc = event.color.toHex();
                        updateBGColor(slc);
                    });



                    $('#savecolors').click(function(){
                        $('.nav-pills a[href="#page_details"]').tab('show');
                    })
                });

                function saveColors(){
//                    console.log('in saveColors');

                    var panel_color = $('#panel_color').val();
                    var text_color = $('#text_color').val();
                    var bg_color = $('#bg_color').val();
                    var bg_img = $('#bg_img').val();
                    var splash_img = $('#splash_img').val();
                    //save the data to sessions
                    $.post('<?=_SPPATH;?>FeatureSessionLayer/saveColor',{
                        panel_color : panel_color,
                        text_color : text_color,
                        bg_color : bg_color,
                        bg_img : bg_img,
                        splash_img : splash_img
                    },function(data){
                        console.log(data);
                        if(data){
//                            console.log('success');
                        }
                    });
                }

            </script>
            <div style="text-align: center; margin-top: 20px;">
            <button id="savecolors" style="width: 50%;" class="btn btn-danger btn-lg">Next</button>
            </div>
            <? $colors = ZAppFeature::loadColor();

            foreach($colors as $key=>$val){

            if($key == "panel_color"){
                ?>
                <script>
                    $(document).ready(function(){
                        updatePanelColor('<?=$val;?>');
                    });
                </script>

            <?
            }

            if($key == "text_color"){
            ?>
                <style>
                    .sim_maskColor{
                        background-color: <?=$val;?>;
                    }
                    .mtab-text{
                        color: <?=$val;?>;
                    }
                    .listview span{
                        color: <?=$val;?>;
                    }
                </style>
                <script>
                    $(document).ready(function(){
                        updateTextColor('<?=$val;?>');
                    });
                </script>
            <?
            }

            if($key == "bg_color"){
            ?>
                <script>
                    $(document).ready(function(){
                        updateBGColor('<?=$val;?>');
                    });
                </script>
            <?
            }

            if($key == "bg_img"){
            if($val != $zp->feat_noimage) {
            ?>
                <script>
                    $(document).ready(function(){
                        onSuccessBG();
                    });
                </script>
            <?
            }
            }

            }
            ?>
            <style>

                div.mcontent{
                    background-repeat: no-repeat;
                    /*background-attachment: fixed;*/
                    /*background-position: center;*/
                    background-size: 100% auto;
                }
                #splash_screen{
                    background-repeat: no-repeat;
                    background-size: 100% auto;
                }
            </style>
        </section>
        <?
    }
} 