<?
$t = time();
?>
    <select class="form-control" id="recep_murid<?= $id; ?><?= $t; ?>">
        <option value=""></option>
        <? foreach ($arrMuridinClass as $m) { ?>
            <option value="<?= $m->admin_id; ?>"><?= $m->getName(); ?> </option>
        <? } ?>
    </select>
<script type="text/javascript">
    $("#recep_murid<?=$id;?><?=$t;?>").change(function () {
        var slc = $("#recep_murid<?=$id;?><?=$t;?>").val();
        $('#kepada').val(slc);
        $('#kepadatext').val(getSelectedText("recep_murid<?=$id;?><?=$t;?>"));
    });
</script><?php



