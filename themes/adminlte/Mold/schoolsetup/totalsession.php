<style type="text/css">
    .tsMjBig {
        font-size: 25px;
    }

    .tsTable {
        font-size: 17px;
        font-weight: bold;
    }

    .tsMjsmall {
        font-size: small;
    }

    .circleme {
        border-radius: 15px;
        width: 15px;
        height: 15px;
        float: left;
        margin-right: 10px;
        margin-left: 5px;
        margin-top: 5px;
    }
</style>
<h1><?= Lang::t('Total Sessions'); ?>
    <small><?= $ta; ?></small>
</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered" style="background-color: white;">

        <tr>
            <th>
                <?= Lang::t('Teacher'); ?>
            </th>
            <th>
                <?= Lang::t('Subject'); ?>
            </th>
            <th>
                <?= Lang::t('Total'); ?>
            </th>
        </tr>

        <? foreach ($arrGuru as $guru) {
            $color = (isset($guru->guru_color) ? $guru->guru_color : "#ff0000");
            ?>
            <tr>
                <td class="tsTable">
                    <div class="circleme" style="background-color:<?= $color; ?>;"></div>
                    <? Action::getLink($guru, "Schoolsetup"); ?>
                </td>
                <td>
                    <? if (isset($hrPerGuru[$guru->guru_id])) { ?>
                        <div class="mjEinzel">
                            <span class="tsTable"><?= Lang::t('Homeroom'); ?></span>
                            <small><?= $hrPerGuru[$guru->guru_id]->kelas_name; ?></small>
                        </div>
                    <? } ?>
                    <?
                    if (isset($detailMJ[$guru->guru_id])) {
                        foreach ($detailMJ[$guru->guru_id] as $mj) {
                            ?>
                            <div class="mjEinzel">
                                <span class="tsTable"><?= $mj->mp_singkatan; ?></span>
                                <small><?= $mj->kelas_name; ?></small>
                                <span class="tsMjsmall">(<?= $mj->mj_jam; ?>)</span>
                            </div>
                        <? }
                    } ?>
                </td>
                <td>
                    <span class="tsMjBig"><?= $totalGuru[$guru->guru_id]; ?></span>
                </td>
            </tr>
        <? } ?>

    </table>
</div>
<?php
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

