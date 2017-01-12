<form id="commentform<?= $id; ?>" role="form" class="form" role="form" method="post"
      action="<?= _SPPATH; ?><?= $webClass; ?>/<?= $method; ?>?cmd=add&id=<?= $id; ?>&klsid=<?= $klsid; ?>&typ=<?= $typ; ?>">
    <div class="form-group">
        <textarea class="form-control" name="c_text" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-default"><?= Lang::t('Submit'); ?></button>
</form>
<? Ajax::ModalAjaxForm("commentform" . $id); ?>
<div class="row">
    <? $fotoweb = new Fotoweb();
    $fotoweb->attachment($id, "commentform"); ?>
</div>
<?php


