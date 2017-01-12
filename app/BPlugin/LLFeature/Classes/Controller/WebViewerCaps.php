<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 9/3/15
 * Time: 9:59 PM
 */

class WebViewerCaps extends WebService{

    static function template($text){

        ?>
        <html>
        <head>

            <link href="<?= _SPPATH; ?>js/css/bootstrap.min.css" rel="stylesheet">
            <script src="<?= _SPPATH; ?>js/jquery-1.11.1.js"></script>
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->


        </head>
        <body>
        <div class="container">
            <div style="padding: 10px;">
            <?=$text;?>
            </div>
        </div>
        <script src="<?= _SPPATH; ?>js/bootstrap.min.js"></script>
        </body>
        </html>
        <?
    }


    static function templateAppear($psn){

        ?>
        <html>
        <head>

            <link href="<?= _SPPATH; ?>js/css/bootstrap.min.css" rel="stylesheet">
            <script src="<?= _SPPATH; ?>js/jquery-1.11.1.js"></script>
            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->


        </head>
        <body>
<!--        <div class="container">-->
            <?
            if($psn->camp_img != ''){
                if($psn->camp_url!=''){
                    ?>
                    <a href="<?=$psn->camp_url;?>">
                <?
                }
                ?>
                <img src="<?=_SPPATH._PHOTOURL.$psn->camp_img;?>" width="100%">
                <?
                if($psn->camp_url!=''){
                    ?>
                    </a>
                <?
                }
            }
            ?>
            <div style="padding: 10px;">
                <?=$psn->camp_msg;?>
            </div>

<?
if($psn->camp_url!=''){
?>
<div style="padding: 10px;text-align: center; ">

<a class="btn btn-default btn-lg" style="width: 100%;" href="<?=$psn->camp_url;?>">OPEN</a>
    </div>
    <?
    }
    ?>
<!--        </div>-->
        <script src="<?= _SPPATH; ?>js/bootstrap.min.js"></script>
        </body>
        </html>
    <?
    }

    function news($args){
        list($id) = $args;

        $nn = new LL_News();
        $nn->getByID($id);

        self::template(stripslashes($nn->news_content));

    }
    function offers($args){
        list($id) = $args;

        $nn = new LL_Program();
        $nn->getByID($id);

        self::template(stripslashes($nn->prog_content));

    }
    function messages($args){
        list($id) = $args;

        $nn = new PushNotCampCaps();
        $nn->getByID($id);

        self::templateAppear($nn);

    }
} 

