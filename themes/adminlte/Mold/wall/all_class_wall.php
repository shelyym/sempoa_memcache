<h1><?= Lang::t('Classwall'); ?> <?= $kelas->kelas_name; ?>
    <small><?= $ta; ?></small>
</h1>
<? if (!$muridview) { ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?dummy=1";
            Selection::kelasSelector($kelas, $urlOnChange);
            ?>
        </div>
    </div>
<? } ?>
<? Mold::both("wall/class_wall_einzel", $arr); ?>


<?php

//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

