<?
$selected_jam = (isset($mj->mj_jam) ? $mj->mj_jam : "");
$selected_guru = (isset($mj->mj_guru_id) ? $mj->mj_guru_id : "");
?>
    <form class="form-inline" role="form" method="post"
          action="<?= _SPPATH; ?><?= $webClass; ?>/<?= $method; ?>?cmd=editSubmit&mj_id=<?= $mj_id; ?>"
          id="formajar_<?= $loadid; ?>">
        <input type="hidden" name="mjid" value="<?= $mj_id; ?>">
        <input type="hidden" name="cancel" value="0">

        <div class="form-group">
            <select class="form-control" name="jam" id="jam_mengajar_pilih_guru_<?= $loadid; ?>">
                <? for ($x = 0; $x < 20; $x++) { ?>
                    <option value="<?= $x; ?>" <? if ($selected_jam == $x) {
                        echo "selected";
                    } ?> ><?= $x; ?></option>
                <? } ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="guru_id" id="mengajar_pilih_guru_<?= $loadid; ?>">
                <option value=""></option>
                <?
                foreach ($arrGuru as $num => $ob) {
                    ?>
                    <option value="<?= $ob->guru_id; ?>" <? if ($selected_guru == $ob->guru_id) {
                        echo "selected";
                    } ?> >
                        <?= $ob->getName(); ?>
                    </option>
                <?
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" id="button_formajar_<?= $loadid; ?>"
                    class="btn btn-default"><?= Lang::t('lang_save'); ?></button>
        </div>
    </form>
<? Ajax::ModalAjaxForm("formajar_" . $loadid); ?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

