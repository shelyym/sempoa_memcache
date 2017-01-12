<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/21/16
 * Time: 11:55 AM
 */

class FeatInbox extends ZAppFeature{

    public $feat_name = "Inbox";
    public $feat_id = "inbox";
    public $feat_icon = "ic_inbox.png";

    public $feat_tab_icon = "ic_inbox.png";
    public $feat_rank_tampil = 12;

    public $feat_active = 1;

    public function formCustom(){

        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:"Inbox";

        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;"><?=$this->feat_name;?></h1>
        <p style="color: #666666; font-size: 12px;">Please complete one or more fields below. <em>All fields are optional.</em></p>



        <script>
            //do not change the function name
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();


                //label_name : mandatory
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    <?=$this->feat_id;?>_pname : contact_pname
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
    <?



    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:"Inbox";


        ?>


            dummy inbox



    <?
    }
} 