<? $t = time(); ?>
    <style>
        .cb_icon {
            color: #f5d313;
        }

        .delivered {
            color: #00b3ee;
        }

        .read {
            color: #88be14;
        }

        .reply {
            color: red;
        }
    </style>
<div class="mailbox row">
    <div class="col-xs-12">
        <div class="box-solid">
            <div class="box-body">
                <div class="row">

                    <div class="col-md-12 col-sm-12">
                        <h1><?= Lang::t('Inbox'); ?></h1>

                        <div class="row pad">

                            <div class="col-md-3 ">
                                <!-- compose message btn -->
                                <a id="inboxCompose" class="btn btn-block btn-primary" data-toggle="modal"
                                   data-target="#myModal"><i
                                        class="fa fa-pencil"></i> <?= Lang::t('Compose Message'); ?></a>
                                <script type="text/javascript">
                                    $('#inboxCompose').click(function (event) {
                                        event.preventDefault();
                                        $('#myModalLabel').empty().append('<?=Lang::t('Compose Message');?>');
                                        $('#myModalBody').load('<?=_SPPATH;?>inboxweb/compose');
                                    });
                                </script>
                            </div>
                            <div class="col-md-3 ">
                                <!--  commbook -->
                                <a id="commbook<?= $t; ?>" class="btn btn-block btn-primary"
                                   style="background-color:#f5d313; border-color: #f5d313;">

                                    <i class='glyphicon glyphicon-book'></i> <?= Lang::t('Communication Book'); ?></a>
                                <script type="text/javascript">
                                    $('#commbook<?=$t;?>').click(function (event) {
                                        event.preventDefault;
                                        openLw(window.selected_page, '<?=_SPPATH;?>Inboxweb/myinbox?begin=0&cb=1&word=' + $('#searchInbox<?=$t;?>').val(), 'fade');
                                    });
                                </script>
                            </div>
                            <div class="col-md-4 col-md-offset-2 search-form">

                                <div class="input-group">
                                    <input id="searchInbox<?= $t; ?>" type="text" class="form-control input-sm"
                                           value="<?= $word; ?>" placeholder="<?= Lang::t('Search'); ?>">

                                    <div class="input-group-btn">
                                        <button id="searchInboxSubmit<?= $t; ?>" type="button" name="q"
                                                class="btn btn-sm btn-primary"><i class="fa fa-search"></i></button>
                                    </div>
                                    <script type="text/javascript">
                                        $("#searchInboxSubmit<?=$t;?>").click(function (event) {
                                            event.preventDefault;
                                            openLw(window.selected_page, '<?=_SPPATH;?>Inboxweb/myinbox?begin=0&search=1&word=' + $('#searchInbox<?=$t;?>').val(), 'fade');
                                        });
                                        $("#searchInbox<?=$t;?>").keyup(function (event) {
                                            event.preventDefault;
                                            if (event.keyCode == 13) { //on enter
                                                openLw(window.selected_page, '<?=_SPPATH;?>Inboxweb/myinbox?begin=0&search=1&word=' + $('#searchInbox<?=$t;?>').val(), 'fade');
                                            }
                                        });
                                    </script>
                                </div>

                            </div>
                        </div>
                        <!-- /.row -->

                        <div class="table-responsive">
                            <!-- THE MESSAGES -->

                            <table class="table table-mailbox">
                                <?
                                $myID = Account::getMyID();
                                foreach ($arrMsg as $msg) {


                                    $idlawan = $msg->inbox_from;
                                    if ($myID == $msg->inbox_from) {
                                        $idlawan = $msg->inbox_to;
                                    }

                                    $acc = new Account();
                                    $acc->getByID($idlawan);

                                    $cssclass = $msg->inbox_type;
                                    if ($msg->inbox_giliran_read == $myID) {
                                        if (!$msg->inbox_read) {
                                            $cssclass .= " unread";
                                        }
                                    }
                                    $isDelivered = '';
                                    if ($msg->inbox_giliran_read != $myID) {
                                        if (!$msg->inbox_read) {
                                            $isDelivered = "<i class='glyphicon glyphicon-envelope delivered'></i>";
                                        } else {
                                            $isDelivered = "<i class='glyphicon glyphicon-ok read'></i>";
                                        }
                                    } else {
                                        $isDelivered = "<i class='glyphicon glyphicon-pencil reply'></i>";
                                    }
                                    $cssclass = "class = '$cssclass'";

                                    $isCB = '';
                                    if ($msg->inbox_type == "cb") {
                                        $isCB = "<i class='glyphicon glyphicon-book cb_icon'></i>";
                                    }
                                    ?>
                                    <tr id="inbox<?= $msg->inbox_id; ?>" <?= $cssclass; ?>>
                                        <td class="small-col"><?= $isDelivered; ?></td>
                                        <td class="small-col"><?= $isCB; ?></td>
                                        <td class="name"><?= $acc->getName(); ?></td>
                                        <td class="subject">
                                            <p><?= stripslashes($msg->inbox_judul); ?></p>
                                        </td>
                                        <td class="subject">
                                            <?= substr(stripslashes(strip_tags($msg->inbox_msg)), 0, 30); ?>..
                                        </td>
                                        <td class="time"><?= ago(strtotime($msg->inbox_changedate)); ?></td>
                                    </tr>
                                    <script type="text/javascript">
                                        $("#inbox<?=$msg->inbox_id;?>").click(function () {
                                            openLw('inboxView<?=$msg->inbox_id;?>', '<?=_SPPATH;?>Inboxweb/see?id=<?=$msg->inbox_id;?>', 'fade');
                                        });
                                    </script>
                                <? } ?>

                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <div class="pull-right">
                    <?
                    $show_end = $begin + $limit;
                    if ($total < $show_end) {
                        $show_end = $total;
                    }

                    ?>
                    <small><?= Lang::t('Showing'); ?> <?= ($begin + 1); ?>-<?= $show_end; ?>/<?= $total; ?></small>
                    <? if ($begin >= $limit) { ?>
                        <button id="prevbutton<?= $t; ?>" class="btn btn-xs btn-primary"><i
                                class="fa fa-caret-left"></i></button>
                        <script type="text/javascript">
                            $('#prevbutton<?=$t;?>').click(function () {
                                var begin = <?=$begin-$limit;?>;
                                openLw(window.selected_page, '<?=_SPPATH;?>Inboxweb/myinbox?begin=' + begin);
                            });
                        </script>
                    <? } ?>
                    <? if ($begin + $limit < $total) { ?>
                        <button id="nextbutton<?= $t; ?>" class="btn btn-xs btn-primary"><i
                                class="fa fa-caret-right"></i></button>
                        <script type="text/javascript">
                            $('#nextbutton<?=$t;?>').click(function () {
                                var begin = <?=$begin+$limit;?>;
                                openLw(window.selected_page, '<?=_SPPATH;?>Inboxweb/myinbox?begin=' + begin);
                            });
                        </script>
                    <? } ?>
                </div>
            </div>
            <!-- box-footer -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col (MAIN) -->
</div><?php

//pr($arr);
