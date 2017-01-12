<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 5/17/16
 * Time: 3:25 PM
 */

class TypeConnect extends AppContentTemplate{

    public $name = "Connect With Us";
    public $isSingular = 1;
    public $icon = "ic_socmed.png";

    public function p(){
        echo "this is for print";
    }
    public function createForm(){
$content = $this->content;

$content_id = $this->content->content_id;

        $fb_id = "";
        $twitter_id = "";
        $instagram_id = "";
        $youtube_id = "";


        if($content->content_inhalt !="") {
            $inhalt = json_decode(stripslashes($content->content_inhalt));

            $fb_id = $inhalt->fb_id;
            $twitter_id = $inhalt->twitter_id;
            $instagram_id = $inhalt->instagram_id;
            $youtube_id = $inhalt->youtube_id;
        }


?>

<div style="background-color: #FFFFFF;">
    <div  style="padding: 10px; background-color: #e1e1e1;">
        Article Name : <input name="articlename" type="text" value="<?=$content->content_name;?>"  id="articlename" placeholder="Enter Title">
        <input type="text" name="cat_order" id="cat_order">
    </div>

    <div  style="padding: 20px; ">



        <div id="socmed_container" style="padding: 20px;">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="fb_id" class="col-sm-2 control-label">Facebook ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fb_id" value="<?=$fb_id;?>" placeholder="Facebook ID">
                    </div>
                </div>
                <div class="form-group">
                    <label for="twitter_id" class="col-sm-2 control-label">Twitter ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="twitter_id" value="<?=$twitter_id;?>" placeholder="Twitter ID">
                    </div>
                </div>
                <div class="form-group">
                    <label for="instagram_id" class="col-sm-2 control-label">Instagram ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="instagram_id" value="<?=$instagram_id;?>" placeholder="Instagram ID">
                    </div>
                </div>
                <div class="form-group">
                    <label for="youtube_id" class="col-sm-2 control-label">Youtube ID</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="youtube_id" value="<?=$youtube_id;?>" placeholder="Youtube ID">
                    </div>
                </div>
            </form>

        </div>




    </div>

    <div class="clearfix"></div>
    <div class="col-md-12" style="padding: 10px; text-align: center;">
        <button type="submit" id="save_<?=$content->content_id;?>" class="btn btn-danger" style="width: 100%;">SAVE</button>
    </div>



</div>
<style>
    .ui-dialog{
        z-index: 5000;
    }

</style>
        <script>
            $('#save_<?=$content->content_id;?>').click(function(){
                var articlename = $('#articlename').val();

                var fb_id = $('#fb_id').val();
                var twitter_id = $('#twitter_id').val();
                var instagram_id = $('#instagram_id').val();
                var youtube_id = $('#youtube_id').val();


                var inhalt = {
                    instagram_id : instagram_id,
                    fb_id : fb_id,
                    twitter_id : twitter_id,
                    youtube_id : youtube_id
                };

                var json = JSON.stringify(inhalt);


                $.post("<?=_SPPATH;?>AppContentWS/editTypeB",
                    {content_id:<?=$this->content->content_id;?>,
                        articlename:articlename,
                        inhalt:json
                    },
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