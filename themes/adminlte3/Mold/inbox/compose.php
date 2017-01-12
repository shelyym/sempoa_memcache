<?
$t = time();
?>
    <form role="form" method="post" id="formcompose<?= $t; ?>" action="<?= _SPPATH; ?>inboxweb/sendMsg">
        <?
        if (!$byID) {

            ?>
            <div class="form-group">
                <label for="exampleInputEmail1"><?= Lang::t('lang_compose_Choose_Recipient'); ?></label>
                <select id="recep<?= $t; ?>" class="form-control">
                    <option value=""></option>
                    <?
                    if (Auth::hasRole("guru")) {
                        ?>
                        <option value="admin"><?= Lang::t('lang_system_admin'); ?></option>
                        <option value="supervisor"><?= Lang::t('lang_supervisor'); ?></option>
                        <option value="tatausaha"><?= Lang::t('lang_tatausaha'); ?></option>
                    <?
                    }
                    ?>
                    <option value="guru"><?= Lang::t('lang_guru'); ?></option>
                    <option value="murid"><?= Lang::t('lang_murid'); ?></option>
                </select>
            </div>
            <div class="form-group" id="selecttu" style="display:none; ">
                <select class="form-control" id="recep_tu<?= $t; ?>">
                    <option value=""></option>
                    <? foreach ($arrTU as $tu_obj) { ?>
                        <option value="<?= $tu_obj->account_id; ?>"><?= $tu_obj->getName(); ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form-group" id="selectsup" style="display:none; ">
                <select class="form-control" id="recep_sup<?= $t; ?>">
                    <option value=""></option>
                    <? foreach ($arrSupervisor as $sup) { ?>
                        <option value="<?= $sup->account_id; ?>"><?= $sup->getName(); ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form-group" id="selectsys" style="display:none; ">
                <select class="form-control" id="recep_sys<?= $t; ?>">
                    <option value=""></option>
                    <? foreach ($arrAdmin as $adm) { ?>
                        <option value="<?= $adm->account_id; ?>"><?= $adm->getName(); ?></option>
                    <? } ?>
                </select>
            </div>
            <div id="selectguru" style="display:none; ">
                <select class="form-control" id="recep_guru<?= $t; ?>">
                    <option value=""></option>
                    <? foreach ($arrGuru as $gr) { ?>
                        <option value="<?= $gr->account_id; ?>"><?= $gr->getName(); ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form-group" id="selectkelas" style="display:none;">
                <select class="form-control" id="recep_kelas<?= $t; ?>">
                    <option value=""></option>
                    <? foreach ($arrKelas as $kls) { ?>
                        <option value="<?= $kls->kelas_id; ?>"><?= $kls->getName(); ?></option>
                    <? } ?>
                </select>
            </div>
            <div class="form-group" id="isikelas">
            </div>

            <div class="form-group">
                <label for="kepadatext"><?= Lang::t('lang_compose_kepada'); ?></label>
                <input name="acc_id" readonly="true" id="kepada" type="hidden"/>
                <input name="acc_idtext" class="form-control" readonly="true" id="kepadatext" type="text"/>
            </div>
        <? } else { ?>
            <div class="form-group">
                <label for="kepadatext"><?= Lang::t('lang_compose_kepada'); ?></label>
                <input name="acc_id" readonly="true" id="kepada" type="hidden" value="<?= $acc->admin_id; ?>"/>
                <input name="acc_idtext" class="form-control" readonly="true" id="kepadatext" type="text"
                       value="<?= $acc->getName(); ?>"/>
            </div>
        <? } ?>


        <div class="form-group">
            <label for="judulmsg"><?= Lang::t('lang_compose_judul'); ?></label>
            <input name="judul" type="text" class="form-control" id="judulmsg">
        </div>

        <div class="form-group">
            <label for="msgcontent"><?= Lang::t('lang_compose_content'); ?></label>
            <textarea name="isi" class="form-control" rows="3" id="msgcontent"></textarea>
        </div>
        <? if (Auth::hasRole("guru")) { ?>
            <div class="form-group">
                <label for="typeinbox"><?= Lang::t('Message Type'); ?></label>
                <select class="form-control" name="type" id="typeinbox">
                    <option value="casual"><?= Lang::t('Normal Message'); ?></option>
                    <option value="cb"><?= Lang::t('Communication Book'); ?></option>
                </select>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="emai" value="1"> <?= Lang::t('Send As Email'); ?>
                </label>
            </div>
        <? } ?>
        <button type="submit" class="btn btn-default"><?= Lang::t('Submit'); ?></button>
    </form>
<? Ajax::ModalAjaxForm("formcompose" . $t); ?>
    <script type="text/javascript">
        $("#recep<?=$t;?>").change(function () {

            var slc = $("#recep<?=$t;?>").val();

            $('#selectguru').hide();
            $('#selectkelas').hide();
            $('#selecttu').hide();
            $('#selectsup').hide();
            $('#selectsys').hide();
            $('#isikelas').hide();

            if (slc == "guru") {
                $('#selectguru').show();
            }
            else if (slc == "tatausaha") {
                $('#selecttu').show();
            }
            else if (slc == "murid") {
                $('#selectkelas').show();
            }
            else if (slc == "supervisor") {
                //$('kepada').value('supervisor');
                $('#selectsup').show();
            }
            else if (slc == "admin") {
                //$('kepada').value('admin');
                $('#selectsys').show();
            }
            else $('#kepada').val('');
        });

        $("#recep_tu<?=$t;?>").change(function () {
            var slc = $("#recep_tu<?=$t;?>").val();
            $('#kepada').val(slc);
            $('#kepadatext').val(getSelectedText("recep_tu<?=$t;?>"));
        });

        $("#recep_sup<?=$t;?>").change(function () {
            var slc = $("#recep_sup<?=$t;?>").val();
            $('#kepada').val(slc);
            $('#kepadatext').val(getSelectedText("recep_sup<?=$t;?>"));
        });

        $("#recep_sys<?=$t;?>").change(function () {
            var slc = $("#recep_sys<?=$t;?>").val();
            $('#kepada').val(slc);
            $('#kepadatext').val(getSelectedText("recep_sys<?=$t;?>"));
        });

        $("#recep_guru<?=$t;?>").change(function () {
            var slc = $("#recep_guru<?=$t;?>").val();
            $('#kepada').val(slc);
            $('#kepadatext').val(getSelectedText("recep_guru<?=$t;?>"));
        });

        $("#recep_kelas<?=$t;?>").change(function () {
            var slc = $("#recep_kelas<?=$t;?>").val();
            $('#isikelas').load('<?=_SPPATH;?>inboxweb/isikelas?aj=1&id=' + slc);
            $('#isikelas').fadeIn();
        });

        function getSelectedText(elementId) {
            var elt = document.getElementById(elementId);

            if (elt.selectedIndex == -1)
                return null;

            return elt.options[elt.selectedIndex].text;
        }
    </script>
<?php

