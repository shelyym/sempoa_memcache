<h1><?= $roleObj->getName(); ?></h1>
<div class="col-md-4">
    <? Account::makeFotoIterator($roleObj->foto, "responsive"); ?>

    <h3><?= Lang::t('Gallery'); ?></h3>
    <?
    $roleObj->getGallery($roleObj->account_id);
    ?>

</div>
<div class="col-md-8">
    <div class="table-responsive">
        <h3 style="padding-left: 10px;"><?= Lang::t('Account Details'); ?></h3>
        <table class="table table-striped">
            <tr>
                <td>
                    <?= Lang::t('Username'); ?> :
                </td>
                <td>
                    <?= Account::getMyUsername(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Password'); ?> :
                </td>
                <td>
                    <?= Account::getMyPassword(); ?>
                </td>
            </tr>
        </table>
    </div>
</div><?php
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

