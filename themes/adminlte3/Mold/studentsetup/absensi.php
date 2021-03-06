<?
$cale = new Calendar();
$arrCl = $cale->arrCl;

$abs = new Absensi();
$arrMacemAbsens = $abs->arrMacamAbsen;


$limithari = 5;
if (Schoolsetting::apaSabtuMasuk()) {
    $limithari = 6;
}
if (Schoolsetting::apaMingguMasuk()) {
    $limithari = 7;
}
?>
    <h1><?= Lang::t('Attendance'); ?> <?= $kls->kelas_name; ?>
        <small><?= $monname; ?> <?= $year; ?></small>
    </h1>

    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <?
            //select on mon
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?klsid=" . $kls->kelas_id;
            Selection::monthSelectorInTA($mon, $ta, $urlOnChange);
            ?>
        </div>
        <div class="col-md-3 col-xs-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?mon=" . $mon . "&year=" . $year;
            Selection::kelasSelector($kls, $urlOnChange);
            ?>
        </div>
    </div>
    <style>
        .absensiOK {
            background-color: #c1e2b3;
        }

        .holidayOK {
            background-color: #cccccc;
        }

        .absenlegend {
            font-size: 20px;
        }
    </style>
    <div class="row" style="margin-bottom: 10px;">
        <?
        foreach ($arrMacemAbsens as $angka => $value) {
            echo "<div class='col-md-2 col-xs-4 col-sm-3 absenlegend'>" . substr($value, 0,
                    1) . " = " . $value . "</div>";
        }?>
    </div>
<?
$nrHoliday = 0;
$nrWeekend = 0;
for ($i = 1; $i <= $numDays; $i++) {
    $ymd = date("Y-m-d", mktime(0, 0, 0, $mon, $i, $year));
    $tandaholiday = "";
    $holtitle = "";
    if (isset($calendar[$ymd])) {
        if (count($calendar[$ymd] > 0)) {
            foreach ($calendar[$ymd] as $hol) {
                if ($hol->cal_type == "holiday") {
                    $nrHoliday++;
                }
            }
        }
    }
    $jenishari = date("N", mktime(0, 0, 0, $mon, $i, $year));
    if ($jenishari > $limithari) {
        $nrWeekend++;
    }
}
?>
    <div class="row" style="margin-bottom: 10px;">
        <div class='col-md-2 col-xs-4 col-sm-3 absenlegend' id="holidaycontainer"><?= Lang::t('Holiday'); ?> : <b
                id="nrHoliday"><?= $nrHoliday; ?></b></div>
        <div class='col-md-4 col-xs-6 col-sm-6 absenlegend' id="weekendcontainer"><?= Lang::t('Weekend'); ?> : <b
                id="nrWeekend"><?= $nrWeekend; ?></b></div>
    </div>
    <style>
        .absennama {
            font-size: 15px;
            font-weight: bold;
        }

        .absenmasuk {
            background-color: #c1e2b3;
        }

        .absenabsen {
            background-color: #dFb5b4;
        }

        #absentable b {
            font-size: 15px;
        }

        .adaholiday {
            background-color: #e1edf7;
        }

        .adaevent {
            background-color: #f7edad;
        }

    </style>
    <div class="table-responsive">
        <table id="absentable" class="table table-bordered">
            <? foreach ($objs as $murid) {
                Mold::both("studentsetup/makeEinzelAbsen",
                    array ("murid"     => $murid, "calendar" => $calendar, "numDays" => $numDays, "mon" => $mon,
                           "year"      => $year, "arrMacemAbsens" => $arrMacemAbsens, "arrCl" => $arrCl,
                           "limithari" => $limithari, "muridview" => 0));
            } ?>
        </table>
    </div>
<?php
//echo __FILE__;
//pr($arr);
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

