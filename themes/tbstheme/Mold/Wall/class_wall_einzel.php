<?
$t = time();
$wweb = new WallPortalWeb();
$limit = $wweb->limit;
?>
    
    <div id='writewall<?= $t; ?>' data-toggle="modal" data-target="#myModal"
         style="width:100%; cursor: pointer; text-align: right; height: 30px; line-height: 30px; color: #999999;  border-bottom: 1px solid #aaaaaa;">
        <i class="glyphicon glyphicon-plus"></i>
    </div>
    <script type="text/javascript">
        $("#writewall<?=$t;?>").click(function () {
            // openLw('writewall<?=$kelas_id;?>','<?= _SPPATH;?>wallweb/composewall?cmd=form&typ=kelas&klsid=<?=$kelas_id;?>','fade');
            $('#myModalLabel').empty().append('<?=Lang::t('Write your thoughts');?>');
            $('#myModalBody').load('<?=_SPPATH;?>WallPortalWeb/composewall?cmd=form&typ=RoleOrganization&klsid=<?=$kelas_id;?>');
        });
    </script>

  
    
    <div id="walllist">
        <? foreach ($arrWall as $m) {
            //pr($m);
            Mold::plugin("Wall","einzel_post",
                array ("m" => $m, "typ" => $type, "klsid" => $kelas_id, "newFor" => $newFor));
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
        //deactivate saat bisa pilih post dari guru..
        var filterwall = 'all';
        $('#loadmoreb<?=$t;?>').click(function () {
            $.get('<?=_SPPATH;?>WallPortalWeb/getKelasWallNext?type=<?=$type;?>&klsid=<?=$kelas_id;?>&begin=' + wallbegin + '&filter=' + filterwall,
                function (data) {
                    if (data == "no") {
                        $('#loadmoreb<?=$t;?>').html('<?=Lang::t('No more result');?>');
                    } else {
                        wallbegin = wallbegin + <?=$limit;?>;
                        $("#walllist").append(data);
                    }

                });
        });
    </script>
    
<? } ?>
    
<?php



