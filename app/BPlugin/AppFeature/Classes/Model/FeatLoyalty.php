<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:49 PM
 */

class FeatLoyalty extends ZAppFeature{

    public $feat_name = "Loyalty";
    public $feat_id = "loyalty";
    public $feat_icon = "ic_loyalty.png";

    public $feat_tab_icon = "ic_loyalty.png";
    public $feat_rank_tampil = 13;

    public $feat_active = 1;



    public function formCustom(){

        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $loyalty_des = isset($valuesNya['loyalty_des'])?$valuesNya['loyalty_des']:"";
        $contact_pslogan = isset($valuesNya["loyalty_offer"])?$valuesNya['loyalty_offer']:"";
        $loyalty_pin = isset($valuesNya['loyalty_pin'])?$valuesNya['loyalty_pin']:"";
        $loyalty_nr = isset($valuesNya['loyalty_nr'])?$valuesNya['loyalty_nr']:6;
        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;"><?=$this->feat_name;?></h1>


        <div class="form-group">
            <label for="loyalty_offer">Offer</label>
            <?
            TextLimiter::inputTextArea("text","loyalty_offer","loyalty_offer","buy 6th coffee get 1 free",$contact_pslogan,500,0,"sim_loyalty_offer");
            ?>
        </div>
        <div class="form-group">
            <label for="loyalty_nr">Number of Stamps</label>
            <select class="form-control" id="loyalty_nr">
                <?
                for($x=2;$x<=12;$x++){
                    ?>
                    <option <?if($x==$loyalty_nr)echo "selected";?> value="<?=$x;?>"><?=$x;?></option>
                    <?
                }
                ?>
            </select>
            <script>
                $('#loyalty_nr').change(function(){
                    var slc =  parseInt($('#loyalty_nr').val());

                    var txt = '';
                    for(var x=1;x<=slc;x++){

                        txt += '<div class="loyalty_stamp">';
                        txt += x;
                        txt += '</div>';

                    }
                    $('#sim_jumlah_loyalty').html(txt);

                });
            </script>
        </div>
        <div class="form-group">
            <label for="loyalty_des">Description</label>
            <?
            TextLimiter::inputTextArea("text","loyalty_des","loyalty_des","Bisa diambil kapan saja",$loyalty_des,500,0,"sim_loyalty_description");
            ?>
        </div>
        <div class="form-group">
            <label for="loyalty_pin">PIN</label>
            <?
            TextLimiter::inputText("text","loyalty_pin","loyalty_pin","4 digit PIN",$loyalty_pin,4,4);
            ?>
        </div>
        <script>
            //do not change the function name
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
                var loyalty_offer = $('#loyalty_offer').html();
                var loyalty_des = $('#loyalty_des').html();
                var loyalty_pin = $('#loyalty_pin').val();
                var loyalty_nr = $('#loyalty_nr').val();

                //label_name : mandatory
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    loyalty_offer : loyalty_offer,
                    loyalty_des:loyalty_des,
                    loyalty_pin : loyalty_pin,
                    loyalty_nr : loyalty_nr,
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

        $sim_loyalty_offer = isset($valuesNya['loyalty_offer'])?$valuesNya['loyalty_offer']:"";
        $loyalty_des = isset($valuesNya['loyalty_des'])?$valuesNya['loyalty_des']:"";
        $loyalty_nr = isset($valuesNya['loyalty_nr'])?$valuesNya['loyalty_nr']:6;
        $loyalty_pin = isset($valuesNya['loyalty_pin'])?$valuesNya['loyalty_pin']:"";

        $ukuranBUlet = 70;
        ?>

        <div class="mdescription" id="sim_loyalty_offer"><?=$sim_loyalty_offer;?></div>
        <div class="mdescription" id="sim_jumlah_loyalty">
            <? for($x=1;$x<=$loyalty_nr;$x++){
            ?>
                <div class="loyalty_stamp">
                    <?=$x;?>
                </div>
           <? } ?>

        </div>
        <div class="clearfix"></div>
        <div class="mdescription prewrap" id="sim_loyalty_description"><?=$loyalty_des;?></div>
        <style>
            #sim_loyalty_offer{
                font-size: 13px;
                color: #555555;
            }
            #sim_loyalty_description{
                font-size: 13px;
                color: #333333;
            }
            .mdescription{
                padding: 10px;

            }
            .prewrap{
                white-space: pre-wrap;
            }
            .loyalty_stamp{
                width: <?=$ukuranBUlet;?>px;
                border-radius: <?=$ukuranBUlet;?>px;
                border: 5px solid #dedede;
                height: <?=$ukuranBUlet;?>px;
                line-height: 65px;
                text-align: center;
                float: left;
                margin: 5px;
                color: #dedede;
                font-size: 30px;
            }
        </style>

    <?
    }
} 