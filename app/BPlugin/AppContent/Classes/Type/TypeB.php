<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:24 PM
 */

class TypeB extends AppContentTemplate{

    public $name = "Wall";
    public $isSingular = 0;
    public $icon = "ic_list.png";

    public $content;
    public $onSuccessJS = "removeBGBlack3();getMyInhalt();";
    public $onFailedJS = "alert('failed');";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){

        $content = $this->content;

//        pr($content);

        //disini kalau ada ID type A yang cocok lgs dikirim pas edit...

        $ta = new TypeAModelDraft();
        $arr = $ta->selectAllIDs($this->content->content_id);


        ?>
        <div style="background-color: #FFFFFF;">
            <div class="col-md-12" style="padding: 10px; background-color: #e1e1e1;">
                Article Name : <input name="articlename" type="text" value="<?=$content->content_name;?>"  id="articlename" placeholder="Enter Title">
            </div>

            <div class="col-md-12" style="padding: 10px; ">
                <button class="btn btn-success" onclick="loadPopUp3('<?=_SPPATH;?>AppContentWS/createTypeA?id=<?=$content->content_id;?>','typea_<?=$content->content_id;?>','typeb_add_typea');">Add New TypeA</button>

                <div id="wadah_typeA">
                    <?=$content->content_inhalt;?>
                    <? foreach($arr as $aid){
                        $msg = unserialize($aid->a_msg);
                        ?>
                        <div class="col-md-2" >
                            <div style="background-color: #dedede; margin: 10px; padding: 10px;" class="name" onclick="loadPopUp3('<?=_SPPATH;?>AppContentWS/editTypeAFromOutside?content_id=<?=$content->content_id;?>&id=<?=$aid->a_id;?>','typea_<?=$aid->a_id;?>','typeb_edit_typea');"><?=$aid->a_id;?></div>
                        </div>
                        <?
                    } ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="padding: 10px; text-align: center;">
                <button type="submit" id="save_<?=$content->content_id;?>" class="btn btn-danger" style="width: 100%;">SAVE</button>
            </div>
        </div>

        <script>
            function getMyInhalt(){
                $.get("<?=_SPPATH;?>AppContentWS/getMyTypeAFromB?content_id=<?=$this->content->content_id;?>",function(data){
                   $('#wadah_typeA').html(data);
                });
            }

            $('#save_<?=$content->content_id;?>').click(function(){
                var articlename = $('#articlename').val();
                $.post("<?=_SPPATH;?>AppContentWS/editTypeB",{content_id:<?=$this->content->content_id;?>,articlename:articlename},
                function(data){
                    alert(data);
                    location.reload();
//                    removeBGBlack();
                });
            });
        </script>

        <?
    }

} 