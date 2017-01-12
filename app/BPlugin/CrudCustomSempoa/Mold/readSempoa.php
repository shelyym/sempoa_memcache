<?
//pr($arr);
//pr($return);
$obj = new $arr['classname']();

//$activeObj = $obj;

$c = $classname;
$t = time() - 10000000;
//pr($obj);
?>
<div class="content-wrapper2">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>
            <?= Lang::t($classname); ?> <? if($crudObj->btn_extra!=""){?><small><?=$crudObj->btn_extra;?></small><?}?>

        </h1>

    </section>
    <!-- Main content -->
    <section class="content">
        <?
        $t = time();
//        $tc_id = isset($_GET['tc_id']) ? addslashes($_GET['tc_id']) : Generic::getFirstTCID(AccessRight::getMyOrgID());


        $orgType = AccessRight::getMyOrgType();
        if ($orgType != KEY::$TC) {
//            $arrAllTC = Generic::getAllMyTC(AccessRight::getMyOrgID());
//            pr($arrAllTC);
//            $arrGuru = Generic::getAllGuruByTcID($tc_id);
            ?>

<!--            <div>

                <div  class="form-group">
                    <select id = "guruAllTC_<?= $t; ?>" class="form-control">
                        <?
                        foreach ($arrAllTC as $key => $val) {
//                            if ($key == $_GET['id_restaurant']) {
//                                echo "<option selected='selected' value='" . $key . "'>" . $val . "</option>";
//                            } else {

                            echo "<option value='" . $key . "'>" . $val . "</option>";
//                            }
                        }
                        ?>
                    </select>

                </div>
            </div>-->
            <script type="text/javascript">
                $('#guruAllTC_<?= $t; ?>').change(function () {

                    var tc_id = $('#guruAllTC_<?= $t; ?>').val();
                    //                console.log("id_restaurant: " + id_restaurant);
                    //
                    openLw("read_status_guru_ibo", "<?= _SPPATH; ?>GuruWeb4/read_status_guru_ibo?tc_id=" + tc_id, "fade");
                });
            </script>
            <?
        }
        ?>


        <div class="row hidden-print" style="margin-bottom: 10px;">
            <? if ($obj->crud_setting['search']) CrudCustomSempoa::searchBox($arr, $webClass, $callFkt); ?>
            <div class="col-md-8 col-xs-12">
                <div class="btn-group">
                    <? if ($obj->crud_setting['viewall']) CrudCustomSempoa::viewAll($arr, $webClass, $callFkt); ?>
                    <? if ($obj->crud_setting['export']) CrudCustomSempoa::exportExcel($arr, $webClass, $callFkt); ?>
                    <? if ($obj->crud_setting['import']) CrudCustomSempoa::importExcel($arr, $webClass, $callFkt); ?>
                    <? if ($obj->crud_setting['add']) CrudCustomSempoa::AddButton($arr, $webClass, $callFkt); ?>
                    <? if ($obj->crud_setting['toggle']) CrudCustomSempoa::filter($arr, $webClass, $t, $callFkt); ?>
                    <? if ($obj->crud_setting['webservice']) CrudCustomSempoa::listWebService($arr, $webClass, $callFkt); ?>
                </div>
            </div>
            <? if ($obj->crud_setting['toggle']) CrudCustomSempoa::filterButton($arr, $webClass, $t, $callFkt, $activeObj); ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover crud-table  form-group" style="background-color: white;">

                <tr>
                    <?
                    if (isset($objs[0]))
                        foreach ($objs[0] as $colom => $isi) {
                            if ($colom == "removeAutoCrudClick")
                                continue;
                            if (in_array($colom, $activeObj->hideColoums))
                                continue;
                            ?>
                            <th id="sort_<?= $colom; ?><?= $t; ?>" class="clickable"><?= Lang::t($colom); ?></th>

                            <?
                            CrudCustomSempoa::sortBy($arr, $webClass, $callFkt, "sort_" . $colom . $t, $colom);
                        }
                    ?>
                </tr>

                <? foreach ($objs as $num => $obj) { ?>
                    <tr id="<?= $c; ?>_<?= $obj->{$main_id}; ?>">

                        <?
                        foreach ($obj as $colom => $isi) {

                            if ($colom == "removeAutoCrudClick")
                                continue;
                            if (in_array($colom, $activeObj->hideColoums))
                                continue;
                            ?>
                            <td id="<?= $colom; ?>_<?= $obj->{$main_id}; ?>" <? if (!in_array($colom, $activeObj->removeAutoCrudClick)) { ?>class="clickable"<? } ?>>
                                <?= stripslashes($isi); ?>
                            </td>
                            <?
                            if (!in_array($colom, $activeObj->removeAutoCrudClick)) {
//                        if($crudObj->ar_edit) {
                                $url = _SPPATH . $webClass . "/" . $callFkt;
                                if ($crudObj->ar_edit_url != "") {
                                    $url = $crudObj->ar_edit_url; //jangan pakai tanda tanya
                                }
                                ?>
                            <script type="text/javascript">
                                $("#<?= $colom; ?>_<?= $obj->{$main_id}; ?>").click(function () {
                                    openLw('<?= $webClass; ?>View', '<?= $url; ?>?cmd=edit&id=<?= $obj->{$main_id}; ?>&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');
                                });
                            </script>
                            <?
//                        }
                        }
                        ?>
                    <? } ?>
                    </tr>


                <? } ?>

            </table>
        </div>
        <div class="row hidden-print">
            <div class="col-md-12">
                <? CrudCustomSempoa::pagination($arr, $webClass, $callFkt); ?>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>



<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

