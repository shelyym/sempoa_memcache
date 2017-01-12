<h1><?= Lang::t('Subjects'); ?></h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <tr>
            <th><?= Lang::t('Subject Name'); ?></th>
            <th><?= Lang::t('Subject Group'); ?></th>

        </tr>
        <?
        foreach ($arrMP as $mp) {
            ?>
            <tr id="mpview<?= $mp->mp_id; ?>">
                <td><?= $mp->mp_name; ?></td>
                <td><?= $mp->mp_group; ?></td>

            </tr>
            <script type="text/javascript">
                $("#mpview<?=$mp->mp_id;?>").click(function () {
                    openLw("Einzelmpview<?=$mp->mp_id;?>", "<?=_SPPATH;?>elearningweb/matapelajaran?mp_id=<?=$mp->mp_id;?>", "fade");
                });
            </script>
        <?
        }
        ?>
    </table>
</div><?php
