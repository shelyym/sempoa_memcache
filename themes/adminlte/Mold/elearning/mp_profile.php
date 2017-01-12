<?
$t = time();
?>
    <h1><?= $mp->mp_name; ?>
        <small><?= Lang::t('level'); ?> <?= $klslevel; ?></small>
    </h1>

    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-12">
            <?
            //select on kelas
            $urlOnChange = _SPPATH . $webClass . "/" . $method . "?mp_id=" . $mp->mp_id;
            Selection::levelSelector($klslevel, $urlOnChange);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">


            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#quiztab" role="tab" data-toggle="tab"><?= Lang::t('Quiz'); ?></a></li>
                <li><a href="#tmtab" role="tab" data-toggle="tab"><?= Lang::t('Topic Maps'); ?></a></li>
                <li><a href="#filetab" role="tab" data-toggle="tab"><?= Lang::t('Files'); ?></a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="quiztab">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><?= Lang::t('Title'); ?></th>
                                <th><?= Lang::t('Type'); ?></th>
                                <th><?= Lang::t('By'); ?></th>
                                <th><?= Lang::t('On'); ?></th>
                            </tr>
                            <?
                            // pr($arrQuiz);
                            foreach ($arrQuiz as $quiz) {
                                ?>
                                <tr>
                                    <td><?= $quiz->quiz_judul; ?></td>
                                    <td><?= Lang::t($quiz->quiz_type); ?></td>
                                    <td><?= $quiz->nama_depan; ?></td>
                                    <td><?= date('d-m-Y', strtotime($quiz->quiz_create_date)); ?></td>
                                </tr>
                            <?
                            }
                            ?>
                        </table>
                    </div>


                </div>
                <div class="tab-pane" id="tmtab">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><?= Lang::t('Title'); ?></th>
                                <th><?= Lang::t('By'); ?></th>
                                <th><?= Lang::t('Nr'); ?></th>
                                <th><?= Lang::t('On'); ?></th>
                            </tr>
                            <?
                            // pr($arrTM);
                            foreach ($arrTM as $tm) {
                                ?>
                                <tr>
                                    <td id="tm_<?= $tm->topicmap_id; ?>">
                                        <?= $tm->tm_name; ?>
                                        <script type="text/javascript">
                                            $('#tm_<?=$tm->topicmap_id;?>').click(function () {
                                                // r = Raphael("holder", 1000, 300);
                                                var t = new Date().getTime();
                                                var params = [
                                                    'height=' + screen.height,
                                                    'width=' + screen.width,
                                                    'fullscreen=yes'
                                                ].join(',');

                                                window.open("<?=_SPPATH;?>topicmapweb/newtopic?load=1&tmid=<?=$tm->topicmap_id;?>&aj=1&mp=<?=$tm->tm_mp_id;?>&kls=<?=$tm->tm_kelas_id;?>&t=<?=$t;?>", "_blank", "directories=0,titlebar=0,toolbar=0,location=0, scrollbars=yes, resizable=yes," + params);
                                                //$('tm_drawing_board').load('<?=_SPPATH;?>topicmap/newtopic?aj=1&mp=<?=$mpid;?>&kls=<?=$klsid;?>',{spinner:"loadingtop"});
                                            });
                                        </script>
                                    </td>
                                    <td><?= $tm->nama_depan; ?></td>
                                    <td><?= $tm->tm_jml_el; ?></td>
                                    <td><?= date('d-m-Y', strtotime($tm->tm_updatedate)); ?></td>
                                </tr>
                            <?
                            }
                            ?>
                        </table>
                    </div>

                </div>
                <div class="tab-pane" id="filetab">
                    empty

                </div>
            </div>


        </div>

    </div>
<?php



