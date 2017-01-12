<?
$t = time();
$wweb = new Wallweb();
$limit = $wweb->limit;
?>
    <style type="text/css">
        .fotomurid_wall {
            width: 55px;
            height: 55px;
            overflow: hidden;
            float: left;
            margin-left: 20px;
        }

        .namamuridwall {
            margin-left: 10px;
            float: left;
        }

        .namamuridwallname {
            font-weight: bold;
            color: #666666;
        }

        .namamuridwalldate {
            font-style: italic;
            color: #999999;
        }

        .wallpicked {
            background-color: #fff;
            color: #999999;
        }

        .wallnotpicked {
            background-color: #ccc;
            color: #fff;
        }

        .wallfoto {
            width: 200px;
            height: 200px;
            overflow: hidden;
            float: left;
        }

        .walltext {
            clear: both;
        }

        .fotocontainer {
            margin-bottom: 10px;
        }
    </style>
    <div id='writewall<?= $t; ?>' data-toggle="modal" data-target="#myModal"
         style="width:100%; height: 30px; line-height: 30px; color: #999999; text-align: center; border-bottom: 1px solid #aaaaaa;">
        <?= Lang::t("Write On Wall"); ?>
    </div>
    <script type="text/javascript">

        $("#writewall<?=$t;?>").click(function () {
            // openLw('writewall<?=$kelas_id;?>','<?= _SPPATH;?>wallweb/composewall?cmd=form&typ=kelas&klsid=<?=$kelas_id;?>','fade');
            $('#myModalLabel').empty().append('<?=Lang::t('Write your thoughts');?>');
            $('#myModalBody').load('<?=_SPPATH;?>wallweb/composewall?cmd=form&typ=kelas&klsid=<?=$kelas_id;?>');

        });
    </script>

    <div
        style="width:100%;  background-color: white; height: 25px; line-height: 25px; color: #999999; text-align: center; ">
        <div id="selectAllpost<?= $t; ?>" class="wallpicked" style="width:50%; float: left; text-align: center;">
            <?= Lang::t("All Posts"); ?>
        </div>
        <div id="selectGurupost<?= $t; ?>" class="wallnotpicked" style="width:50%; float: left; text-align: center;">
            <?= Lang::t("Teachers Posts"); ?>
        </div>
    </div>
    <script type="text/javascript">
        var filterwall = 'all';
        $('#selectAllpost<?=$t;?>').click(function () {
            $('#selectAllpost<?=$t;?>').removeClass('wallnotpicked').addClass('wallpicked');
            $('#selectGurupost<?=$t;?>').removeClass('wallpicked').addClass('wallnotpicked');
            filterwall = 'all';
            $.get('<?=_SPPATH;?>wallweb/getKelasWallNext?klsid=<?=$kelas_id;?>&begin=0&filter=' + filterwall,
                function (data) {
                    if (data == "no") {
                        $("#walllist<?=$t;?>").html('<?=Lang::t('No more result');?>');
                    } else {
                        $("#walllist<?=$t;?>").html(data);
                    }
                });
        });

        $('#selectGurupost<?=$t;?>').click(function () {
            $('#selectGurupost<?=$t;?>').removeClass('wallnotpicked').addClass('wallpicked');
            $('#selectAllpost<?=$t;?>').removeClass('wallpicked').addClass('wallnotpicked');
            filterwall = 'guru';
            $.get('<?=_SPPATH;?>wallweb/getKelasWallNext?klsid=<?=$kelas_id;?>&begin=0&filter=' + filterwall,
                function (data) {
                    if (data == "no") {
                        $("#walllist<?=$t;?>").html('<?=Lang::t('No more result');?>');
                    } else {

                        $("#walllist<?=$t;?>").html(data);
                    }

                });
        });
    </script>
    <div id="walllist<?= $t; ?>">
        <? foreach ($arrWall as $m) {
            Mold::both("wall/einzel_post",
                array ("m" => $m, "typ" => "kelas", "klsid" => $kelas_id, "newFor" => $newFor));
        } ?>
    </div>
<?
$nmore = (isset($_GET['nomoreresults']) ? addslashes($_GET['nomoreresults']) : 'no');
if ($nmore != "yes") {
    ?>
    <div class="loadmore" style="padding:10px; text-align: center;">
    <span style="padding:10px; cursor: pointer; color: #777; background-color: #fff; border-radius: 5px;"
          id="loadmoreb<?= $t; ?>">
        <?= Lang::t('show more results'); ?>
    </span>
    </div>
    <script type="text/javascript">
        var wallbegin = <?=$limit;?>;
        $('#loadmoreb<?=$t;?>').click(function () {
            $.get('<?=_SPPATH;?>wallweb/getKelasWallNext?klsid=<?=$kelas_id;?>&begin=' + wallbegin + '&filter=' + filterwall,
                function (data) {
                    if (data == "no") {
                        $('#loadmoreb<?=$t;?>').html('<?=Lang::t('No more result');?>');
                    } else {
                        wallbegin = wallbegin + <?=$limit;?>;
                        $("#walllist<?=$t;?>").append(data);
                    }

                });
        });
    </script>
<? } ?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

