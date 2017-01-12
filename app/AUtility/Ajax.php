<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ajax
 * Ajax adalah pengeinheitlichan dari semua ajax calls supaya kalau ganti framework gampang
 *
 * @author Elroy
 */
class Ajax extends \Leap\View\Ajax {
    public $return;

    public function __construct ($return)
    {
        $this->return = $return;
    }

    public static function ModalAjaxForm ($formID)
    {
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
                    if (data.bool) {
                        $('#myModal').modal('hide')
                        lwrefresh(window.selected_page);
                    }
                    else {
                        alert(data.err);
                    }
                }, 'json');


            });
        </script>
    <?
    }

    public function delete ($buttonID,$crudObj = null)
    {
        $return = $this->return;
        $obj = $return['id'];
        $main_id = $obj->{$obj->main_id};

        $url = _SPPATH . $return['webClass'] . "/" . strtolower($return['classname']) . "?cmd=delete";
        if($crudObj!=null){
            $url =  _SPPATH . $crudObj->callClass . "/" . strtolower($crudObj->callFkt) . "?cmd=delete";
        }

        ?>
        <script type="text/javascript">
            $('#<?=$buttonID;?>').click(function () {
                if (confirm("<?=Lang::t('Are you sure, you want to delete this object?');?>")) {
                    var url = '<?=$url;?>';
                    //alert(url);
                    var posting = $.post(url, {id: '<?=$main_id;?>'}, function (data) {
                        console.log( data );
                        //alert(data);
                        if (data.bool) {
                            <?
                            if($crudObj->ar_onDeleteSuccess_js!=''){
                                echo $crudObj->ar_onDeleteSuccess_js;
                            }else{
                            ?>
                            lwclose(window.selected_page);
                            lwrefresh(window.beforepage);
                            <? } ?>
                        }
                        else {
                            alert("<?=Lang::t('Error, Cannot Delete');?>");
                        }

                    }, 'json');
                }
            });
        </script>
    <?
    }

    public function submit ()
    {
        $return = $this->return;

//        pr($this->return['id']->onAjaxSuccess);
        ?>
        <script type="text/javascript">
           // console.log(array_rte);
            $("#<?=$return['formID'];?>").submit(function (event) {
                //alert( "Handler for .submit() called." );
                
               // console.log(array_rte);
                for(key in array_rte){
                    var tb = array_rte[key];
                   // console.log(tb);
                    //get data
                    var data = CKEDITOR.instances;
                    //console.log(data);
                    var data2 = data[tb];
                    //console.log(data2);
                    var data1 = data2.getData();
                   // console.log(data1);
                    $("#hidden_"+tb).val(data1);
                }
                
                // Stop form from submitting normally
                event.preventDefault();

                // Get some values from elements on the page:
                var $form = $(this),
                    url = $form.attr("action");

                // Send the data using post
                var posting = $.post(url, $form.serialize(), function (data) {
                    //alert(data);
                    console.log( data ); // John
                    //console.log( data.bool ); // 2pm
                    $("#<?=$return['formID'];?> .form-group").removeClass('has-error');
                    $("#<?=$return['formID'];?> .help-block").hide();
                    $('#<?=$return['formID'];?> .resultme').empty().hide();

                    if (data.bool) {
                        <?if($this->return['id']->onAjaxSuccess!=""){ ?>
                            <?=$this->return['id']->onAjaxSuccess;?>
                        <?}else{?>
                        lwclose(window.selected_page);
                        lwrefresh(window.beforepage);
                        <? } ?>
                    }
                    else {
                        var obj = data.err;
                        var tim = data.timeId;
                        //console.log( obj );
                        for (var property in obj) {
                            if (obj.hasOwnProperty(property)) {
                                if (property != 'all') {
                                    $('#<?=$return['formID'];?> #formgroup_' + property).addClass('has-error');
                                    $('#<?=$return['formID'];?> #warning_' + property).empty().append(obj[property]).fadeIn('slow');
                                }
                                else {
                                    $('#<?=$return['formID'];?> .resultme').empty().append(obj[property]).fadeIn('slow');
                                }
                            }
                        }
                    }
                }, 'json');


            });
        </script>
        <?
        //return 1;
    }
}
