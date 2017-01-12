<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/18/16
 * Time: 9:12 PM
 */

class AppAPIPrinter2 extends WebService{

    var $access_typeB_edit = "normal_user";
    public function typeB_edit(){

        //pakai panggilan API
        $url = _BPATH."AppAPI/get_content_typeB";


        $fields = array("content_id"=>addslashes($_GET['content_id']));
        $res = AppContentHelper::doCURLPost($url,$fields);

        $return = json_decode($res);

        $content = $return->results;
        $t = time()."_".$content->content_id;

        $type = $content->content_type;
        $new = new $type();

        $icon = _SPPATH."bridge_icons/".$new->icon;
        if($content->content_icon!="")
            $icon = _SPPATH._PHOTOURL.$content->content_icon;

        $array_a = $content->typeA;
        ?>
        <div class="col-md-4 col-md-offset-4" style="padding: 10px;">
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
                        post.content_id = "<?=addslashes($_GET['content_id']);?>";
                        post.api_lokal = 1;
                        post.content_icon = $('#<?=$container;?>').val();


                        post.typeA_order =  $('#typeb_order_<?=$t;?>').val();
                        post.typeA_hidden =  $('#typeb_order_hidden_<?=$t;?>').val();

                        console.log(post);

                        $.post("<?=_SPPATH;?>AppAPI/set_content_typeB",post,function(data){
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

            <!-- EDIT -->
            <div class="judulbesar" style="margin-bottom: 10px;">Pages <div onclick="add_typeA_<?=$t;?>();" class="menu_adder">+</div></div>

            <script>
                function add_typeA_<?=$t;?>(){
                    var now = $.now();
                    var url = "<?=_SPPATH;?>AppAPIPrinter/typeA_edit?content_id=<?=$content->content_id;?>&from_b=1";
                    addPage("contentitem_fromb_"+now,url,"New Page","contentitem_<?=$content->content_id;?>");
                }

                var hide_array = {};
            </script>

            <div id="mulai_b_<?=$t;?>">
                <?
                foreach($array_a as $num=>$a){



                    ?>
                    <div class="a_item" id="<?=$a->a_id;?>">
                        <div id="a_img_<?=$a->a_id;?>" onclick="setVisibility_<?=$t;?>('a_img_<?=$a->a_id;?>','<?=$num;?>');" class="a_visibility_icon <?if($a->a_hide)echo "a_visibility_icon_selected";?>"></div>
<!--                        <img   src="--><?//=_SPPATH;?><!--bridge_icons/ic_visible.png" align="absmiddle" class="a_visibility_icon"> &nbsp;-->
                        <a onclick="openContentTypeB_<?=$t;?>('<?=$a->a_id;?>','<?=$a->msg[0]->contenttitle;?>');"><?=$a->msg[0]->contenttitle;?></a>
                        <div class="deleter" onclick="deleteTypeAfromB_<?=$t;?>('<?=$a->a_id;?>');">x</div>

                        <?
                        if($a->a_hide){
                            ?>
                            <script>
                                hide_array['<?=$num;?>'] = 1;
                            </script>

                        <?
                        }else{
                        ?>
                            <script>
                                hide_array['<?=$num;?>'] = 0;
                            </script>
                        <?
                        }
                        ?>
                    </div>
                    <?
                }
                ?>
            </div>
            <style>
                .a_visibility_icon{
                    height: 20px;
                    width: 20px;
                    float: left;
                    margin-right: 10px;
                    display: inline;
                    cursor: pointer;
                }
                .a_item{
                    border: 1px solid #cccccc;
                    margin-bottom: 5px;
                    padding: 10px;
                    background-color: #FFFFFF;
                }
                .deleter{
                    float: right;
                    display: inline;
                    text-align: right;
                    cursor: pointer;
                }
                .a_item .a_visibility_icon { width: 20px; height: 20px; background-color: #00c0ef; }
                .a_item .a_visibility_icon { -webkit-mask-image: url('<?=_SPPATH;?>bridge_icons/ic_visible.png');-webkit-mask-size: 20px 20px; }
                .a_item .a_visibility_icon_selected{ background-color: #cccccc;}
            </style>
            <input type="text" id="typeb_order_<?=$t;?>">
            <input type="text" id="typeb_order_hidden_<?=$t;?>">
            <script>
                function setVisibility_<?=$t;?>(id,urutan){
//                    if($("#"+id).hasClass('a_visibility_icon_selected')){
//                        //dulu visible skrg ga lagi
//                        hide_array[urutan] = 0;
//                    }else{
//                        //dulu tidak visible skrg visible
//                        hide_array[urutan] = 1;
//                    }
//                    $("#"+id).toggleClass('a_visibility_icon_selected');
//                    console.log("in");

                    $("#"+id).toggleClass('a_visibility_icon_selected');
                    updateVisibility_<?=$t;?>();

                }
                function updateVisibility_<?=$t;?>(){

//                    console.log(hide_array);
//                    var arr = [];
//                    for (var key in hide_array) {
//                        console.log(key, hide_array[key]);
//                        arr.push(hide_array[key]);
//                    }
//                    console.log(arr);
//                    $('#typeb_order_hidden_<?//=$t;?>//').val(arr.join());
                    updateTypeBOrder_<?=$t;?>();
                }

                $( function() {
                    $( "#mulai_b_<?=$t;?>" ).sortable({
                        update: function(event, ui) {
                            updateTypeBOrder_<?=$t;?>();
                        }
                    });
                    $( "#mulai_b_<?=$t;?>" ).disableSelection();

                    //set history
//                            sethistoryback("app_id");
                    updateTypeBOrder_<?=$t;?>();
//                    updateVisibility_<?//=$t;?>//();
                } );

                function removeTypeB_<?=$t;?>(input_id,img_id){

                    if(confirm("This will delete the selected carousel item")) {
                        $('#' + input_id).val("");
                        $('#' + img_id).attr("src", "<?=_SPPATH;?>images/noimage.jpg");
                        updateTypeBOrder_<?=$t;?>();
                    }
                }


                function updateTypeBOrder_<?=$t;?>(){

                    var orders = [];
                    var hide = [];
                    var urutan = 0;
                    $.each($( "#mulai_b_<?=$t;?>" ).children(), function(i, item) {
//
                        var xx = $(item).attr("id");
                        orders.push(xx);

                        //updateorder
                        var anak = $(item).find( ".a_visibility_icon" );
                        console.log(anak);

                        if(anak.hasClass('a_visibility_icon_selected')){
                            hide.push(1);
//                            hide_array[urutan] = 1;
                        }else{
                            hide.push(0);
//                            hide_array[urutan] = 0;
                        }
                        urutan++;
                    });
//                            console.log(orders);
                    $('#typeb_order_<?=$t;?>').val(orders.join(","));
                    $('#typeb_order_hidden_<?=$t;?>').val(hide.join(","));
                }

                function openContentTypeB_<?=$t;?>(a_id,pagetitle){

                        var url = "<?=_SPPATH;?>AppAPIPrinter/typeA_edit?content_id=<?=$content->content_id;?>&a_id="+a_id;
                        addPage("contenttypeAfromB_"+a_id,url,pagetitle,"contentitem_<?=$content->content_id;?>");

                }

                function deleteTypeAfromB_<?=$t;?>(a_id){
                    if(confirm("This will delete this page")){
                        $.post('<?=_SPPATH;?>AppAPI/delete_content_typeA',{a_id:a_id},function(data){
                            if(data.status_code){
                                active_page_refresher();
                            }else{
                                alert(data.status_message);
                            }
                        },'json');
                    }
                }
            </script>
        </div><!-- col-md-6-->
        <div class="clearfix"></div>
        <?
        pr($return);
    }

    var $access_typeC_edit = "normal_user";
    public function typeC_edit(){

        //pakai panggilan API
        $url = _BPATH."AppAPI/get_content_typeC";
        $fields = array("content_id"=>addslashes($_GET['content_id']));
        $res = AppContentHelper::doCURLPost($url,$fields);

        $return = json_decode($res);

        $content = $return->results;
        $t = time()."_".$content->content_id;

        $type = $content->content_type;
        $new = new $type();

        $icon = _SPPATH."bridge_icons/".$new->icon;
        if($content->content_icon!="")
            $icon = _SPPATH._PHOTOURL.$content->content_icon;

        $categories = $content->categories;

        $array_a = $content->typeA;
        ?>
        <div class="col-md-4 col-md-offset-4" style="padding: 10px;">
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
                    post.content_id = "<?=addslashes($_GET['content_id']);?>";
                    post.api_lokal = 1;
                    post.content_icon = $('#<?=$container;?>').val();


                    post.typeB_order =  $('#typeb_order_<?=$t;?>').val();
                    post.typeB_hidden =  $('#typeb_order_hidden_<?=$t;?>').val();

                    console.log(post);

                    $.post("<?=_SPPATH;?>AppAPI/set_content_typeC",post,function(data){
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

        <!-- EDIT -->
        <div class="judulbesar" style="margin-bottom: 10px;">Categories <div onclick="add_typeA_<?=$t;?>();" class="menu_adder">+</div></div>
        <div id="dialog_category_<?=$t;?>" title="Category data">
            <form>
                <fieldset class="ui-helper-reset">
                    <label for="tab_title">Cat Title</label>
                    <input type="text" name="cat_title" id="cat_title_<?=$t;?>" value="Category" class="ui-widget-content ui-corner-all">
                    <!--                            <div style="display: none;">-->
                    <!--                            <label for="tab_content">Content</label>-->
                    <!--                            <textarea name="tab_content" id="tab_content" class="ui-widget-content ui-corner-all">Tab content</textarea>-->
                    <!--                            </div>-->
                </fieldset>
            </form>
        </div>
        <script>
            function add_typeA_<?=$t;?>(){
                dialog.dialog("open");
            }

            // modal dialog init: custom buttons and a "close" callback resetting the form inside
            var dialog = $("#dialog_category_<?=$t;?>").dialog({
                autoOpen: false,
                modal: true,
                buttons: {
                    Add: function () {
                        addCats_<?=$t;?>();
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
                addCats_<?=$t;?>();
                dialog.dialog( "close" );
                event.preventDefault();
            });




            // actual addTab function: adds new tab using the input from the form above
            function addCats_<?=$t;?>() {
                //wadah_typeB
                var cat_title = $('#cat_title_<?=$t;?>').val();


                $.post("<?=_SPPATH;?>AppAPI/add_content_typeB",{
                    category_name : cat_title,
                    content_id : <?=$content->content_id;?>,
                    app_id : <?=$content->content_app_id;?>
                },function(data){
                    if(data.status_code){

                        active_page_refresher();

//

                    }else{
                        alert(data.status_message);
                    }
                },'json');


            }


        </script>

        <div id="mulai_b_<?=$t;?>">
            <?
            foreach($categories as $num=>$a){



                ?>
                <div class="cat_item" id="<?=$a->id;?>">
                    <div id="cat_img_<?=$a->id;?>" onclick="setVisibility_<?=$t;?>('cat_img_<?=$a->id;?>','<?=$num;?>');" class="a_visibility_icon <?if($a->hide)echo "a_visibility_icon_selected";?>"></div>
                    <!--                        <img   src="--><?//=_SPPATH;?><!--bridge_icons/ic_visible.png" align="absmiddle" class="a_visibility_icon"> &nbsp;-->
                    <a onclick="openContentTypeB_<?=$t;?>('<?=$a->id;?>','<?=$a->name;?>');"><?=$a->name;?></a>
                    <div class="deleter" onclick="deleteTypeBfromC_<?=$t;?>('<?=$a->id;?>');">x</div>


                </div>
            <?
            }
            ?>
        </div>
        <style>
            .a_visibility_icon{
                height: 20px;
                width: 20px;
                float: left;
                margin-right: 10px;
                display: inline;
                cursor: pointer;
            }
            .cat_item{
                border: 1px solid #cccccc;
                margin-bottom: 5px;
                padding: 10px;
                background-color: #FFFFFF;
            }
            .deleter{
                float: right;
                display: inline;
                text-align: right;
                cursor: pointer;
            }
            .cat_item .a_visibility_icon { width: 20px; height: 20px; background-color: #00c0ef; }
            .cat_item .a_visibility_icon { -webkit-mask-image: url('<?=_SPPATH;?>bridge_icons/ic_visible.png');-webkit-mask-size: 20px 20px; }
            .cat_item .a_visibility_icon_selected{ background-color: #cccccc;}
        </style>
        <input type="text" id="typeb_order_<?=$t;?>">
        <input type="text" id="typeb_order_hidden_<?=$t;?>">
        <script>
            function setVisibility_<?=$t;?>(id,urutan){
//                    if($("#"+id).hasClass('a_visibility_icon_selected')){
//                        //dulu visible skrg ga lagi
//                        hide_array[urutan] = 0;
//                    }else{
//                        //dulu tidak visible skrg visible
//                        hide_array[urutan] = 1;
//                    }
//                    $("#"+id).toggleClass('a_visibility_icon_selected');
//                    console.log("in");

                $("#"+id).toggleClass('a_visibility_icon_selected');
                updateVisibility_<?=$t;?>();

            }
            function updateVisibility_<?=$t;?>(){

//                    console.log(hide_array);
//                    var arr = [];
//                    for (var key in hide_array) {
//                        console.log(key, hide_array[key]);
//                        arr.push(hide_array[key]);
//                    }
//                    console.log(arr);
//                    $('#typeb_order_hidden_<?//=$t;?>//').val(arr.join());
                updateTypeBOrder_<?=$t;?>();
            }

            $( function() {
                $( "#mulai_b_<?=$t;?>" ).sortable({
                    update: function(event, ui) {
                        updateTypeBOrder_<?=$t;?>();
                    }
                });
                $( "#mulai_b_<?=$t;?>" ).disableSelection();

                //set history
//                            sethistoryback("app_id");
                updateTypeBOrder_<?=$t;?>();
//                    updateVisibility_<?//=$t;?>//();
            } );

            function removeTypeB_<?=$t;?>(input_id,img_id){

                if(confirm("This will delete the selected carousel item")) {
                    $('#' + input_id).val("");
                    $('#' + img_id).attr("src", "<?=_SPPATH;?>images/noimage.jpg");
                    updateTypeBOrder_<?=$t;?>();
                }
            }


            function updateTypeBOrder_<?=$t;?>(){

                var orders = [];
                var hide = [];
                var urutan = 0;
                $.each($( "#mulai_b_<?=$t;?>" ).children(), function(i, item) {
//
                    var xx = $(item).attr("id");
                    orders.push(xx);

                    //updateorder
                    var anak = $(item).find( ".a_visibility_icon" );
                    console.log(anak);

                    if(anak.hasClass('a_visibility_icon_selected')){
                        hide.push(1);
//                            hide_array[urutan] = 1;
                    }else{
                        hide.push(0);
//                            hide_array[urutan] = 0;
                    }
                    urutan++;
                });
//                            console.log(orders);
                $('#typeb_order_<?=$t;?>').val(orders.join(","));
                $('#typeb_order_hidden_<?=$t;?>').val(hide.join(","));
            }

            function openContentTypeB_<?=$t;?>(cat_id,pagetitle){

                var url = "<?=_SPPATH;?>AppAPIPrinter2/typeB_category_edit?is_category=1&category_id="+cat_id;
                addPage("contenttypeBfromC_"+cat_id,url,pagetitle,"contentitem_<?=$content->content_id;?>");

            }

            function deleteTypeBfromC_<?=$t;?>(cat_id){
                if(confirm("This will delete this category")){
                    $.post('<?=_SPPATH;?>AppAPI/delete_content_typeB',{category_id:cat_id},function(data){
                        if(data.status_code){
                            active_page_refresher();
                        }else{
                            alert(data.status_message);
                        }
                    },'json');
                }
            }
        </script>
        </div><!-- col-md-6-->
        <div class="clearfix"></div>
        <?
        pr($return);
    }

    var $access_typeB_category_edit = "normal_user";
    public function typeB_category_edit(){

        //pakai panggilan API
        $url = _BPATH."AppAPI/get_content_typeB";


        $fields = array("category_id"=>addslashes($_GET['category_id']));
        $res = AppContentHelper::doCURLPost($url,$fields);

        $return = json_decode($res);

        $category = $return->results;
        $content_id = $category->content_id;
        $t = time()."_".$category->id;

//        $type = $content->content_type;
//        $new = new $type();
//
//        $icon = _SPPATH."bridge_icons/".$new->icon;
//        if($content->content_icon!="")
//            $icon = _SPPATH._PHOTOURL.$content->content_icon;

        $array_a = $category->typeA;
        ?>
        <div class="col-md-4 col-md-offset-4" style="padding: 10px;">
        <div class="app_container">

            <div class="col-md-12" style="padding-left: 20px; ">
                <input type="text" id="articlename_<?=$t;?>" style="margin-bottom: 10px;" class="form-control" value="<?=$category->name;?>">
                <button class="btn btn-danger btn-sm" id="save_<?=$t;?>"  style="width: 100%;">SAVE</button>
            </div>
            <div class="clearfix"></div>
            <script>
                $('#save_<?=$t;?>').click(function(){
                    var post = {};
                    post.category_name = $('#articlename_<?=$t;?>').val();
                    post.category_id = "<?=addslashes($_GET['category_id']);?>";



                    post.typeA_order =  $('#typeb_order_<?=$t;?>').val();
                    post.typeA_hidden =  $('#typeb_order_hidden_<?=$t;?>').val();

                    console.log(post);

                    $.post("<?=_SPPATH;?>AppAPI/set_content_typeB",post,function(data){
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

        <!-- EDIT -->
        <div class="judulbesar" style="margin-bottom: 10px;">Products <div onclick="add_typeA_<?=$t;?>();" class="menu_adder">+</div></div>

        <script>
            function add_typeA_<?=$t;?>(){
                var now = $.now();
                var url = "<?=_SPPATH;?>AppAPIPrinter/typeA_edit?category_id=<?=$category->id;?>&content_id=<?=$content_id;?>&from_b=1";
                addPage("contentitem_fromb_"+now,url,"New Page","contenttypeBfromC_<?=$category->id;?>");
            }

            var hide_array = {};
        </script>

        <div id="mulai_b_<?=$t;?>">
            <?
            foreach($array_a as $num=>$a){



                ?>
                <div class="a_item" id="<?=$a->a_id;?>">
                    <div id="a_img_<?=$a->a_id;?>" onclick="setVisibility_<?=$t;?>('a_img_<?=$a->a_id;?>','<?=$num;?>');" class="a_visibility_icon <?if($a->a_hide)echo "a_visibility_icon_selected";?>"></div>
                    <!--                        <img   src="--><?//=_SPPATH;?><!--bridge_icons/ic_visible.png" align="absmiddle" class="a_visibility_icon"> &nbsp;-->
                    <a onclick="openContentTypeB_<?=$t;?>('<?=$a->a_id;?>','<?=$a->msg[0]->contenttitle;?>');"><?=$a->msg[0]->contenttitle;?></a>
                    <div class="deleter" onclick="deleteTypeAfromB_<?=$t;?>('<?=$a->a_id;?>');">x</div>


                </div>
            <?
            }
            ?>
        </div>
        <style>
            .a_visibility_icon{
                height: 20px;
                width: 20px;
                float: left;
                margin-right: 10px;
                display: inline;
                cursor: pointer;
            }
            .a_item{
                border: 1px solid #cccccc;
                margin-bottom: 5px;
                padding: 10px;
                background-color: #FFFFFF;
            }
            .deleter{
                float: right;
                display: inline;
                text-align: right;
                cursor: pointer;
            }
            .a_item .a_visibility_icon { width: 20px; height: 20px; background-color: #00c0ef; }
            .a_item .a_visibility_icon { -webkit-mask-image: url('<?=_SPPATH;?>bridge_icons/ic_visible.png');-webkit-mask-size: 20px 20px; }
            .a_item .a_visibility_icon_selected{ background-color: #cccccc;}
        </style>
        <input type="text" id="typeb_order_<?=$t;?>">
        <input type="text" id="typeb_order_hidden_<?=$t;?>">
        <script>
            function setVisibility_<?=$t;?>(id,urutan){
//                    if($("#"+id).hasClass('a_visibility_icon_selected')){
//                        //dulu visible skrg ga lagi
//                        hide_array[urutan] = 0;
//                    }else{
//                        //dulu tidak visible skrg visible
//                        hide_array[urutan] = 1;
//                    }
//                    $("#"+id).toggleClass('a_visibility_icon_selected');
//                    console.log("in");

                $("#"+id).toggleClass('a_visibility_icon_selected');
                updateVisibility_<?=$t;?>();

            }
            function updateVisibility_<?=$t;?>(){

//                    console.log(hide_array);
//                    var arr = [];
//                    for (var key in hide_array) {
//                        console.log(key, hide_array[key]);
//                        arr.push(hide_array[key]);
//                    }
//                    console.log(arr);
//                    $('#typeb_order_hidden_<?//=$t;?>//').val(arr.join());
                updateTypeBOrder_<?=$t;?>();
            }

            $( function() {
                $( "#mulai_b_<?=$t;?>" ).sortable({
                    update: function(event, ui) {
                        updateTypeBOrder_<?=$t;?>();
                    }
                });
                $( "#mulai_b_<?=$t;?>" ).disableSelection();

                //set history
//                            sethistoryback("app_id");
                updateTypeBOrder_<?=$t;?>();
//                    updateVisibility_<?//=$t;?>//();
            } );

            function removeTypeB_<?=$t;?>(input_id,img_id){

                if(confirm("This will delete the selected carousel item")) {
                    $('#' + input_id).val("");
                    $('#' + img_id).attr("src", "<?=_SPPATH;?>images/noimage.jpg");
                    updateTypeBOrder_<?=$t;?>();
                }
            }


            function updateTypeBOrder_<?=$t;?>(){

                var orders = [];
                var hide = [];
                var urutan = 0;
                $.each($( "#mulai_b_<?=$t;?>" ).children(), function(i, item) {
//
                    var xx = $(item).attr("id");
                    orders.push(xx);

                    //updateorder
                    var anak = $(item).find( ".a_visibility_icon" );
                    console.log(anak);

                    if(anak.hasClass('a_visibility_icon_selected')){
                        hide.push(1);
//                            hide_array[urutan] = 1;
                    }else{
                        hide.push(0);
//                            hide_array[urutan] = 0;
                    }
                    urutan++;
                });
//                            console.log(orders);
                $('#typeb_order_<?=$t;?>').val(orders.join(","));
                $('#typeb_order_hidden_<?=$t;?>').val(hide.join(","));
            }

            function openContentTypeB_<?=$t;?>(a_id,pagetitle){

                var url = "<?=_SPPATH;?>AppAPIPrinter/typeA_edit?category_id=<?=$category->id;?>&content_id=<?=$content_id;?>&a_id="+a_id;
                addPage("contenttypeAfromB_"+a_id,url,pagetitle,"contenttypeBfromC_<?=$category->id;?>");

            }

            function deleteTypeAfromB_<?=$t;?>(a_id){
                if(confirm("This will delete this page")){
                    $.post('<?=_SPPATH;?>AppAPI/delete_content_typeA',{a_id:a_id},function(data){
                        if(data.status_code){
                            active_page_refresher();
                        }else{
                            alert(data.status_message);
                        }
                    },'json');
                }
            }
        </script>
        </div><!-- col-md-6-->
        <div class="clearfix"></div>
        <?
        pr($return);
    }
} 