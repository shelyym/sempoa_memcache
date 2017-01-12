<?
$t = time();
?>
    <h1><?= Lang::t('BagiKelas'); ?> <?= $kls->kelas_name; ?>
        <small><?= $ta; ?></small>
    </h1>
    <style>
        .countmurid {
            padding: 5px;
            margin: 5px;
            font-size: 25px;
        }
    </style>
    <div class="row">
        <div class="col-md-4">

            <? if (count($muridFree) > 0) { ?>
                <style>
                    .muridfree {
                        padding: 5px;
                        margin: 5px;
                    }

                    .muridfree:hover {
                        background-color: #efefef;
                    }

                    .checkboxml {
                        margin-left: 10px;
                    }
                </style>
                <div class="row countmurid">
                    <?= Lang::t('Students w/o Class'); ?> :  <?= count($muridFree); ?>
                </div>
                <form role="form" method="post"
                      action="<?= _SPPATH; ?>StudentSetup/ins_murid_kelas?cmd=move&klsid=<?= $kls->kelas_id; ?>"
                      id="form_ins_murid_kelas" name="form_ins_murid_kelas">
                    <div class="checkbox checkboxml">
                        <label class="muridfree">
                            <input type="checkbox" id="selectall<?= $t; ?>"> <?= Lang::t('lang_select_all'); ?>
                        </label>
                    </div>
                    <script language="JavaScript">
                        $("#selectall<?=$t;?>").click(function selectAll() {
                            checkboxes = document.getElementsByName('chk[]');
                            for (var i in checkboxes)
                                checkboxes[i].checked = this.checked;
                        });
                    </script>
                    <hr>
                    <? foreach ($muridFree as $murid) { ?>
                        <div class="checkbox checkboxml">
                            <label class="muridfree">
                                <input type="checkbox" name="chk[]" id="chk[]"
                                       value="<?= $murid->murid_id; ?>"> <? Action::getLink($murid, "Studentsetup"); ?>
                            </label>
                        </div>

                    <? } ?>
                    <button type="submit"
                            class="btn btn-default"><?= Lang::t('Move Selected To'); ?> <?= $kls->kelas_name; ?></button>
                </form>
                <script type="text/javascript">
                    $('#form_ins_murid_kelas').submit(function (event) {
                        // Stop form from submitting normally
                        event.preventDefault();

                        // Get some values from elements on the page:
                        var $form = $(this),
                            url = $form.attr("action");

                        // Send the data using post
                        var posting = $.post(url, $form.serialize(), function (data) {
                            //alert(data);
                            //console.log( data ); // John

                            if (data.bool) {
                                lwrefresh(window.selected_page);
                            }
                            else {
                                alert(data.err);
                            }
                        }, 'json');

                    });
                </script>
            <?
            } else {
                echo Lang::t("Murid without Class not available");
            }?>
            <? //pr($muridFree);?>
        </div>
        <div class="col-md-8">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-12">
                    <?
                    //select on kelas
                    $urlOnChange = _SPPATH . $webClass . "/" . $method . "?";
                    Selection::kelasSelector($kls, $urlOnChange);
                    ?>
                </div>
            </div>
            <? if (count($muridKelas) > 0) { ?>
                <style type="text/css">
                    .muridkelas {
                        padding: 5px;
                        margin: 5px;
                        border-radius: 4px;
                        background-color: #efefef;
                    }

                </style>
                <div class="row countmurid">
                    <?= Lang::t('Number of Students'); ?> :  <?= count($muridKelas); ?>
                </div>
            <? foreach ($muridKelas as $murid){ ?>
                <div class="row muridkelas">
                    <a href id="del_<?= $murid->mk_id; ?>"><?= Lang::t('<<'); ?></a>
                    &nbsp;&nbsp;&nbsp; <? Action::getLink($murid, "Studentsetup"); ?>
                </div>


                <script type="text/javascript">
                    $("#del_<?=$murid->mk_id;?>").click(function () {
                        event.preventDefault();
                        $.get('<?=_SPPATH;?>StudentSetup/del_murid_kelas?mk_id=<?=$murid->mk_id;?>',
                            function (data) {
                                lwrefresh(window.selected_page);
                            });
                    });
                </script>

            <? } ?>
            <?
            } else {
                echo Lang::t("Murid not available");
            } ?>
            <? //pr($muridKelas);?>
        </div>
    </div>
<?php
//pr($arr);
