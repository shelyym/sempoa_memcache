<?
//pr($arr); 
//pr($return);
$obj = new $arr['classname']();
//pr($obj);
$activeObj = $obj;

$c = $classname;
$t = time() - 10000000;
?>
<h1><?= Lang::t($classname); ?></h1>
<div class="row hidden-print" style="margin-bottom: 10px;">
    <? if($obj->crud_setting['search'])Crud::searchBox($arr, $webClass); ?>
    <div class="col-md-8 col-xs-12">
        <div class="btn-group">
            <? if($obj->crud_setting['viewall'])Crud::viewAll($arr, $webClass); ?>
            <? if($obj->crud_setting['export'])Crud::exportExcel($arr, $webClass); ?>
            <? if($obj->crud_setting['import'])Crud::importExcel($arr, $webClass); ?>
            <? if($obj->crud_setting['add'])Crud::AddButton($arr, $webClass); ?>
            <? if($obj->crud_setting['toggle'])Crud::filter($arr, $webClass,$t); ?>
            <? if($obj->crud_setting['webservice'])Crud::listWebService($arr, $webClass); ?>
        </div>
    </div>
    <? if($obj->crud_setting['toggle'])Crud::filterButton($arr, $webClass,$t); ?>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover crud-table" style="background-color: white;">

        <tr>
            <? 
            if(isset($objs[0]))
            foreach ($objs[0] as $colom => $isi) {
                if($colom == "removeAutoCrudClick")continue;
                if(in_array($colom,$activeObj->hideColoums))continue;
                ?>
                <th id="sort_<?= $colom; ?><?= $t; ?>"><?= Lang::t($colom); ?></th>

                <?
                Crud::sortBy($arr, $webClass, "sort_" . $colom . $t, $colom);
            }
            ?>
        </tr>

        <? foreach ($objs as $num => $obj) { ?>
            <tr id="<?= $c; ?>_<?= $obj->{$main_id}; ?>">

                <? foreach ($obj as $colom => $isi) {
                    if($colom == "removeAutoCrudClick")continue;
                    if(in_array($colom,$activeObj->hideColoums))continue;
                    ?>
                    <td id="<?= $colom; ?>_<?= $obj->{$main_id}; ?>">
                        <?= stripslashes($isi); ?>
                    </td>
                    <? if(!in_array($colom,$obj->removeAutoCrudClick)){?>
                    <script type="text/javascript">
                        $("#<?=$colom;?>_<?=$obj->{$main_id};?>").click(function () {
                            openLw('<?=$webClass;?>View', '<?=_SPPATH;?><?=$webClass;?>/<?=$c;?>?cmd=edit&id=<?=$obj->{$main_id};?>&parent_page=' + window.selected_page+'&loadagain='+$.now(), 'fade');
                        });
                    </script>
                    <?}?>
                <? } ?>
            </tr>


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

