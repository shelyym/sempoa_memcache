<? $t = time(); ?>
    <h1><?= $acc->getName(); ?></h1>
    <div class="col-md-4">
        <? Account::makeFotoIterator($acc->admin_foto, "responsive"); ?>
        <div style="padding-top: 10px;">
            <button id="inboxComposeProfile<?= $acc->admin_id; ?>" data-toggle="modal" data-target="#myModal"
                    type="button" class="btn btn-primary btn-block"><?= Lang::t('Send Message'); ?></button>
            <script type="text/javascript">
                $('#inboxComposeProfile<?=$acc->admin_id;?>').click(function (event) {
                    event.preventDefault();
                    $('#myModalLabel').empty().append('<?=Lang::t('Compose Message');?>');
                    $('#myModalBody').load('<?=_SPPATH;?>inboxweb/composeByID?acc_id=<?=$acc->admin_id;?>');
                });
            </script>
            <? if (Account::getMyRole() != "murid") { ?>
                <button style="margin-top:5px;" id="Gallery<?= $acc->admin_id; ?>" type="button"
                        class="btn btn-primary btn-block"><?= Lang::t('Upload Photos'); ?></button>
                <script>
                    $('#Gallery<?=$acc->admin_id;?>').click(function () {
                        openLw('ViewGallery<?=$acc->admin_id;?>', '<?=_SPPATH;?>Muridweb/sendGallery?acc_id=<?=$acc->admin_id;?>', 'fade');
                    });
                </script>
            <? } ?>
        </div>
    </div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-12">
            <? //pr($roleObj);?>
        </div>
    </div>
</div><?php
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

