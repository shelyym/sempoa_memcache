<?php

unset($wall->wall_commentcount);
Mold::both("wall/einzel_post", array ("m" => $wall, "typ" => "kelas", "klsid" => $klsid, "nodelete" => 1));
$t = time();


?>
    <div id='commmentformv<?= $t; ?>' data-toggle="modal" data-target="#myModal"
         style="width:100%; height: 30px; line-height: 30px; color: #999999; text-align: center; border-bottom: 1px solid #aaaaaa;">
        <?= Lang::t("Write Comment"); ?>
    </div>
    <script type="text/javascript">
        $("#commmentformv<?=$t;?>").click(function () {
            $('#myModalLabel').empty().append('<?=Lang::t('Write your reply');?>');
            $('#myModalBody').load('<?=_SPPATH;?>wallweb/viewcomment?cmd=form&typ=kelas&klsid=<?=$klsid;?>&wid=<?=$wall->wall_id;?>');
        });
    </script>
    <h1 style="padding-top: 20px;"><?= count($mwc); ?> <?= Lang::t('Comments'); ?></h1>
<?
foreach ($mwc as $c) {
    Mold::both("wall/einzel_comment", array ("c" => $c));
}
//pr($arr);

