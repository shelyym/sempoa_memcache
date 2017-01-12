<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/22/16
 * Time: 9:14 PM
 */

class ZAppFeatureListRTE extends ZAppFeature{

    public $feat_element_name = 'rename feat element name';

    public $feat_noimage = "images/noimage2.png";

    public $feat_default_description = "Description";

    public $limit_text_for_more = 120;


    function __construct() {
        parent::__construct();

        $this->feat_noimage = _BPATH."images/noimage2.png";

    }

    public function overwriteModal(){
        global $modalReg;
        $modalReg->addAboveBGBlur(array(get_called_class(),"addForm")); //harus dioverwrite
    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $arrDeals = $valuesNya[$this->arrayID];

        ?>


        <div class="<?=$this->feat_id;?>_mcontent" id="app_<?=$this->feat_id;?>_listcontent" >

            <? $this->appListViewer();?>


        </div>
        <style>
            #mcontent_<?=$this->feat_id;?>{
                background-color: #cccccc;
            }
            .<?=$this->feat_id;?>_item{
                /*margin: 10px;*/
                /*padding: 10px;*/
                background-color: #FFFFFF;
                margin: 10px;
            }
            .<?=$this->feat_id;?>_item_pic{
                width: 100%;

            }
            .<?=$this->feat_id;?>_item_pic img{
                width: 100%;
            }
            .<?=$this->feat_id;?>_item_title{
                font-weight: bold;
                font-size: 16px;
                padding-top: 5px;

            }
            .<?=$this->feat_id;?>_item_description{
                background-color: #FFFFFF;
                white-space: pre-wrap;
                padding: 10px;
            }
        </style>


    <?
    }

    public function formCustom(){
        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);


        $deal_array = isset($valuesNya[$this->arrayID])?$valuesNya[$this->arrayID]:array();

//pr($deal_array);


        $this->overwriteModal();


        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;">
            <?=$this->feat_name;?>
        </h1>
        <div id="notfound_<?=$this->feat_id;?>_button" class="deal_not_found" <?if(count($deal_array)>0){?>style="display: none;"<?}?>>
            <h3 style="text-align: center; padding: 30px; color: #bbbbbb;">Oops, sorry no <?=$this->feat_element_name;?> was found...</h3>
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
                            <div class="col-md-9 arraylist_name"><?=substr(strip_tags( $deal[$this->feat_id.'_des']),0,30);?>...</div>
                            <div class="col-md-3 arraylist_action">
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
            <button onclick="createDeal_<?=$this->feat_id;?>();" class="btn btn-success btn-lg">Create New <?=$this->feat_element_name;?></button>
        </div>


        <script>
            function createDeal_<?=$this->feat_id;?>(){

//                console.log("createdeal");
                $('.bgblur').show();
                $('#<?=$this->feat_id;?>_kosong').show();

                //reset value deal_kosong
                $('#<?=$this->feat_id;?>_id').val('-1');
//                $('#<?//=$this->feat_id;?>//_name').val('Name');
                $('#<?=$this->feat_id;?>_des').html('<?=$this->feat_default_description;?>');
                $('#<?=$this->feat_id;?>_pic').val("<?=$this->feat_noimage;?>");

                //images
                $('#<?=$this->feat_id;?>_logo_prev').attr("src",$('#<?=$this->feat_id;?>_pic').val());
                $('#sim_<?=$this->feat_id;?>_pic').attr("src",$('#<?=$this->feat_id;?>_pic').val());

                //texts
//                $('#sim_<?//=$this->feat_id;?>//_title').html($('#<?//=$this->feat_id;?>//_name').val());
                $('#sim_<?=$this->feat_id;?>_des').html($('#<?=$this->feat_id;?>_des').html());

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
//                        $('#<?//=$this->feat_id;?>//_name').val(attr['<?//=$this->feat_id;?>//_name']);
                        $('#<?=$this->feat_id;?>_des').html(attr['<?=$this->feat_id;?>_des']);
                        $('#<?=$this->feat_id;?>_pic').val(attr['<?=$this->feat_id;?>_pic']);

                        //images
                        $('#<?=$this->feat_id;?>_logo_prev').attr("src",attr['<?=$this->feat_id;?>_pic']);
                        $('#sim_<?=$this->feat_id;?>_pic').attr("src",attr['<?=$this->feat_id;?>_pic']);

                        //texts
//                        $('#sim_<?//=$this->feat_id;?>//_title').html(attr['<?//=$this->feat_id;?>//_name']);
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

    public function addForm(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        //default values
        $deal_name = "Name";
        $deal_des = $this->feat_default_description;

        $deal_pic = $this->feat_noimage;


        ?>
        <div class="list_item_form" id="<?=$this->feat_id;?>_kosong" style="display: none; padding: 10px; padding-top: 0px;">
            <div style="float: right; width: 10px; height: 10px; padding-top: 10px;color: #dedede; cursor:pointer;" onclick="closeBlur();">x</div>
            <div style="width: 600px;" >
                <h1 style="text-align: center; font-size: 17px;">New <?=$this->feat_element_name;?></h1>
                <hr>
                <div class="col-md-7">

                    <input type="hidden" id="<?=$this->feat_id;?>_id" name="<?=$this->feat_id;?>_id" value="-1">

                    <div class="form-group">

                        <? $bannerModalID = $this->feat_id."_logo";?>


                        <label for="<?=$bannerModalID;?>_prev"><?=$this->feat_name;?> picture </label>
                        <div class="previewImg">
                            <img style="cursor:pointer;"  data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$deal_pic;?>">
                        </div>

                        <?
                        global $modalReg;

                        $modalReg->regCropper($bannerModalID,$this->feat_name." Picture",$this->feat_id."_pic",$deal_pic,"0:0",array($this->feat_id."_logo_prev","sim_".$this->feat_id."_pic"));

                        ?>



                        <div class="clearfix"></div>

                        <input type="hidden"  id="<?=$this->feat_id;?>_pic" name="<?=$this->feat_id;?>_pic" value="<?=$deal_pic;?>" >


                    </div>


                    <div class="form-group">
                        <label for="<?=$this->feat_id;?>_des"><?=$this->feat_name;?> Description</label>
                        <?
                        TextLimiter::inputTextArea("text",$this->feat_id."_des",$this->feat_id."_des",$this->feat_name." Description",$deal_des,500,1,"sim_".$this->feat_id."_des");
                        ?>
                    </div>
                    <button id="<?=$this->feat_id;?>_add_item_button" style="width: 100%;" class="btn btn-lg btn-success">Save</button>
                </div>
                <div class="col-md-5">
                    <div class="<?=$this->feat_id;?>_item" style="border: 1px solid #dedede;">
                        <div class="<?=$this->feat_id;?>_item_pic" >
                            <img id="sim_<?=$this->feat_id;?>_pic" src="<?=$deal_pic;?>">
                        </div>

                        <div class="<?=$this->feat_id;?>_item_description" id="sim_<?=$this->feat_id;?>_des"><?=$deal_des;?></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>


        </div>
        <script>
            $('#<?=$this->feat_id;?>_add_item_button').click(function(){
//                var deal_name = $('#<?//=$this->feat_id;?>//_name').val();
                var deal_des = $('#<?=$this->feat_id;?>_des').html();
                var deal_pic = $('#<?=$this->feat_id;?>_pic').val();
                var deal_id = $('#<?=$this->feat_id;?>_id').val();


                $.post("<?=_SPPATH;?>FeatureSessionLayer/addArrayItem?id=<?=$this->feat_id;?>&arrayID=<?=$this->arrayID;?>&cekID=<?=$this->feat_id;?>_id",{
//                    <?//=$this->feat_id;?>//_name : deal_name,
                    <?=$this->feat_id;?>_des : deal_des,
                    <?=$this->feat_id;?>_pic : deal_pic,
                    <?=$this->feat_id;?>_id : deal_id
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


                    design += '<div class="<?=$this->feat_id;?>_item" id="<?=$this->feat_id;?>_'+x+'">';

                    if(attr['<?=$this->feat_id;?>_pic'] != '<?=$this->feat_noimage;?>') {
                        design += '<div class="<?=$this->feat_id;?>_item_pic">';

                        if (data_<?=$this->feat_id;?>_justUpdated != -1) {
                            design += '<img src="' + attr['<?=$this->feat_id;?>_pic'] + '?t=' + $.now() + '">';
//                        data_<?//=$this->feat_id;?>//_justUpdated = -1;
                        } else {
                            design += '<img src="' + attr['<?=$this->feat_id;?>_pic'] + '">';
                        }
                        design += '</div>';
                    }
//                    design += '<div class="<?//=$this->feat_id;?>//_item_title">';
//                    design += attr['<?//=$this->feat_id;?>//_name'];
//                    design += '</div>';
                    if(attr['<?=$this->feat_id;?>_des']!='') {
                        design += '<div class="<?=$this->feat_id;?>_item_description" >';
                        design += attr['<?=$this->feat_id;?>_des'];
                        design += '</div>';
                    }
                    design += '</div>';




                    list += '<li class="ui-state-default" id="<?=$this->feat_id;?>_arr_'+x+'">';
                    list += '<div class="arraylist_item" >';
                    list += '<div class="col-md-9 arraylist_name">'+strip(attr['<?=$this->feat_id;?>_des']).substring(0, 30)+'...</div>';
                    list += '<div class="col-md-3 arraylist_action">' +
                    ' <i onclick="edit_<?=$this->feat_id;?>(\''+x+'\');" class="glyphicon glyphicon-pencil"></i>'+
                    ' &nbsp; '+
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

    function appListViewer(){
        $valuesNya = FeatureSessionLayer::load($this->feat_id);
        $arrDeals = $valuesNya[$this->arrayID];



        ?>
        <? foreach($arrDeals as $num=>$deal){?>
            <div class="<?=$this->feat_id;?>_item" id="<?=$this->feat_id;?>_<?=$num;?>">
                <?
                //limit the limit_text_for_more
//                $des = strip_tags($deal[$this->feat_id.'_des'],"<div>");
                $des = $deal[$this->feat_id.'_des'];
                if(strlen($des)>$this->limit_text_for_more){
//                    $des = truncateHtml($des,$this->limit_text_for_more);
                }


                $mystring = $deal[$this->feat_id.'_pic'];
                $findme = $this->feat_noimage;
                $pos = strpos($mystring, $findme);
                if ($pos === false) {
                   ?>
                    <div class="<?=$this->feat_id;?>_item_pic">
                        <img src="<?=$deal[$this->feat_id.'_pic'];?>">
                    </div>
                    <?
                }
                ?>

                <? if($deal[$this->feat_id.'_des']!=''){?>
                <div class="<?=$this->feat_id;?>_item_description" ><?=$des;?></div>
                <? } ?>
            </div>
        <?} ?>

    <?
    }
} 