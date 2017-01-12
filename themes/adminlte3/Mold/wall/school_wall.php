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
    <h1><?= Lang::t('Schoolwall'); ?></h1>
<?
if (Account::getMyRole() == "supervisor" && !$noPost) {
    ?>
    <div id='writewall<?= $t; ?>' data-toggle="modal" data-target="#myModal"
         style="width:100%; height: 30px; line-height: 30px; color: #999999; text-align: center; border-bottom: 1px solid #aaaaaa;">
        <?= Lang::t("Write On Wall"); ?>
    </div>
    <script type="text/javascript">
        $("#writewall<?=$t;?>").click(function () {
            $('#myModalLabel').empty().append('<?=Lang::t('Write your thoughts');?>');
            $('#myModalBody').load('<?=_SPPATH;?>wallweb/composewall?cmd=form&typ=school');
        });
    </script>
<? } ?>
    <div id="walllist<?= $t; ?>">

        <? foreach ($arrWall as $m) {
            Mold::both("wall/einzel_post", array ("m" => $m, "typ" => "school", "klsid" => "", "newFor" => $newFor));
        } ?>
    </div>
<?
$nmore = (isset($_GET['nomoreresults']) ? addslashes($_GET['nomoreresults']) : 'no');
if ($nmore != "yes" && !$noPost) {
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
            $.get('<?=_SPPATH;?>wallweb/schoolwallNext?begin=' + wallbegin,
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
<?
} else {
    ?>
    <div class="loadmore" style="padding:10px; text-align: center;">
    <span style="padding:10px; cursor: pointer; color: #777; background-color: #fff; border-radius: 5px;"
          id="loadmoreb<?= $t; ?>">
        <?= Lang::t('show more results'); ?>
    </span>
    </div>
    <script type="text/javascript">
        $('#loadmoreb<?=$t;?>').click(function () {
            openLw('Schoolwall', '<?=_SPPATH;?>wallweb/Schoolwall', 'fade');

        });
    </script>
<?
} ?><?php

