<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/17/16
 * Time: 1:48 PM
 */

class PrinterHelper {

    public static function printCarouselSelector($a,$input_id){
        $t = time().rand(0,105);
        ?>
        <div id="carousel_<?=$t;?>">
        <?
    $exp = $a->carousel;

    for($x=0;$x<6;$x++){
    $e = $exp[$x];
    if($e == "")$img = _SPPATH."images/noimage.jpg";
    else $img = $e;

    $bannerModalID = "typea_carousel_img_".$x;
    $container = "typea_car_pic_".$x;
    ?>

    <div class="carousel_custom_img">
        <input class="carousel_isi_img" value="<?=$e;?>" type="hidden" id="<?=$container;?>" name="<?=$container;?>">

        <div class="carousel_custom_img_inside">


            <?
            Cropper::createModal($bannerModalID,"Upload Picture",$container,$img,"10:10",array($bannerModalID."_prev"),"updateCarHeaderImg_$t('".$container."');");
            ?>
            <div onclick="removeCarouselImg_<?=$t;?>('<?=$container;?>','<?=$bannerModalID;?>_prev');" class="carousel_remover">x</div>
            <img style="cursor: pointer;" data-toggle="modal" data-target="#<?=$bannerModalID;?>" id="<?=$bannerModalID;?>_prev" src="<?=$img;?>" >

        </div>



    </div>
<?
}
?>
</div>
        <script>
            $( function() {
                $( "#carousel_<?=$t;?>" ).sortable({
                    update: function(event, ui) {
                        updateOrderCarousel_<?=$t;?>();
                    }
                });
                $( "#carousel_<?=$t;?>" ).disableSelection();

                //set history
//                            sethistoryback("app_id");
            } );

            function removeCarouselImg_<?=$t;?>(input_id,img_id){

                if(confirm("This will delete the selected carousel item")) {
                    $('#' + input_id).val("");
                    $('#' + img_id).attr("src", "<?=_SPPATH;?>images/noimage.jpg");
                    updateOrderCarousel_<?=$t;?>();
                }
            }
            function updateCarHeaderImg_<?=$t;?>(id){

                updateOrderCarousel_<?=$t;?>();


            }

            function updateOrderCarousel_<?=$t;?>(){

                var orders = [];
                $.each($( "#carousel_<?=$t;?>" ).children(), function(i, item) {
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
                $('#<?=$input_id;?>').val(orders.join(","));

                /*$.post("<?=_SPPATH;?>AppAPI/set_home_header",{
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
                },'json');*/
            }
        </script>

        <style>
            #carousel_<?=$t;?> .carousel_remover{
                position: absolute;
                z-index: 2;
                background-color: #dedede;
                text-align: center;
                line-height: 30px;
                cursor: pointer;
                width: 30px;
                height: 30px;
            }
            #carousel_<?=$t;?> .carousel_custom_img{
                width: 33%;
                float: left;
            }
            #carousel_<?=$t;?> .carousel_custom_img_inside{
                padding: 10px;
            }
            #carousel_<?=$t;?> .carousel_custom_img_inside img{
                width: 100%;
                cursor: pointer;
                object-fit: cover;

            }



        </style>
    <?

    }

    public static function printMap($a,$input_id){

        $t = time().rand(0,105).$a->a_id;

        $lat = "";
        $lng = "";

        $exp = explode(",",$a->a_map);
        if(count($exp)>0 && $a->a_map!="") {
            $lat = $exp[0];
            $lng = $exp[1];
        }
        ?>
        <div class="form-inline22">
            <div class="col-md-6" >
                <div style="margin-right: 10px;">
                    <input type="text" value="<?=$lat;?>" class="form-control" id="lat_<?=$t;?>" placeholder="Latitude">
                </div>
            </div>
            <div class="col-md-6" >
                <div style="margin-left: 10px;">
                    <input type="text" value="<?=$lng;?>"  class="form-control" id="lng_<?=$t;?>" placeholder="Longitude">
                </div>
            </div>

            <div class="clearfix"></div>

            <button style="width: 100%;  margin-top: 20px;" class="btn btn-default" onclick="$('.map_selector_<?=$t;?>').toggle();kerjakanMap_<?=$t;?>();">pick from map</button>
            <div class="map_selector_<?=$t;?>" style="display: none;">
                <div id="map-canvas_<?=$t;?>"></div>
            </div>
            <style>
                #map-canvas_<?=$t;?>{
                    width: 100%;
                    height: 300px;
                    margin-top: 20px;
                }
            </style>
            <script>

                var latawal_<?=$t;?>;
                var lngawal_<?=$t;?>;

                $( function() {
                    <?
                    if(count($exp)>0 && $a->a_map!="") {
                    ?>
                    latawal_<?=$t;?> = '<?=$exp[0];?>';
                    lngawal_<?=$t;?> = '<?=$exp[1];?>';
                    kerjakanMap_<?=$t;?>();
                    <?
                    }else{
                    ?>
                    getLocation_<?=$t;?>();
                    <? } ?>
                } );


                function getLocation_<?=$t;?>() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition_<?=$t;?>);
                    } else {
//                        $('.map_selector_<?//=$t;?>//').hide();
                       console.log("Geolocation is not supported by this browser.");
                    }
                }

                function showPosition_<?=$t;?>(position) {
                    latawal_<?=$t;?> = position.coords.latitude;
                    lngawal_<?=$t;?> = position.coords.longitude;
                    kerjakanMap_<?=$t;?>();

                }













                function kerjakanMap_<?=$t;?>() {

                    if(latawal_<?=$t;?> === undefined)latawal = '-6.1877805'; //default jkt
                    if(lngawal_<?=$t;?> === undefined)lngawal = '106.8309227'; //default jkt

                    if (latawal_<?=$t;?> != '' && lngawal_<?=$t;?> != '') {
//        var rukobintaro = new google.maps.LatLng(-6.2819987, 106.7130693);
                        var center = new google.maps.LatLng(latawal_<?=$t;?>, lngawal_<?=$t;?>);

                        console.log(latawal_<?=$t;?> + ' lng : ' + lngawal_<?=$t;?>);

                        var mapOptions = {
                            zoom: 14,
                            center: center,
                            streetViewControl: false,
                            mapTypeControl: false
                        }

                        var map = new google.maps.Map(document.getElementById("map-canvas_<?=$t;?>"), mapOptions);

                        // Place a draggable marker on the map
                        var marker = new google.maps.Marker({
                            position: center,
                            map: map,
                            draggable: true,
                            title: "Drag me to pinpoint your location!"
                        });


                        google.maps.event.addListener(marker, "dragend", function (event) {
                            var lat = event.latLng.lat();
                            var lng = event.latLng.lng();

                            latawal_<?=$t;?> = lat;
                            lngawal_<?=$t;?> = lng;
//            alert('drag end' + lat + ' lng ' + lng);
                            saveCurrent_<?=$t;?>(lat, lng);
                        });
                    }
                }
                function saveCurrent_<?=$t;?>(lat,lng){
                    $('#<?=$input_id;?>').val(lat+","+lng);
                    $('#lat_<?=$t;?>').val(lat);
                    $('#lng_<?=$t;?>').val(lng);
//                    $.get("<?//=_SPPATH;?>//FeatureSessionLayer/saveMap?id=444&lat="+lat+"&lng="+lng,
//                        function(data){
//                            console.log("map saved");
//                            console.log(data);
//                        },'json');
                }


            </script>
        </div>

        <?
    }
} 