<?
$selected_guru = (isset($hr->guru_id) ? $hr->guru_id : "");
?>
    <form class="form-inline" role="form" method="post"
          action="<?= _SPPATH; ?><?= $webClass; ?>/<?= $method; ?>?cmd=editSubmitHr&hrid=<?= $hrid; ?>"
          id="formajar_<?= $loadid; ?>">
        <input type="hidden" name="hrid" value="<?= $hrid; ?>">

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
//pr($hr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

