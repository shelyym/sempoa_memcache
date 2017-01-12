<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/28/16
 * Time: 11:29 AM
 */

class ZAppFeatureSocial extends ZAppFeature{

    public $socialID = "SocialID";

    public function formCustom(){

        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);


        $contact_pslogan = isset($valuesNya['social_id'])?$valuesNya['social_id']:"";

        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;"><?=$this->feat_name;?></h1>
        <p style="color: #666666; font-size: 12px;">Please complete one or more fields below. <em>All fields are optional.</em></p>

        <div class="form-group">
            <label for="info_slogan">Your <?=$this->socialID;?></label>
            <?
            TextLimiter::inputText("text",$this->feat_id."_social_id",$this->feat_id."_social_id","",$contact_pslogan,100,0);

            ?>
        </div>
        <div style="padding-top: 10px; text-align: right;">
            <button id="load_button_<?=$this->feat_id;?>" class="btn btn-default">Load <?=$this->feat_name;?></button>
        </div>

        <script>
            //do not change the function name
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
                var contact_pslogan = $('#<?=$this->feat_id;?>_social_id').val();

                //label_name : mandatory
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    social_id : contact_pslogan,
                    <?=$this->feat_id;?>_pname : contact_pname
                },function(data){
                    console.log(data);
                    if(data){
                        $(".hiddenform").hide();
                        //update Selected App dan Layout di Simulator
                        updateSelectedAppAndSimulator();
                        //update
                        loadSocial_<?=$this->feat_id;?>(contact_pslogan);

                    }
                });

            }

            $('#load_button_<?=$this->feat_id;?>').click(function(){
                var contact_pslogan = $('#<?=$this->feat_id;?>_social_id').val();

                if(contact_pslogan!='')
                loadSocial_<?=$this->feat_id;?>(contact_pslogan);
                else{
                    alert('Please insert SocialMedia ID');
                }
            });

        </script>
        <? $this->socialJSLoader();?>
        <style>
            #<?=$this->feat_id."_des";?>{
                white-space:pre-wrap !important;

            }
        </style>
    <?

    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pslogan = isset($valuesNya[$this->feat_id.'_social_id'])?$valuesNya[$this->feat_id.'_social_id']:"";

        ?>

        <div class="msos" id="<?=$this->feat_id;?>_social_load"></div>
        <style>
            .msos{

                font-weight: normal;
                margin: 10px;

            }

        </style>

    <?
    }

    public function socialJSLoader(){
        ?>
    <script>
        function loadSocial_<?=$this->feat_id;?>(socialID){
            $('#<?=$this->feat_id;?>_social_load').html(socialID+ 'please define in child');
        }
    </script>
        <?
    }
} 