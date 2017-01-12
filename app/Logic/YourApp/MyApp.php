<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/18/15
 * Time: 4:58 PM
 */

class MyApp extends WebApps{

    var $access_newApp = "normal_user";
    function newApp(){

        ?>
        <style>
            .helper{
                font-size: 12px;
                padding-top: 5px;
                color:#999999;
            }
            .foto100{
                width: 100px;
                height: 100px;
                overflow: hidden;
            }
            .foto100 img{
                height: 100px;
            }
            .err{
                display: none;
            }
            .hype{
                text-align: center;
            }
        </style>
        <div class="container attop" >
        <div class="appear_logo_pages">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-apps.png" >
            </a>
        </div>


        <div class="col-md-8 col-md-offset-2" style="padding: 10px;">
            <small><a href="<?=_SPPATH;?>myapps">back to dashboard</a> </small>
            <div id="resultajax" style="display: none;"></div>
<!--            <h1 class="hype">Form Pendaftaran App</h1>-->
            <form class="form-horizontal" role="form" id="formaddapp">
                <hr>
                <h2 class="hype">Application Descriptions</h2>
                <hr>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="apptitle">Application Title:
                        <div class="helper">max 30 chars</div>
                    </label>
                    <div class="col-sm-8">
                        <input name="apptitle" type="text" class="form-control" id="apptitle" placeholder="Enter Application Title">
                        <div class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appshort">Short Description:
                        <div class="helper">max 80 chars</div>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" name="appshort" class="form-control" id="appshort" placeholder="Enter Short Description">
                        <div class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appfull">Full Description:
                        <div class="helper">max 4000 chars</div>
                    </label>
                    <div class="col-sm-8">
                        <textarea name="appfull" class="form-control" id="appfull" rows="5"></textarea>
                        <div class="err"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appkey">Keywords:
                        <div class="helper">comma separated</div>
                    </label>
                    <div class="col-sm-8">
                        <input type="text" name="appkey" class="form-control" id="appkey" placeholder="Enter Keywords">
                        <div class="err"></div>
                    </div>
                </div>
                <hr>
                <h2 class="hype">Application Icons and Images</h2>
                <hr>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appicon">Icon:
                        <div class="helper">1024x1024 (32bit PNG)</div>
                    </label>
                    <div class="col-sm-8">
                        <?
                        $foto = new \Leap\View\InputFoto("appicon","appicon","");
                        $foto->p();

                        ?>

<!--                        <input type="file" name="appicon" class="form-control" id="appicon" placeholder="Enter Keywords">-->
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appfeat">Feature Graphics:
                        <div class="helper">1024w x 500h (JPG/24bit PNG)</div>
                    </label>
                    <div class="col-sm-8">
                        <?
                        $foto = new \Leap\View\InputFoto("appfeat","appfeat","");
                        $foto->p();

                        ?>

                    </div>
                </div>
                <hr>
                <h2 class="hype">Pricing</h2>
                <hr>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="appfeat">Package:
<!--                        <div class="helper">learn more about package <a target="_blank" href="--><?//=_SPPATH;?><!--pricing">here</a> </div>-->
                    </label>
                    <div class="col-sm-8">
                        <select name="apppaket" id="apppaket" class="form-control">
                        <?
                        $paket = new Paket();
                        $arrPaket = $paket->getWhere("paket_active = 1 ORDER BY paket_price ASC");

                        foreach($arrPaket as $num=>$paket){
                        ?>
                          <option <? if($paket->paket_recommended)echo "selected";?>  value="<?=$paket->paket_id;?>"><?=$paket->paket_name;?> <? if($paket->paket_price>0){?>- Rp.<?=idrK($paket->paket_price);?>/year<?}?></option>
                        <? } ?>
                        </select>
                        <div class="err"></div>
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    <div class="col-sm-8 col-sm-offset-2">
                        <button type="submit" style="width: 100%;" class="btn btn-lg btn-success">Submit</button>
                        <a href="<?=_SPPATH;?>myapps" style="width: 100%; margin-top: 10px;" class="btn btn-lg btn-default">Cancel</a>
                    </div>
                </div>
            </form>

            <script>
                $( "#formaddapp" ).submit(function( event ) {

                    $(".err").hide();

//                        alert("benar semua1");
                        var $form = $(this);
                        var url = "<?=_SPPATH;?>MyApp/appReg";

                        $(".err").hide();

                        // Send the data using post
                        var posting = $.post(url, $form.serialize(), function (data) {
                            console.log(data);
                            if (data.bool) {
                                //kalau success masuk ke check your email....
                                document.location = "<?=_SPPATH;?>myapps?mode=redirect&id="+data.app_id;
//                                document.location = "<?//=_SPPATH;?>//PaymentWeb/payfor?app_id="+data.app_id;
                            }
                            else {
                                if(data.all!="") {
                                    $("#resultajax").show();
                                    $("#resultajax").html(data.all);
                                }
                                var obj = data.err;
                                var tim = data.timeId;
                                //console.log( obj );
                                for (var property in obj) {
                                    if (obj.hasOwnProperty(property)) {
                                        $( "#"+property ).css( "border-color", "red");
                                        $( "#"+property ).next(".err").css( "color", "red").show().empty().append(obj[property]).fadeIn('slow');
                                    }
                                }
                            }
                        }, 'json');




                    event.preventDefault();
                });
            </script>

<!--            Application Descriptions-->
<!--            Application Title : 30 chars-->
<!--            Short Desc : 80 chars-->
<!--            Full Desc : 4000 chars-->
<!--            Keywords : comma separated (for more accurate search result)-->
<!--            Contoh : The Body Shop; Body Butter; Soap; Skin;-->
<!---->
<!--            Images-->
<!--            App Icon : 1024x1024 (32bit PNG)-->
<!--            Feature Graphic : 1024w x 500h (JPG/24bit PNG)-->
        </div>
    <?
    }

    var $access_appReg = "normal_user";
    function appReg(){

        $err = array();
        $json['bool'] = 0;
//       $json['err'] = array("apptitle"=>"harus diisi");

        $apptitle = addslashes($_POST['apptitle']);
        if($apptitle == ""){
            $err['apptitle'] = "App Title must be filled";
        }
        if(strlen($apptitle) > 30){
            $err['apptitle'] = "Max 30 Chars";
        }

        $appshort = addslashes($_POST['appshort']);
        if($appshort == ""){
            $err['appshort'] = "Short Description must be filled";
        }
        if(strlen($appshort) > 80){
            $err['appshort'] = "Max 80 Chars";
        }

        $appfull = addslashes($_POST['appfull']);
        if($appfull == ""){
            $err['appfull'] = "Full Description must be filled";
        }
        if(strlen($appfull) > 4000){
            $err['appfull'] = "Max 4000 Chars";
        }

        $appkey = addslashes($_POST['appkey']);
        if($appkey == ""){
            $err['appkey'] = "Keywords must be filled";
        }

        $appicon = addslashes($_POST['appicon']);
        if($appicon == ""){
            $err['appicon'] = "Please insert Icon";
        }


        $appfeat = addslashes($_POST['appfeat']);
        if($appfeat == ""){
            $err['appfeat'] = "Please insert Feature Graphics";
        }

        $apppaket = addslashes($_POST['apppaket']);
        if($apppaket == ""){
            $err['apppaket'] = "Please select Package";
        }



        if(count($err)>0){
            $json['bool'] = 0;
            $json['err'] = $err;
        }
        else{
            //save here


            //add app
            $app = new AppAccount();
            $app->app_name = $apptitle;
            $app->app_shortdes = $appshort;
            $app->app_fulldes = $appfull;
            $app->app_icon = $appicon;
            $app->app_feat = $appfeat;
            $app->app_keywords = $appkey;

            $app->app_create_date = leap_mysqldate();
            $app->app_active = 0;
            $app->app_client_id = Account::getMyID();
            $app->app_token = md5($apptitle.time());
            $app->app_pulsa = 1000;
            $app->app_paket_id = $apppaket;

            $app_id = $app->save();

            if($app_id) {
                //add app2acc
                $app2acc = new App2Acc();
                $app2acc->ac_admin_id = Account::getMyID();
                $app2acc->ac_app_id = $app_id;
                $succ = $app2acc->save();
                if($succ) {

                    $appContent = new AppContentDraft();
                    $appContent->content_app_id = $app_id;
                    $appContent->content_name = "Inbox";
                    $appContent->content_type = "TypeInbox";
                    $appContent->content_inhalt = "";
                    $content_id = $appContent->save();



                    $app->app_order_draft = $content_id;
                    $app->app_id = $app_id;
                    $app->save(1);

                    $json['bool'] = 1;
                    $json['app_id'] = $app_id;
                }else{
                    $json['bool'] = 0;
                    $json['all'] = "Saving Role Error";
                }
            }else{
                $json['bool'] = 0;
                $json['all'] = "Saving App Error";
            }
        }

        echo json_encode($json);
        die();
    }

    var $access_appView = "normal_user";
    function appView(){
        $id = addslashes($_GET['id']);





        if(in_array("master_admin",Account::getMyRoles())){

//            $acc = new AppAccount();
//            $apps = $acc->getAll();
//
            $app = new AppAccount();
            $app->getByID($id);

        }else{
            $acc = new App2Acc();

            //AND app_active = 1
            $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));
//            pr($apps);

            if(count($apps)<1){
                die("hacking attempt");
            }else{
                $app = $apps[0];

            }
        }

        $paket = new Paket();
        $paket->getByID($app->app_paket_id);

        if(!$app->app_active){
            header("Location:"._SPPATH."PaymentWeb/payfor?app_id=".$app->app_id);
            die();
        }

        ?>
        <div class="container attop" >
        <div class="col-md-8 col-md-offset-2">
        <small><a href="<?=_SPPATH;?>mydashboard">back to dashboard</a> </small>
        <h1><?=$app->app_name;?> <small><a href="">edit app</a></small></h1>

        <div class="paket">Paket : <b style="font-size: 18px;"><?=$paket->paket_name;?></b> &nbsp; <i>[<a href="">Edit Paket</a>]</i> </div>
        <div style="padding: 10px;">
            <? if(!$app->app_active){?>

                <a class="btn btn-success btn-lg" href="<?=_SPPATH;?>PaymentWeb/payfor?app_id=<?=$app->app_id;?>">Payment</a>
            <? }else{ ?>
                <a class="btn btn-success btn-lg" href="<?=_SPPATH;?>PushHome/setID?app_id=<?=$app->app_id;?>">Admin Panel</a>
            <? } ?>
            </div>
        </div>

        </div>
        <?

//        pr($app);
    }

    var $access_editbridge = "normal_user";
    function editbridge(){

        //cek ID
        if(isset($_GET['id'])) {
            $id = addslashes($_GET['id']);
            $appAcc = new AppAccount();
            $appAcc->getByID($id);

            if ($appAcc->app_client_id != Account::getMyID()&& !in_array("master_admin",Account::getMyRoles())) {
                die("Owner's ID Mismatch");
            } else {
                AppPageHolde::pageholder();
//                 self::editform();
            }
        }else{
            die();
        }

    }

    var $access_editform = "normal_user";
    function editform(){

        $id = addslashes($_GET['id']);
        $appAcc = new AppAccount();
        $appAcc->getByID($id);

        $order = $appAcc->app_order_draft;
        $orderArr = explode(",",$order);

//        pr($appAcc);

        $appContent = new AppContentDraft();
        $arrContent = $appContent->getWhere("content_app_id = '$id'");



        //urutkan

        if(count($orderArr)>1) {
            $baru = array();
            foreach ($orderArr as $nourut) {
                foreach ($arrContent as $cont) {
                    if ($nourut == $cont->content_id) {
                        $baru[] = $cont;
                    }
                }
            }
            $arrContent = $baru;
        }

        global $template;
        $template->pagetitle = substr($appAcc->app_name,0,30);

//        pr($arrContent);

        $types = AppContentTemplate::getObjectOfSubclassesOf();

        //harus buka object nya dr yang sementara
        //jadi draft tidak dihapus, melainkan mencerminkan keadaan terbaru
        //kalau revert draft jd kita copy dr yang asli ke draft ...
        // please be good


//        pr($arrDraftContent);

//        $store = new CustStoreModel();
//        $store->printColumlistAsAttributes();
        ?>
        <style>
            ul { list-style-type: none; margin: 0; padding: 0; margin-bottom: 10px; }
            li { margin: 5px; padding: 5px; width: 150px; }

            #droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }

            .gallery{
                width: 100%;
            }
            .ui-widget-content {
                width: 100%;
            }

        </style>
        <div class="container attop" >



        <div class="col-md-8 col-md-offset-2" style="padding: 10px;">
            <div class="button_holder" style="display: none;">
            <button class="btn btn-default">Update App Info</button>
            <button class="btn btn-default">Update Animation and Themes</button>
            <button onclick="$('#update_content').toggle();" class="btn btn-default">Update Content</button>

            </div>
            <div class="clearfix">
                <div id="update_content" >
                    <div class="col-md-4" style="padding: 10px;">
                        <ul id="gallery" style="background-color: #dedede; min-height: 10px;" class="gallery ui-helper-reset ui-helper-clearfix">
                            <?
                            $typeSudah = array();
                            foreach($arrContent as $obj){
                                $typeSudah[] = $obj->content_type;
                                ?>
                                <li data-x="<?=$obj->content_type;?>" class="klikable ui-widget-content ui-corner-tr" id="<?=$obj->content_id;?>"><?=$obj->content_name;?></li>
                                <?
                            }

                            ?>



                        </ul>
                    </div>
                    <div class="col-md-2" style="padding: 10px;">
                        <ul>
                            <?
                            foreach($types as $typeObj){
                                if($typeObj->isSingular && in_array(get_class($typeObj),$typeSudah)){

                                }else {
                                    ?>
                                    <li data-x="<?= get_class($typeObj); ?>" id="<?= get_class($typeObj); ?>"
                                        class="<? if ($typeObj->isSingular) echo "typeB"; else echo "typeA"; ?> ui-widget-content ui-corner-tr"><?= $typeObj->name; ?></li>
                                <?
                                }
                            }

                            ?>


                        </ul>

                        <div id="trash" class="ui-widget-content ui-state-default">
                            <h4 class="ui-widget-header"><span class="ui-icon ui-icon-trash">Trash</span> Trash</h4>
                        </div>
                    </div>


                    <div class="clearfix"></div>
                    <div id="info"></div>
                    <input type="text" id="menuorder" value="<?=$order;?>">

                    <button class="btn btn-default">Save As Draft</button>
                    <button class="btn btn-default">Preview</button>
                    <button class="btn btn-default">Publish</button>
                    <?
//                    $ta = new TypeAModel();
//                    $ta->printColumlistAsAttributes();
                    ?>
                </div>
        </div>

        </div>

        <script>
            var droppedId;
            var $gallery = $( "#gallery" ),
                $trash = $( "#trash" );
            var $active_item;
            $(function() {




                $( "#gallery" ).sortable({
                    revert: true,
//                    receive: function(event, ui) {
//                        console.log(ui);
//                         droppedId = ui.sender.attr('id');
//                        console.log(droppedId);
//
////
////                        var html = [];
////                        $(this).find('li').each(function() {
////                            html.push('<div class="toggle">'+$(this).html()+'</div>');
////                        });
////                        $(this).find('li').replaceWith(html.join(''));
//                    },
//                    update: function(e, ui) {
//                        ui.item.attr('id', droppedId);
//                    }

                    update: function(event, ui) {
//                        console.log("update "+droppedId);
//                        ui.item.attr('id', droppedId);
//                        var orders = [];
//                        $.each($(this).children(), function(i, item) {
////                            orders.push($(item).data("x"));
//                            orders.push($(item).attr("id"));
//                        });
//
//                        $("#info").text("Order: " + orders.join(","));
//                        $('#menuorder').val(orders.join(","));
                        updateOrder();
                    },
                    receive: function (ev, ui) {
                        var $target = ($(this).data('sortable')  || $(this).data('ui-sortable')).currentItem;

                        $target.css('remove-class', 'ui-state-default').addClass('ui-state-highlight klikable');

                        $.post("<?=_SPPATH;?>AppContentWS/add",{
                            app_id : '<?=$appAcc->app_id;?>',
                            content_type : ui.item.attr('id')
                        },function(data){
//                           var cur = $(this).data().uiSortable.currentItem;
//                            cur.attr("id",data.id);
//                            console.log(cur);
//                            droppedId = data.id;
//                            console.log(droppedId);
                            $target.data("x",data.id);
                            $target.attr("id",data.id);
                            $target.dblclick(function(){
                                var id = $target.attr("id",data.id);
                                var url = "<?=_SPPATH;?>AppContentWS/openURL?id="+data.id;
                                loadPopUp(url,id,"content_item");
                            });

                            updateOrder();

                        },'json');
                    }
//                    ,
//                    receive: function(event, ui) {
//                        alert($(this).attr('id'));
//                        alert("dropped item ID: " + ui.item.attr('id'));
//
//
//                        $.post("<?//=_SPPATH;?>//AppContentWS/add",{
//                            app_id : '<?//=$appAcc->app_id;?>//',
//                            content_type : ui.item.attr('id')
//                        },function(data){
////                           var cur = $(this).data().uiSortable.currentItem;
////                            cur.attr("id",data.id);
////                            console.log(cur);
//                            droppedId = data.id;
//                            console.log(droppedId);
//                        },'json');
//
//                    }
                });
                $( ".typeA" ).draggable({
                    connectToSortable: "#gallery",
                    helper: "clone",
                    revert: "invalid"
                });

                $( ".typeB" ).draggable({
                    connectToSortable: "#gallery",

                    revert: "invalid"
                });


                $( "#droppable" ).droppable({
                    drop: function( event, ui ) {
                        $( this )
                            .addClass( "ui-state-highlight" )
                            .find( "p" )
                            .html( "Dropped!" );
                        deleteImage( ui.draggable );
                    }
                });

                // let the trash be droppable, accepting the gallery items
                $trash.droppable({
                    accept: "#gallery > li",
                    activeClass: "ui-state-highlight",
                    drop: function( event, ui ) {
                        deleteImage( ui.draggable );
                    }
                });

                // let the gallery be droppable as well, accepting items from the trash
                $gallery.droppable({
                    accept: "#trash li",
                    activeClass: "custom-state-active",
                    drop: function( event, ui ) {
//                        recycleImage( ui.draggable );
                        console.log(ui.draggable);
                    }

                });

                // image deletion function

                function deleteImage( $item ) {
                    if(confirm("this will delete item?")) {
                        $active_item = $item;
                        $.post("<?=_SPPATH;?>AppContentWS/del",{
                            app_id : '<?=$appAcc->app_id;?>',
                            content_id : $item.attr('id')
                        },function(data){
                            console.log(data);
                            if(data.bool) {
                                $active_item.remove();
                                //kembalikan singletonnya kalau nanti dibutuhkan...
                            }
                            else alert("delete failed");

                        },'json');


//                        $item.fadeOut(function () {
//                        var $list = $( "ul", $trash ).length ?
//                            $( "ul", $trash ) :
//                            $( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
//
////                        $item.find( "a.ui-icon-trash" ).remove();
//                        $item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
//                            $item
//                                .animate({ width: "48px" })
//                                .find( "img" )
//                                .animate({ height: "36px" });
//                        });


//                        });
                    }
                }

                // image recycle function
                var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</a>";
                function recycleImage( $item ) {
                    $item.fadeOut(function() {
                        $item
//                            .find( "a.ui-icon-refresh" )
//                            .remove()
                            .end()
                            .css( "width", "96px")
                            .append( trash_icon )
                            .find( "img" )
                            .css( "height", "72px" )
                            .end()
                            .appendTo( $gallery )
                            .fadeIn();
                    });
                }

                $( "ul, li" ).disableSelection();

                updateOrder();
            });
            $(".delete").click(function() {
                $(this).parent().remove();
            });
            function deleteMe(el){
                $(el).parent().remove();
                alert('halo')
            }

            function updateOrder(){

                var orders = [];
                $.each($gallery.children(), function(i, item) {
//                            orders.push($(item).data("x"));
                    orders.push($(item).attr("id"));
                });
                $('#menuorder').val(orders.join(","));

                $.post('<?=_SPPATH;?>AppContentWS/editOrder',
                    {
                        order:orders.join(","),
                        app_id:<?=$id;?>
                    },
                    function(data){
                    console.log(data);
                });


                $("#info").text("Order: " + orders.join(","));
            }

            $('.klikable').dblclick(function(){
                var id = $(this).attr('id');
                var url = "<?=_SPPATH;?>AppContentWS/openURL?id="+id;
                loadPopUp(url,id,"content_item");
            });


        </script>
        <style>
            .klikable{
                cursor: pointer;
            }

        </style>




        <?
        if($_GET['app'])die();
    }


} 