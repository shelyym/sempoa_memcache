<div class="row widgethead">
    <div class="col-md-12">
        <h3><?= Lang::t('Homeroom'); ?></h3>
    </div>
</div>
<hr/>
<div class="row" style="margin-top: 10px;">
    <div onclick="openProfile('<?= $guru->account_id; ?>');" class="col-lg-3 col-md-3 col-sm-5 col-xs-5">
        <? Account::makeFotoIterator($guru->foto, "responsive"); ?>
    </div>
    <div class="col-md-8 col-lg-8 col-sm-7 col-xs-7" style="margin-left: 0; padding-left: 0;">
        <div onclick="openProfile('<?= $guru->account_id; ?>');" class="namahomeroom"
             style="font-size: 17px; font-weight: bold;"><?= $guru->getName(); ?></div>
        <small><?= Lang::t('Homeroom'); ?> <?= $kelas->kelas_name; ?></small>
    </div>
</div>
<?php
//pr($guru);
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

