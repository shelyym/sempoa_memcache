<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/20/16
 * Time: 11:50 AM
 */

class TypeAModelDraft extends Model{
    var $table_name = "push__typeAmodel_draft";
    var $main_id = "a_id";

    //Default Coloms for read
    public $default_read_coloms = "a_id,a_title,a_msg,a_carousel,a_app_id,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_payment_gateway,a_order,a_hide,a_header_type";

//allowed colom in CRUD filter
    public $coloumlist = "a_id,a_title,a_msg,a_carousel,a_app_id,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_payment_gateway,a_content_id,a_category,a_order,a_hide,a_header_type";
    public $a_id;
    public $a_title;
    public $a_msg;
    public $a_carousel;
    public $a_app_id;
    public $a_update_date;
    public $a_posting_date;
    public $a_video;
    public $a_map;
    public $a_action;
    public $a_price;
    public $a_payment_gateway;
    public $a_content_id;
    public $a_category;
    public $a_order;

    var $a_hide;
    var $a_header_type;

    var $crud_webservice_allowed = "a_id,a_msg,a_update_date,a_posting_date,a_video,a_map,a_action,a_price,a_order,a_hide,a_header_type";

    public function p(){
        echo "this is for print";
    }

    public function loadOneWithContentID($id,$readcoloums = "*"){
        global $db;
        $q = "SELECT $readcoloums FROM {$this->table_name} WHERE a_content_id = '$id' LIMIT 0,1";
        $obj = $db->query($q, 1);
        $row = toRow($obj);
        $this->fill($row);
        $this->load = 1;
    }

    public function selectID($id,$readcoloums = "*"){
        global $db;
        $q = "SELECT a_id FROM {$this->table_name} WHERE a_content_id = '$id' LIMIT 0,1";
        $obj = $db->query($q, 1);

        if($obj->a_id != "" && $obj->a_id > 0)
            return $obj->a_id;
        else
            return 0;
    }

    public function selectAllIDs($id,$readcoloums = "*"){
        global $db;
        $q = "SELECT $readcoloums FROM {$this->table_name} WHERE a_content_id = '$id' ORDER BY a_update_date DESC";
        $obj = $db->query($q, 2);

        return $obj;
    }

    public function printForm($content,$existing_id = 0,$onSuccessJS = "",$onFailedJS = "", $dariLuar = 1){

        $reload = 0;
        if($existing_id>0)
        $this->getByID($existing_id);

        $typeAcat = $_GET['cat'];
        $mod = $_GET['mod'];

        $action = array();
        if($this->a_id != ""){
            $reload = 1;
            echo "load ".$this->a_id;

            $msg = unserialize($this->a_msg);
            $action = unserialize($this->a_action);
//            pr($msg);

            if($this->a_category != "" && $this->a_category >0){
                $typeAcat = $this->a_category;
            }
        }


        ?>
        <style>
            #dialog label, #dialog input { display:block; }
            #dialog label { margin-top: 0.5em; }
            #dialog input, #dialog textarea { width: 95%; }
            #tabs { margin-top: 1em; }
            #tabs li .ui-icon-close { float: left; margin: 0.4em 0.2em 0 0; cursor: pointer; }
            #add_tab { cursor: pointer; }
        </style>
        <style>
            .pillar{
                padding: 10px;
            }
            .pillar-content{
                background-color: #dedede;
            }
            .helper{
                clear: left;
                font-size: 11px;
            }
            .ui-dialog{
                z-index: 2000;
            }
        </style>

        <script>
            <? if(!$reload){
            $max = 2;
            $tabsdata = 1;
            ?>
            var tabsdata = [1];
            <? }else{
            $tabsdata = $msg['tabsdata'];

//            $max = max($tabsdata)+2;
            $tabsdataarr = explode(",",$tabsdata);

            if(count($tabsdataarr)>1)
                $max = max($tabsdataarr)+1;
            else $max = $tabsdata+1;
            ?>
            var tabsdata = [<?=$tabsdata;?>];
            <?}?>
            $(function() {
                var tabTitle = $( "#tab_title" ),
                    tabContent = $( "#tab_content" ),
                    tabTemplate = "<li data-x='#{id}'><a href='#{href}'>#{label}</a> <i class='glyphicon glyphicon-remove' role='presentation'></i></li>",
                    tabCounter = <?=$max;?>;

                var tabs = $( "#tabs" ).tabs();
//                var tabs = $( "#tabs" ).tabs();
                tabs.find( ".ui-tabs-nav" ).sortable({
                    axis: "x",
                    stop: function(event,ui) {
                        tabs.tabs( "refresh" );

                        var orders = [];
                        var $gallery = $( "#tabs ul" );
                        $.each($gallery.children(), function(i, item) {
                            orders.push($(item).data("x"));
//                            orders.push($(item).attr("id"));
                        });
                        $('#tabsdata').val(orders.join(","));
//                        $("#info").text("Order: " + orders.join(","));


                    }
                });

                // modal dialog init: custom buttons and a "close" callback resetting the form inside
                var dialog = $( "#dialog" ).dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        Add: function() {
                            addTab();
                            $( this ).dialog( "close" );
                        },
                        Cancel: function() {
                            $( this ).dialog( "close" );
                        }
                    },
                    close: function() {
//                        form[ 0 ].reset();
                    }
                });

                // addTab form: calls addTab function on submit and closes the dialog
                var form = dialog.find( "form" ).submit(function( event ) {
                    addTab();
                    dialog.dialog( "close" );
                    event.preventDefault();
                });

                // actual addTab function: adds new tab using the input from the form above
                function addTab() {
                    var label = tabTitle.val() || "Tab " + tabCounter,
                        id = "tabs-" + tabCounter,
                        li = $( tabTemplate.replace( /#\{id\}/g, tabCounter ).replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
                        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";

                    tabContentHtml = $('#tabContentHtml').html();

                    tabs.find( ".ui-tabs-nav" ).append( li );
                    tabs.append( "<div id='" + id + "'>" +id+ tabContentHtml + "</div>" );
                    tabs.tabs( "refresh" );


                    //edit the name of the form accordingly
                    $("#"+id+" .contenttext").attr('name','contenttext-'+tabCounter);
                    $("#"+id+" .contenttitle").attr('name','contenttitle-'+tabCounter);
                    $("#"+id+" .tabtitle").attr('name','tabtitle-'+tabCounter);

                    tabsdata.push(tabCounter);

                    $('#tabsdata').val(tabsdata.join());

                    tabCounter++;
                }

                // addTab button: just opens the dialog
                $( "#add_tab" )
                    .button()
                    .click(function() {
//                        dialog.dialog("open");
                        var tabCount = $('#tabs >ul >li').size();;
                        if(tabCount<3) {
                            dialog.dialog("open");
                        }
                        else{
                            alert("max tab adalah 3");
                        }
                    });

                // close icon: removing the tab on click
                tabs.delegate( "i.glyphicon-remove", "click", function() {

                    var removeItem = $( this ).closest( "li").data('x');

                    var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
                    $( "#" + panelId ).remove();
//                    tabCounter--;

                    console.log(removeItem);
                    tabsdata.splice( $.inArray(removeItem, tabsdata), 1 );
                    $('#tabsdata').val(tabsdata.join());

                    tabs.tabs( "refresh" );
                });

                tabs.bind( "keyup", function( event ) {
                    if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
                        var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
                        $( "#" + panelId ).remove();
                        tabs.tabs( "refresh" );
                    }
                });
            });
        </script>

        <form id="formaddapp">
        <div class="form-typeA" style="background-color: #FFFFFF;">
            <? if(!$dariLuar){?>
            <div class="col-md-12" style="padding: 10px; background-color: #e1e1e1;">
                Article Name : <input name="articlename" type="text" value="<?=$content->content_name;?>"  id="articlename" placeholder="Enter Title">

                <div class="col-md-3">
                    AID : <input type="text" name="a_id" id="a_id" value="<?=$this->a_id;?>"><br>
                    TabsData : <input type="text" name="tabsdata" id="tabsdata" value="<?=$tabsdata;?>">
                </div>
                <div class="col-md-3">
                    Cont ID : <input type="text" name="content_id" id="content_id" value="<?=$content->content_id;?>">
                </div>
                <div class="col-md-3">

                    Cat ID : <input type="text" name="cat" id="cat" value="<?=$typeAcat;?>">

                    <? if($mod == "typec"){

                        if($reload) {
                            $rel = new TypeCCatRelDraft();
//                            echo "rel_a_id = '{$this->a_id}'";
                            $arrCats = $rel->getWhereFromMultipleTable("rel_a_id = '{$this->a_id}' AND cat_id = rel_cat_id",array("TypeCCategoryModelDraft"));

//                            pr($arrCats);

                            foreach($arrCats as $cat){
                                ?><?=$cat->cat_name;?>,<?
                            }
                        }
                        ?>

                        <button type="button">add new category</button>
                    <?} ?>
                </div>
            </div>
            <? } ?>
            <div class="col-md-3 pillar pillar-header">
                <h2 class="hype">Headings</h2>
                <div class="form-group">
                    <label class="control-label " for="carousel">
                        Image:
                        <div class="helper">max 5 images</div>
                    </label>
                    <div class="">

                        <?
                        $foto = new \Leap\View\InputGallerySortable("carousel","carousel",$this->a_carousel);
                        $foto->p();

                        ?>
                    </div>


                </div>



            </div>


            <div class="col-md-6 pillar pillar-content">
                <h2 class="hype"><div style="float: right;">
                        <button type="button" id="add_tab" style="font-size: 10px;">Add Tab</button></div>Body
                </h2>


                <div id="dialog" title="Tab data">
                    <form>
                        <fieldset class="ui-helper-reset">
                            <label for="tab_title">Title</label>
                            <input type="text" name="tab_title" id="tab_title" value="Tab Title" class="ui-widget-content ui-corner-all">
<!--                            <div style="display: none;">-->
<!--                            <label for="tab_content">Content</label>-->
<!--                            <textarea name="tab_content" id="tab_content" class="ui-widget-content ui-corner-all">Tab content</textarea>-->
<!--                            </div>-->
                        </fieldset>
                    </form>
                </div>

                <div id="tabContentHtml" style="display: none;">
                    <div class="form-group">
                        <label class="control-label col-sm-12" for="tabtitle">Tab Text:
                            <div class="helper">max 15 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <input name="tabtitle" type="text" class="form-control tabtitle"  placeholder="Enter Title">
                            <div class="err"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-12" for="contenttitle">Title:
                            <div class="helper">max 100 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <input name="contenttitle" type="text" class="form-control contenttitle"  placeholder="Enter Title">
                            <div class="err"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-12" for="appshort">Message:
                            <div class="helper">max 4000 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <textarea name="contenttext" class="form-control contenttext"  rows="5"></textarea>
                            <div class="err"></div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>



                    <div id="tabs">
                    <ul>
                        <?
                        if(!$reload){
                        ?>
                        <li data-x="1"><a href="#tabs-1">Title 1</a> <i class="glyphicon glyphicon-remove" role="presentation"></i></li>
                            <? }else{



                            foreach($msg['content'] as $num=>$data){
                            ?>
                                <li data-x="<?=$num;?>"><a href="#tabs-<?=$num;?>"><?=$data['tabtitle'];?></a> <i class="glyphicon glyphicon-remove" role="presentation"></i></li>

                            <? }} ?>
                    </ul>
        <?
        if(!$reload){
            ?>
                    <div id="tabs-1">
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="tabtitle">Tab Text:
                                <div class="helper">max 15 chars</div>
                            </label>
                            <div class="col-sm-12">
                                <input name="tabtitle-1" type="text" class="form-control tabtitle"  placeholder="Enter Title">
                                <div class="err"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-12" for="contenttitle">Title:
                                <div class="helper">max 100 chars</div>
                            </label>
                            <div class="col-sm-12">
                                <input name="contenttitle-1" type="text" class="form-control contenttitle"  placeholder="Enter Title">
                                <div class="err"></div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-12" for="appshort">Message:
                                <div class="helper">max 4000 chars</div>
                            </label>
                            <div class="col-sm-12">
                                <textarea name="contenttext-1" class="form-control contenttext"  rows="5"></textarea>
                                <div class="err"></div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                    </div>

            <? }else{
            foreach($msg['content'] as $num=>$data){
            ?>
                <div id="tabs-<?=$num;?>">
                    <div class="form-group">
                        <label class="control-label col-sm-12" for="tabtitle">Tab Text:
                            <div class="helper">max 15 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <input value="<?=$data['tabtitle'];?>" name="tabtitle-<?=$num;?>" type="text" class="form-control tabtitle"  placeholder="Enter Title">
                            <div class="err"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-12" for="contenttitle">Title:
                            <div class="helper">max 100 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <input value="<?=$data['contenttitle'];?>" name="contenttitle-<?=$num;?>" type="text" class="form-control contenttitle"  placeholder="Enter Title">
                            <div class="err"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-12" for="appshort">Message:
                            <div class="helper">max 4000 chars</div>
                        </label>
                        <div class="col-sm-12">
                            <textarea name="contenttext-<?=$num;?>" class="form-control contenttext"  rows="5"><?=$data['contenttext'];?></textarea>
                            <div class="err"></div>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
            <? }} ?>

                </div>







            </div>
            <div class="col-md-3 pillar pillar-footer">
                <h2 class="hype">Add</h2>
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                    Call Now Button</a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <input value="<?=$action['call']['callbutton_text'];?>" name="callbutton_text" type="text" class="form-control" id="callbutton_text" placeholder="Enter Button Text">
                                        <div class="err"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <input value="<?=$action['call']['callbutton_number'];?>" name="callbutton_number" type="text" class="form-control" id="callbutton_number" placeholder="Enter Phone">
                                        <div class="err"></div>
                                    </div>
                                    Activate <input type="checkbox"   <? if($action['call']['callbutton_active'])echo "checked";?>  name="callbutton_active" id="callbutton_active">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                    Email Now Button</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <input value="<?=$action['email']['emailbutton_text'];?>" name="emailbutton_text" type="text" class="form-control" id="emailbutton_text" placeholder="Enter Button Text">
                                        <div class="err"></div>
                                    </div>
                                    <div class="col-sm-12">
                                        <input value="<?=$action['email']['emailbutton_mail'];?>" name="emailbutton_mail" type="text" class="form-control" id="emailbutton_mail" placeholder="Enter Email">
                                        <div class="err"></div>
                                    </div>
                                    Activate <input   <? if($action['email']['emailbutton_active'])echo "checked";?>  type="checkbox" id="emailbutton_active" name="emailbutton_active">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                    Share Button</a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">

                                Activate <input <? if($action['share']['sharebutton_active'])echo "checked";?> type="checkbox" id="sharebutton_active" name="sharebutton_active">
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                    Product Price</a>
                            </h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">

                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <input  value="<?=$action['price']['value'];?>" name="price" type="text" class="form-control" id="price" placeholder="Enter Price">
                                        <div class="err"></div>
                                    </div>
                                    Activate <input <? if($action['price']['price_active'])echo "checked";?> type="checkbox" id="price_active" name="price_active">

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="padding: 10px; text-align: center;">
                <button type="submit" id="save_<?=$content->content_id;?>" class="btn btn-danger" style="width: 100%;">SAVE</button>
            </div>

            <div class="clearfix"></div>
        </div>
        <script>
//            $('#save_<?//=$content->content_id;?>//').click(function(){
//                alert('hello');
//                removeBGBlack();
//            });

            $( "#formaddapp" ).submit(function( event ) {

                $(".err").hide();

//                        alert("benar semua1");
                var $form = $(this);
                var url = "<?=_SPPATH;?>AppContentWS/editTypeA";

                $(".err").hide();

                // Send the data using post
                var posting = $.post(url, $form.serialize(), function (data) {
                    console.log(data);


                    if (data.bool) {
                        alert("sucess");
//                        location.reload();
                        <?=$onSuccessJS;?>
                        //kalau success masuk ke check your email....
//                        document.location = "<?//=_SPPATH;?>//myapps?mode=redirect&id="+data.app_id;
//                                document.location = "<?//=_SPPATH;?>//PaymentWeb/payfor?app_id="+data.app_id;
                    }
                    else {
                        <?=$onFailedJS;?>
                    }


                },'json');




                event.preventDefault();


            });
        </script>

        </form>
        <?
    }


    function cleanIsi($cleanObj){


        $msg = unserialize($this->a_msg);
        $action = unserialize($this->a_action);

//        pr($msg);
        unset($cleanObj['a_msg']);
        unset($cleanObj['a_action']);

        $arrTabs = array();
        foreach($msg['content'] as $tabs){
            $arrTabs[] = $tabs;
        }

        $carousel = array();
        $exp = explode(",",trim(rtrim($this->a_carousel)));
        foreach($exp as $a){
            if($a!="")
            $carousel[] = _BPATH._PHOTOURL.$a;
        }
        $cleanObj['carousel'] = $carousel;
        $cleanObj['carousel_asli'] = $this->a_carousel;

        $cleanObj['msg'] = $arrTabs;
        $cleanObj['action'] = $action;


        return $cleanObj;
    }
} 