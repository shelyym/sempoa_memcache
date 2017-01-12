<?
//pr($arr); 
//pr($return);
$c = $classname;
$t = time() - 10000000;
?>
<h1><?= Lang::t($classname); ?></h1>
<div class="row hidden-print" style="margin-bottom: 10px;">
    <? Crud::searchBox($arr, $webClass); ?>
    <div class="col-md-8 col-xs-12">
        <div class="btn-group">
            <? Crud::viewAll($arr, $webClass); ?>
            <? Crud::exportExcel($arr, $webClass); ?>
            <? Crud::AddButton($arr, $webClass); ?>
            <? Crud::filter($arr, $webClass); ?>
        </div>
    </div>
    <? Crud::filterButton($arr, $webClass); ?>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" style="background-color: white;">

        <tr>
            <? 
            if(isset($objs[0]))
            foreach ($objs[0] as $colom => $isi) { ?>
                <th id="sort_<?= $colom; ?><?= $t; ?>"><?= Lang::t($colom); ?></th>

                <?
                Crud::sortBy($arr, $webClass, "sort_" . $colom . $t, $colom);
            }
            ?>
        </tr>

        <? foreach ($objs as $num => $obj) { ?>
            <tr id="<?= $c; ?>_<?= $obj->{$main_id}; ?>">

                <? foreach ($obj as $colom => $isi) { ?>
                    <td>
                        <?= stripslashes($isi); ?>
                    </td>
                <? } ?>
            </tr>

            <script type="text/javascript">
                $("#<?=$c;?>_<?=$obj->{$main_id};?>").click(function () {
                    openLw('<?=$webClass;?>View', '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?cmd=edit&id=<?=$obj->{$main_id};?>&parent_page=' + window.selected_page, 'fade');
                });
            </script>
        <? } ?>

    </table>
</div>
<div class="row hidden-print">
    <div class="col-md-12">
        <? Crud::pagination($arr, $webClass); ?>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

