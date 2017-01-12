<?
$t = time();
$sehariInMinute = 60 * 60 * 24 * $newFor;
$timestamp = (isset($m->wall_timestamp) ? strtotime($m->wall_timestamp) : strtotime($m->wall_update));
$createTimestamp_date = (isset($m->wall_date) ? date('d-m-Y', strtotime($m->wall_date)) : date('d-m-y'));
$createTimestamp_jam = (isset($m->wall_date) ? date('h:i:s', strtotime($m->wall_date)) : date('h:i:s'));
$createTimestampPostDate = (isset($m->wall_date) ? strtotime($m->wall_date) : 0);

//cek apakah  new 
$isNew = 0;
$isNewUpdate = 0;
if (($t - $createTimestampPostDate) < $sehariInMinute) {
    $isNew = 1;
}
if (($t - $timestamp) < $sehariInMinute) {
    $isNewUpdate = 1;
}
//echo $sehariInMinute;
//echo "<br>".$createTimestampPostDate." ".$t." ".($createTimestampPostDate-$t);

$klsid2 = (isset($klsid) ? $klsid : "");
$typ2 = (isset($typ) ? $typ : "");
$nodelete2 = (isset($nodelete) ? $nodelete : 0);
?>
    <style>
        .fotobehalter {
            padding-top: 10px;
            clear: both;
        }

        .datamurid_table_wall {
            background-color: white;
            padding: 10px;
            margin-bottom: 10px;
        }

        .roleguru {
            background-color: #efefef;
        }

        .rolesupervisor {

        }

        .namamuridwallname {
            cursor: pointer;
            color: #005888;
            font-weight: bold;
        }

        .lastcomments {
            background-color: #fff;
            margin-top: -10px;

        }

        .commentButton {
            width: 100%;
            padding-left: 10px;
            padding-top: 5px;
            padding-bottom: 5px;
            border-top: 1px solid #aaaaaa;
            border-bottom: 1px solid #aaaaaa;
        }
    </style>
    <div style=" box-shadow: 2px 2px 3px #aaaaaa; margin-bottom: 20px;">
        <div class="datamurid_table_wall role<?= $m->wall_role; ?>" id="wall<?= $m->wall_id; ?>">
            <? if ($m->wall_from == Account::getMyID() && !$nodelete2) { ?>
                <div id="deleteWallPost<?= $m->wall_id; ?><?= $t; ?>" style="  height: 20px; text-align: right;"><span
                        class="glyphicon glyphicon-remove viel_glyph hidden-print"></span></div>
                <script type="text/javascript">
                    $("#deleteWallPost<?= $m->wall_id; ?><?=$t;?>").click(function () {
                        if (confirm("<?=Lang::t('Are you sure, you want to delete this object?');?>")) {
                            var url = '<?=_SPPATH;?>Wallweb/delete';
                            //alert(url);
                            var posting = $.post(url, {id: '<?= $m->wall_id; ?>', typ: '<?=$typ;?>'}, function (data) {
                                //console.log( data );
                                //alert(data);
                                if (data.bool) {
                                    lwrefresh(window.selected_page);
                                    //lwrefresh(window.beforepage);
                                }
                                else {
                                    alert("<?=Lang::t('Error, Cannot Delete');?>");
                                }
                            }, 'json');
                        }
                    });
                </script>
            <? } ?>
            <? if ($isNew) { ?>
                <small class="badge pull-right bg-red blink_me"><?= Lang::t('new'); ?></small>
            <? } ?>
            <div class="row">
                <? //pr($m->acc);?>
                <div class="fotomurid_wall" onclick="openProfile('<?= $m->acc->admin_id; ?>');">
                    <?
                    $m->acc->makeFoto(55);?>
                </div>
                <div class="namamuridwall">
                    <div class="namamuridwallname"
                         onclick="openProfile('<?= $m->acc->admin_id; ?>');"><?= $m->acc->getName(); ?></div>
                    <div class="namamuridwalldate"><i class="fa fa-calendar"></i> <?= $createTimestamp_date; ?>  &nbsp;
                        <i class="fa fa-clock-o"></i> <?= $createTimestamp_jam; ?></div>
                    <div class="namamuridwalldate"><i class="fa fa-retweet"></i> <?= ago($timestamp); ?></div>
                </div>
            </div>

            <div class="row" style="padding-top: 10px;">
                <div class="col-md-12">
                    <?= nl2br($m->wall_msg); ?>
                </div>
                <div class="fotobehalter">
                    <? foreach ($m->foto as $p) {
                        $p->printFoto();
                    }?>
                </div>
            </div>
        </div>
        <?
        if (isset($m->wall_commentcount)) {
            ?>
            <div class="lastcomments role<?= $m->wall_role; ?>">

                <div id="comment<?= $m->wall_id; ?><?= $t; ?>" class="commentButton namamuridwallname">
                    <? if ($m->wall_commentcount > 0) { ?>
                        <?= Lang::t('View'); ?> <?= $m->wall_commentcount; ?> <?= Lang::t('comments'); ?>
                    <? } else { ?>
                        <?= Lang::t('Write Comments'); ?>
                    <? } ?>
                    <? if ($isNewUpdate && $m->wall_commentcount != 0) { ?>
                        <small class="badge bg-orange blink_me"><?= Lang::t('new'); ?></small>
                    <? } ?>
                </div>
                <script type="text/javascript">
                    $("#comment<?= $m->wall_id; ?><?=$t;?>").click(function () {
                        openLw("commentView<?=$m->wall_id;?>", '<?=_SPPATH;?>Wallweb/viewcomment?cmd=view&wid=<?=$m->wall_id;?>&typ=<?=$typ2;?>&klsid=<?=$klsid2;?>', 'fade');
                    });
                </script>
                <?
                //lastcomment
                $lastComment = (isset($m->lastComment) ? $m->lastComment : 0);
                if (isset($lastComment->wid)) {

                    ?>
                    <div class="row" style="margin-top:5px;">
                        <div class="fotomurid_wall" onclick="openProfile('<?= $lastComment->acc->admin_id; ?>');">
                            <? $lastComment->acc->makeFoto(45); ?>
                        </div>
                        <div class="namamuridwall">
                            <div class="namamuridwallname"
                                 onclick="openProfile('<?= $m->acc->admin_id; ?>');"><?= $lastComment->acc->getName(); ?>
                                <small><i class="fa fa-retweet"></i> <?= ago(strtotime($lastComment->c_date)); ?>
                                </small>
                            </div>
                            <div class="commentText"><?= nl2br($lastComment->c_text); ?></div>
                        </div>
                    </div>

                <? } ?>
            </div>
            <!-- last comments-->
        <? } ?>

    </div><!--shadoww-->
<?php
//pr($m);

