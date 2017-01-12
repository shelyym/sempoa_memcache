<h1><?= $kelas->kelas_name; ?>
    <small><?= $ta; ?></small>
</h1>
<?php
//print if user is supervisor, so that he can select which class he want to see
if ($selectKelas) {
    ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?d=1";
            Selection::kelasSelector($kelas, $urlOnChange);
            ?>
        </div>
    </div>
<?
}

// Iterate Students
foreach ($arrMurid as $murid) {
    //Molding design for each Students
    Mold::both("murid/printEinzelAsBadge", array ("murid" => $murid, "nrRow" => $nrRow));
}
?>
<div style="clear: both;"></div>