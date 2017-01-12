<h1><?= $murid->getName(); ?></h1>
<div class="col-md-4">
    <? Account::makeFotoIterator($murid->foto, "responsive"); ?>
    <div style="padding-top: 10px;">
        <button type="button" class="btn btn-primary btn-block"><?= Lang::t('Send Message'); ?></button>
    </div>
</div>
<div class="col-md-8">
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
</div>
<?php
//pr($murid);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

