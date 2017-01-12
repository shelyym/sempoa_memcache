<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jQuery
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class jQuery {
    
    public static function ajaxsubmitJSON($formID,$onSuccess="lwrefresh(window.selected_page);",$onFailure = "alert(data.err);"){
        
        ?>
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
            console.log(data);
            if (data.bool) {
               <?=$onSuccess;?>
            }
            else {
               <?=$onFailure;?>
            }
        }, 'json');
    });
</script>
        <?
    }
    public static function ajaxsubmitText($formID,$onSuccess="lwrefresh(window.selected_page);"){
        
        ?>
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
            <?=$onSuccess;?>
        });
    });
</script>
        <?
    }
}
