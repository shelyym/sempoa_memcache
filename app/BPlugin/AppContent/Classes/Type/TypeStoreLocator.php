<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:25 PM
 */

class TypeStoreLocator extends AppContentTemplate{

    public $name = "Store Locator";
    public $isSingular = 1;
    public $icon = "ic_store.png";
    public function p(){
        echo "this is for print";
    }
    public function createForm(){

        $content = $this->content;

        $content_id = $this->content->content_id;

        ?>

        <div style="background-color: #FFFFFF;">
            <div class="col-md-12" style="padding: 10px; background-color: #e1e1e1;">
                Article Name : <input name="articlename" type="text" value="<?=$content->content_name;?>"  id="articlename" placeholder="Enter Title">
                <input type="text" name="cat_order" id="cat_order">
            </div>

            <div class="col-md-12" style="padding: 10px; ">
                <button class="btn btn-success" id="add_store" >Add New Store</button>


                <div id="store_container">


                </div>




            </div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="padding: 10px; text-align: center;">
                <button type="submit" id="save_<?=$content->content_id;?>" class="btn btn-danger" style="width: 100%;">SAVE</button>
            </div>


            <div id="dialog_store" title="Store data">
                <form>
                    <fieldset class="ui-helper-reset">
                        <input type="text" name="store_id" id="store_id">
                        <label for="store_name">Store Name</label>
                        <input type="text" name="store_name" id="store_name" value="Store Name" class="ui-widget-content ui-corner-all">

                        <label for="store_descr">Description</label>
                        <textarea name="store_descr" id="store_descr" class="ui-widget-content ui-corner-all">Description</textarea>

                        <label for="store_phone">Phone</label>
                        <input type="text" name="store_phone" id="store_phone" value="Phone" class="ui-widget-content ui-corner-all">

                        <label for="store_email">Email</label>
                        <input type="email" name="store_email" id="store_email" value="Email" class="ui-widget-content ui-corner-all">


                        <label for="store_address">Address</label>
                        <textarea name="store_address" id="store_address" class="ui-widget-content ui-corner-all">Address</textarea>


                        <label for="opening_hour">Opening Hour</label>
                        <textarea name="opening_hour" id="opening_hour" class="ui-widget-content ui-corner-all">Opening Hour</textarea>


                        <label for="lat">Latitude</label>
                        <input type="text" name="lat" id="lat" value="109.6481216" class="ui-widget-content ui-corner-all">

                        <label for="lng">Longitude</label>
                        <input type="text" name="lng" id="lng" value="-7.398366" class="ui-widget-content ui-corner-all">


                    </fieldset>
                </form>
            </div>
        </div>
        <style>
            .ui-dialog{
                z-index: 5000;
            }

        </style>
        <script>
            function openStore(sid){


                $.post("<?=_SPPATH;?>AppContentWS/openStore",{
                    store_id:sid
                },function(data){

                    if(data.bool){
                        $('#store_name').val(data.store_name);
                        $('#store_descr').val(data.store_descr);
                        $('#store_phone').val(data.phone);
                        $('#store_email').val(data.email);
                        $('#opening_hour').val(data.opening_hour);
                        $('#store_address').val(data.address);
                        $('#lat').val(data.latitude);
                        $('#lng').val(data.longitude);
                        $('#store_id').val(data.store_id);

                        // modal dialog init: custom buttons and a "close" callback resetting the form inside
                        var dialog = $("#dialog_store").dialog({
                            autoOpen: false,
                            modal: true,
                            buttons: {
                                Add: function () {
//                            addCats();
                                    addStore();
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

                        dialog.dialog("open");
                    }
                },'json');

            }



            function addStore(){


                var store_id = $('#store_id').val();
                var store_name = $('#store_name').val();
                var store_descr = $('#store_descr').val();
                var store_phone = $('#store_phone').val();
                var store_address = $('#store_address').val();

                var store_email = $('#store_email').val();
                var opening_hour = $('#opening_hour').val();
                var lat = $('#lat').val();
                var lng = $('#lng').val();

                $.post("<?=_SPPATH;?>AppContentWS/addStore",{
                    store_name:store_name,store_descr:store_descr,store_phone:store_phone,
                    store_email:store_email,opening_hour:opening_hour,
                    lat:lat,lng:lng,store_address:store_address,store_id:store_id,
                    app_id:<?=$content->content_app_id;?>,
                    content_id:<?=$content_id;?>
                },function(data){

                    if(data.bool){
                        alert("Success");
                        reloadStore();
                    }
                },'json');
            }

            function reloadStore(){

                //store_container
                $("#store_container").load("<?=_SPPATH;?>AppContentWS/reloadStore?app_id=<?=$content->content_app_id;?>&content_id=<?=$content_id;?>");
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
        </script>

        <script>
            $(function() {



// modal dialog init: custom buttons and a "close" callback resetting the form inside
                var dialog = $("#dialog_store").dialog({
                    autoOpen: false,
                    modal: true,
                    buttons: {
                        Add: function () {
//                            addCats();
                            addStore();
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
                    addStore();
                    dialog.dialog( "close" );
                    event.preventDefault();
                });


                $("#add_store")
                    .button()
                    .click(function () {
                        $('#store_id').val('');
//
//                        addStore();
                        dialog.dialog("open");

                    });




                reloadStore();


            });


        </script>
        <?
    }

} 