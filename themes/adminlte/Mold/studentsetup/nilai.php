<?
//pr($nilai);
?>

    <h1><?= Lang::t('Grade'); ?> <?= $kls->kelas_name; ?>
        <small><?= Lang::t('Subject'); ?>: <?= $mp->mp_name; ?></small>
    </h1>
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-3 col-xs-12">
            <?
            //select on mon
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?klsid=" . $kls->kelas_id;
            Selection::subjectSelector($mp, $urlOnChange);
            ?>
        </div>
        <div class="col-md-3 col-xs-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?mp_id=" . $mp->mp_id;
            Selection::kelasSelector($kls, $urlOnChange);
            $t = time();
            ?>
        </div>
    </div>
    <div class="table-responsive">


        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <td style="width:20%;"><?= Lang::t('Name'); ?></td>
                <td>Graph</td>
                <?
                foreach ($nilai->arrayTanggalUjian as $tgl_ulangan) {
                    ?>
                    <td><?= date("d-m-Y", strtotime($tgl_ulangan->tgl_ujian)); ?></td>
                <?
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?
            foreach ($nilai->arrayNilai as $nama_murid => $obj) {
                ?>
                <tr>
                    <td id="nama_<?= str_replace(" ", "",
                        str_replace('.', '', $nama_murid)); ?>"><?= $nama_murid; ?></td>
                    <td id="graph_<?= str_replace(" ", "", str_replace('.', '', $nama_murid)); ?>"><i
                            class="glyphicon glyphicon-asterisk"></i></td>
                    <?
                    foreach ($obj as $tgl_ujian => $obj2) {
                        foreach ($obj2 as $value) {
                            ?>
                            <td id="nilai_<?= str_replace('.', '', $nama_murid) . "_" . $tgl_ujian; ?>">
                                <?= $nilai->arrayNilai[$nama_murid][$tgl_ujian][0]->nilai;
                                ?>
                            </td>
                        <?
                        }
                        ?>
                    <?
                    }
                    ?>
                </tr>
                <script>
                    //            $("#nama_<?=str_replace(" ","",str_replace('.', '', $nama_murid));?>").click(function(){
                    //
                    //               alert("<?=str_replace(" ","",str_replace('.', '', $nama_murid));?>");
                    //
                    //            });
                    //
                    $("#graph_<?=str_replace(" ","",str_replace('.', '', $nama_murid));?>").click(function () {
                        openLw("graph_<?=str_replace(" ","",str_replace('.', '', $nama_murid)) ."_". $mp->mp_id;?>", "<?=_SPPATH.$webClass."/";?>viewNilaiGraph?matapelajaranID=<?=$mp->mp_id ."&";?>ta=<?= $nilai->tahunAjaran ."&";?>murid_id=<?=$nilai->arrayNilai[$nama_murid][$tgl_ujian][0]->murid_id;?>", "fade");

                    });
                </script>
            <?

            }?>
            </tbody>
        </table>
    </div>
    <script>
        $("#insertTanggal_<?=$t;?>").click(function () {
            openLw("Insertnilai<?=$mp->mp_id;?>", "<?=_SPPATH.$webClass."/";?>insertNilai?mp_id=<?=$mp->mp_id;?>", "fade");
        });
    </script>

<?php


