<?
$t = time() + rand(100, 10000);
if (!isset($kejadian)) {
    $kejadian = new Calendar();
    $kejadian->cal_id = 0;
    $kejadian->cal_name = "";
}
?>

    <form id="kej_<?= $t ?>" role="form" action="<?= _SPPATH; ?>schoolsetup/getEffDay?cmd=add">
        <div class="alert alert-danger" role="alert" style="display:none;"></div>
        <input type="hidden" value="<?= $kejadian->cal_id; ?>" name="cal_id">

        <div class="form-group">
            <label for="cal_name"><?= Lang::t('Event Name'); ?></label>
            <input value="<?= $kejadian->cal_name; ?>" type="text" class="form-control" id="cal_name"
                   placeholder="<?= Lang::t('Name'); ?>">
        </div>
        <div class="form-group">
            <label for="cal_mulai"><?= Lang::t('Starting Date'); ?></label>
            <input value="<?= $kejadian->cal_mulai; ?>" type="date" class="form-control" id="cal_mulai">
        </div>
        <div class="form-group">
            <label for="cal_akhir"><?= Lang::t('End Date'); ?></label>
            <input value="<?= $kejadian->cal_akhir; ?>" type="date" class="form-control" id="cal_akhir">
        </div>
        <div class="form-group">
            <label for="cal_type"><?= Lang::t('Event Type'); ?></label>
            <select class="form-control" id="cal_type">
                <option>Holiday</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
    <script>
        $("#kej_<?=$t?>").submit(function (event) {
            //alert( "Handler for .submit() called." );
            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            var $form = $(this),
                url = $form.attr("action");

            // Send the data using post
            var posting = $.post(url, $form.serialize(), function (data) {
                //alert(data);
                console.log(data); // John
                //console.log( data.bool ); // 2pm


                if (data.bool) {
                    $('#myModal').modal('hide');
                    lwrefresh(window.selected_page);
                }
                else {
                    $("#kej_<?=$t?> .alert").empty().append(data.err).fadeIn('slow');
                }
            }, 'json');


        });
    </script>
<?php
//pr($arr);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

