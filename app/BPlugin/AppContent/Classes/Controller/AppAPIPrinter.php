<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/14/16
 * Time: 2:46 PM
 */

class AppAPIPrinter extends WebService{

    var $access_app_getByID = "normal_user";
    function app_getByID(){
        $app_id = addslashes($_GET['app_id']);

        $appAcc = new AppAccount();
        $appAcc->getByID($app_id);

        $icon = _SPPATH."images/noimage2.png";
        if($appAcc->app_icon!="")
        $icon =  _SPPATH._PHOTOURL.$appAcc->app_icon;


        ?>
        <div class="col-md-8 col-md-offset-2" style="padding: 10px;">
        <div class="heading">
            <div class="app_container">
                <div class="col-md-3">
                    <img src="<?=$icon;?>" width="100%">
                </div>
                <div class="col-md-9" style="padding-left: 20px; padding-bottom: 10px;">
                    <div class="appname"><?=$appAcc->app_name;?></div>
                    <div class="appdetail"><?=$appAcc->app_active;?></div>
                    <div class="appexpiry">Expired : <?=$appAcc->app_contract_end;?></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- EDIT -->
            <div class="judulbesar">Edit</div>
            <div class="icons_container">
                <div id="edit_header" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_header.png" >
                    <div class="icon_name">Header</div>
                </div>

                <div id="edit_content" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_content.png" >
                    <div class="icon_name">Content</div>
                </div>

                <div id="edit_theme" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_themes.png" >
                    <div class="icon_name">Themes</div>
                </div>
                <div class="clearfix"></div>
            </div>

            <!-- push notif -->
<!--            <div class="judulbesar">Send Push Notification</div>-->
        </div>
        <script>
            $('#edit_header').click(function(){
                addPage("page_edit_header","<?=_SPPATH;?>AppAPIPrinter/edit_header?app_id="+app_id,"Edit Header","app_id");
            });
            $('#edit_content').click(function(){
                addPage("page_edit_content","<?=_SPPATH;?>AppAPIPrinter/edit_content?app=1&id="+app_id,"Edit Content","app_id");
            });

        </script>
        <style>
            .heading{
                padding-left: 100px;
                padding-right: 100px;
            }
            .app_container{
                padding-bottom: 20px;
                padding-top: 10px;
            }
            .appname{
                font-size: 22px;
                color: #333333;
            }
            .judulbesar{
                background-color: #f6f6f6;
                padding: 10px;
            }
            .icons_container{
                /*padding-left: 50px;*/
                /*padding-right: 50px;*/
                padding-bottom: 20px;
                padding-top: 10px;
            }
            .icons{
                text-align: center;
                cursor: pointer;
            }
            .icons img{
                width: 50%;

            }
        </style>
        </div>
        <?

//        pr($appAcc);
    }


    var $access_edit_header = "normal_user";
    function edit_header(){
        $app_id = addslashes($_GET['app_id']);

        $appAcc = new AppAccount();
        $appAcc->getByID($app_id);

        $carousel_custom = 0;
        if($appAcc->home_header_style_draft == "carousel_custom"){
            $carousel_custom = 1;
        }

        $none = 0;
        if($appAcc->home_header_style_draft == "none"){
            $none = 1;
        }

        $lastupdate = 0;
        if($appAcc->home_header_style_draft == "carousel_update" || $appAcc->home_header_style_draft == ""){
            $lastupdate = 1;
        }
        ?>
        <div class="col-md-8 col-md-offset-2" style="padding: 10px;">
        <input type="hidden" id="header_style" value="<?=$appAcc->home_header_style_draft;?>">
        <input type="hidden" id="home_header_inhalt_draft" value="<?=$appAcc->home_header_inhalt_draft;?>">
        <div class="heading">
            <div class="selector">
                <div class="col-sm-8">Show Header</div>
                <div class="col-sm-4"><input onclick="header_carousel_checker('carousel_none');" id="carousel_none" class="selcheck" type="checkbox" <? if(!$none){?>checked<?}?>></div>
                <div class="clearfix"></div>
            </div>

            <div class="selector">
                <div class="col-sm-8">Last Activity
                <div class="small">*Header will be automatically taken from your last 6 updated posts</div>
                </div>
                <div class="col-sm-4"><input onclick="header_carousel_checker('carousel_update');" id="carousel_update" class="selcheck" type="checkbox" <? if($lastupdate){?>checked<?}?>></div>
                <div class="clearfix"></div>
            </div>

            <div class="selector">
                <div class="col-sm-8">Upload Image
                    <div class="small">*Upload your own image</div>
                </div>
                <div class="col-sm-4"><input onclick="header_carousel_checker('carousel_custom');" id="carousel_custom" class="selcheck" type="checkbox" <? if($carousel_custom){?>checked<?}?>></div>
                <div class="clearfix"></div>
                <div id="carousel_custom_inhalt" style="<? if(!$carousel_custom){?>display:none;<?}?>">
<!--                    <button style="float: right;" class="btn btn-default">Add Image</button>-->
<!--                    <div class="clearfix"></div>-->
                    <div id="carousel_custom_inhalt_isi">
                        <?
                        $exp = explode(",",trim(rtrim($appAcc->home_header_inhalt_draft)));

                        for($x=0;$x<6;$x++){
                            $e = $exp[$x];
                            if($e == "")$img = _SPPATH."images/noimage.jpg";
                            else $img = _SPPATH._PHOTOURL.$e;
                            ?>
                            <?
                            $bannerModalID = "carousel_img_".$x;
                            $container = "car_pic_".$x;
                            ?>

                        <div class="carousel_custom_img">
                            <input class="carousel_isi_img" value="<?=$e;?>" type="hidden" id="<?=$container;?>" name="<?=$container;?>">

                            <div class="carousel_custom_img_inside">

<!--                            <img src="--><?//=$img;?><!--">-->

                                <?



//                                global $modalReg;
                                //$id,$modal_title,$InputToUpdate,$value,$ratio = "0:0",$imgIDToBeUpdated = array() ,$onSuccessJS = ''
//                                $modalReg->regCropper($bannerModalID,"Upload Picture","comm_pic",$img,"0:0",array($bannerModalID."_prev"));
                                Cropper::createModal($bannerModalID,"Upload Picture",$container,$img,"0:0",array($bannerModalID."_prev"),"updateCarHeaderImg('".$container."');");
                                ?>
                                <div onclick="removeCarouselImg('<?=$container;?>','<?=$bannerModalID;?>_prev');" class="carousel_remover">x</div>
                                <img style="cursor: pointer;" data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$img;?>" >

                            </div>



                        </div>
                            <?
                        }

                        ?>

                    </div>
                    <div class="clearfix"></div>
                    <script>
                        $( function() {
                            $( "#carousel_custom_inhalt_isi" ).sortable({
                                update: function(event, ui) {
                                    updateOrderCarouselHeader();
                                }
                            });
                            $( "#carousel_custom_inhalt_isi" ).disableSelection();

                            //set history
//                            sethistoryback("app_id");
                        } );

                        function removeCarouselImg(input_id,img_id){

                            if(confirm("This will delete the selected carousel item")) {
                                $('#' + input_id).val("");
                                $('#' + img_id).attr("src", "<?=_SPPATH;?>images/noimage.jpg");
                                updateOrderCarouselHeader();
                            }
                        }
                        function updateCarHeaderImg(id){

                            updateOrderCarouselHeader();


                        }

                        function updateOrderCarouselHeader(){

                            var orders = [];
                            $.each($( "#carousel_custom_inhalt_isi" ).children(), function(i, item) {
//                                console.log(item);
                                var xx = $(item).find( "input.carousel_isi_img" );
//                                console.log(xx);
//                                console.log(xx.val());


                                if(xx.val()!="") {
                                    var lagi2 = xx.val().replace("<?=_BPATH._PHOTOURL;?>","");
                                    orders.push(lagi2);
                                }
                            });
//                            console.log(orders);
                            $('#home_header_inhalt_draft').val(orders.join(","));

                            $.post("<?=_SPPATH;?>AppAPI/set_home_header",{
                                acc_id : "<?=Account::getMyID();?>",
                                app_id : "<?=$app_id;?>",
                                header_style : $('#header_style').val(),
                                carousel_order : $('#home_header_inhalt_draft').val()
                            },function(data){
//                                console.log(data);
                                if(data.status_code){
//                                    console.log("success");
                                }else{
                                    alert(data.status_message);
                                }
                            },'json');
                        }
                    </script>
                </div>
            </div>


        </div>
        <style>
            .carousel_remover{
                position: absolute;
                z-index: 2;
                background-color: #dedede;
                text-align: center;
                line-height: 30px;
                cursor: pointer;
                width: 30px;
                height: 30px;
            }
            .carousel_custom_img{
                width: 33%;
                float: left;
            }
            .carousel_custom_img_inside{
                padding: 10px;
            }
            .carousel_custom_img_inside img{
                width: 150px;
                cursor: pointer;
                object-fit: cover;
                height: 150px;
            }
            #carousel_custom_inhalt{
                padding: 20px;
                margin: 20px;
                margin-right: 0px;
                margin-left: 0px;
                background-color: #f6f6f6;
            }
            .selector{
                clear: both;
                padding-bottom: 20px;
            }
            .selector .col-sm-4{
                text-align: right;
            }
            .selector .col-sm-8{
                font-size: 22px;
            }
            .selector .col-sm-8 .small{
                font-size: 14px;
                color: #999999;
            }
            /*.selcheck[type="checkbox"]{*/
                /*width: 60px;*/
                /*height: 60px;*/
            /*}*/
        </style>
        <script>

            function header_carousel_checker(id){

                if(id == "carousel_none"){
                    if($("#carousel_none").prop('checked')) {
                        //unchecked both
                        $('#carousel_update').prop('checked', true);
                        $('#carousel_custom').prop('checked', false);

                        $('#carousel_custom_inhalt').hide();
                        $('#header_style').val("carousel_update");
                    }else{
                        //unchecked both
                        $('#carousel_update').prop('checked', false);
                        $('#carousel_custom').prop('checked', false);

                        $('#carousel_custom_inhalt').hide();
                        $('#header_style').val("none");
                    }
                }
                if(id == "carousel_update"){

                    if($("#carousel_update").prop('checked')) {
                        //unchecked both
                        $('#carousel_update').prop('checked', true);
                        $('#carousel_custom').prop('checked', false);

                        $('#carousel_none').prop('checked', true);

                        $('#carousel_custom_inhalt').hide();
                        $('#header_style').val("carousel_update");
                    }else{
                        //unchecked both
                        $('#carousel_update').prop('checked', false);
                        $('#carousel_custom').prop('checked', true);

                        $('#carousel_none').prop('checked', true);

                        $('#carousel_custom_inhalt').show();
                        $('#header_style').val("carousel_custom");
                    }
                }

                if(id == "carousel_custom"){

                    if($("#carousel_custom").prop('checked')) {
                        //unchecked both
                        $('#carousel_update').prop('checked', false);
                        $('#carousel_custom').prop('checked', true);

                        $('#carousel_none').prop('checked', true);
                        $('#header_style').val("carousel_custom");
                        $('#carousel_custom_inhalt').show();
                    }else{
                        //unchecked both
                        $('#carousel_update').prop('checked', true);
                        $('#carousel_custom').prop('checked', false);

                        $('#carousel_none').prop('checked', true);
                        $('#header_style').val("carousel_update");
                        $('#carousel_custom_inhalt').hide();
                    }
                }
                updateOrderCarouselHeader();
            }
        </script>
        </div>
        <?
//        pr($appAcc);
    }

    var $access_edit_content = "normal_user";
    function edit_content(){

        $id = addslashes($_GET['id']);

        //pakai panggilan API
        $url = _BPATH."AppAPI/get_content";
        $fields = array("app_id"=>$id);
        $res = AppContentHelper::doCURLPost($url,$fields);

        $return = json_decode($res);



        $appAcc = new AppAccount();
        $appAcc->getByID($id);

//
////        pr($appAcc);
////        list,grid_1,grid_2,grid_3
//
        $picked = $appAcc->home_menu_style_draft;
        if($appAcc->home_menu_style_draft == "" || $appAcc->home_menu_style_draft == "list"){
            $picked = "list";
        }

        $types = AppContentTemplate::getObjectOfSubclassesOf();

//        pr($types);
        ?>
        <div class="col-md-8 col-md-offset-2" style="padding: 10px;">
        <input type="hidden" id="menu_home_order" value="<?=$return->order;?>">
        <div class="heading" style="margin-left: 50px; margin-right: 50px;">
<!--            <div class="judulbesar">Select View</div>-->
        <div class="app_container" style="border-bottom: 3px solid #000000;">
            <div id="selector_menu_list" onclick="changeGridTo('list');" class="col-md-3 menu_style <? if($picked=="list")echo "menu_style_selected";?>">
                <img src="<?=_SPPATH;?>bridge_icons/ic_list.png">
            </div>
            <div id="selector_menu_grid_1" onclick="changeGridTo('grid_1');" class="col-md-3 menu_style <? if($picked=="grid_1")echo "menu_style_selected";?>">
                <img src="<?=_SPPATH;?>bridge_icons/ic_grid_1.png">
            </div>
            <div id="selector_menu_grid_2" onclick="changeGridTo('grid_2');" class="col-md-3 menu_style <? if($picked=="grid_2")echo "menu_style_selected";?>">
                <img src="<?=_SPPATH;?>bridge_icons/ic_grid_2.png">
            </div>
            <div id="selector_menu_grid_3" onclick="changeGridTo('grid_3');" class="col-md-3 menu_style <? if($picked=="grid_3")echo "menu_style_selected";?>">
                <img src="<?=_SPPATH;?>bridge_icons/ic_grid_3.png">
            </div>
            <div class="clearfix"></div>
        </div>

        <!-- EDIT -->
        <div class="judulbesar" style="display: none;">Content Menu <div onclick="moveSisaMenu();" class="menu_adder">+</div></div>

            <div id="menu_isi">

                <div id="menu_active">
                    <?
                    $ada_yg_hidden = 0;
                    $arrContent = $return->content;
                    $typeSudah = array();
                    foreach($arrContent as $obj){
                        $typeSudah[] = $obj->content_type;
                        $basicType = $obj->content_type;
                        $new = new $basicType();

                        if($obj->content_name == ""){

                            $obj->content_name = $new->name;
                        }
                        $icon = _SPPATH._PHOTOURL.$obj->content_icon;
                        if($obj->content_icon == ""){
                            $icon = _SPPATH."bridge_icons/".$new->icon;
                        }
                        if($obj->content_hide){$ada_yg_hidden = 1;continue;}
                        ?>
                        <div class="menu_dragger menu_<?=$picked;?>" id="content_<?=$obj->content_id;?>">
                            <div class="menu_dragger_dlm">
                            <div class="menu_dragger_icon"><img ondblclick="openContent('<?=$obj->content_id;?>','<?=$obj->content_type;?>','<?=$obj->content_name;?>');" src="<?=$icon;?>"></div>
                                <a onclick="openContent('<?=$obj->content_id;?>','<?=$obj->content_type;?>','<?=$obj->content_name;?>');">
                                <?=$obj->content_name;?>
                                </a>
                                <? if(!$new->isSingular){?>

                                    <div class="menu_hider" onclick="menu_content_delete('<?=$obj->content_id;?>');">delete</div>

                                <?}else{?>
                                    <div class="menu_hider" onclick="menu_content_hider('<?=$obj->content_id;?>');">hide</div>

                                <?}?>

                                </div>
                        </div>
                    <?
                    }

                    ?>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>

        <div id="menusisa_picker">
            <div class="menusisa_component" style="<? if(!$ada_yg_hidden){?>display: none;<?}?>">
            <div class="judulbesar">Business Features</div>
            <div id="menusisa_picker_dragger_business">

                <?
                foreach($arrContent as $obj){
                    if(!$obj->content_hide)continue;
                    $basicType = $obj->content_type;
                    $new = new $basicType();

                    if($obj->content_name == ""){

                        $obj->content_name = $new->name;
                    }
                    $icon = _SPPATH._PHOTOURL.$obj->content_icon;
                    if($obj->content_icon == ""){
                        $icon = _SPPATH."bridge_icons/".$new->icon;
                    }
                    ?>
                    <div class="menuhidden_element" id="menuhidden_<?=$obj->content_id;?>">
                        <img src="<?=$icon;?>"> <?=$obj->content_name;?>

                        <div class="menuhidden_element_hider" onclick="menu_content_shower('<?=$obj->content_id;?>');">show</div>

                    </div>
                    <?
                }

                ?>

                <div class="clearfix"></div>
            </div>
            </div>

            <div class="menusisa_component">
            <div class="judulbesar">Advanced Features</div>
            <div id="menusisa_picker_dragger">

                <?
                foreach($types as $typeObj){
                    if(get_class($typeObj) == "TypeC")continue;
                    if($typeObj->isSingular && in_array(get_class($typeObj),$typeSudah)){

                    }else {
                        $icon = _SPPATH."bridge_icons/".$typeObj->icon;
                        ?>
                        <div class="menuhidden_element" id="menuhidden_<?=$typeObj->name;?>">
                            <img src="<?=$icon;?>"> <?= $typeObj->name; ?>
                            <div class="menuhidden_element_hider" onclick="menu_content_add('<?=get_class($typeObj);?>','<?= $typeObj->name; ?>');">add</div>
                        </div>

                         <?
                    }
                }

                ?>


            </div>
            </div>
        </div>
        <style>
            .menuhidden_element img{
                width: 30px;
                height: 30px;
            }
            .menuhidden_element{
                line-height: 30px;
                padding: 5px;
            }
            #menusisa_picker{
                position: fixed;
                right: 0px;
                top: 0px;
                width: 250px;
                height: 100%;
                background-color: #f6f6f6;
                /*display: none;*/
                overflow-y: auto;
            }
            #menusisa_picker .judulbesar{
                text-align: center;
                background-color: #cccccc;
            }

            #menu_active{
                padding-top: 10px;
            }
            .menu_style{
                text-align: center;
                cursor: pointer;
            }
            .menu_adder{
                display: inline;
                line-height: 25px;
                float: right;
                color: white;
                background-color: #00c0ef;
                border-radius: 30px;
                width: 30px;
                height: 30px;
                text-align: center;
                font-weight: bold;
                font-size: 30px;
                margin-top: -5px;
                cursor: pointer;
            }
            .menu_hider,.menuhidden_element_hider{
                font-size: 12px;
                color: #007bb6;
                cursor: pointer;
            }
            .menuhidden_element_hider{
                display: inline;
                float: right;
                text-align: right;
            }
            .menu_style_selected{
                background-color: #efefef;
            }
            .menu_style img{
                width: 50px;
                height: 50px;
            }
            .menu_dragger_icon{
                padding-bottom: 10px;
            }
            .menu_list{
                margin-bottom: 10px;
                border: 1px dotted #dedede;
                padding: 5px;
            }
            .menu_list .menu_dragger_icon{
                display: none;
            }
            .menu_list .menu_hider{
                display: inline;
                text-align: right;
                float: right;

            }
            .menu_grid_1{
                text-align: center;

            }
            .menu_grid_1 .menu_dragger_icon{
                display: block;
                width: 100%;
            }
            .menu_grid_1 .menu_dragger_dlm{
                padding: 10px;
            }

            .menu_grid_2{
                float: left;
                width: 50%;
                text-align: center;
            }
            .menu_grid_2 .menu_dragger_icon{
                display: block;
                width: 100%;
            }
            .menu_grid_2 .menu_dragger_dlm{
                padding: 10px;
            }

            .menu_grid_3{
                float: left;
                width: 33%;
                text-align: center;
            }
            .menu_grid_3 .menu_dragger_icon{
                display: block;
                width: 100%;
            }
            .menu_grid_3 .menu_dragger_dlm{
                padding: 10px;
            }
            .menu_dragger_icon img{
                width: 100%;
            }
            .menu_grid_3 .menu_dragger_dlm,.menu_grid_1 .menu_dragger_dlm,.menu_grid_2 .menu_dragger_dlm{
                padding-bottom: 20px;
            }

            .menu_dragger{
                border: 1px dotted #cccccc;
                background-color: white;
                cursor:move;
            }
        </style>
        <script>
            var menu_current_picked = "<?=$picked;?>";
            $( function() {
                $( "#menu_active" ).sortable({
                    update: function(event, ui) {
                        updateOrderContent();
                    }
                });
                $( "#menu_active" ).disableSelection();
//                sethistoryback("app_id");
            } );

            function changeGridTo(picked){
                $('.menu_dragger').removeClass("menu_"+menu_current_picked).addClass("menu_"+picked);
                menu_current_picked = picked;

                $(".menu_style").removeClass("menu_style_selected");
                $("#selector_menu_"+picked).addClass("menu_style_selected");

                //
                $.post("<?=_SPPATH;?>AppAPI/set_home_menu_style",
                    {
                        acc_id : "<?=Account::getMyID();?>",
                        app_id : "<?=$id;?>",
                        menu_style : picked
                    },
                    function(data){
                    if(data.status_code){
//                        console.log("success");
                    }else{
                        alert(data.status_message);
                    }
                },'json');
            }

            function moveSisaMenu(){
                if($('#menusisa_picker').is(":visible"))
                    $('#menusisa_picker').hide('slide',{direction:'right'},1000);
                else
                    $('#menusisa_picker').show('slide',{direction:'right'},1000);
            }

            function menu_content_hider(id){
                $("#content_"+id).hide();
                $.post("<?=_SPPATH;?>AppAPI/hide_content",{content_id:id},function(data){
                    if(data.status_code){
                        page_refresher("page_edit_content");
                    }else{
                        alert(data.status_message);
                    }
                },'json');
            }

            function menu_content_shower(id){
                $("#menuhidden_"+id).hide();
                $.post("<?=_SPPATH;?>AppAPI/unhide_content",{content_id:id},function(data){
                    if(data.status_code){
//                        $('#menusisa_picker').hide('slide',{direction:'right'},1000,function(){
                            page_refresher("page_edit_content");
//                        });

                    }else{
                        alert(data.status_message);
                    }
                },'json');
            }

            function menu_content_add(thetype,articlename){
                $.post("<?=_SPPATH;?>AppAPI/add_content",
                    {
                        acc_id : "<?=Account::getMyID();?>",
                        app_id : "<?=$id;?>",
                        content_type:thetype,
                        articlename:articlename
                    },function(data){
                    if(data.status_code){
//                        $('#menusisa_picker').hide('slide',{direction:'right'},1000,function(){
                        page_refresher("page_edit_content");
//                        });

                    }else{
                        alert(data.status_message);
                    }
                },'json');
            }

            function menu_content_delete(content_id){
                $.post("<?=_SPPATH;?>AppAPI/del_content",
                    {
                        acc_id : "<?=Account::getMyID();?>",
                        app_id : "<?=$id;?>",
                        content_id:content_id
                    },function(data){
                        if(data.status_code){
//                        $('#menusisa_picker').hide('slide',{direction:'right'},1000,function(){
                            page_refresher("page_edit_content");
//                        });

                        }else{
                            alert(data.status_message);
                        }
                    },'json');
            }

            function updateOrderContent(){

                var orders = [];
                $.each($( "#menu_active" ).children(), function(i, item) {
                    var word = $(item).attr("id").split("_");
                    if(word[1]!="")
                    orders.push(word[1]);
//                    if(xx.val()!="") {
//                        var lagi2 = xx.val().replace("<?//=_BPATH._PHOTOURL;?>//","");
//                        orders.push(lagi2);
//                    }
                });
//                console.log(orders);
                $('#menu_home_order').val(orders.join(","));

                $.post("<?=_SPPATH;?>AppAPI/save_urutan",{
                    acc_id : "<?=Account::getMyID();?>",
                    app_id : "<?=$id;?>",
                    order : $('#menu_home_order').val()
                },function(data){
//                    console.log(data);
                    if(data.status_code){
//                        console.log("success");
                    }else{
                        alert(data.status_message);
                    }
                },'json');
            }

            function openContent(content_id,content_type,pagetitle){
                if(content_type == "TypeA" || content_type == "TypeAbout"){
                    var url = "<?=_SPPATH;?>AppAPIPrinter/typeA_edit?content_id="+content_id;
                    addPage("contentitem_"+content_id,url,pagetitle,"page_edit_content");
                }
                if(content_type == "TypeB" || content_type == "TypePromo" || content_type == "TypeUpdate"){
                    var url = "<?=_SPPATH;?>AppAPIPrinter2/typeB_edit?content_id="+content_id;
                    addPage("contentitem_"+content_id,url,pagetitle,"page_edit_content");
                }
                if(content_type == "TypeC" || content_type == "TypeProduct"){
                    var url = "<?=_SPPATH;?>AppAPIPrinter2/typeC_edit?content_id="+content_id;
                    addPage("contentitem_"+content_id,url,pagetitle,"page_edit_content");
                }
            }
        </script>
        </div>
        <?
//        pr($return);
//        pr($arrContent);
    }

    var $access_typeA_edit = "normal_user";
    public function typeA_edit()
    {

        if (!$_GET['from_b']) {


            //pakai panggilan API
            $url = _BPATH . "AppAPI/get_content_typeA";
            $a_id = addslashes($_GET['a_id']);
            if($a_id!=""){
                $fields = array("a_id" => addslashes($_GET['a_id']));
                $res = AppContentHelper::doCURLPost($url, $fields);

                $return = json_decode($res);

                $a = $return->results;
                $content = new AppContentDraft();
                $content->getByID(addslashes($_GET['content_id']));
//                $a = $return->results->typeA;

            }else {
                $fields = array("content_id" => addslashes($_GET['content_id']));
                $res = AppContentHelper::doCURLPost($url, $fields);

                $return = json_decode($res);

                $content = $return->results;
                $a = $return->results->typeA;
            }


        }else{
            $content = new AppContentDraft();
            $content->getByID(addslashes($_GET['content_id']));

            $a = new TypeAModelDraft();


        }




        $type = $content->content_type;
        $new = new $type();

        $icon = _SPPATH."bridge_icons/".$new->icon;
        if($content->content_icon!="")
            $icon = _SPPATH._PHOTOURL.$content->content_icon;

        $t = time()."_".$a->a_id;
        ?>


            <div class="col-md-4" style="padding: 10px;">
                <? if (!$_GET['from_b']) { ?>
            <div class="app_container">
                <div class="col-md-3">
                    <?
                    $bannerModalID = "c_icon_".$t;
                    $container = "c_icon_car_pic_".$t;
                    Cropper::createModal($bannerModalID,"Upload Picture",$container,$icon,"10:10",array($bannerModalID."_prev"),'',1);
                    ?>
                    <img style="cursor: pointer;border: 1px dotted #dedede; width: 100%;" data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$icon;?>" >
                    <input type="text" value="<?=$content->content_icon;?>" id="<?=$container;?>">

                </div>
                <div class="col-md-9" style="padding-left: 20px; ">
                    <input type="text" id="articlename_<?=$t;?>" style="margin-bottom: 10px;" class="form-control" value="<?=$content->content_name;?>">
                    <button class="btn btn-danger btn-sm" id="save_<?=$t;?>"  style="width: 100%;">SAVE</button>
                </div>
                <div class="clearfix"></div>
                <script>
                    $('#save_<?=$t;?>').click(function(){
                        var post = {};
                        post.articlename = $('#articlename_<?=$t;?>').val();
                        post.header_type = $("input[name=edit_header_<?=$t;?>]:checked").val();
                        post.content_id = "<?=addslashes($_GET['content_id']);?>";
                        post.a_id = "<?=$a->a_id;?>";
                        post.api_lokal = 1;
                        post.content_icon = $('#<?=$container;?>').val();

                        //tabs
                        post.tabsdata = $('#tab_order_<?=$t;?>').val(); //not yet, 1,2,3  //pilih ordernya

                        post['tabtitle-1'] = $('#m<?=$t;?>_tabtitle-1').val();
                        post['contenttitle-1'] = $('#m<?=$t;?>_contenttitle-1').val();
                        post['contenttext-1'] = $('#m<?=$t;?>_content-1').val();

                        post['tabtitle-2'] = $('#m<?=$t;?>_tabtitle-2').val();
                        post['contenttitle-2'] = $('#m<?=$t;?>_contenttitle-2').val();
                        post['contenttext-2'] = $('#m<?=$t;?>_content-2').val();

                        post['tabtitle-3'] = $('#m<?=$t;?>_tabtitle-3').val();
                        post['contenttitle-3'] = $('#m<?=$t;?>_contenttitle-3').val();
                        post['contenttext-3'] = $('#m<?=$t;?>_content-3').val();

                        post.tabsdata_active = $('#tab_order_picked_<?=$t;?>').val(); //yang active saja..new ini !!

                        //carousel
//                        post.carouseldata = ""; //not yet, 1,2,3

                        //action
                        if($('#m<?=$t;?>_edit_addons_call_active').prop("checked"))
                            post.callbutton_active = 1;
                        else
                            post.callbutton_active = 0;

                        post.callbutton_text = $('#m<?=$t;?>_call_button').val();
                        post.callbutton_number = $('#m<?=$t;?>_call_text').val();

                        //action
                        if($('#m<?=$t;?>_edit_addons_email_active').prop("checked"))
                        post.emailbutton_active = 1;
                        else
                            post.emailbutton_active = 0;
                        post.emailbutton_text = $('#m<?=$t;?>_email_button').val();
                        post.emailbutton_mail = $('#m<?=$t;?>_email_text').val();

                        //action
                        if($('#m<?=$t;?>_edit_addons_share_active').prop("checked"))
                        post.sharebutton_active = 1;
                        else
                            post.sharebutton_active = 0;
                        post.sharebutton_text = $('#m<?=$t;?>_share_button').val();
                        post.sharebutton_url = $('#m<?=$t;?>_share_text').val();

                        //action
                        post.price = $('#m<?=$t;?>_price_text').val();
                        if($('#m<?=$t;?>_edit_addons_price_active').prop("checked"))
                        post.price_active = 1;
                        else
                            post.price_active = 0;


                        //action
                        post.urlbutton_text = $('#m<?=$t;?>_url_button').val();
                        post.urlbutton_url = $('#m<?=$t;?>_url_text').val();
                        if($('#m<?=$t;?>_edit_addons_url_active').prop("checked"))
                        post.urlbutton_active = 1;
                        else post.urlbutton_active = 0;

                        post.video = $('#video_link_<?=$t;?>').val();
                        post.map = $('#<?="map_typeA".$t;?>').val();
                        post.carousel = $('#<?="carousel_sort_typeA".$t;?>').val();

                        //cat
                        post.category_id = "<?=addslashes($_GET['category_id']);?>"; //untuk type B dan Type C

                        console.log(post);

                        $.post("<?=_SPPATH;?>AppAPI/set_content_typeA",post,function(data){
                            console.log(data);
                            if(data.status_code){
                                back_page_refresher();
                                goto_back_page();
                            }else{
                                alert(data.status_message);
                            }
                        },'json');
                    });
                </script>
            </div>
        <? }else{ ?>
    <div class="app_container">
                    <button class="btn btn-danger btn-sm" id="save_<?=$t;?>"  style="width: 100%;">SAVE</button>
                    <script>
                        $('#save_<?=$t;?>').click(function(){
                            var post = {};

                            post.header_type = $("input[name=edit_header_<?=$t;?>]:checked").val();
                            post.content_id = "<?=addslashes($_GET['content_id']);?>";
                            post.a_id = "<?=$a->a_id;?>";
                            post.api_lokal = 1;


                            //tabs
                            post.tabsdata = $('#tab_order_<?=$t;?>').val(); //not yet, 1,2,3  //pilih ordernya

                            post['tabtitle-1'] = $('#m<?=$t;?>_tabtitle-1').val();
                            post['contenttitle-1'] = $('#m<?=$t;?>_contenttitle-1').val();
                            post['contenttext-1'] = $('#m<?=$t;?>_content-1').val();

                            post['tabtitle-2'] = $('#m<?=$t;?>_tabtitle-2').val();
                            post['contenttitle-2'] = $('#m<?=$t;?>_contenttitle-2').val();
                            post['contenttext-2'] = $('#m<?=$t;?>_content-2').val();

                            post['tabtitle-3'] = $('#m<?=$t;?>_tabtitle-3').val();
                            post['contenttitle-3'] = $('#m<?=$t;?>_contenttitle-3').val();
                            post['contenttext-3'] = $('#m<?=$t;?>_content-3').val();

                            post.tabsdata_active = $('#tab_order_picked_<?=$t;?>').val(); //yang active saja..new ini !!

                            //carousel
//                        post.carouseldata = ""; //not yet, 1,2,3

                            //action
                            if($('#m<?=$t;?>_edit_addons_call_active').prop("checked"))
                                post.callbutton_active = 1;
                            else
                                post.callbutton_active = 0;

                            post.callbutton_text = $('#m<?=$t;?>_call_button').val();
                            post.callbutton_number = $('#m<?=$t;?>_call_text').val();

                            //action
                            if($('#m<?=$t;?>_edit_addons_email_active').prop("checked"))
                                post.emailbutton_active = 1;
                            else
                                post.emailbutton_active = 0;
                            post.emailbutton_text = $('#m<?=$t;?>_email_button').val();
                            post.emailbutton_mail = $('#m<?=$t;?>_email_text').val();

                            //action
                            if($('#m<?=$t;?>_edit_addons_share_active').prop("checked"))
                                post.sharebutton_active = 1;
                            else
                                post.sharebutton_active = 0;
                            post.sharebutton_text = $('#m<?=$t;?>_share_button').val();
                            post.sharebutton_url = $('#m<?=$t;?>_share_text').val();

                            //action
                            post.price = $('#m<?=$t;?>_price_text').val();
                            if($('#m<?=$t;?>_edit_addons_price_active').prop("checked"))
                                post.price_active = 1;
                            else
                                post.price_active = 0;


                            //action
                            post.urlbutton_text = $('#m<?=$t;?>_url_button').val();
                            post.urlbutton_url = $('#m<?=$t;?>_url_text').val();
                            if($('#m<?=$t;?>_edit_addons_url_active').prop("checked"))
                                post.urlbutton_active = 1;
                            else post.urlbutton_active = 0;

                            post.video = $('#video_link_<?=$t;?>').val();
                            post.map = $('#<?="map_typeA".$t;?>').val();
                            post.carousel = $('#<?="carousel_sort_typeA".$t;?>').val();

                            //cat
                            post.category_id = "<?=addslashes($_GET['category_id']);?>"; //untuk type B dan Type C

                            console.log(post);

                            $.post("<?=_SPPATH;?>AppAPI/set_content_typeA",post,function(data){
                                console.log(data);
                                if(data.status_code){
                                    back_page_refresher();
                                    goto_back_page();
                                }else{
                                    alert(data.status_message);
                                }
                            },'json');
                        });
                    </script>
</div>
                <? } ?>

            <!-- EDIT -->
            <div class="judulbesar">Choose Your Header</div>
            <div class="icons_container">
                <div id="edit_header_image_<?=$t;?>" class="col-md-4 icons do_check_onclick">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_header.png" >
                    <div class="icon_name">Image <input id="checked_carousel_<?=$t;?>" onclick="check_value_radio1_<?=$t;?>();" value="carousel" <? if($a->a_header_type == "carousel" || $a->a_header_type =="")echo "checked";?> type="radio" name="edit_header_<?=$t;?>"> </div>
                </div>

                <div id="edit_header_video_<?=$t;?>" class="col-md-4 icons do_check_onclick">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_video.png" >
                    <div class="icon_name">Video <input id="checked_video_<?=$t;?>" onclick="check_value_radio1_<?=$t;?>();" value="video" <? if($a->a_header_type == "video")echo "checked";?> type="radio" name="edit_header_<?=$t;?>"></div>
                </div>

                <div id="edit_header_map_<?=$t;?>" class="col-md-4 icons do_check_onclick">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_map.png" >
                    <div class="icon_name">Location <input id="checked_map_<?=$t;?>" onclick="check_value_radio1_<?=$t;?>();" value="map" <? if($a->a_header_type == "map")echo "checked";?> type="radio" name="edit_header_<?=$t;?>"></div>
                </div>
                <div class="clearfix"></div>
                <div class="edit_headertypea_isi_<?=$t;?>" id="edit_header_isi_carousel_<?=$t;?>" style="<? if($a->a_header_type != "carousel" && $a->a_header_type !="")echo "display:none";?>">
                    <h1>Edit Images</h1>

                    <?
                    $input_id = "carousel_sort_typeA".$t;
                    PrinterHelper::printCarouselSelector($a,$input_id);
                    ?>
                    <div class="clearfix"></div>
                    <input id="<?=$input_id;?>" value="<?=$a->carousel_asli;?>">
                </div>
                <div class="edit_headertypea_isi_<?=$t;?>" id="edit_header_isi_video_<?=$t;?>" style="<? if($a->a_header_type != "video" )echo "display:none";?>">
                    <h1>Edit Youtube Link</h1>
                    <input class="form-control" name="video_link" id="video_link_<?=$t;?>" value="<?=$a->a_video;?>">
                </div>
                <div class="edit_headertypea_isi_<?=$t;?>" id="edit_header_isi_map_<?=$t;?>" style="<? if($a->a_header_type != "map" )echo "display:none";?>">
                    <h1>Edit Location</h1>
                    <?
                    $input_id2 = "map_typeA".$t;
                    PrinterHelper::printMap($a,$input_id2);
                    ?>
                    <div class="clearfix"></div>
                    <input id="<?=$input_id2;?>" value="<?=$a->a_map;?>">
                </div>
                <script>
                    function check_value_radio1_<?=$t;?>(){
                        var slc = $("input[name=edit_header_<?=$t;?>]:checked").val();
                        $('.edit_headertypea_isi_<?=$t;?>').hide();
                        $('#edit_header_isi_'+slc+"<?="_$t";?>").show();


                    }
                    $('#edit_header_image_<?=$t;?>').click(function(){
                        $('#checked_carousel_<?=$t;?>').prop("checked",true);
                        check_value_radio1_<?=$t;?>();
                    });
                    $('#edit_header_video_<?=$t;?>').click(function(){

                        $('#checked_video_<?=$t;?>').prop("checked",true);
                        check_value_radio1_<?=$t;?>();
                    });
                    $('#edit_header_map_<?=$t;?>').click(function(){

                        $('#checked_map_<?=$t;?>').prop("checked",true);
                        check_value_radio1_<?=$t;?>();
                    });
                </script>
                <style>
                    .edit_headertypea_isi_<?=$t;?>{
                        background-color: #f6f6f6;
                        padding: 20px;
                        margin-top: 20px;
                        margin-bottom: 20px;
                    }
                    .edit_headertypea_isi_<?=$t;?> h1{
                        font-size: 18px;
                        padding: 0px;
                        margin: 0px;
                        text-align: center;
                        margin-bottom: 20px;
                    }
                </style>
                <div class="clearfix"></div>
            </div>



            </div><!-- col-md-6-->


            <div class="col-md-5" style="padding: 10px;">



            <div class="judulbesar">Content <i class="small" style="float: right; display: inline; text-align: right;">*double click tab to edit content</i></div>

            <div class="tabcontainer">
                <div class="tabselectable_<?=$t;?>">
                    <?
                    $sel_tab = 1;
                    if(count($a->msg)>0) {
                        foreach ($a->msg as $num=>$tab) {
                            if($num == 0)
                            $sel_tab = $tab->id;
                            ?>
                            <div class="tab_element_<?=$t;?>  tab_selected_<?=$t;?>" id="m<?=$t;?>_tab_<?=$tab->id;?>" ondblclick="m<?=$t;?>_opentypeatab('<?=$tab->id;?>');">Tab <?=$tab->id;?> <input <?if($tab->is_active)echo "checked";?> value="<?=$tab->id;?>" class="tab_picker_<?=$t;?>" type="checkbox" id="tab_<?=$tab->id;?>_picked_<?=$t;?>"></div>

                        <?
                        }
                    }else{


                    ?>
                <div class="tab_element_<?=$t;?>  tab_selected_<?=$t;?>" id="m<?=$t;?>_tab_1" ondblclick="m<?=$t;?>_opentypeatab('1');">Tab 1 <input value="1" class="tab_picker_<?=$t;?>" type="checkbox" id="tab_1_picked_<?=$t;?>"></div>
                <div class="tab_element_<?=$t;?> " id="m<?=$t;?>_tab_2" ondblclick="m<?=$t;?>_opentypeatab('2');">Tab 2 <input value="2" class="tab_picker_<?=$t;?>" type="checkbox" id="tab_2_picked_<?=$t;?>"></div>
                <div class="tab_element_<?=$t;?> " id="m<?=$t;?>_tab_3" ondblclick="m<?=$t;?>_opentypeatab('3');">Tab 3 <input value="3" class="tab_picker_<?=$t;?>" type="checkbox" id="tab_3_picked_<?=$t;?>"></div>
                        <? } ?>
                </div>
                <div class="clearfix"></div>

        <?
        if(count($a->msg)>0) {
            foreach ($a->msg as $tab) {
                ?>
                <div id="m<?=$t;?>_tab<?=$tab->id;?>_container" class="tab_container_isi_<?=$t;?>" >
                    <input id="m<?=$t;?>_tabtitle-<?=$tab->id;?>" value="<?=$tab->tabtitle;?>" type="text" class="form-control" placeholder="tab title">
                    <input id="m<?=$t;?>_contenttitle-<?=$tab->id;?>" value="<?=$tab->contenttitle;?>"  type="text" class="form-control" placeholder="content title">
                    <textarea id="m<?=$t;?>_content-<?=$tab->id;?>" rows="13" class="form-control" placeholder="content"><?=$tab->contenttext;?></textarea>
                </div>
            <?
            }
        }else{


            ?>
                <div id="m<?=$t;?>_tab1_container" class="tab_container_isi_<?=$t;?>" >
                    <input id="m<?=$t;?>_tabtitle-1" type="text" class="form-control" placeholder="tab title">
                    <input id="m<?=$t;?>_contenttitle-1" type="text" class="form-control" placeholder="content title">
                    <textarea id="m<?=$t;?>_content-1" rows="13" class="form-control" placeholder="content"></textarea>
                </div>

                <div id="m<?=$t;?>_tab2_container" class="tab_container_isi_<?=$t;?>">
                    <input id="m<?=$t;?>_tabtitle-2" type="text" class="form-control" placeholder="tab title">
                    <input id="m<?=$t;?>_contenttitle-2" type="text" class="form-control" placeholder="content title">
                    <textarea id="m<?=$t;?>_content-2" rows="13" class="form-control" placeholder="content"></textarea>
                </div>

                <div id="m<?=$t;?>_tab3_container" class="tab_container_isi_<?=$t;?>">
                    <input id="m<?=$t;?>_tabtitle-3" type="text" class="form-control" placeholder="tab title">
                    <input id="m<?=$t;?>_contenttitle-3" type="text" class="form-control" placeholder="content title">
                    <textarea id="m<?=$t;?>_content-3" rows="13" class="form-control" placeholder="content"></textarea>
                </div>
        <? } ?>
                <style>
                    .tabcontainer{
                        padding-top: 20px;
                    }
                    .tab_container_isi_<?=$t;?>{
                        background-color: #f6f6f6;
                        padding: 20px;

                        margin-bottom: 20px;
                    }
                    .tab_selected_<?=$t;?>{
                        background-color: #f6f6f6;
                    }
                    .tab_container_isi_<?=$t;?> input{
                        margin-bottom: 10px;
                    }
                    .tab_element_<?=$t;?>{
                        -webkit-user-select: none; /* webkit (safari, chrome) browsers */
                        -moz-user-select: none; /* mozilla browsers */
                        -khtml-user-select: none; /* webkit (konqueror) browsers */
                        -ms-user-select: none; /* IE10+ */
                    }
                    .tab_element_<?=$t;?>{
                        text-align: center;
                        padding: 10px;
                        padding-top: 20px;
                        padding-bottom: 20px;
                        font-size: 15px;
                        cursor: pointer;
                        width: 33%;
                        float: left;
                    }
                </style>
                <script>
                    var tab_sel_<?=$t;?> = <?=$sel_tab;?>;
                    $( function() {
                        $( ".tabselectable_<?=$t;?>" ).sortable({
                            update: function(event, ui) {
                                updateOrderTab_<?=$t;?>();
                            }
                        });
                        $( ".tabselectable_<?=$t;?>" ).disableSelection();

                        m<?=$t;?>_opentypeatab(tab_sel_<?=$t;?>);
                        updateOrderTab_<?=$t;?>();
                        //set history
//                            sethistoryback("app_id");
                    } );

                    function m<?=$t;?>_opentypeatab(id){
                        $('.tab_element_<?=$t;?>').removeClass('tab_selected_<?=$t;?>');
                        $('#m<?=$t;?>_tab_'+id).addClass('tab_selected_<?=$t;?>');

                        $('.tab_container_isi_<?=$t;?>').hide();
                        $('#m<?=$t;?>_tab'+id+'_container').show();
                        tab_sel_<?=$t;?> = id;
                    }

                    function updateOrderTab_<?=$t;?>(){
                        var orders = [];
                        $.each($( ".tabselectable_<?=$t;?>" ).children(), function(i, item) {
                            var xx = $(item).attr('id').split("_");
                            orders.push(xx.pop());
                        });
//                            console.log(orders);
                        $('#tab_order_<?=$t;?>').val(orders.join(","));
                    }

                    var tab_picked_<?=$t;?> = {tab_1:0,tab_2:0,tab_3:0};
    <?
    if(count($a->msg)>0) {

        ?><?
        foreach ($a->msg as $tab) {
                if($tab->is_active){
            ?>
                    tab_picked_<?=$t;?>['tab_<?=$tab->id;?>'] = 1;
                    <?
                    }
                    }
                    ?>
                    updatetabpicked_<?=$t;?>();
                    <?
                }?>

                    $('.tab_picker_<?=$t;?>').click(function(){
                        var val = $(this).val();
                       if($(this).prop("checked")){

                           tab_picked_<?=$t;?>['tab_'+val] = 1;
                       }else{
                           tab_picked_<?=$t;?>['tab_'+val] = 0;
                       }
                        console.log(tab_picked_<?=$t;?>);
                        updatetabpicked_<?=$t;?>();
                    });

                    function updatetabpicked_<?=$t;?>(){
                        var arrpick = [];
                        if(tab_picked_<?=$t;?>.tab_1){
                            arrpick.push(1);
                        }
                        if(tab_picked_<?=$t;?>.tab_2){
                            arrpick.push(2);
                        }
                        if(tab_picked_<?=$t;?>.tab_3){
                            arrpick.push(3);
                        }
                        $('#tab_order_picked_<?=$t;?>').val(arrpick.join());
                    }
                </script>
                <input type="text" id="tab_order_<?=$t;?>">
                <input type="text" id="tab_order_picked_<?=$t;?>">
            </div>
            <div class="clearfix"></div>

            </div>

        <div class="col-md-3" style="padding: 10px;">

        <div class="judulbesar">Add-ons</div>

            <?

            $action = $a->action;

            ?>
        <div class="icons_container">
            <div class="action_button_<?=$t;?>">
            <div id="m<?=$t;?>_edit_addons_call" class="col-md-4 icons">
                <img src="<?=_SPPATH;?>bridge_icons/ic_call.png" >
                <div class="icon_name">Call <input <? if($action->call->callbutton_active)echo "checked";?> value="1" id="m<?=$t;?>_edit_addons_call_active" type="checkbox"> </div>
            </div>
                <div class="col-md-8">
                    <input type="text" value="<?=$action->call->callbutton_text;?>" id="m<?=$t;?>_call_button" placeholder="Button Text" class="form-control">
                    <input type="text" value="<?=$action->call->callbutton_number;?>"  id="m<?=$t;?>_call_text" placeholder="Phone number" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>



            <div class="action_button_<?=$t;?>">
                <div id="m<?=$t;?>_edit_addons_url" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_price.png" >
                    <div class="icon_name">URL <input <? if($action->url->urlbutton_active)echo "checked";?> value="1" id="m<?=$t;?>_edit_addons_url_active" type="checkbox"></div>
                </div>
                <div class="col-md-8">
                    <input type="text" value="<?=$action->url->urlbutton_text;?>"  id="m<?=$t;?>_url_button" placeholder="Button Text" class="form-control">
                    <input type="text" value="<?=$action->url->urlbutton_url;?>"  id="m<?=$t;?>_url_text" placeholder="URL" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="action_button_<?=$t;?>">
                <div id="m<?=$t;?>_edit_addons_email" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_email.png" >
                    <div class="icon_name">Email <input <? if($action->email->emailbutton_active)echo "checked";?> value="1" id="m<?=$t;?>_edit_addons_email_active" type="checkbox"></div>
                </div>
                <div class="col-md-8">
                    <input type="text" value="<?=$action->email->emailbutton_text;?>" id="m<?=$t;?>_email_button" placeholder="Button Text" class="form-control">
                    <input type="text" value="<?=$action->email->emailbutton_mail;?>" id="m<?=$t;?>_email_text" placeholder="Email" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="action_button_<?=$t;?>">
                <div id="m<?=$t;?>_edit_addons_share" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_share.png" >
                    <div class="icon_name">Share <input <? if($action->share->sharebutton_active)echo "checked";?> value="1" id="m<?=$t;?>_edit_addons_share_active" type="checkbox"></div>
                </div>
                <div class="col-md-8">
                    <input type="text" value="<?=$action->share->sharebutton_text;?>"  id="m<?=$t;?>_share_button" placeholder="Button Text" class="form-control">
                    <input type="text" value="<?=$action->share->sharebutton_url;?>"  id="m<?=$t;?>_share_text" placeholder="Share URL" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="action_button_<?=$t;?>">
                <div id="m<?=$t;?>_edit_addons_price" class="col-md-4 icons">
                    <img src="<?=_SPPATH;?>bridge_icons/ic_price.png" >
                    <div class="icon_name">Price <input <? if($action->price->price_active)echo "checked";?> value="1" id="m<?=$t;?>_edit_addons_price_active" type="checkbox"></div>
                </div>
                <div class="col-md-8">
<!--                    <input type="tex" placeholder="Button Text" class="form-control">-->
                    <input type="text" value="<?=$action->price->value;?>" id="m<?=$t;?>_price_text" placeholder="Price" class="form-control">
                </div>
                <div class="clearfix"></div>
            </div>

            <style>
                .action_button_<?=$t;?>{
                    clear: both;
                    margin-bottom: 30px;
                }
            </style>

            <script>
                $('.action_button_<?=$t;?> .icons').click(function(){
                    var xx = $(this).find(".icon_name input");
//                    console.log(xx);
                        if(xx.prop("checked")){
//                            alert("checked");
                            xx.prop("checked",false);
                        }else{
//                            alert("not checked");
                            xx.prop("checked",true);
                        }
//                    $('#checked_carousel').prop("checked",true);
//                    check_value_radio1()
                });
            </script>





            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        </div>

            <!-- push notif -->
            <!--            <div class="judulbesar">Send Push Notification</div>-->

        <style>

        </style>
        <div class="clearfix"></div>
        <?
        pr($return);
        pr($_GET);
    }
} 