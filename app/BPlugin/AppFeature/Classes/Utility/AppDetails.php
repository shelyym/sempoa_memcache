<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/28/16
 * Time: 10:50 AM
 */

class AppDetails {

    public static function page(){

        $zp = new ZAppFeature();
        $details = ZAppFeature::loadDetails();
        ?>
        <section id="details">
            <h2 class="header_besar">Insert the details of your App <abbr class="required" title="required">*</abbr></h2>
            <hr class="garisbatas">
            <div class="form-group">
                <label for="contact_pname">App Name</label>
                <?
                TextLimiter::inputText("text","app_name","app_name","App Name",$details['app_name'],15,7,"my_app_icon_text");
                ?>
            </div>

            <div class="form-group">
                <label for="app_icon_img">App Icon</label>

                <? $bannerModalID = "app_icon_img_cropper";?>

                <div class="previewImg">
                    <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$details['app_icon'];?>">
                </div>


                <?
                global $modalReg;

                $modalReg->regCropper($bannerModalID,"App Icon","app_icon",$details['app_icon'],"1300:1300",array($bannerModalID."_prev",'my_app_icon_img_src'));

                ?>
                <input type="hidden" id="app_icon" value="<?=$details['app_icon'];?>">
            </div>

            <div class="form-group">
                <label for="app_des_short">App Short Description</label>
                <?
                TextLimiter::inputTextAreaBiasa("text","app_des_short","app_des_short","App Short Description",$details['app_des_short'],100,10);
                ?>
            </div>

            <div class="form-group">
                <label for="contact_pname">App Long Description</label>
                <?
                TextLimiter::inputTextAreaBiasa("text","app_des_long","app_des_long","App Long Description",$details['app_des_long'],2000,10);
                ?>
            </div>

            <div class="form-group">
                <label for="contact_pname">App Feature Graphics</label>
                <? $bannerModalID = "app_feat_cropper";?>

                <div class="previewImg">
                    <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$details['app_feature_img'];?>">
                </div>


                <?
                global $modalReg;

                $modalReg->regCropper($bannerModalID,"App Feature Graphics","app_feature_img",$details['app_feature_img'],"3000:1300",array($bannerModalID."_prev"));

                ?>
                <input type="hidden" id="app_feature_img" value="<?=$details['app_feature_img'];?>">
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button id="savedetails" style="width: 50%;" class="btn btn-danger btn-lg">Next</button>
            </div>

            <script>
                $('#savedetails').click(function(){
                    saveAppDetails(1);

                });

                function saveAppDetails(mode){
                    var app_name = $('#app_name').val();
                    var app_icon = $('#app_icon').val();
                    var app_des_short = $('#app_des_short').val();
                    var app_des_long = $('#app_des_long').val();
                    var app_feature_img = $('#app_feature_img').val();
                    //save the data to sessions
                    $.post('<?=_SPPATH;?>FeatureSessionLayer/saveDetails',{
                        app_name : app_name,
                        app_icon : app_icon,
                        app_des_short : app_des_short,
                        app_des_long : app_des_long,
                        app_feature_img : app_feature_img
                    },function(data){
                        console.log(data);
                        if(data){
//                            console.log('success');
                            //save JSON
                            $.get('<?=_SPPATH;?>FeatureSessionLayer/createJSON?id=<?=$_GET['id'];?>',function(data){
                               console.log(data);
                                if(mode == 1){
                                    $.get('<?=_SPPATH;?>FeatureSessionLayer/saveIntoApp?id=<?=$_GET['id'];?>',function(data){
                                        document.location = '<?=_SPPATH;?>PaymentWeb/pay?app_id='+data.id;
                                    },'json');

                                }
                            });
                        }
                    });
                }
            </script>
        </section>

        <?
    }
} 