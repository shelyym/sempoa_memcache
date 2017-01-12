<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/21/16
 * Time: 10:11 AM
 */

class TextLimiter {

    public static function inputText($type,$id,$name,$placeholder,$value,$maxlength = 25,$minlength = 0,$toWrite = '',$onSuccessJS =''){

        ?>

        <input style="padding-right: 35px"  type="<?=$type;?>" name="<?=$name;?>" maxlength="<?=$maxlength;?>" class="form-control" id="<?=$id;?>" placeholder="<?=$placeholder;?>" value="<?=$value;?>">
        <div class="wadahcounter">
            <div id="<?=$id;?>_charNum" class="roundChar" <? if($value==""){?>style="display: none;"<?}?>><?=($maxlength-strlen($value));?></div>
        </div>
        <div id="<?=$id;?>_minWarning" class="minwarning" style="display: none;">Min <?=$minlength;?> Chars</div>
        <script>
            $("#<?=$id;?>").keyup(function(){
                var slc = $("#<?=$id;?>").val();

                <? if($toWrite != ''){?>
                $("#<?=$toWrite;?>").html(slc);
                <? } ?>

                var len = slc.length;
                var max = <?=$maxlength;?>;
                var min = <?=$minlength;?>;

                if(len<min){
                    $('#<?=$id;?>_minWarning').show();
                }else{
                    $('#<?=$id;?>_minWarning').hide();
                }

                if (len > max) {
                    $('#<?=$id;?>_charNum').hide();
                } else {
                    $('#<?=$id;?>_charNum').show();
                    var char = max - len;
                    $('#<?=$id;?>_charNum').text(char);
                }
            });

            <? if($onSuccessJS!=''){
            ?>
            $('#<?=$id;?>').blur(function(){
               <?=$onSuccessJS;?>
            });
            <?} ?>
        </script>
        <style>
            .wadahcounter{
                position: absolute;

                /*z-index: -100;*/
                width: 100%;
                height: 22px;
            }
            .roundChar{
                float: right;
                width: 22px;
                height: 22px;
                border-radius: 22px;
                background-color: #008000;
                color: white;
                text-align: center;
                line-height: 22px;
                font-size: 11px;
                margin-right: 30px;
                margin-top: -27px;

            }
            .minwarning{
                font-size: 10px;
                color: #aaaaaa;
                padding-top: 5px;

            }
        </style>
        <?
    }


    public static function inputTextAreaBiasa($type,$id,$name,$placeholder,$value,$maxlength = 25,$minlength = 0,$toWrite = '',$rows = 6){

        ?>


        <textarea rows="<?=$rows;?>"   type="<?=$type;?>" name="<?=$name;?>" maxlength="<?=$maxlength;?>" class="form-control" id="<?=$id;?>" placeholder="<?=$placeholder;?>"><?=$value;?></textarea>
        <div class="wadahcounter">
            <div id="<?=$id;?>_charNum" class="roundChar" <? if($value==""){?>style="display: none;"<?}?>><?=($maxlength-strlen($value));?></div>
        </div>
        <div id="<?=$id;?>_minWarning" class="minwarning" style="display: none;">Min <?=$maxlength;?> Chars</div>
        <script>
                        $("#<?=$id;?>").keyup(function(){
                            var slc = $("#<?=$id;?>").val();

                            <? if($toWrite != ''){?>
                            $("#<?=$toWrite;?>").html(slc);
                            <? } ?>

                            var len = slc.length;
                            var max = <?=$maxlength;?>;
                            var min = <?=$minlength;?>;

                            if(len<min){
                                $('#<?=$id;?>_minWarning').show();
                            }else{
                                $('#<?=$id;?>_minWarning').hide();
                            }

                            if (len > max) {
                                $('#<?=$id;?>_charNum').hide();
                            } else {
                                $('#<?=$id;?>_charNum').show();
                                var char = max - len;
                                $('#<?=$id;?>_charNum').text(char);
                            }


                        });


        </script>


        <style>

            .wadahcounter{
                position: absolute;

                /*z-index: -100;*/
                width: 100%;
                height: 22px;
            }
            .roundChar{
                float: right;
                width: 22px;
                height: 22px;
                border-radius: 22px;
                background-color: lightseagreen;
                color: white;
                text-align: center;
                line-height: 22px;
                font-size: 11px;
                margin-right: 30px;
                margin-top: -27px;

            }
            .minwarning{
                font-size: 10px;
                color: #aaaaaa;
                padding-top: 5px;

            }


        </style>
    <?
    }

    public static function inputTextArea($type,$id,$name,$placeholder,$value,$maxlength = 25,$minlength = 0,$toWrite = '',$rows = 6){

        ?>

        <div class="rte_ac">
            <div class="rte_icon" id="bold_<?=$id;?>" >
                <i class="fa fa-bold"></i>
            </div>
            <div class="rte_icon">
                <i class="fa fa-italic" id="italic_<?=$id;?>" ></i>
            </div>
            <div class="rte_icon rte_big" id="small_<?=$id;?>">
                Small
            </div>
            <div class="rte_icon rte_big" id="big_<?=$id;?>">
                Big
            </div>
            <div class="clearfix"></div>
        </div>
        <div contenteditable="true" id="<?=$id;?>" class="textarea_div"><?=$value;?></div>
<!--        <textarea rows="--><?//=$rows;?><!--"   type="--><?//=$type;?><!--" name="--><?//=$name;?><!--" maxlength="--><?//=$maxlength;?><!--" class="form-control" id="--><?//=$id;?><!--" placeholder="--><?//=$placeholder;?><!--">--><?//=$value;?><!--</textarea>-->
        <div class="wadahcounter">
            <div id="<?=$id;?>_charNum" class="roundChar" <? if($value==""){?>style="display: none;"<?}?>><?=($maxlength-strlen($value));?></div>
        </div>
        <div id="<?=$id;?>_minWarning" class="minwarning" style="display: none;">Min <?=$maxlength;?> Chars</div>
        <script>
//            $("#<?//=$id;?>//").keyup(function(){
//                var slc = $("#<?//=$id;?>//").val();
//
//                <?// if($toWrite != ''){?>
//                $("#<?//=$toWrite;?>//").html(slc);
//                <?// } ?>
//
//                var len = slc.length;
//                var max = <?//=$maxlength;?>//;
//                var min = <?//=$minlength;?>//;
//
//                if(len<min){
//                    $('#<?//=$id;?>//_minWarning').show();
//                }else{
//                    $('#<?//=$id;?>//_minWarning').hide();
//                }
//
//                if (len > max) {
//                    $('#<?//=$id;?>//_charNum').hide();
//                } else {
//                    $('#<?//=$id;?>//_charNum').show();
//                    var char = max - len;
//                    $('#<?//=$id;?>//_charNum').text(char);
//                }
//
//
//            });
            function updateSim_<?=$id;?>(){
                var slc = $("#<?=$id;?>").html();

                <? if($toWrite != ''){?>
                //filter yang tidak boleh masuk..
                $("#<?=$id;?>").find("*").not("b,i,small,big,div,br").each(function() {
                    $(this).replaceWith(this.innerText);
                });
                slc = $("#<?=$id;?>").html();

                $("#<?=$toWrite;?>").html(slc);
                <? } ?>

                var len = slc.length;
                var max = <?=$maxlength;?>;
                var min = <?=$minlength;?>;

                if(len<min){
                    $('#<?=$id;?>_minWarning').show();
                }else{
                    $('#<?=$id;?>_minWarning').hide();
                }

                if (len > max) {
                    $('#<?=$id;?>_charNum').hide();
                } else {
                    $('#<?=$id;?>_charNum').show();
                    var char = max - len;
                    $('#<?=$id;?>_charNum').text(char);
                }
            }

            $("#<?=$id;?>").keyup(function(){

//                console.log("edit keyup");

                updateSim_<?=$id;?>();
            });

//            $("#<?//=$id;?>//_editable").keydown(function(){
//                ShowSelection('<?//=$id;?>//');
//                var el = document.getElementById('<?//=$id;?>//_editable');
//                var sel = getSelectedTextWithin(el);
//                console.log(sel);
//            });

            $(document).ready(function(){

                var toggleBoldRedButton = gEBI("bold_<?=$id;?>");
                toggleBoldRedButton.disabled = false;
                toggleBoldRedButton.ontouchstart = toggleBoldRedButton.onmousedown = function() {
                    toggleBold();
                    updateSim_<?=$id;?>();
                    return false;
                };

                var toggleBoldRedButton2 = gEBI("small_<?=$id;?>");
                toggleBoldRedButton2.disabled = false;
                toggleBoldRedButton2.ontouchstart = toggleBoldRedButton2.onmousedown = function() {
                    toggleSmall();
                    updateSim_<?=$id;?>();
                    return false;
                };

                var toggleBoldRedButton3 = gEBI("italic_<?=$id;?>");
                toggleBoldRedButton3.disabled = false;
                toggleBoldRedButton3.ontouchstart = toggleBoldRedButton3.onmousedown = function() {
                    toggleItalic();
                    updateSim_<?=$id;?>();
                    return false;
                };

                var toggleBoldRedButton4 = gEBI("big_<?=$id;?>");
                toggleBoldRedButton4.disabled = false;
                toggleBoldRedButton4.ontouchstart = toggleBoldRedButton4.onmousedown = function() {
                    toggleBig();
                    updateSim_<?=$id;?>();
                    return false;
                };
            });


        </script>


        <style>
            .textarea_div{
                /*padding:5px;*/
                /*background-color: #ffffff;*/
                /*border: 1px solid #dedede;*/
                /*border-radius: 3px;*/
                white-space: pre-wrap;
                min-height: 34px;
                padding: 6px 12px;

                line-height: 1.42857143;
                color: #555;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;

                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
                -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            }
            .wadahcounter{
                position: absolute;

                /*z-index: -100;*/
                width: 100%;
                height: 22px;
            }
            .roundChar{
                float: right;
                width: 22px;
                height: 22px;
                border-radius: 22px;
                background-color: lightseagreen;
                color: white;
                text-align: center;
                line-height: 22px;
                font-size: 11px;
                margin-right: 30px;
                margin-top: -27px;

            }
            .minwarning{
                font-size: 10px;
                color: #aaaaaa;
                padding-top: 5px;

            }
            .rte_icon{
                width: 30px;
                height: 30px;
                line-height: 30px;
                border: 1px solid #cccccc;
                background-color: #cccccc;
                border-radius: 3px;
                text-align: center;
                float: left;
                margin: 1px;
            }
            .rte_big{
                width: auto;
                padding-left: 5px;
                padding-right: 5px;
                font-size: 11px;
            }

        </style>
    <?
    }
} 