<h1><?= Lang::t('JadwalMP'); ?></h1>
<? if (Account::getMyRole() == "supervisor" || Account::getMyRole() == "tatausaha" || Account::getMyRole() == "guru") { ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?klsid=" . $kls->kelas_id;
            Selection::kelasSelector($kls, $urlOnChange);
            ?>
        </div>
    </div>
<? } ?>
<?
//pr($jadwalMatapelajaran);
//anzahl schultag
$anzahlSchulTag = $jadwalMatapelajaran->anzahlSchultag;
//kelastingkatan
$arrKelas = $jadwalMatapelajaran->arrayVonKelastingkatan;
/*
foreach($arrKelas as $kelas){
    if($kelas->kelas_tingkatan == $kls->kelas_id){
       $kelasName =  $kelas->kelas_name;
     }
    }*/
$kelasName = $kls->kelas_name;
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tr>
            <th><?= Lang::t('Hour'); ?></th>
            <? for ($day = 1; $day <= $anzahlSchulTag; $day++) {
                ?>
                <th><?= TahunAjaran::fgetDay($day); ?></th>
            <? } ?>
        </tr>

        <?
        $slotID = 0;
        foreach ($jadwalMatapelajaran->matapelajaran as $slotvalue => $slots) {

            //pr($slots);
            ?>
            <tr>
                <td>
                    <div style="width: 100px;"><?= $slotvalue; ?></div>
                </td>
                <? for ($day = 1; $day <= $anzahlSchulTag; $day++) {
                    ?>
                    <td id="kls<?= $kls->kelas_id; ?>_<?= $slotID; ?>_<?= $day; ?>"
                        <? if (Account::getMyRole() == "supervisor" || Account::getMyRole() == "tatausaha"){ ?>ondblclick="selectMPNoRestriction('<?= $slotID; ?>','<?= $day; ?>','<?= $slots[$day][$kelasName][0]->jw_mp_id; ?>','<?= $slots[$day][$kelasName][0]->jw_type; ?>');" <? } ?>><?= $slots[$day][$kelasName][0]->namaMatapelajaran; ?></td>
                <? } ?>
            </tr>
            <?
            $slotID++;
        } ?>
    </table>
</div>
<? if (Account::getMyRole() == "supervisor" || Account::getMyRole() == "tatausaha") { ?>
    <script>
        function selectMPNoRestriction(slotID, day, mp_id, mp_type) {
            //alert(slotID+" "+day);
            //$('#kls<?=$kls->kelas_id;?>_'+slotID+'_'+day).load('<?=_SPPATH;?>index');

            $('#kls<?=$kls->kelas_id;?>_' + slotID + '_' + day).load('<?=_SPPATH;?>StudentSetup/getJadwalMPSelector?kls_id=<?=$kls->kelas_id;?>&mp_id=' + mp_id + '&mp_type=' + mp_type + '&slotID=' + slotID + '&day=' + day);
            $('#kls<?=$kls->kelas_id;?>_' + slotID + '_' + day).click(function () {
            });
        }
    </script>
<? } ?>
<?
//pr($arr);
?>