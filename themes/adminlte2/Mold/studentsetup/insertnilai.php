<div class="row" style="margin-bottom: 10px;">
    <div class="col-md-2 col-xs-12">
        <input type="date" name="tglujian" id="tglujian">
    </div>
    <div class="col-md-3 col-xs-12">
        <?
        //select on mon
        $urlOnChange = _SPPATH . $webClass . "/" . $method . "?klsid=" . $kls->kelas_id . "&mp_id=" . $mp->mp_id;
        // echo "URL: " . $urlOnChange;
        Selection::subjectSelector($mp, $urlOnChange);
        ?>
    </div>
    <div class="col-md-3 col-xs-12">
        <?
        //select on kelas
        $urlOnChange = _SPPATH . $webClass . "/" . $method . "?mp_id=" . $mp->mp_id;
        // echo "URL: " . $urlOnChange;
        Selection::kelasSelector($kls, $urlOnChange);
        $t = time();
        ?>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover" id="table_insert_nilai">
        <thead>
        <tr>
            <td><?= Lang::t('Name'); ?></td>
            <td><?= Lang::t('Nilai'); ?></td>
        </tr>
        </thead>
        <tbody>
        <?
        foreach ($murid as $muridName) {
            ?>
            <tr id="row_insert_<?= $muridName->murid_id; ?>">

                <td id="<?= $muridName->murid_id; ?>">
                    <?
                    echo $muridName->admin_nama_depan;
                    ?>
                </td>
                <td><input type="text" name="insertNilai_<?= $muridName->murid_id . $t; ?>"
                           id="insertNilai_<?= $muridName->murid_id . "_" . $t; ?>" value=""
                           placeholder="Insert the grad">
                </td>
                <script>
                    $("#insertNilai_<?=$muridName->murid_id  ."_". $t;?>").change(function () {
                        var slc = $("#insertNilai_<?=$muridName->murid_id  ."_". $t;?>").val();
                        var tgl_ujian = $("#tglujian").val();
                        $("#insertNilai_<?=$muridName->murid_id ."_". $t;?>").load('<?=_SPPATH.$webClass."/".$method;?>?cmd=insert&murid_id=<?=$muridName->murid_id;?>&matapelajaranID=<?=$mp->mp_id;?>&kelas_id=<?=$kls->kelas_id;?>&nilaiUjian=' + slc + '&tglUjian=' + tgl_ujian);
                    });
                </script>
            </tr>
        <?
        }
        ?>
        </tbody>
    </table>
</div>

<?
pr($arr);
?>