<?
//pr($arr);
$c = $classname;
$obj = $id;
$_SESSION['target_id']['classname'] = $classname;
$_SESSION['target_id']['obj'] = $obj;

?>
    <div id="resultme"></div>
    <form role="form" method="<?= $method; ?>" action="<?= _SPPATH . $action; ?>" id="<?= $formID; ?>">
        <?
        foreach ($formColoms as $inputID => $input) {
            if ($input instanceof \Leap\View\InputText) {
                if ($input->type == "hidden") {
                    $input->p();
                    continue;
                }
            }
            ?>
            <div id="formgroup_<?= $input->id; ?>" class="form-group">
                <label for="<?= $inputID; ?>" class="col-sm-2 control-label"><?= Lang::t($inputID); ?></label>

                <div class="col-sm-10">
                    <?= $input->p(); ?>
                    <span class="help-block" id="warning_<?= $input->id; ?>"></span>
                </div>
            </div>
        <? } ?>
        <div class="form-group">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default"><?= Lang::t('submit'); ?></button>
                <? if ($load) { ?>
                    <button type="button" id="delete_button_<?= $formID; ?>"
                            class="btn btn-default"><?= Lang::t('delete'); ?></button>
                    <?
                    $ajax->delete("delete_button_" . $formID);
                }?>
            </div>
        </div>
    </form>
    <div class="clearfix visible-xs-block"></div>
<?php
$ajax->submit();
//Ajax::submit($arr);

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

