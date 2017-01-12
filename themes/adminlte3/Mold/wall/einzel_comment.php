<style>
    .fotobehalter {
        padding-top: 10px;
        clear: both;
    }
</style>
<div class="datamurid_table_wall" style="background-color:white; padding: 10px; margin-bottom: 10px;"
     id="wallcomment<?= $c->cid; ?>">
    <? if ($c->cid_admin_id == Account::getMyID()) { ?>
        <div id="deleteWallComment<?= $c->cid;; ?>" style="float:right; width:20px; height: 20px;"><span
                class="glyphicon glyphicon-remove viel_glyph hidden-print"></span></div>
        <script type="text/javascript">
            $("#deleteWallComment<?= $c->cid;; ?>").click(function () {
                if (confirm("<?=Lang::t('Are you sure, you want to delete this object?');?>")) {
                    var url = '<?=_SPPATH;?>Wallweb/commentdelete';
                    //alert(url);
                    var posting = $.post(url, {id: '<?= $c->cid; ?>'}, function (data) {
                        //console.log( data );
                        //alert(data);
                        if (data.bool) {
                            lwrefresh(window.selected_page);
                            lwrefresh(window.beforepage);
                        }
                        else {
                            alert("<?=Lang::t('Error, Cannot Delete');?>");
                        }
                    }, 'json');
                }
            });
        </script>
    <? } ?>
    <div class="row">
        <div class="fotomurid_wall">
            <img src="<?= $c->cid_admin_foto; ?>" onload="OnImageLoad(event, 55);"/>
        </div>
        <div class="namamuridwall">
            <div class="namamuridwallname"><?= ucfirst($c->cid_admin_nama); ?></div>
            <div class="namamuridwalldate"><?= ago(strtotime($c->c_date)); ?></div>
        </div>
    </div>

    <div class="row" style="padding-top: 10px;">
        <div class="col-md-12">
            <?= nl2br($c->c_text); ?>
        </div>
    </div>
</div>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

