<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:49 PM
 */

class FeatDealsold extends ZAppFeature{

    public $feat_name = "Deals";
    public $feat_id = "deals";
    public $feat_icon = "glyphicon glyphicon-tags";

    public $feat_tab_icon = "glyphicon glyphicon-tags";
    public $feat_rank_tampil = 4;

    public $feat_active = 0;


    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $arrDeals = $valuesNya[$this->arrayID];

//        pr($arrDeals);
        ?>


        <div class="deal_mcontent" id="app_<?=$this->feat_id;?>_listcontent" >

            <? foreach($arrDeals as $num=>$deal){?>
                <div class="deal_item" id="<?=$this->feat_id;?>_<?=$num;?>">
                    <div class="deal_item_pic">
                        <img src="<?=$deal['deal_pic'];?>">
                    </div>
                    <div class="deal_item_title">
                        <?=$deal['deal_name'];?>
                    </div>
                    <div class="deal_item_description" ><?=$deal['deal_des'];?></div>
                </div>
            <?} ?>

        </div>
        <style>
            #mcontent_deals{
                background-color: #cccccc;
            }
            .deal_item{
                margin: 5px;
                padding: 10px;
                background-color: #FFFFFF;
            }
            .deal_item_pic{
                width: 100%;

            }
            .deal_item_pic img{
                width: 100%;
            }
            .deal_item_title{
                font-weight: bold;
                font-size: 16px;
                padding-top: 5px;
                padding-bottom: 10px;
            }
            .deal_item_description{
                font-size: 11px;
                white-space: pre-wrap;
            }
        </style>


    <?
    }

    public function formCustom(){
        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);


        $deal_array = isset($valuesNya[$this->arrayID])?$valuesNya[$this->arrayID]:array();




        global $modalReg;
        $modalReg->addAboveBGBlur(array("FeatDeals","addForm"));


        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;">
            Deals
        </h1>





                <div id="notfound_<?=$this->feat_id;?>_button" class="deal_not_found" <?if(count($deal_array)>0){?>style="display: none;"<?}?>>
                <h3 style="text-align: center; padding: 30px; color: #bbbbbb;">Oops, sorry no deals was found...</h3>
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
                    <div class="col-md-7 arraylist_name"><?=$deal['deal_name'];?></div>
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
                <button onclick="createDeal();" class="btn btn-success btn-lg">Create New Deals</button>
            </div>


        <script>
            function createDeal(){

//                console.log("createdeal");
                $('.bgblur').show();
                $('#deal_kosong').show();

                //reset value deal_kosong
                $('#deal_id').val('-1');
                $('#deal_name').val('Name');
                $('#deal_des').val('Description');
                $('#deal_pic').val("<?=_BPATH;?>images/run.jpg");

                //images
                $('#deal_logo_prev').attr("src",$('#deal_pic').val());
                $('#sim_deal_pic').attr("src",$('#deal_pic').val());

                //texts
                $('#sim_deal_title').html($('#deal_name').val());
                $('#sim_deal_des').html($('#deal_des').val());

                $('#image2cropdeal_logo').attr("src",$('#deal_pic').val());
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
//                    deal_name : deal_name,
//                    deal_des : deal_des,
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
                $('#deal_kosong').show();

                var data = data_<?=$this->feat_id;?>;
                for(var x=0;x<data.length;x++) {
                    var attr = data[x];

                    if(x==num){
                        //masukan ke #dealkosong
                        $('#deal_id').val(x);
                        $('#deal_name').val(attr['deal_name']);
                        $('#deal_des').val(attr['deal_des']);
                        $('#deal_pic').val(attr['deal_pic']);

                        //images
                        $('#deal_logo_prev').attr("src",attr['deal_pic']);
                        $('#sim_deal_pic').attr("src",attr['deal_pic']);

                        //texts
                        $('#sim_deal_title').html(attr['deal_name']);
                        $('#sim_deal_des').html(attr['deal_des']);

                        //image2crop+id
                        $('#image2cropdeal_logo').attr("src",attr['deal_pic']);

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

    public function addForm(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        //default values
        $deal_name = "Name";
        $deal_des = "Description";

        $deal_pic = _BPATH."images/run.jpg";


        ?>
        <div class="list_item_form" id="deal_kosong" style="display: none; padding: 10px; padding-top: 0px;">
            <div style="float: right; width: 10px; height: 10px; padding-top: 10px;color: #dedede; cursor:pointer;" onclick="closeBlur();">x</div>
            <div style="width: 600px;" >
                <h1 style="text-align: center; font-size: 17px;">New Deal</h1>
                <hr>
                <div class="col-md-7">

                    <input type="hidden" id="deal_id" name="deal_id" value="-1">

                    <div class="form-group">

                        <? $bannerModalID = "deal_logo";?>


                            <label for="info_profilepic">Deal picture </label>
                            <div class="previewImg">
                                <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$deal_pic;?>">
                            </div>

                        <?
                        global $modalReg;

                        $modalReg->regCropper($bannerModalID,"Deal Picture","deal_pic",$deal_pic,"0:0",array("deal_logo_prev","sim_deal_pic"));

                        ?>



                        <div class="clearfix"></div>

                        <input type="hidden"  id="deal_pic" name="deal_pic" value="<?=$deal_pic;?>" >


                    </div>

                    <div class="form-group">
                        <label for="deal_name">Deal Title</label>
                        <?
                        TextLimiter::inputText("text","deal_name","deal_name","Deal Name",$deal_name,25,1,"sim_deal_title");
                        ?>
                    </div>


                    <div class="form-group">
                        <label for="deal_des">Deal Description</label>
                        <?
                        TextLimiter::inputTextArea("text","deal_des","deal_des","Deal Description",$deal_des,500,1,"sim_deal_des");
                        ?>
                    </div>
                    <button id="deal_add_item_button" style="width: 100%;" class="btn btn-lg btn-success">Save</button>
                </div>
                <div class="col-md-5">
                    <div class="deal_item" style="border: 1px solid #dedede;">
                        <div class="deal_item_pic" >
                            <img id="sim_deal_pic" src="<?=$deal_pic;?>">
                        </div>
                        <div class="deal_item_title" id="sim_deal_title">
                            <?=$deal_name;?>
                        </div>
                        <div class="deal_item_description" id="sim_deal_des"><?=$deal_des;?></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


        </div>
        <script>
            $('#deal_add_item_button').click(function(){
                var deal_name = $('#deal_name').val();
                var deal_des = $('#deal_des').val();
                var deal_pic = $('#deal_pic').val();
                var deal_id = $('#deal_id').val();


                $.post("<?=_SPPATH;?>FeatureSessionLayer/addArrayItem?id=<?=$this->feat_id;?>&arrayID=<?=$this->arrayID;?>&cekID=deal_id",{
                    deal_name : deal_name,
                    deal_des : deal_des,
                    deal_pic : deal_pic,
                    deal_id : deal_id
                },function(data){
                    console.log(data);
                    closeBlur();
                    update_<?=$this->feat_id;?>_Simulator(data);
                },'json');
            });

            function update_<?=$this->feat_id;?>_Simulator(data){

                data_<?=$this->feat_id;?> = data;

                var design = '';
                var list = '';

                for(var x=0;x<data.length;x++){
                    var attr = data[x];


                    design += '<div class="deal_item" id="<?=$this->feat_id;?>_'+x+'">';
                    design += '<div class="deal_item_pic">';

                    if(data_<?=$this->feat_id;?>_justUpdated != -1){
                        design += '<img src="' + attr['deal_pic'] + '?t='+$.now()+'">';
//                        data_<?//=$this->feat_id;?>//_justUpdated = -1;
                    }else {
                        design += '<img src="' + attr['deal_pic'] + '">';
                    }
                    design += '</div>';
                    design += '<div class="deal_item_title">';
                    design += attr['deal_name'];
                    design += '</div>';
                    design += '<div class="deal_item_description" >';
                    design += attr['deal_des'];
                    design += '</div></div>';




                    list += '<li class="ui-state-default" id="<?=$this->feat_id;?>_arr_'+x+'">';
                    list += '<div class="arraylist_item" >';
                    list += '<div class="col-md-7 arraylist_name">'+attr['deal_name']+'</div>';
                    list += '<div class="col-md-5 arraylist_action">' +
                    ' <i onclick="edit_<?=$this->feat_id;?>(\''+x+'\');" class="glyphicon glyphicon-pencil"></i>'+
                    '&nbsp;'+
                    '<i onclick="delete_<?=$this->feat_id;?>(\''+x+'\');" class="glyphicon glyphicon-remove"></i> ' +
                    '</div>';
                    list += '<div class="clearfix"></div>';
                    list += '</div>';
                    list += '</li>';

                }



                $('#<?=$this->feat_id;?>_sortable').html(list);
                $("#app_<?=$this->feat_id;?>_listcontent").html(design);

                if(data.length>0) {
                    $('#notfound_<?=$this->feat_id;?>_button').hide();
                    $("#wadahform_<?=$this->feat_id;?>_button").show();
                }else{
                    $('#notfound_<?=$this->feat_id;?>_button').show();
                    $("#wadahform_<?=$this->feat_id;?>_button").hide();
                }
            }
        </script>
        <?
    }

} 