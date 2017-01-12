<div class="col-md-2 col-lg-2 col-sm-4 col-xs-6" onclick="openProfile('<?= $murid->account_id; ?>');">
    <? Account::makeFotoIterator($murid->foto, "responsive"); ?>
    <div
        style="text-align: center; margin-bottom: 20px; margin-top: 5px; font-weight: bold;"><?= $murid->getName(); ?></div>
</div>
<?php
//pr($murid);


