<?
$dateObj = DateTime::createFromFormat('!m', $mon);
$monthName = $dateObj->format('F');

?>

    <style>
        .widget_cal_element {
            border-bottom: 1px solid #074d72;
            font-size: 15px;
        }

        .lastel {
            border-bottom: 0px solid #074d72;
        }
    </style>
    <div class="row widgethead">
        <div class="col-md-7">
            <h3><?= Lang::t('School Calendar'); ?></h3>
        </div>
        <div class="col-md-5">
            <?
            //select on mon
            $urlOnChange = _SPPATH . "widget/mySchoolCalendarWidget?d=1";
            Selection::monthSelectorInTARefreshID($refreshID, $mon, $ta, $urlOnChange);
            ?>
        </div>
    </div>
    <hr/>
<?
foreach ($bln as $num => $act) {
    $datem = date("j M", strtotime($act->cal_mulai));
    $daten = date("j M", strtotime($act->cal_akhir));
    if ($datem == $daten) {
        $fdate = $datem;
    } else {
        $fdate = $datem . "-" . $daten;
    }
    $last = "";
    if ($num == (count($bln) - 1)) {
        $last = "lastel";
    }

    echo "<div class='widget_cal_element $last'>";
    echo "<small>" . $fdate . "</small><br>";

    echo "<b>" . $act->cal_name . "</b>";
    echo "</div>";
}
//pr($arr);
?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

