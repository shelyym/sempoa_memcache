<?
$t = time();
?>
    <style type="text/css">
        .baloon {
            margin: 10px;
        }

        .sender {
            padding: 10px;
            padding-top: 0px;
        }

        .senderdate {
            font-size: 0.9em;
            font-style: italic;
            color: #999;
        }

        .sendername {
            font-weight: bold;
        }

        .msg {
            background-color: #7fffaf;
            padding: 10px;
        }

        .to .sender {
        }

        .to .msg {
            background-color: #7FDBFF;
        }

        .judulinbox {
            font-size: 16px;
            padding: 5px;
            margin: 5px;
        }

        .skipbalon0 {
            margin-top: -20px;
        }

    </style>
<? if (!$all) { ?>
    <div style=" font-size: 1.2em;width: 100%; text-align: center; height: 40px; line-height: 40px;">
        <?= $inbox->inbox_judul; ?>
    </div>
<? } ?>
<? if (!$all) { ?>
    <div id='chatInbox<?= $inbox->inbox_id; ?>'>
<? } ?>
<?
$obj = $inbox;
$prevID = 0;
foreach ($merge as $num => $obja) {
    if ($obja->inbox_from == $obj->inbox_from) {
        $class = "from";
        $data = $from;
    } else {
        $class = "to";
        $data = $to;
    }


    $replyid = (isset($obja->inbox_reply_id) ? $obja->inbox_reply_id : $obja->inbox_id);

    //cek prevID
    if ($prevID == $obja->inbox_from) {
        $skipbalon = 0;
    } else {
        $skipbalon = 1;
        $prevID = $obja->inbox_from;
    }
    ?>
    <div class="row <?= $class; ?> baloon" id="inbox-<?= $replyid; ?>">
        <div class="skipbalon<?= $skipbalon; ?>">
            <? if ($class == "to") { ?>

                <div class="msg col-md-8 col-xs-8 col-md-offset-2">
                    <?= stripslashes($obja->inbox_msg); ?></div>

                <div class="sender col-md-2 col-xs-4">
                    <? if ($skipbalon) { ?>
                        <div class="sendername"><?= ucwords($data->getName()); ?> </div>
                    <? } ?>
                    <div class="senderdate"><?= ago(strtotime($obja->inbox_createdate)); ?></div>
                </div>

            <? } else { ?>

                <div class="sender col-md-2 col-xs-4">
                    <? if ($skipbalon) { ?>
                        <div class="sendername"><?= ucwords($data->getName()); ?> </div>

                    <? } ?>
                    <div class="senderdate"><?= ago(strtotime($obja->inbox_createdate)); ?></div>
                </div>

                <div class="msg col-md-8 col-xs-8"><?= stripslashes($obja->inbox_msg); ?></div>
            <? } ?>
        </div>
    </div>

<?
if ($total > $limit && !$all){
if ($num == 0){
$prevID = 0;
$moreresult = $total - $limit;
?>
    <div id="overwrite<?= $t; ?>">
        <div id="showallmsg<?= $t; ?>" class="col-md-8 col-md-offset-2"
             style="cursor: pointer;text-align: center; background-color: #dedede; padding-top: 10px; padding-bottom: 10px; margin-bottom: 10px; margin-top: 10px;">
            <?= Lang::t('Show all conversations'); ?> <?= "($moreresult)"; ?>
        </div>
    </div>

    <script type="text/javascript">
        $("#showallmsg<?=$t;?>").click(function () {
            $("#overwrite<?=$t;?>").load('<?=_SPPATH;?>Inboxweb/see?id=<?=$inbox->inbox_id;?>&begin=all');
        });
    </script>
<?
}
}
}
?>
<? if (!$all) { ?>
    </div>
    <!-- end chat-->
<? } ?>
<? if (!$all) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="input-group">

                    <input class="form-control" id="textreply<?= $t; ?>" type="text"
                           placeholder="<?= Lang::t('Write Message'); ?>">

                    <div id="replybutton<?= $t; ?>" class="input-group-addon"><?= Lang::t('Send'); ?></div>
                </div>
            </div>
        </div>

    </div>
    <?

    $replyTo = $inbox->inbox_from;
    $myclass = "to";
    if ($replyTo == Account::getMyID()) {
        $replyTo = $inbox->inbox_to;
        $myclass = "from";
    }

    ?>
    <script type="text/javascript">
        var newreply = <?=$replyid;?>;

        $("#replybutton<?=$t;?>").click(function () {
            newreply++;
            var bagianreply = '<?=$myclass;?>';

            if (bagianreply == "to")
                $('#chatInbox<?=$inbox->inbox_id;?>').append('<div class="row <?=$myclass;?> baloon" id="inbox-' + newreply + '"><div class="skipbalon1"><div class="msg col-md-8 col-xs-8 col-md-offset-2">' + $('#textreply<?=$t;?>').val() + '</div><div class="sender col-md-2 col-xs-4"><div class="sendername"><?=Account::getMyName();?></div><div class="senderdate"><?=Lang::t('just now');?></div></div></div></div>');
            else
                $('#chatInbox<?=$inbox->inbox_id;?>').append('<div class="row <?=$myclass;?> baloon" id="inbox-' + newreply + '"><div class="skipbalon1"><div class="sender col-md-2 col-xs-4"><div class="sendername"><?=Account::getMyName();?></div><div class="senderdate"><?=Lang::t('just now');?></div></div><div class="msg col-md-8 col-xs-8">' + $('#textreply<?=$t;?>').val() + '</div></div></div>');


            $.post('<?=_SPPATH;?>inboxweb/sendReplyMsg', {
                    acc_id: '<?=$replyTo;?>',
                    inboxid: '<?=$inbox->inbox_id;?>',
                    isi: $('#textreply<?=$t;?>').val()
                },
                function (data) {
                    //alert(data);  
                    if (data.bool) {

                        $('#textreply<?=$t;?>').val('');
                        // $('#myModal').modal('hide')
                        // lwrefresh(window.selected_page);
                    }
                    else {
                        alert(data.err);
                    }
                }, 'json');

        });
        $("#textreply<?=$t;?>").keyup(function (event) {
            if (event.keyCode == 13) { //on enter
                var bagianreply = '<?=$myclass;?>';
                newreply++;

                if (bagianreply == "to")
                    $('#chatInbox<?=$inbox->inbox_id;?>').append('<div class="row <?=$myclass;?> baloon" id="inbox-' + newreply + '"><div class="skipbalon1"><div class="msg col-md-8 col-xs-8 col-md-offset-2">' + $('#textreply<?=$t;?>').val() + '</div><div class="sender col-md-2 col-xs-4"><div class="sendername"><?=Account::getMyName();?></div><div class="senderdate"><?=Lang::t('just now');?></div></div></div></div>');
                else
                    $('#chatInbox<?=$inbox->inbox_id;?>').append('<div class="row <?=$myclass;?> baloon" id="inbox-' + newreply + '"><div class="skipbalon1"><div class="sender col-md-2 col-xs-4"><div class="sendername"><?=Account::getMyName();?></div><div class="senderdate"><?=Lang::t('just now');?></div></div><div class="msg col-md-8 col-xs-8">' + $('#textreply<?=$t;?>').val() + '</div></div></div>');

                $.post('<?=_SPPATH;?>inboxweb/sendReplyMsg', {
                        acc_id: '<?=$replyTo;?>',
                        inboxid: '<?=$inbox->inbox_id;?>',
                        isi: $('#textreply<?=$t;?>').val()
                    },
                    function (data) {
                        //alert(data);
                        if (data.bool) {
                            $('#textreply<?=$t;?>').val('');
                            // $('#myModal').modal('hide')
                            //lwrefresh(window.selected_page);
                        }
                        else {
                            alert(data.err);
                        }
                    }, 'json');
            }
        });
    </script>
<? } //all ?>
<?php
//pr($arr);
