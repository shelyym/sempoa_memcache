<h1><?= Lang::t('MyJadwalMP'); ?>
    <small> <?= TahunAjaran::fgetDay($jadwalMatapelajaran->hari); ?></small>
</h1>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-3 col-xs-12">
        <?
        //select on mon
        $urlOnChange = _SPPATH . $webClass . "/" . $method . "?klsid=" . $kls->kelas_id;
        Selection::subjectSelector($mp, $urlOnChange);
        ?>
    </div>

</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            <th style="width: 20%;">Hour</th>
            <th style="width: 50%;"><?= TahunAjaran::fgetDay($jadwalMatapelajaran->hari); ?></th>

        </tr>
        <?foreach ($jadwalMatapelajaran->matapelajaran as $slotvalue => $slots) {
            ?>
            <tr>
                <td><?= $slotvalue; ?></td>
                <?
                foreach ($slots as $mp) {
                    ?><?
                    if (($mp->jw_mulai . " - " . $mp->jw_end) == $slotvalue) {
                        ?><td style="background-color:<?= $mp->guru->guru_color; ?> "><?
                        echo $mp->namaMatapelajaran;
                    }
                    ?></td><?
                }
                ?>
            </tr>
        <? } ?>
    </table>
</div>
<?