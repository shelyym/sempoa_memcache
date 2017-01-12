<?
//untuk id nya
$totalcolom = 0;
?>
    <style type="text/css">
        .mjGroup {
            text-align: center;
            background-color: #dedede;
        }

        .mjMpName {
            background-color: #efefef;
            font-weight: bold;
        }

        .mjcorner {
            background-color: #ccc;
        }

        .mjsubtotal {
            background-color: #ecf0f1;
        }

        .mjtotal {
            background-color: #dff0d8;
        }

        .mjBigNr {
            font-size: 25px;
        }

        .mjNamaGuru {
            line-height: 25px;
            margin-left: 10px;
        }

    </style>
    <h1><?= Lang::t('lang_h1_tabel_mengajar'); ?>
        <small><?= $ta; ?></small>
    </h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="mjcorner">
                    <?= Lang::t('MP / Kelas'); ?>
                </th>
                <? foreach ($kelas as $kls) { ?>
                    <th class="mjMpName">
                        <? Action::getLink($kls, "Schoolsetup"); ?>
                    </th>
                <? } ?>
            </tr>
            </thead>
            <tbody>
            <tr class="mjhomeroom">
                <td><?= Lang::t('Homeroom'); ?></td>
                <? foreach ($kelas as $num => $kl) {
                    $color = (isset($hrPerKelas[$kl->kelas_name]->guru_color) ? $hrPerKelas[$kl->kelas_name]->guru_color : "#ff0000");
                    $hr_id = $ta . "_" . $kl->kelas_id;
                    ?>
                    <td data-toggle="modal" data-target="#myModal" id="hr_<?= $num; ?>"
                        style="background-color:<?= $color; ?>;"><span
                            class="mjNamaGuru"><?= $hrPerKelas[$kl->kelas_name]->nama_depan; ?></span></td>
                    <script type="text/javascript">
                        $("#hr_<?=$num;?>").click(function () {
                            $('#myModalLabel').empty().append('<?=Lang::t('Homeroom Teacher for ').$kl->kelas_name;?>');
                            $('#myModalBody').load('<?=_SPPATH;?>schoolsetup/tablemengajar?cmd=editHr&hr_id=<?=$hr_id;?>&kelas_id=<?=$kl->kelas_id;?>');
                        });
                    </script>
                <? } ?>
            </tr>
            <? foreach ($sortArrMj as $group => $arrMp) { ?>
                <tr class="mjGroup">
                    <td colspan="<?= (count($kelas) + 1); ?>"><?= $group; ?></td>
                </tr>
                <?
                ksort($arrMp);

                foreach ($arrMp as $mpname => $kelases) {
                    ?>
                    <tr>
                        <td class="mjMpName"><? Action::getLink($arrObjs[$mpname], "Schoolsetup"); ?></td>
                        <?
                        ksort($kelases);
                        foreach ($kelases as $kelasname => $mj) {
                            $load = 0;
                        if (isset($mj)){
                            $load = 1;
                            $color = (isset($mj->guru_color) ? $mj->guru_color : "#ff0000");
                            ?>
                            <td data-toggle="modal" data-target="#myModal" id="tmj_<?= $totalcolom; ?>"
                                style="background-color:<?= $color; ?>;"><span
                                    class="mjBigNr"><?= $mj->mj_jam; ?></span> <span
                                    class="mjNamaGuru"><?= $mj->nama_depan; ?></span></td>
                        <?
                        }else{
                            ?>
                            <td data-toggle="modal" data-target="#myModal" id="tmj_<?= $totalcolom; ?>"></td>
                        <?
                        }

                        //cek needed variable
                        $guru_id = (isset($mj->guru_id) ? $mj->guru_id : '');
                        $mp_id = (isset($mj->mp_obj->mp_id) ? $mj->mp_obj->mp_id : $arrIDs[$mpname]);
                        $kelas_id = (isset($mj->kelas_obj->kelas_id) ? $mj->kelas_obj->kelas_id : $arrIDs[$kelasname]);
                        ?>
                            <script type="text/javascript">
                                $("#tmj_<?=$totalcolom;?>").click(function () {
                                    $('#myModalLabel').empty().append('<?=Lang::t('Insert Teaching Table ').$mpname." ".$kelasname;?>');
                                    $('#myModalBody').load('<?=_SPPATH;?>schoolsetup/tablemengajar?cmd=edit&load=<?=$load;?>&guru_id=<?=$guru_id;?>&mp_id=<?=$mp_id;?>&kelas_id=<?=$kelas_id;?>');
                                });
                            </script>
                            <?
                            $totalcolom++;
                        } ?>
                    </tr>
                <? } ?>
                <tr class="mjsubtotal">
                    <td><?= Lang::t('subtotal'); ?></td>
                    <? foreach ($kelas as $kl) { ?>
                        <td><span class="mjBigNr"><?= $totalPerGroup[$group][$kl->kelas_name]; ?></span></td>
                    <? } ?>
                </tr>
            <? } ?>
            <tr class="mjtotal">
                <td><?= Lang::t('Total'); ?></td>
                <? foreach ($kelas as $kl) { ?>
                    <td><span class="mjBigNr"><?= $totalPerKelas[$kl->kelas_name]; ?></span></td>
                <? } ?>
            </tr>
            </tbody>
        </table>
    </div>
<?php


