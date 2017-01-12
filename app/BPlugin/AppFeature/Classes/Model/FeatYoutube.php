<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/20/16
 * Time: 10:56 PM
 */

class FeatYoutube extends ZAppFeatureSocial{

    public $feat_name = "Youtube";
    public $feat_id = "youtube";
    public $feat_icon = "ic_youtube.png";

    public $feat_tab_icon = "ic_youtube.png";
    public $feat_rank_tampil = 24;

    public $feat_active = 1;

    public function socialJSLoader(){
        ?>
        <script>
            function loadSocial_<?=$this->feat_id;?>(socialID){
                var slc = $('#<?=$this->feat_id."_social_id";?>').val();
                $.post("<?=_SPPATH;?>SocMedParser/yt",{
                    pid : slc
                },function(datas){
//                    console.log(datas);

                    var html = '';
                    if(datas.hasOwnProperty('items')) {
//                        console.log(arrs);

                        var arrs = datas.items;
                        console.log(arrs);

                        for (var x = 0; x < arrs.length; x++) {
                            var obj = arrs[x].snippet;

                            html += '<div class="socmed_item">';
                            if (obj.hasOwnProperty('thumbnails')) {
                                html += '<div class="socmed_img"><img src="' + obj.thumbnails.medium.url + '"></div>';
                            }
                            html += '<div class="socmed_name">' + obj.title.substring(0,100) + '...</div>';

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