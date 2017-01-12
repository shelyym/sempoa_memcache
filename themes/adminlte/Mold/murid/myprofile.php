<h1><?= $murid->getName(); ?></h1>
<div class="col-md-4">
    <? Account::makeFotoIterator($murid->foto, "responsive"); ?>

    <h3><?= Lang::t('Gallery'); ?></h3>
    <?
    //pr($murid);
    $murid->getGallery($murid->account_id);
    ?>
</div>
<div class="col-md-8">
    <div class="table-responsive">
        <h3 style="padding-left: 10px;"><?= Lang::t('Personal Details'); ?></h3>
        <table class="table table-striped">
            <tr>
                <td>
                    <?= Lang::t('ID'); ?> :
                </td>
                <td>
                    <?= $murid->nomor_induk; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Name'); ?> :
                </td>
                <td>
                    <?= $murid->nama_depan; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Birthday'); ?> :
                </td>
                <td>
                    <?= date('l jS \of F Y', strtotime($murid->tgllahir)); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Birthplace'); ?> :
                </td>
                <td>
                    <?= $murid->tmplahir; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Address'); ?> :
                </td>
                <td>
                    <?= $murid->alamat; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Phone'); ?> :
                </td>
                <td>
                    <?= $murid->telp; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Religion'); ?> :
                </td>
                <td>
                    <?= $murid->agama; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t("Father's Name"); ?> :
                </td>
                <td>
                    <?= $murid->namayah; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t("Mother's Name"); ?> :
                </td>
                <td>
                    <?= $murid->namaibu; ?>
                </td>
            </tr>
        </table>


        <h3 style="padding-left: 10px;"><?= Lang::t('Class Details'); ?></h3>
        <table class="table table-striped">
            <tr>
                <td>
                    <?= Lang::t('School Level'); ?> :
                </td>
                <td>
                    <?= $murid->murid_tingkatan; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= Lang::t('Classname'); ?> :
                </td>
                <td>
                    <?= $kelas->kelas_name; ?>
                </td>
            </tr>
        </table>

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

