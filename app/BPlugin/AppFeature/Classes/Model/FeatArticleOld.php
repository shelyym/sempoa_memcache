<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/22/16
 * Time: 9:13 PM
 */

class FeatArticleOld extends ZAppFeatureList{

    public $feat_name = "Article";
    public $feat_id = "article";
    public $feat_icon = "ic_article.png";

    public $feat_tab_icon = "ic_article.png";
    public $feat_rank_tampil = 6;

    public $feat_active = 0;

    public function formCustom(){
        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);


        $deal_array = isset($valuesNya[$this->arrayID])?$valuesNya[$this->arrayID]:array();



        global $modalReg;
        $modalReg->addAboveBGBlur(array("FeatArticle","addForm")); //harus dioverwrite


        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;">
            <?=$this->feat_name;?>
        </h1>





        <div id="notfound_<?=$this->feat_id;?>_button" class="deal_not_found" <?if(count($deal_array)>0){?>style="display: none;"<?}?>>
            <h3 style="text-align: center; padding: 30px; color: #bbbbbb;">Oops, sorry no <?=$this->feat_name;?> was found...</h3>
        </div>


        <div <?if(count($deal_array)<1){?>style="display: none;"<?}?> class="wadahform_deal_button" id="wadahform_<?=$this->feat_id;?>_button">

            <script>


                $(function() {
                    $("#<?=$this->feat_id;?>_sortable").sortable({
                        stop: function(event, ui) {

                            var idsInOrder = $("#<?=$this->feat_id;?>_sortable").sortable("toArray");
                            console.log(idsInOrder);

                            $.post("<?=_SPPATH;?>FeatureSessionLayer/setArrayOrder?id=<?=$this->feat_id;?>&arrayID=<?=$this->arrayID;?>",{
                                ids : idsInOrder.join()
                            },function(data){
                                console.log(data);
                                update_<?=$this->feat_id;?>_Simulator(data);
                            },'json');
                        }
                    });
                    $( "#<?=$this->feat_id;?>_sortable" ).disableSelection();
                });
            </script>
            <style>
                .arraylist_sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
                .arraylist_sortable li { background-color: #ffffff; padding: 5px; margin: 5px; }
                .arraylist_action{text-align: right;}
                .arraylist_action i{cursor: pointer;}
                .arraylist_action i.glyphicon-pencil{color: #008000;}
                .arraylist_action i.glyphicon-remove{color: #ff0000;}
            </style>

            <ul id="<?=$this->feat_id;?>_sortable" class="arraylist_sortable">
                <? foreach($deal_array as $num=>$deal){?>
                    <li class="ui-state-default" id="<?=$this->feat_id;?>_arr_<?=$num;?>">
                        <div class="arraylist_item" >
                            <div class="col-md-7 arraylist_name"><?=$deal[$this->feat_id.'_name'];?></div>
                            <div class="col-md-5 arraylist_action">
                                <i onclick="edit_<?=$this->feat_id;?>('<?=$num;?>');" class="glyphicon glyphicon-pencil"></i>
                                &nbsp;
                                <i onclick="delete_<?=$this->feat_id;?>('<?=$num;?>');" class="glyphicon glyphicon-remove"></i>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </li>
                <? } ?>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button onclick="createDeal_<?=$this->feat_id;?>();" class="btn btn-success btn-lg">Create New <?=$this->feat_name;?></button>
        </div>


        <script>
            function createDeal_<?=$this->feat_id;?>(){

//                console.log("createdeal");
                $('.bgblur').show();
                $('#<?=$this->feat_id;?>_kosong').show();

                //reset value deal_kosong
                $('#<?=$this->feat_id;?>_id').val('-1');
                $('#<?=$this->feat_id;?>_name').val('Name');
                $('#<?=$this->feat_id;?>_des').val('Description');
                $('#<?=$this->feat_id;?>_pic').val("<?=_BPATH;?>images/run.jpg");

                //images
                $('#<?=$this->feat_id;?>_logo_prev').attr("src",$('#<?=$this->feat_id;?>_pic').val());
                $('#sim_<?=$this->feat_id;?>_pic').attr("src",$('#<?=$this->feat_id;?>_pic').val());

                //texts
                $('#sim_<?=$this->feat_id;?>_title').html($('#<?=$this->feat_id;?>_name').val());
                $('#sim_<?=$this->feat_id;?>_des').html($('#<?=$this->feat_id;?>_des').val());

                $('#image2crop<?=$this->feat_id;?>_logo').attr("src",$('#<?=$this->feat_id;?>_pic').val());
            }
        </script>
        <script>
            //penyimpanan dataActual
            var data_<?=$this->feat_id;?> = <?=json_encode($deal_array);?>;
            var data_<?=$this->feat_id;?>_justUpdated = -1;

            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
//                var deal_pic = $('#deal_pic').val();
//                var deal_des = $('#deal_des').val();
//                var deal_name = $('#deal_name').val();

                //harus selalu ada ini..
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();

                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
//                    <?=$this->feat_id;?>_name : <?=$this->feat_id;?>_name,
//                    <?=$this->feat_id;?>_des : <?=$this->feat_id;?>_des,
//                    deal_pic : deal_pic,
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


            function edit_<?=$this->feat_id;?>(num){
                $('.bgblur').show();
                $('#<?=$this->feat_id;?>_kosong').show();

                var data = data_<?=$this->feat_id;?>;
                for(var x=0;x<data.length;x++) {
                    var attr = data[x];

                    if(x==num){
                        //masukan ke #dealkosong
                        $('#<?=$this->feat_id;?>_id').val(x);
                        $('#<?=$this->feat_id;?>_name').val(attr['<?=$this->feat_id;?>_name']);
                        $('#<?=$this->feat_id;?>_des').val(attr['<?=$this->feat_id;?>_des']);
                        $('#<?=$this->feat_id;?>_pic').val(attr['<?=$this->feat_id;?>_pic']);

                        //images
                        $('#<?=$this->feat_id;?>_logo_prev').attr("src",attr['<?=$this->feat_id;?>_pic']);
                        $('#sim_<?=$this->feat_id;?>_pic').attr("src",attr['<?=$this->feat_id;?>_pic']);

                        //texts
                        $('#sim_<?=$this->feat_id;?>_title').html(attr['<?=$this->feat_id;?>_name']);
                        $('#sim_<?=$this->feat_id;?>_des').html(attr['<?=$this->feat_id;?>_des']);

                        //image2crop+id
                        $('#image2crop<?=$this->feat_id;?>_logo').attr("src",attr['<?=$this->feat_id;?>_pic']);

                        data_<?=$this->feat_id;?>_justUpdated = x;
                    }
                }
            }

            function delete_<?=$this->feat_id;?>(num){
                if(confirm("Are you sure you want to delete this Item?"))
                    $.post("<?=_SPPATH;?>FeatureSessionLayer/removeArrayItem?id=<?=$this->feat_id;?>&arrayID=<?=$this->arrayID;?>",{
                        pos : num
                    },function(data){
                        update_<?=$this->feat_id;?>_Simulator(data);
                    },'json');
            }
        </script>





    <?
    }

    function appListViewer(){
        $valuesNya = FeatureSessionLayer::load($this->feat_id);
        $arrDeals = $valuesNya[$this->arrayID];
        ?>
        <? foreach($arrDeals as $num=>$deal){?>
            <div class="<?=$this->feat_id;?>_item" id="<?=$this->feat_id;?>_<?=$num;?>">
                <div class="<?=$this->feat_id;?>_item_pic">
                    <img src="<?=$deal[$this->feat_id.'_pic'];?>">
                </div>
                <div class="<?=$this->feat_id;?>_item_title">
                    <?=$deal[$this->feat_id.'_name'];?>
                </div>
                <div class="<?=$this->feat_id;?>_item_description" ><?=$this->keepLines($deal[$this->feat_id.'_des'],2);?></div>
            </div>
        <?} ?>

    <?
    }

    function keepLines($string, $lines = 20)
    {
        for ($offset = 0, $x = 0; $x < $lines; $x++) {
            $offset = strpos($string, "\n", $offset) + 1;
        }

        return substr($string, 0, $offset);
    }
} 