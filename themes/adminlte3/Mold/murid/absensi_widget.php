<div class="row widgethead">
    <div class="col-md-7">
        <h3><?= Lang::t('Attendance'); ?></h3>
    </div>
    <div class="col-md-5">
        <?
        //select on mon
        $urlOnChange = _SPPATH . "widget/myAbsensiWidget?d=1";
        Selection::monthSelectorInTARefreshID($refreshID, $mon, $ta, $urlOnChange);
        ?>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center;">
        <div style="background-color: white; padding: 10px;">
            <div style="font-size: 40px; color: green;"><?= $absensi['Masuk']; ?></div>
            <div><?= Lang::t("Att"); ?> </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center;">
        <div style="background-color: white; padding: 10px;">
            <div style="font-size: 40px; color: red;"><?= $absensi['Absen']; ?></div>
            <div><?= Lang::t("Abs"); ?> </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center;">
        <div style="background-color: white; padding: 10px;">
            <div style="font-size: 40px; color: yellow;"><?= $absensi['Ijin']; ?></div>
            <div><?= Lang::t("Per"); ?> </div>
        </div>
    </div>
</div>
<?php

//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

