<?php

/**
 * Created by PhpStorm.
 * User: efindiongso
 * Date: 12/1/16
 * Time: 5:35 PM
 */
class WS extends WebService
{


    public function updateProfile()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $id_murid = addslashes($_POST['id_murid']);
        $nama_siswa = addslashes($_POST['nama_siswa']);
        $jenis_kelamin = addslashes($_POST['jenis_kelamin']);
        $alamat = addslashes($_POST['alamat']);
        $agama = addslashes($_POST['agama']);
        $tempat_lahir = addslashes($_POST['tempat_lahir']);
        $tanggal_lahir = addslashes($_POST['tanggal_lahir']);
        $telepon = addslashes($_POST['telepon']);
        $nama_sekolah = addslashes($_POST['nama_sekolah']);
        $nama_ortu = addslashes($_POST['nama_ortu']);
        $email_ortu = addslashes($_POST['email_ortu']);


        $json = array();
        if ($id_murid == "") {
            $json['status_code'] = 0;
            $json['status_message'] = "ID Murid Kosong!";
            echo json_encode($json);
            die();
        }
        $murid = new MuridModel();
        $murid->getByID($id_murid);
        if (is_null($murid->id_murid)) {
            $json['status_code'] = 0;
            $json['status_message'] = "Murid tidak ditemukan!";
            echo json_encode($json);
            die();
        }

        $constraint = array('nama_siswa', 'tanggal_lahir', 'alamat', 'telepon');

        $dataWS = $murid->crud_webservice_allowed;
        $arrDataWS = explode(",", $dataWS);
        $update = false;

        foreach ($_POST as $key => $value) {
            if (in_array($key, $constraint)) {
                if ($_POST[$key] == "") {
                    Generic::errorMsg($key . " Kosong!");
                }

            }

        }

        foreach ($arrDataWS as $dataSiswa) {

            if ($dataSiswa == "agama") {
                $update = true;
                $murid->$dataSiswa = $_POST[$dataSiswa];
            } elseif ($dataSiswa == "jenis_kelamin") {
                $murid->$dataSiswa = $_POST[$dataSiswa];
                $update = true;
            } else {
                if ($_POST[$dataSiswa] != "") {
                    if (in_array($dataSiswa, $murid->crud_add_photourl)) {
                        $picname = self::savePic($_POST[$dataSiswa]);
                        $murid->$dataSiswa = $picname;
                    } else {
                        $murid->$dataSiswa = $_POST[$dataSiswa];
                    }

                    $update = true;
                }

            }

        }

        $update = true;
        if ($update) {
            $succ = $murid->save(1);
            if ($succ) {

                $arrhlp = array();
                foreach ($arrDataWS as $val) {

                    if ($val == "id_level_sekarang") {
                        $arrhlp["level"] = Generic::getLevelNameByID($murid->$val);
                    } elseif ($val == "gambar") {
                        if ($murid->$val == "") {
                            $arrhlp[$val] = _BPATH . _PHOTOURL . "noimage.jpg";
                        } else {
                            $arrhlp[$val] = _BPATH . _PHOTOURL . $murid->$val;
                        }

                    } else {
                        $arrhlp[$val] = $murid->$val;
                    }


                }
                $tc = Generic::getTCNamebyID($murid->murid_tc_id);
                $arrhlp['tc'] = $tc;
                $json['murid'] = $arrhlp;
                $json['status_code'] = 1;
                $json['status_message'] = "Profile Murid berhasil diUpdate!";
                echo json_encode($json);
                die();
            }
        } else {
            $json['status_code'] = 1;
            $json['status_message'] = "Tidak ada Data yang diUpdate!";
            echo json_encode($json);
            die();
        }


    }

    public function getTCNearBy()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $lat = isset($_GET['latitude']) ? addslashes($_GET['latitude']) : "";

        if ($lat != "") {
            if (!self::checkLatitude($lat)) {
                Generic::errorMsg("Latitude harus numeric!");
            }
        } else {
            Generic::errorMsg("Latitude Kosong");
        }


        $long = isset($_GET['longitude']) ? addslashes($_GET['longitude']) : "";

        if ($long != "") {
            if (!self::checklongitude($long)) {
                Generic::errorMsg("Longitude harus numeric!");
            }
        } else {
            Generic::errorMsg("Longitude Kosong!");
        }

        $tc = new SempoaOrg();

        global $db;
        $q = "SELECT *, SQRT(POW(69.1 * (org_lat - $lat), 2) + POW(69.1 * ($long - org_lng ) * COS(org_lat / 57.3), 2)) AS distance FROM {$tc->table_name}  HAVING distance < 25 ORDER by distance";

        $qry = "SELECT *,(((acos(sin(( $lat *pi()/180)) * sin((org_lat*pi()/180))+cos(( $lat *pi()/180)) * cos((org_lat*pi()/180)) * cos((( $long- org_lng)*pi()/180))))*180/pi())*60*1.1515*1.609344) as distance
FROM {$tc->table_name} HAVING distance < 25 ORDER by distance";


        $arrTCs = $db->query($qry, 2);
        if (count($arrTCs) == 0) {
            Generic::errorMsg("Tidak ditemukan TC yg dekat Anda!");
        }
        $alle = array();

        foreach ($arrTCs as $val) {
            $alle['tc'][] = $val;
        }

        $json['status_code'] = 1;
        $json['tc'] = $arrTCs;
        echo json_encode($json);
        die();


    }

    public function signin()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $kode_murid = isset($_POST['kode_siswa']) ? addslashes($_POST['kode_siswa']) : "";
        $gebDatum = isset($_POST['tanggal_lahir']) ? addslashes($_POST['tanggal_lahir']) : "";

        if ($gebDatum == "") {
            Generic::errorMsg("Password kosong!");
        }
        $date = new DateTime($gebDatum);
        $gebDatum = $date->format("Y-m-d");
        $murid = new MuridModel();
        $murid->getWhereOne("kode_siswa='$kode_murid' AND tanggal_lahir='$gebDatum'");
        $ws = $murid->crud_webservice_allowed;
        $wsArray = explode(",", $ws);
        $arrhlp = array();
        foreach ($wsArray as $val) {
            if ($val == "id_level_sekarang") {
                $arrhlp["level"] = Generic::getLevelNameByID($murid->$val);
            } elseif ($val == "gambar") {
                if ($murid->$val == "") {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . "noimage.jpg";
                } else {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . $murid->$val;
                }

            } else {
                $arrhlp[$val] = $murid->$val;
            }

        }
        $tc = Generic::getTCNamebyID($murid->murid_tc_id);
        $arrhlp['tc'] = $tc;
        if (!is_null($murid->id_murid)) {
            $json['status_code'] = 1;
            $json['murid'] = $arrhlp;
            $json['status_message'] = "Login Berhasil!";
            echo json_encode($json);
            die();
        }

        Generic::errorMsg("Login Gagal!");

    }

    public function getMuridByID()
    {
        if (Efiwebsetting::getData('checkOAuth') == 'yes')
            IMBAuth::checkOAuth();

        $id_murid = addslashes($_GET['id_murid']);

        if ($id_murid == "") {
            Generic::errorMsg("ID Murid Kosong!");
        }

        $murid = new MuridModel();
        $murid->getWhereOne("id_murid='$id_murid'");
        $ws = $murid->crud_webservice_allowed;
        $wsArray = explode(",", $ws);
        $arrhlp = array();
        foreach ($wsArray as $val) {
            if ($val == "id_level_sekarang") {
                $arrhlp["level"] = Generic::getLevelNameByID($murid->$val);
            } elseif ($val == "gambar") {
                if ($murid->$val == "") {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . "noimage.jpg";
                } else {
                    $arrhlp[$val] = _BPATH . _PHOTOURL . $murid->$val;
                }

            } else {
                $arrhlp[$val] = $murid->$val;
            }

        }
        $tc = Generic::getTCNamebyID($murid->murid_tc_id);
        $arrhlp['tc'] = $tc;
        if (!is_null($murid->id_murid)) {
            $json['status_code'] = 1;
            $json['murid'] = $arrhlp;
            $json['status_message'] = "Login Berhasil!";
            echo json_encode($json);
            die();
        }

        Generic::errorMsg("Login Gagal!");

    }

    public static function checkConstrainUpdate($arrConstraint, $obj)
    {


        foreach ($arrConstraint as $val) {
//            pr($obj->$val);
            if (($obj->$val == "")) {
                $json['status_code'] = 0;
                $json['status_message'] = $val . " kosong!!";
                echo json_encode($json);
                die();
            }
        }
    }

    public static function checkLatitude($lat)
    {
        if (preg_match('/^(\\-?\\d+[.\\d]+),?\\s*(\\-?\\d+[.\\d]+)?$/', $lat)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checklongitude($long)
    {
        if (preg_match("/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/", $long)) {
            return true;
        } else {
            return false;
        }
    }

    public static function savePic($data)
    {

        if ($_GET['ios'] == "1") {
            $data = base64_decode(str_replace(" ", " + ", $data));
        } else
            $data = base64_decode($data);

        $im = imagecreatefromstring($data);
        if ($im !== false) {
            $ff = md5(mt_rand()) . '.png';
            $filename = _PHOTOPATH . $ff;

            //header('Content-Type: image/png');
            $succ = imagepng($im, $filename);
            //imagedestroy($im);
            if ($succ) {
                return $ff;
            } else {
                return 0;
            }
        }
        return 0;
    }

    public static function getDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $unit)
    {
//Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) + cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        if ($unit == "K") {
            return ($miles * 1.609344) . ' km';
        } else if ($unit == "N") {
            return ($miles * 0.8684) . ' nm';
        } else {
            return $miles . ' mi';
        }
    }

    public function getLatLong()
    {

        $t = time();
        $lat = -6.2263719;
        $lng = 106.6609089;
        ?>
        <div class="col-sm-12">
            <input id="pac-input<?= $t; ?>" class="controls" type="text" placeholder="Search">

            <div class="col-sm-12" id="map<?= $t; ?>"
                 style="width: 100%;height: 450px;background-color: #CCC;"></div>
            <script>
                function initAutocomplete<?=$t;?>() {
                    var markers = [];
                    var icon = {
//                        url: _sppath + "images/ic_location_pointer.png",
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };
                    var map = new google.maps.Map(document.getElementById("map<?= $t; ?>"), {
                        center: {lat: <?=$lat;?>, lng: <?=$lng;?>},
                        zoom: 15,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        disableDefaultUI: true
                    });

                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        position: {lat: <?=$lat;?>, lng: <?=$lng;?>}
                    }));
                    // Create the search box and link it to the UI element.
                    var input = document.getElementById("pac-input<?=$t;?>");
                    var searchBox = new google.maps.places.SearchBox(input);
                    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                    // Bias the SearchBox results towards current map's viewport.
                    map.addListener("bounds_changed", function () {
                        searchBox.setBounds(map.getBounds());
                    });


                    google.maps.event.addListener(map, "click", function (event) {
                        var lat = event.latLng.lat();
                        var lng = event.latLng.lng();
                        markers.forEach(function (marker) {
                            marker.setMap(null);
                        });
                        markers = [];
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            position: {lat: lat, lng: lng}
                        }));

                        $("#<?=$idLat;?>").val(lat);
                        $("#<?=$idLong;?>").val(lng);
                        var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lng + "&language=en&key=AIzaSyAjTYhXjHK4MgwGPK8UlveENUMCjgZcSZA";
                        console.log(url);
                        $.ajax({
                                method: "GET",
                                url: url
                            })
                            .done(function (msg) {
                                if (msg.results[3] == null) {
                                    $("#district<?=$t;?>").val("");
                                    $("#city<?=$t;?>").val("");
                                    $("#<?=$idLat;?>").val("");
                                    $("#<?=$idLong;?>").val("");
                                    alert("Cannot get exact location\nPlease zoom in and select again");
                                    return;
                                }
                                var arrComponents = msg.results[3].address_components;
//                                console.log(arrComponents);
                                $.each(arrComponents, function (jObj) {
//                                console.log(arrComponents[jObj].types[0]);
                                    if (arrComponents[jObj].types[0] == "administrative_area_level_3") {
                                        $("#district<?=$t;?>").val(arrComponents[jObj].long_name.toUpperCase());
                                    }
                                    else if (arrComponents[jObj].types[0] == "administrative_area_level_2") {
                                        $("#city<?=$t;?>").val(arrComponents[jObj].long_name.toUpperCase());
                                    }
                                });
                            });
                    });

                    // [START region_getplaces]
                    // Listen for the event fired when the user selects a prediction and retrieve
                    // more details for that place.
                    searchBox.addListener("places_changed", function () {
                        var places = searchBox.getPlaces();

                        if (places.length == 0) {
                            return;
                        }

                        // Clear out the old markers.
                        markers.forEach(function (marker) {
                            marker.setMap(null);
                        });
                        markers = [];

                        // For each place, get the icon, name and location.
                        var bounds = new google.maps.LatLngBounds();
                        places.forEach(function (place) {

                            if (place.geometry.viewport) {
                                // Only geocodes have viewport.
                                bounds.union(place.geometry.viewport);
                            } else {
                                bounds.extend(place.geometry.location);
                            }
                        });
                        map.fitBounds(bounds);
                    });
                    // [END region_getplaces]
                }


            </script>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDq98DfhRzBAAT1o8o8_GZbVmIgZw7K9hY&libraries=places&callback=initAutocomplete<?= $t; ?>"
                async defer></script>

            <span class="help-block" id="warning_map"></span>
        </div>
        <div class="clearfix"></div>
        <?
    }


    public function cobaAbsen()
    {

        $guru = new SempoaGuruModel();
        $guru->getByID(57);
        $guru->nama_panggilan = "Mike";
        $guru->guru_first_register = 1;
        $guru->save(1);
        pr($guru);
        die();
        $a = new CronJob();

        $b = $a->getPenjualanKuponByTC('5', 12, 2016);
        pr($b);
        die();
        $date = new DateTime('today');

        $week = $date->format("W");
        $hari = $date->format("w");
        $hlpHari = 'ac_' . $hari;
        $hlpLevel = 'ac_level_' . $hari;
        $id = "18_50";
        //cari dulu, sdh ada d db belum
        $hlp = new RekapAbsenCoach();
        $count = $hlp->searchMuridSdhAbsen($id, $date);
        if ($count > 0) {
            $newRekap = new RekapAbsenCoach();
            $newRekap->getByID($id);
            $newRekap->$hlpHari = $newRekap->$hlpHari + 1;
//            $newRekap->$hlpLevel = $levelmurid . "," . $newRekap->$hlpLevel;

            if ($newRekap->$hlpLevel == "") {
                $newRekap->$hlpLevel = $newRekap->$hlpLevel;
            } else {
                $newRekap->$hlpLevel = 2 . "," . $newRekap->$hlpLevel;
            }
            if ($newRekap->$hlpLevel == "") {
                echo "Kosong";
            }
            else{
                echo "tdk kosong";
            }
            pr($newRekap->$hlpLevel);
            pr($newRekap);
            die();
            $newRekap->save(1);
        }

        pr($newRekap);
    }

    public function testIBDaan(){
        $myorg = AccessRight::getMyOrgID();
        echo $myorg;
        $bln = isset($_GET['bln']) ? addslashes($_GET['bln']) : date("n");
        $thn = isset($_GET['thn']) ? addslashes($_GET['thn']) : date("Y");
        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : AccessRight::getMyOrgID();
        $murid = new MuridModel();
        $arrMurid = $murid->getWhere("(status = 1  OR status = 2) AND murid_tc_id = $tc_id ORDER BY nama_siswa ASC");
        $status = new MuridWeb2Model();
        $arrs = $status->getAll();

        $arrSTatus = array();
        foreach ($arrs as $st) {
            $arrSTatus[$st->id_status_murid] = $st->status;
        }
        $arrBulan = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

        // Kupon
        $kupon = new KuponSatuan();
        $arrkupon = $kupon->getWhere("kupon_owner_id = '$myorg' AND kupon_status = 0 ORDER BY kupon_id ASC");
        $checkKupon = count($arrkupon);
//        $checkKupon = 0;
        $arrSTatus = array("<b>Unpaid</b>", "Paid");
        $t = time();

        ?>

        <section class="content-header">
            <h1>
                <div class="pull-right" style="font-size: 13px;">
                    Bulan :<select id="bulan_<?= $t; ?>">
                        <?
                        foreach ($arrBulan as $bln2) {
                            $sel = "";
                            if ($bln2 == $bln) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $bln2; ?>" <?= $sel; ?>><?= $bln2; ?></option>
                            <?
                        }
                        ?>
                    </select>
                    Tahun :<select id="tahun_<?= $t; ?>">
                        <?
                        for ($x = date("Y") - 2; $x < date("Y") + 2; $x++) {
                            $sel = "";
                            if ($x == $thn) {
                                $sel = "selected";
                            }
                            ?>
                            <option value="<?= $x; ?>" <?= $sel; ?>><?= $x; ?></option>

                            <?
                        }
                        ?>
                        }
                        ?>
                    </select>

                    <button id="submit_bln_<?= $t; ?>">submit</button>
                </div>
                Iuran Bulanan
            </h1>
            <script>
                $('#submit_bln_<?= $t; ?>').click(function () {
                    var bln = $('#bulan_<?= $t; ?>').val();
                    var thn = $('#tahun_<?= $t; ?>').val();
                    var tc_id = '<?= $myorg ?>';
                    openLw('create_operasional_pembayaran_iuran_bulanan_tc', '<?=_SPPATH;?>LaporanWeb/create_operasional_pembayaran_iuran_bulanan_tc'+'?now='+$.now()+'&bln='+bln+ "&thn=" + thn + "&tc_id=" + tc_id, 'fade');
                });
            </script>
        </section>


        <section class="content">
            <div id="summary_holder" style="text-align: left; font-size: 16px;"></div>
            <div class="table-responsive" style="background-color: #FFFFFF; margin-top: 20px;">
                <table class="table table-striped ">
                    <thead>
                    <tr>
                        <th>
                            Nama Murid
                        </th>
                        <th>
                            Level
                        </th>
                        <th>
                            Tanggal
                        </th>
                        <th>
                            Kupon
                        </th>
                        <th>
                            Status
                        </th>

                    </tr>
                    </thead>

                    <tbody id="container_iuran_<?= $t; ?>">
                    <?
                    $sudahbayar = 0; $belumbayar = 0;
                    foreach ($arrMurid as $mk) {

                        $iuranBulanan = new IuranBulanan();
                        $iuranBulanan->getWhereOne("bln_murid_id = '$mk->id_murid' AND bln_mon = $bln AND bln_tahun = $thn AND bln_tc_id=$myorg");
                        ?>

                        <tr id='payment_<?= $iuranBulanan->bln_id; ?>' class="<?if ($iuranBulanan->bln_status) {?>sudahbayar <?}else{?> belumbayar<?}?>">
                            <td><a style="cursor: pointer;"
                                   onclick="back_to_profile_murid('<?= $mk->id_murid; ?>');"><?= $mk->nama_siswa; ?></a>
                            </td>
                            <td><?= Generic::getLevelNameByID($mk->id_level_sekarang); ?></td>
                            <td><?
                                $kuponSatuan = new KuponSatuan();
                                $kuponSatuan->getWhereOne("kupon_id=$iuranBulanan->bln_kupon_id");
                                //                            echo $kuponSatuan->kupon_pemakaian_date;
                                if ($iuranBulanan->bln_status) {
                                    echo $iuranBulanan->bln_date_pembayaran;
                                }

                                ?></td>

                            <td class='kupon'>
                                <?
                                if ($iuranBulanan->bln_status) {
                                    echo $iuranBulanan->bln_kupon_id;
                                    $sudahbayar++;
                                } else {
//                                echo $iuranBulanan->bln_id . " saas";
                                    $belumbayar++;
                                    ?>
                                    <button id='pay_now_<?= $iuranBulanan->bln_id; ?>' class="btn btn-default">Pay Now
                                    </button>
                                    <?
                                }
                                ?>
                            </td>
                            <td><?= $arrSTatus[$iuranBulanan->bln_status]; ?></td>
                        </tr>

                        <script>


                            $('#pay_now_<?= $iuranBulanan->bln_id; ?>').click(function () {
                                openLw('murid_Invoices_<?= $mk->id_murid; ?>', '<?= _SPPATH; ?>MuridWebHelper/murid_invoices?id=<?= $mk->id_murid; ?>', 'fade');
                            })
                        </script>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div id="summary_bayar" style="display: none;">
                <span style="cursor: pointer;" onclick="$('.sudahbayar').show();$('.belumbayar').hide();">Sudah Bayar</span> : <b><?echo $sudahbayar;?></b>
                <br>
                <span style="cursor: pointer;" onclick="$('.sudahbayar').hide();$('.belumbayar').show();">Belum Bayar</span> : <b style="color: red;"><?=$belumbayar;?></b>
            </div>
            <script>
//                $(document).ready(function(){
//                    $('#summary_holder').html($('#summary_bayar').html());
//                });
            </script>
        </section>

        <?
    }
}