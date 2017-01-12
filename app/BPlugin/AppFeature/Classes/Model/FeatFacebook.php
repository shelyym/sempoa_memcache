<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 1/18/16
 * Time: 9:46 PM
 */

class FeatFacebook extends ZAppFeatureSocial{
    public $feat_name = "Facebook";
    public $feat_id = "facebook";
    public $feat_icon = "ic_facebook.png";

    public $feat_tab_icon = "ic_facebook.png";
    public $feat_rank_tampil = 21;

    public $feat_active = 1;

    public function socialJSLoader(){
        ?>
        <script>
            function loadSocial_<?=$this->feat_id;?>(socialID){
                var slc = $('#<?=$this->feat_id."_social_id";?>').val();
                $.post("<?=_SPPATH;?>SocMedParser/fb",{
                    pid : slc
                },function(datas){
//                    console.log(datas);

                    var html = '';
                    if(datas.data !== null) {
//                        console.log(arrs);

                        var arrs = datas.data;
                        for (var x = 0; x < arrs.length; x++) {
                            var obj = arrs[x];

                            html += '<div class="socmed_item">';
                            if (obj.full_picture !== null) {
                                html += '<div class="socmed_img"><img src="' + obj.full_picture + '"></div>';
                            }
                            html += '<div class="socmed_name">' + obj.name.substring(0,100) + '...</div>';

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
//                   loadSocial_<?//=$this->feat_id;?>//(slc);
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