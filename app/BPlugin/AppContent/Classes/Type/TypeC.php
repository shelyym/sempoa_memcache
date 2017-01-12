<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:24 PM
 */

class TypeC extends AppContentTemplate{

    public $name = "Group";
    public $isSingular = 0;
    public $icon = "ic_grid_3.png";
    public $content;
    public $onSuccessJS = "removeBGBlack3();";
    public $onFailedJS = "alert('failed');";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){

        $content = $this->content;

        $content_id = $this->content->content_id;
//        pr($content);

        //disini kalau ada ID type A yang cocok lgs dikirim pas edit...


        $ta = new TypeAModelDraft();
        //$arr = $ta->selectAllIDs($this->content->content_id);


        $cat = new TypeCCategoryModelDraft();
        $arrCats = $cat->getWhere("cat_content_id = '$content_id' ORDER BY cat_order ASC");


        global $db;

        $rel = new TypeCCatRelDraft();
        $q = "SELECT * FROM {$rel->table_name},{$ta->table_name} WHERE a_id = rel_a_id AND rel_content_id = '$content_id'";
        $arr = $db->query($q,2);

        //pr($arr2);
        ?>

        <style>
            /*.ui-tabs-vertical { width: 55em; }*/
            /*.ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 150px; }*/
            /*.ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }*/
            /*.ui-tabs-vertical .ui-tabs-nav li a { display:block; }*/
            /*.ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }*/
            /*.ui-tabs-vertical .ui-tabs-panel { padding: 10px; margin-left: 160px;}*/
        </style>

        <div style="background-color: #FFFFFF;">
            <div class="col-md-12" style="padding: 10px; background-color: #e1e1e1;">
                Article Name : <input name="articlename" type="text" value="<?=$content->content_name;?>"  id="articlename" placeholder="Enter Title">
                <input type="text" name="cat_order" id="cat_order">
            </div>

            <div class="col-md-12" style="padding: 10px; ">
                <button class="btn btn-success" id="add_cats" >Add New Category</button>
                <button class="btn btn-info" id="add_typeA" >Add New TypeA in Selected Category</button>

                <div id="cat_tabs">
                    <div class="col-md-2">

                    <ul>
                        <?
                        $imp = array();
                        foreach($arrCats as $c){
                            $imp[] = $c->cat_id;
                            ?>
                        <li data-x="<?=$c->cat_id;?>"><a href="#cat_tabs-<?=$c->cat_id;?>"><?=$c->cat_name;?></a>  <i class='glyphicon glyphicon-remove' role='presentation'></i></li>
                        <? } ?>

                    </ul>
                    </div>
                    <div class="col-md-10" id="cat_tab_isi">
        <? foreach($arrCats as $c){ ?>
                    <div id="cat_tabs-<?=$c->cat_id;?>">
                        <? foreach($arr as $aid){
                            $msg = unserialize($aid->a_msg);

                            if($aid->rel_cat_id == $c->cat_id) {
                                ?>
                                <div class="col-md-2">
                                    <div style="background-color: #dedede; margin: 10px; padding: 10px;" class="name"
                                         onclick="loadPopUp3('<?= _SPPATH; ?>AppContentWS/editTypeAFromOutside?content_id=<?= $content->content_id; ?>&id=<?= $aid->a_id; ?>&mod=typec','typea_<?= $aid->a_id; ?>','typeb_edit_typea');"><?= $aid->a_id; ?></div>
                                </div>
                            <?
                            }
                        } ?>
                    </div>
            <? } ?>


                    </div>
                </div>

                <div id="wadah_typeB"></div>

                <div class="clearfix"></div>
                <div id="wadah_typeB_typeA"></div>


            </div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="padding: 10px; text-align: center;">
                <button type="submit" id="save_<?=$content->content_id;?>" class="btn btn-danger" style="width: 100%;">SAVE</button>
            </div>


            <div id="dialog_category" title="Category data">
                <form>
                    <fieldset class="ui-helper-reset">
                        <label for="tab_title">Cat Title</label>
                        <input type="text" name="cat_title" id="cat_title" value="Category" class="ui-widget-content ui-corner-all">
                        <!--                            <div style="display: none;">-->
                        <!--                            <label for="tab_content">Content</label>-->
                        <!--                            <textarea name="tab_content" id="tab_content" class="ui-widget-content ui-corner-all">Tab content</textarea>-->
                        <!--                            </div>-->
                    </fieldset>
                </form>
            </div>
        </div>

        <script>

            var cats = [<?=implode(",",$imp);?>];
            var catsJumlah = 0;
            var selectedCat;
            $(function() {


                var tabs = $( "#cat_tabs" ).tabs();
                var vtabTemplate = "<li data-x='#{id}'><a href='#{href}'>#{label}</a> <i class='glyphicon glyphicon-remove' role='presentation'></i></li>";


                $( "#cat_tabs" ).tabs({
                    activate: function (event, ui) {
                        console.log(ui.newPanel[0].id);
                        var cat_id = ui.newPanel[0].id.split("-")[1];
                        console.log(cat_id);
                        selectedCat = cat_id;
                    }
                }).addClass( "ui-tabs-vertical ui-helper-clearfix" );
                $( "#cat_tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

                tabs.find( ".ui-tabs-nav" ).sortable({
                    axis: "y",
                    stop: function(event,ui) {
                        tabs.tabs( "refresh" );

                        var orders = [];
                        var $gallery = $( "#cat_tabs ul" );
                        $.each($gallery.children(), function(i, item) {
                            orders.push($(item).data("x"));
//                            orders.push($(item).attr("id"));
                        });
                        cats = orders;
                        hitungOrderCats();

                        $.post("<?=_SPPATH;?>AppContentWS/updateTypeCCatOrder",
                            {
                                content_id:<?=$content_id;?>,
                                order_ids : cats.join()
                            },
                            function(data){

                            }
                        );
                    }
                });


                // modal dialog init: custom buttons and a "close" callback resetting the form inside
                var dialog = $("#dialog_category").dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        Add: function () {
                            addCats();
                            $(this).dialog("close");
                        },
                        Cancel: function () {
                            $(this).dialog("close");
                        }
                    },
                    close: function () {
//                        form[ 0 ].reset();
                    }
                });

                // addTab form: calls addTab function on submit and closes the dialog
                var form = dialog.find( "form" ).submit(function( event ) {
                    addCats();
                    dialog.dialog( "close" );
                    event.preventDefault();
                });


                $("#add_cats")
                    .button()
                    .click(function () {
//
                        dialog.dialog("open");

                    });

                // actual addTab function: adds new tab using the input from the form above
                function addCats() {
                    //wadah_typeB
                    var cat_title = $('#cat_title').val();


                    $.post("<?=_SPPATH;?>AppContentWS/addTypeCCat",{
                        cat_name : cat_title,
                        content_id : <?=$content->content_id;?>,
                        content_app_id : <?=$content->content_app_id;?>
                    },function(data){
                        if(data.bool){

                            var id = data.bool;

//                            $('#wadah_typeB').append("<div onclick=\"showOnlyCat('"+id+"');\" id='cattitle_"+id+"' class='cat_title col-md-2' data-x='"+cat_title+"'>"+cat_title+"</div>");

//                            $('#wadah_typeB_typeA').append("<div id='catisi_"+id+"'  class='cat_isi' data-x='"+cat_title+"'>content "+id+"</div>");
//                            hitungOrderCats();


                            cats.push(id);

//                            showOnlyCat(id);
//                            catsJumlah++;

                            addCatsToTab(id);

                            hitungOrderCats();

                        }else{
                            alert("failed");
                        }
                    },'json');


                }


                function addCatsToTab(cat_id){
                    var label = $('#cat_title').val() || "Tab " + cat_id,
                        id = "cat_tabs-" + cat_id,
                        li = $( vtabTemplate.replace( /#\{id\}/g, cat_id ).replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) );
                    var tabContentHtml = id;

                    tabs.find( ".ui-tabs-nav" ).append( li );
                    $('#cat_tab_isi').append( "<div id='" + id + "'>" +id+ tabContentHtml + "</div>" );
                    tabs.tabs( "refresh" );



                }

                // close icon: removing the tab on click
                tabs.delegate( "i.glyphicon-remove", "click", function() {

                    if(confirm("this will delete category")) {
                        var removeItem = $(this).closest("li").data('x');

                        var panelId = $(this).closest("li").remove().attr("aria-controls");
                        $("#" + panelId).remove();


                        $.post("<?=_SPPATH;?>AppContentWS/deleteTypeCCat",{
                           cat_id : removeItem,
                           content_id : <?=$content_id;?>
                        },function(data){
                            if(data.bool){

//                    tabCounter--;

                                console.log(removeItem);
                                cats.splice($.inArray(removeItem, cats), 1);


                                tabs.tabs("refresh");

                                hitungOrderCats();
                            }
                        },'json');


                    }
                });


                hitungOrderCats();
            });


            function hitungOrderCats(){

                $('#cat_order').val(cats.join());
            }

            function showOnlyCat(id){
                $('.cat_isi').hide();
                $('#catisi_'+id).show();
                selectedCat = id;
                $('.cat_title').removeClass('cat_selected');
                $('#cattitle_'+id).addClass('cat_selected');
            }



            $('#save_<?=$content->content_id;?>').click(function(){
                var articlename = $('#articlename').val();
                $.post("<?=_SPPATH;?>AppContentWS/editTypeB",{content_id:<?=$this->content->content_id;?>,articlename:articlename},
                    function(data){
                        alert(data);
                        location.reload();
//                    removeBGBlack();
                    });
            });

            $('#add_typeA').click(function(){
//                var cat = $("#cat_tabs .ui-tabs-panel:visible").data("x");
                loadPopUp3('<?=_SPPATH;?>AppContentWS/createTypeA?id=<?=$content->content_id;?>&cat='+selectedCat+'&mod=typec','typeac_<?=$content->content_id;?>','typec_add_typea');
            });
        </script>

        <style>
            .ui-dialog{
                z-index: 5000;
            }
            .cat_title{
                margin: 10px;
                padding: 10px;
                border:1px solid #cccccc;
            }
            .cat_isi{
                background-color: #dedede;
                min-height: 100px;
                display: none;

            }
            .cat_selected{
                background-color: #ffff00;
            }
        </style>
    <?
    }

} 