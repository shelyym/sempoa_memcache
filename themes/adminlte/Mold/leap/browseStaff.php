<h1><?= Lang::t('Teachers'); ?></h1>
<?php
foreach ($arrGuru as $murid) {
    Mold::both("leap/printEinzelAsBadge", array ("murid" => $murid));
}
?>
<div style="clear: both; margin: 10px;">&nbsp;</div>
<h1><?= Lang::t('Administratives'); ?></h1>
<?php
foreach ($arrTU as $murid) {
    Mold::both("leap/printEinzelAsBadge", array ("murid" => $murid));
}
?>
<div style="clear: both;margin: 10px;">&nbsp;</div>
<h1><?= Lang::t('Supervisors'); ?></h1>
<?php
foreach ($arrSupervisor as $murid) {
    Mold::both("leap/printEinzelAsBadge", array ("murid" => $murid));
}
?>
<div style="clear: both;margin: 10px;">&nbsp;</div>
<?
//pr($arr);


//pr($arr);

