<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 8:50 PM
 */

class FeatMap extends ZAppFeature{

    public $feat_name = "Map";
    public $feat_id = "map";
    public $feat_icon = "ic_location.png";

    public $feat_tab_icon = "ic_location.png";
    public $feat_rank_tampil = 3;

    public $feat_active = 1;


    public function formCustom(){

        $sel = ZAppFeature::selectedFeature();

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pname = isset($valuesNya[$this->feat_id.'_pname'])?$valuesNya[$this->feat_id.'_pname']:"Page Name";
        $contact_pslogan = isset($valuesNya[$this->feat_id.'_pslogan'])?$valuesNya[$this->feat_id.'_pslogan']:"";

        ?>
        <h1 class="header_besar" style="padding: 0; margin: 0; text-align: center; margin-top: 10px; margin-bottom: 10px;"><?=$this->feat_name;?></h1>

        <div class="form-group">
            <label for="info_slogan">Please enter a starting point of your Location</label>
            <br><small>e.g can be your city, kecamatan or kelurahan.</small>
            <?
            TextLimiter::inputText("text",$this->feat_id."_pslogan",$this->feat_id."_pslogan","e.g Jakarta/Pondok Indah/Ciputat/Kelapa Gading",$contact_pslogan,150,0);

            ?>
        </div>
        <div style="text-align: center; margin-top: 30px;">
            <button onclick="addAddress2Map();" class="btn btn-success btn-lg">Adjust Map</button>
            <br><small>You can drag the red marker <i class="glyphicon glyphicon-map-marker"></i> to your business position </small>

        </div>



        <script>



            //do not change the function name
            function info_save_<?=$this->feat_id;?>(){
                //get all data from inputs
                var contact_pname = $('#<?=$this->feat_id;?>_pname').val();
                var contact_pslogan = $('#<?=$this->feat_id;?>_pslogan').val();

                //label_name : mandatory
                var label_name = $('#<?=$this->feat_id;?>_labelname').val();



                //save the data to sessions
                $.post('<?=_SPPATH;?>FeatureSessionLayer/save?id=<?=$this->feat_id;?>',{
                    <?=$this->feat_id;?>_labelname : label_name,
                    <?=$this->feat_id;?>_pslogan : contact_pslogan,
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
        </script>
    <?

    }

    public function appPageCustom(){

        $valuesNya = FeatureSessionLayer::load($this->feat_id);

        $contact_pslogan = isset($valuesNya[$this->feat_id.'_pslogan'])?$valuesNya[$this->feat_id.'_pslogan']:"";

        //lokasi maps
        $arrLatLng = $valuesNya[$this->arrayID];

        if(isset($arrLatLng['lat'])){
            $lat = $arrLatLng['lat'];
        }
        else $lat = '';

        if(isset($arrLatLng['lng'])){
            $lng= $arrLatLng['lng'];
        }
        else $lng = '';

        ?>
        <div id="map-canvas"></div>
        <div class="mdescription" id="<?=$this->feat_id;?>_des"><?=$contact_pslogan;?></div>
        <style>
            .mdescription{
                padding: 10px;
            }
        </style>
        <style>
            #map-canvas {
                width: 269px;
                height: 385px;
            }
            #map_canvas {
                background: transparent url(<?=_SPPATH;?>images/leaploader.gif) no-repeat center center;
            }

        </style>

        <script>

            var latawal = '<?=$lat;?>';
            var lngawal = '<?=$lng;?>';



            function addAddress2Map(){
                var geocoder =  new google.maps.Geocoder();
                var address = $("#<?=$this->feat_id;?>_pslogan").val();
                console.log('map');
                console.log(address);
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        latawal = results[0].geometry.location.lat();
                        lngawal = results[0].geometry.location.lng();
                        kerjakanMap();
//                alert("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng());
                        saveCurrent(latawal,lngawal);

                    } else {
                        alert("Something got wrong " + status);
                    }
                });
            }






        </script>

        <script>
            function kerjakanMap() {

                if (latawal != '' && lngawal != '') {
//        var rukobintaro = new google.maps.LatLng(-6.2819987, 106.7130693);
                    var center = new google.maps.LatLng(latawal, lngawal);

                    console.log(latawal + ' lng : ' + lngawal);

                    var mapOptions = {
                        zoom: 17,
                        center: center,
                        streetViewControl: false,
                        mapTypeControl: false
                    }

                    var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

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

                        latawal = lat;
                        lngawal = lng;
//            alert('drag end' + lat + ' lng ' + lng);
                        saveCurrent(lat, lng);
                    });
                }
            }
            function saveCurrent(lat,lng){
                $.get("<?=_SPPATH;?>FeatureSessionLayer/saveMap?id=<?=$this->feat_id;?>&lat="+lat+"&lng="+lng,
                    function(data){
                        console.log("map saved");
                        console.log(data);
                    },'json');
            }

            $(document).ready(function() {
                    kerjakanMap();
            });
        </script>
    <?
    }
} 