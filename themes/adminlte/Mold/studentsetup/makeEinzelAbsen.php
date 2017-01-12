<?
//pr($arr);
// untuk hitung anzahl holiday otomatis
$nrHoliday = 0;
$nrWeekend = 0;
?>
    <tr>
        <td rowspan="2">
            <div class="absennama"><?= $murid->getName(); ?></div>


            <div id='total_absen_<?= $murid->murid_id; ?>'>
                <div class="newrow">
                    <div class="col-md-6" style="text-align:center; background-color: white;">
                        <div style="font-size: 40px; color: green;"><?= $murid->absensi['Masuk']; ?></div>
                        <?= Lang::t("Att"); ?>
                    </div>
                    <div class="col-md-6" style="text-align:center;background-color: white;">
                        <div style="font-size: 40px; color: red;"><?= $murid->absensi['Absen']; ?></div>
                        <?= Lang::t("Abs"); ?>
                    </div>
                </div>
                <div class="absenijin" style="background-color:yellow;"><?= Lang::t('Permission'); ?> :
                    <b><?= $murid->absensi['Ijin']; ?></b></div>
            </div>
        </td>
        <? for ($i = 1; $i <= 15; $i++) {
            //TODO bag ini masi copas harus dibagusin
            // 1 monday 7 sunday
            $jenishari = date("N", mktime(0, 0, 0, $mon, $i, $year));
            $bgcolor = "";
            $locked = "";
            if ($jenishari > $limithari) {
                $bgcolor = "background-color:#faf2cc;";
                $nrWeekend++;
                $locked = 4;
            }
            //cari di data absen
            $selected = "";
            $arrAbsensi = array ();

            if (isset($murid->absensi['hari'])) {
                $arrAbsensi = $murid->absensi['hari'];
            }
            //selected spy bisa atur select dibawah
            if (isset($arrAbsensi[$i])) {
                $selected = $arrAbsensi[$i];
            }


            //cari apakah ada event/haribesar
            $ymd = date("Y-m-d", mktime(0, 0, 0, $mon, $i, $year));
            $tandaholiday = "";
            $holtitle = "";
            if (isset($calendar[$ymd])) {
                if (count($calendar[$ymd] > 0)) {
                    foreach ($calendar[$ymd] as $hol) {
                        if ($hol->cal_type == "holiday") {
                            $tandaholiday = "adaholiday";
                            $holtitle = $hol->cal_name . " " . date("j M",
                                    strtotime($hol->cal_mulai)) . "-" . date("j M", strtotime($hol->cal_akhir));
                            $locked = 2;
                            $nrHoliday++;
                        }
                        if ($hol->cal_type != "holiday") {
                            $tandaholiday = "adaevent";
                            $holtitle = $hol->cal_name . " " . date("j M",
                                    strtotime($hol->cal_mulai)) . "-" . date("j M", strtotime($hol->cal_akhir));
                        }
                    }
                }
            }

            ?>
            <td class="<?= $tandaholiday; ?>" style="<?= $bgcolor; ?>">
                <span onclick="$('#caltitle<?= $i; ?>').fadeToggle();"><?= $i; ?></span>

                <div id="caltitle<?= $i; ?>" style="display:none;"><?= $holtitle; ?></div>
                <?

                //cek locked
                $readonly = "";
                if ($locked != "") {
                    $readonly = "disabled";
                }
                if ($muridview) {
                    $readonly = "disabled";
                }
                ?>
                <select id="select_<?= $murid->murid_id; ?>_<?= $i; ?>" <?= $readonly; ?>>
                    <option value=""></option>
                    <?
                    foreach ($arrMacemAbsens as $angka => $value) {

                        if ($selected == $angka && $selected != "") {
                            $nowselected = "selected";
                            ?>
                            <script
                                type="text/javascript">$("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('absensiOK');</script>
                        <?
                        } else {
                            $nowselected = "";
                        }
                        //cek locked
                        $readonly = "";
                        if ($locked != "" && $locked == $angka) {
                            $nowselected = "selected";
                            ?>
                            <script
                                type="text/javascript">$("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('holidayOK');</script>
                        <?

                        } else {
                            if ($angka == 2 || $angka == 4) {
                                continue;
                            }
                        }
                        ?>
                        <option value="<?= $angka; ?>" <?= $nowselected; ?> ><?= substr($value, 0, 1); ?></option>
                    <? } ?>
                </select>
                <? if (!$muridview) { ?>
                    <script type="text/javascript">
                        $("#select_<?=$murid->murid_id;?>_<?=$i;?>").change(function () {
                            var slc = $('#select_<?=$murid->murid_id;?>_<?=$i;?>').val();
                            $("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('absensiOK');
                            $('#total_absen_<?=$murid->murid_id;?>').load('<?=_SPPATH;?>StudentSetup/add_absen?murid=<?=$murid->murid_id;?>&mon=<?=$mon;?>&year=<?=$year;?>&day=<?=$i;?>&ta=<?=$ta;?>&absenstat=' + slc);
                        });
                    </script>
                <? } ?>
            </td>
        <? } ?>
    </tr>
<tr>
<? for ($i = 16; $i <= $numDays; $i++) {
    //TODO bag ini masi copas harus dibagusin
    // 1 monday 7 sunday
    $jenishari = date("N", mktime(0, 0, 0, $mon, $i, $year));
    $bgcolor = "";
    $locked = "";
    if ($jenishari > $limithari) {
        $bgcolor = "background-color:#faf2cc;";
        $nrWeekend++;
        $locked = 4;
    }
    //cari di data absen
    $selected = "";
    $arrAbsensi = array ();

    if (isset($murid->absensi['hari'])) {
        $arrAbsensi = $murid->absensi['hari'];
    }
    //selected spy bisa atur select dibawah
    if (isset($arrAbsensi[$i])) {
        $selected = $arrAbsensi[$i];
    }


    //cari apakah ada event/haribesar
    $ymd = date("Y-m-d", mktime(0, 0, 0, $mon, $i, $year));
    $tandaholiday = "";
    $holtitle = "";
    if (isset($calendar[$ymd])) {
        if (count($calendar[$ymd] > 0)) {
            foreach ($calendar[$ymd] as $hol) {
                if ($hol->cal_type == "holiday") {
                    $tandaholiday = "adaholiday";
                    $holtitle = $hol->cal_name . " " . date("j M", strtotime($hol->cal_mulai)) . "-" . date("j M",
                            strtotime($hol->cal_akhir));
                    $locked = 2;
                    $nrHoliday++;
                }
                if ($hol->cal_type != "holiday") {
                    $tandaholiday = "adaevent";
                    $holtitle = $hol->cal_name . " " . date("j M", strtotime($hol->cal_mulai)) . "-" . date("j M",
                            strtotime($hol->cal_akhir));
                }
            }
        }
    }

    ?>
    <td class="<?= $tandaholiday; ?>" style="<?= $bgcolor; ?>">
        <span onclick="$('#caltitle<?= $i; ?>').fadeToggle();"><?= $i; ?></span>

        <div id="caltitle<?= $i; ?>" style="display:none;"><?= $holtitle; ?></div>
        <?

        //cek locked
        $readonly = "";
        if ($locked != "") {
            $readonly = "disabled";
        }
        if ($muridview) {
            $readonly = "disabled";
        }
        ?>
        <select id="select_<?= $murid->murid_id; ?>_<?= $i; ?>" <?= $readonly; ?>>
            <option value=""></option>
            <?
            foreach ($arrMacemAbsens as $angka => $value) {

                if ($selected == $angka && $selected != "") {
                    $nowselected = "selected";
                    ?>
                    <script
                        type="text/javascript">$("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('absensiOK');</script>
                <?
                } else {
                    $nowselected = "";
                }
                //cek locked
                $readonly = "";
                if ($locked != "" && $locked == $angka) {
                    $nowselected = "selected";
                    ?>
                    <script
                        type="text/javascript">$("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('holidayOK');</script>
                <?

                } else {
                    if ($angka == 2 || $angka == 4) {
                        continue;
                    }
                }
                ?>
                <option value="<?= $angka; ?>" <?= $nowselected; ?> ><?= substr($value, 0, 1); ?></option>
            <? } ?>
        </select>
        <? if (!$muridview) { ?>
            <script type="text/javascript">
                $("#select_<?=$murid->murid_id;?>_<?=$i;?>").change(function () {
                    var slc = $('#select_<?=$murid->murid_id;?>_<?=$i;?>').val();
                    $("#select_<?=$murid->murid_id;?>_<?=$i;?>").addClass('absensiOK');
                    $('#total_absen_<?=$murid->murid_id;?>').load('<?=_SPPATH;?>StudentSetup/add_absen?murid=<?=$murid->murid_id;?>&mon=<?=$mon;?>&year=<?=$year;?>&day=<?=$i;?>&ta=<?=$ta;?>&absenstat=' + slc);
                });
            </script>
        <? } ?>
    </td>
<? } ?>
</tr><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

