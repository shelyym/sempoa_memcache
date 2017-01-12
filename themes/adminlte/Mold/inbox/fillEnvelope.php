<?
$t = time();
?>
    <style>
        .cb_li {
            background-color: #f8efc0;
        }
    </style>
    <li class="header"><span id='jmlEnvBaru'></span> <?= Lang::t(' new messages'); ?></li>
    <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
            <? foreach ($arrMsg as $obja) {
                $classname = '';
                if ($obja->inbox_type == 'cb') {
                    $classname = 'cb_li';
                }
                $data = $obja->data;
                ?>
                <li id="Upinbox<?= $obja->inbox_id; ?>" class="<?= $classname; ?>"><!-- start message -->
                    <a href="#">
                        <div class="pull-left">
                            <? $data->makeFoto(40); ?>
                        </div>
                        <h4>
                            <?= ucwords($data->getName()); ?>
                            <small><i class="fa fa-clock-o"></i><?= ago(strtotime($obja->inbox_changedate)); ?></small>
                        </h4>
                        <p><?= stripslashes($obja->inbox_judul); ?></p>

                        <p><?= substr(stripslashes(strip_tags($obja->inbox_msg)), 0, 30); ?>..</p>
                    </a>
                </li><!-- end message -->
                <script type="text/javascript">
                    $("#Upinbox<?=$obja->inbox_id;?>").click(function () {
                        openLw('inboxView<?=$obja->inbox_id;?>', '<?=_SPPATH;?>Inboxweb/see?id=<?=$obja->inbox_id;?>', 'fade');
                    });
                </script>
            <? } ?>

        </ul>
    </li>
    <li id="UpinboxAll" class="footer"><a href="#"><?= Lang::t('See all messages'); ?></a></li>
<script type="text/javascript">
    $("#UpinboxAll").click(function () {
        openLw('Inbox', '<?=_SPPATH;?>Inboxweb/myinbox', 'fade');
    });
</script><?php


