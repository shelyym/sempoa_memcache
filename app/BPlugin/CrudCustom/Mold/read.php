<?
//pr($arr);
//pr($return);
$obj = new $arr['classname']();

//$activeObj = $obj;

$c = $classname;
$t = time() - 10000000;

?>
    <div class="content-wrapper2">
    <!-- Content Header (Page header) -->
    <section class="content-header">


    <h1>
        <?= Lang::t($classname); ?> <? if($crudObj->btn_extra!=""){?><small><?=$crudObj->btn_extra;?></small><?}?>
        <small style="color:#888888;font-size: 18px !important; font-weight: normal;">found <?=$total_item;?> results</small>
    </h1>

        <? if($crudObj->filter_extra=="status_murid"){
            $myOrgType = AccessRight::getMyOrgType();
            if($myOrgType == "tc"){$cname = "MuridWeb";$fkname = "read_murid_tc";$lid = "read_murid_tc";}
            if($myOrgType == "ibo"){$cname = "MuridWebHelper";$fkname = "read_murid_tc_ibo";$lid = "get_murid_ibo";}
            ?>
    <div style="margin-top: 30px;">
            <div class="col-md-1" style=" padding-right: 0px; line-height: 34px;">
            Status: &nbsp;
            </div>
            <div class="col-md-2" style="padding-left: 0px; padding-right: 0px;">
            <select class="form-control"  id="pilih_status_<?= $t; ?>">

                <?
                $arrStatusMurid = Generic::getAllStatusMurid();
                $arrStatusMurid[KEY::$STATUSINDEXALL] = KEY::$STATUSALL;

                $status = $_SESSION['filter_status_murid'];
                if($status == "")$status = 99;

                foreach ($arrStatusMurid as $key => $val) {
                    if ($key == $status) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }

                    ?>
                    <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                <?
                }
                ?>
            </select>
            </div>
            <div class="col-md-2" style="padding-left: 0px;">
            <button class="btn btn-default" id="submit_status_<?= $t; ?>">submit</button></div>
            <div class="clearfix"></div>
            <script>
                $('#submit_status_<?= $t; ?>').click(function () {
                    var status = $('#pilih_status_<?= $t; ?>').val();
                    openLw('<?=$lid;?>', '<?=_SPPATH;?><?=$cname;?>/<?=$fkname;?>?status_murid='+status, 'fade');
                    activkanMenuKiri('<?=$lid;?>');
//                $('#content_load_murid_<?//=$t;?>//').load('<?//= _SPPATH; ?>//MuridWebHelper/read_murid_tc_page?status=' + status, function () {
//
//                }, 'json');
                });

            </script>
    </div>
        <?}?>
        <? if($crudObj->filter_extra=="status_guru"){

            $myOrgType = AccessRight::getMyOrgType();
            if($myOrgType == "tc"){$cname = "GuruWeb2";$fkname = "read_guru_tc";$lid = "read_guru_tc";}
            if($myOrgType == "ibo"){$cname = "GuruWebHelper";$fkname = "guru_crud_per_tc";$lid = "guru_tc_ibo";}

            ?>
            <div style="margin-top: 30px;">
                <div class="col-md-1" style=" padding-right: 0px; line-height: 34px;">
                    Status: &nbsp;
                </div>
                <div class="col-md-2" style="padding-left: 0px; padding-right: 0px;">
                    <select class="form-control"  id="pilih_status_<?= $t; ?>">

                        <?
                        $arrStatusGuru = Generic::getAllStatusGuru();
                        $arrStatusGuru["88"] = KEY::$STATUSALL;

                        $status = $_SESSION['filter_status_guru'];
                        if($status == "")$status = 88;

                        foreach ($arrStatusGuru as $key => $val) {
                            if ($key == $status) {
                                $selected = "selected";
                            } else {
                                $selected = "";
                            }

                            ?>
                            <option value="<?= $key; ?>" <?= $selected; ?>><?= $val; ?></option>
                        <?
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2" style="padding-left: 0px;">
                    <button class="btn btn-default" id="submit_status_<?= $t; ?>">submit</button></div>
                <div class="clearfix"></div>
                <script>
                    $('#submit_status_<?= $t; ?>').click(function () {
                        var status = $('#pilih_status_<?= $t; ?>').val();
                        openLw('<?=$lid;?>', '<?=_SPPATH;?><?=$cname;?>/<?=$fkname;?>?status_guru='+status, 'fade');
                        activkanMenuKiri('<?=$lid;?>');
//                $('#content_load_murid_<?//=$t;?>//').load('<?//= _SPPATH; ?>//MuridWebHelper/read_murid_tc_page?status=' + status, function () {
//
//                }, 'json');
                    });

                </script>
            </div>
        <?}?>
<!--        <ol class="breadcrumb">-->
<!--            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>-->
<!--            <li><a href="#">Tables</a></li>-->
<!--            <li class="active">Data tables</li>-->
<!--        </ol>-->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row hidden-print" style="margin-bottom: 10px;">
            <? if($obj->crud_setting['search'])CrudCustom::searchBox($arr, $webClass, $callFkt); ?>
            <div class="col-md-8 col-xs-12">
                <div class="btn-group">
                    <? if($obj->crud_setting['viewall'])CrudCustom::viewAll($arr, $webClass, $callFkt); ?>
                    <? if($obj->crud_setting['export'])CrudCustom::exportExcel($arr, $webClass, $callFkt); ?>
                    <? if($obj->crud_setting['import'])CrudCustom::importExcel($arr, $webClass, $callFkt); ?>
                    <? if($obj->crud_setting['add'])CrudCustom::AddButton($arr, $webClass, $callFkt); ?>
                    <? if($obj->crud_setting['toggle'])CrudCustom::filter($arr, $webClass,$t,$callFkt); ?>
                    <? if($obj->crud_setting['webservice'])CrudCustom::listWebService($arr, $webClass, $callFkt); ?>

                </div>
            </div>
            <? if($obj->crud_setting['toggle'])CrudCustom::filterButton($arr, $webClass,$t,$callFkt,$activeObj); ?>
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
                            <th id="sort_<?= $colom; ?><?= $t; ?>" class="clickable"><?= Lang::t($colom); ?></th>

                            <?
                            CrudCustom::sortBy($arr, $webClass, $callFkt, "sort_" . $colom . $t, $colom);
                        }
                    ?>
                </tr>

                <? foreach ($objs as $num => $obj) { ?>
                    <tr id="<?= $c; ?>_<?= $obj->{$main_id}; ?>">

                        <? foreach ($obj as $colom => $isi) {

                            if($colom == "removeAutoCrudClick")continue;
                            if(in_array($colom,$activeObj->hideColoums))continue;
                            ?>
                            <td id="<?= $colom; ?>_<?= $obj->{$main_id}; ?>" <? if(!in_array($colom,$activeObj->removeAutoCrudClick)){?>class="clickable"<?}?>>
                                <?= stripslashes($isi); ?>
                            </td>
                        <? if(!in_array($colom,$activeObj->removeAutoCrudClick)){
//                        if($crudObj->ar_edit) {
                        $url = _SPPATH . $webClass . "/" . $callFkt;
                        if ($crudObj->ar_edit_url != "") {
                            $url = $crudObj->ar_edit_url; //jangan pakai tanda tanya
                        }

                        ?>
                            <script type="text/javascript">
                                $("#<?=$colom;?>_<?=$obj->{$main_id};?>").click(function () {
                                    openLw('<?=$webClass;?>View', '<?=$url;?>?cmd=edit&id=<?=$obj->{$main_id};?>&parent_page=' + window.selected_page + '&loadagain=' + $.now(), 'fade');
                                });
                            </script>
                        <?
//                        }
                        }?>
                        <? } ?>
                    </tr>


                <? } ?>

            </table>
        </div>
        <div class="row hidden-print">
            <div class="col-md-12">
                <? CrudCustom::pagination($arr, $webClass, $callFkt); ?>
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

