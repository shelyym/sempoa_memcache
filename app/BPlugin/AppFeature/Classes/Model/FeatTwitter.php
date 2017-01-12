<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 10:56 PM
 */

class FeatTwitter extends ZAppFeatureSocial{

    public $feat_name = "Twitter";
    public $feat_id = "twitter";
    public $feat_icon = "ic_twitter.png";

    public $feat_tab_icon = "ic_twitter.png";
    public $feat_rank_tampil = 23;

    public $feat_active = 1;

    public function socialJSLoader(){
        ?>
        <script>
            function loadSocial_<?=$this->feat_id;?>(socialID){
                var slc = $('#<?=$this->feat_id."_social_id";?>').val();
                $.post("<?=_SPPATH;?>SocMedParser/tw",{
                    pid : slc
                },function(datas){

//                   datanya lsg array

                    var html = '';
                    if(datas[0].text !== null) {
//                        console.log(arrs);


                        for (var x = 0; x < datas.length; x++) {
                            var obj = datas[x];

                            html += '<div class="socmed_item">';
                            if(obj.hasOwnProperty('entities'))
                            if (obj.entities.hasOwnProperty('media')) {
                                var arrmedia = obj.entities.media;
//                                var el1 = arrmedia.pop();
//                                console.log(el1);
                                console.log(arrmedia);
                                for(var y=0;y<arrmedia.length;y++) {
                                    var media = arrmedia[y];
                                    if(media.media_url !== null)
                                    html += '<div class="socmed_img"><img src="' + media.media_url + '"></div>';
                                }
                            }
                            html += '<div class="socmed_name">' + obj.text.substring(0,100) + '...</div>';

                            html += '</div>';

                        }
                    }
                    else{
                        html += "error<br>make sure you enter the right pageID";
                    }

                    $('#<?=$this->feat_id;?>_social_load').html(html);
                },'json');

            }

            $(document).ready(function(){
                var slc = $('#<?=$this->feat_id."_social_id";?>').val();
                if(slc != ''){
//                    loadSocial_<?//=$this->feat_id;?>//(slc);
                }
            });
        </script>
        <style>
            .socmed_item{
                background-color: #FFFFFF;
                margin-bottom: 10px;
            }
            .socmed_img img{
                width: 100%;
            }
            .socmed_name{
                padding: 10px;
                color: #666666;
            }
        </style>
    <?
    }
} 