<?
$targetClass = (isset($mode) ? $mode : "kelaswall");
$formID = "composewall".$id;
?>
    <form id="composewall<?= $id; ?>" role="form" class="form" role="form" method="post"
          action="<?= _SPPATH; ?><?= $webClass; ?>/<?= $method; ?>?cmd=add&id=<?= $id; ?>&klsid=<?= $klsid; ?>&typ=<?= $typ; ?>">
        <div class="form-group">
            <textarea class="form-control" name="wall_msg" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-default"><?= Lang::t('Submit'); ?></button>
    </form>
<script type="text/javascript">
            $("#<?=$formID;?>").submit(function (event) {
                //alert( "Handler for .submit() called." );
                // Stop form from submitting normally
                event.preventDefault();

                // Get some values from elements on the page:
                var $form = $(this),
                    url = $form.attr("action");

                // Send the data using post
                var posting = $.post(url, $form.serialize(), function (data) {
                    //alert(data);
                    if (data.bool) {
                        $('#myModal').modal('hide')
                        //lwrefresh(window.selected_page);
                        $('#wallcontainer').load('<?=_SPPATH;?>loadDepartmentWall?klsid=<?=$klsid;?>&typ=<?= $typ; ?>');
                    }
                    else {
                        alert(data.err);
                    }
                }, 'json');


            });
        </script>
<? if ($targetClass == 'kelaswall') { ?>
    <div class="row">
        <? $fotoweb = new Fotoweb();
        $fotoweb->attachment($id, $targetClass); ?>
    </div>
<? } ?>
<?php



