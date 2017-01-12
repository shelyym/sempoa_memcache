<h1><?= Lang::t('Grade'); ?>
    <small><?= Lang::t('Subject'); ?>: <?= $mp->mp_name; ?></small>
</h1>
<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-3 col-xs-12">
        <?
        //select on mon
        $urlOnChange = _SPPATH . $webClass . "/" . $method . "?mp_id=" . $mp->mp_id;
        //        echo $urlOnChange;
        Selection::subjectSelector($mp, $urlOnChange);
        $t = time();
        ?>
    </div>

</div>

</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <td><?= Lang::t('Name'); ?></td>
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
                <td id="nama_<?= str_replace(" ", "", str_replace('.', '', $nama_murid)); ?>"><?= $nama_murid; ?></td><?
                foreach ($obj as $tgl_ujian => $obj2) {
                    foreach ($obj2 as $value) {
                        ?>
                        <td id="nilaiMurid_"<?= $t;
                        s ?>>
                            <?= $nilai->arrayNilai[$nama_murid][$tgl_ujian][0]->nilai;
                            ?>
                        </td>
                    <?
                    }
                }
                ?>
            </tr>
            <script>
                $("#nama_<?=str_replace(" ","",str_replace('.', '', $nama_murid));?>").click(function () {

                    openLw("graph_<?=$t . str_replace(" ","",str_replace('.', '', $nama_murid)) ."_". $mp->mp_id;?>", "<?=_SPPATH.$webClass."/";?>viewMyNilaiGraph?matapelajaranID=<?=$mp->mp_id ."&";?>ta=<?= $nilai->tahunAjaran ."&";?>murid_id=<?=$nilai->arrayNilai[$nama_murid][$tgl_ujian][0]->murid_id;?>", "fade");

                });
            </script>
        <?
        }?>

        </tbody>

    </table>
</div>
<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

