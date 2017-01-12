<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $metaKey; ?>
    <?= $metaDescription; ?>

    <meta name="author" content="">

    <link rel="shortcut icon" href="<?=_SPPATH;?>favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?=_SPPATH;?>favicon.ico" type="image/x-icon">

    <title><?=$title;?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=_SPPATH._THEMEPATH;?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=_SPPATH._THEMEPATH;?>/css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=_SPPATH._THEMEPATH;?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <?/*<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
*/?>
    <!-- pricing -->
   <?/* <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>*/ ?>
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/css/pricing3.css?t=11">


    <!-- jQuery -->
    <script src="<?=_SPPATH._THEMEPATH;?>/js/jquery.js"></script>
    <script src="<?=_SPPATH._THEMEPATH;?>/js/modernizr.js"></script>

    <script src="<?=_SPPATH;?>js/jqueryui_new.js"></script>

    <script type="text/javascript" src="<?=_SPPATH;?>js/rangy-core.js"></script>
    <script type="text/javascript" src="<?=_SPPATH;?>js/rangy-classapplier.js"></script>


    <link rel="stylesheet" href="<?=_SPPATH;?>css/jqueryui.css">

    <link rel="stylesheet" href="<?= _SPPATH; ?>themes/adminlte2/dist/cropper.css">
    <link href="<?= _SPPATH; ?>css/bootstrap-colorpicker.css" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body{
            font-weight: normal;
        }
        .hype{
            text-align: center;
        }
        .attop{
            margin-top: 100px;
            margin-bottom: 100px;
            min-height: 360px;
        }

        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript,
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(<?=_SPPATH;?>images/Preloader_4.gif) center no-repeat #FFFFFF;

        }
        .se-pre-con2 {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;

/*            background: url(*/<?//=_SPPATH;?>/*images/Preloader_3.gif) center no-repeat #fff;*/
        }

        #navigator{
            padding: 5px;
            text-align: right;
            padding-right: 15px;
            background-color: #F7F7F7;
        }

        body{
            font-weight: normal;
            background-color: #FFFFFF;
            color: #73879C;
        }

        a{
            color: #73879C;
        }

        @media (max-width: 768px) {

            .monly {
                display: initial;
            }

            .donly {
                display: none;
            }
            .container{
                padding-right: 0px;
                padding-left: 0px;
            }
            .attop{
                margin-top: 0px;
                padding-top: 10px;
            }
            .hiddenform {
                /*position: absolute;*/
                /*z-index: 1000;*/
                padding: 10px;
                /*margin-left: -15px;*/
                /*width: 100%;*/
                /*margin-top: -72px;*/
                background-color: #F7F7F7;
                /*border: 1px solid #cccccc;*/
                /* border-radius: 5px; */
                /*height: 100%;*/
                /*overflow-x: hidden;*/
                /*overflow-y: auto;*/

            }


        }

        @media (min-width: 768px) {
            .monly {
                display: none;
            }

            .donly {
                display: initial;
            }
            .attop{
                margin-top: 10px;
            }
            .hiddenform{
                /*position: absolute;*/
                /*z-index: 1000;*/
                padding: 10px;
                /*margin-left:-15px;*/
                /*width: 570px;*/
                /*margin-top: -72px;*/
                background-color: #F7F7F7;
                /*border: 1px solid #cccccc;*/
                /*border-radius: 5px;*/
                /*min-height: 690px;*/
                /*max-height: 690px;*/
                overflow-x: hidden;
                overflow-y: auto;
                /*padding-bottom: 40px;*/
                max-height: 500px;
            }

        }
    </style>

    <style>
        <?
        //load custon css
        echo ThemeReg::mod("custom_css","","text");
        ?>
    </style>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
</head>

<body>
<?// Mold::plugin("FacebookLogin","facebookjs"); ?>
<div id="loadingtop" style="display:none; opacity: 0.3; position: fixed; width:100%; top:40%;z-index:200000000;">
    <div id="loadingtop2"
         style="text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #5c6e7d; font-weight: bold; margin:0 auto;">
        <img style="margin-bottom:10px;" src="<?= _SPPATH; ?>images/leaploader.gif"/>

        <div><?= Lang::t('lang_loading'); ?></div>
    </div>
</div>
<div class="se-pre-con"></div>
<div class="se-pre-con2" style="display: none;">
    <div style="text-align: center; padding-top: 100px;">
        <h1 >Verifying Payments..</h1>
        <h5>Do not close this window</h5>
    </div>
    </div>

<? Mold::theme("afterBodyJS"); ?>
<? Mold::theme("ajaxLoader"); ?>
<!-- Navigation -->
<? if($ok){?>
<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
    <div class="container topnav">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topnav" href="<?=_SPPATH;?>"><img style="margin-top: -5px;" height="35px" src="<?=_SPPATH;?>images/appear-icontext.png"></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
<!--                <li>-->
<!--                    <a href="--><?//=_SPPATH;?><!--about">About</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="--><?//=_SPPATH;?><!--pricing">Pricing</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="--><?//=_SPPATH;?><!--contact">Contact</a>-->
<!--                </li>-->

                <? if(Auth::isLogged()){?>
                    <li <? if($_GET['url']=="mydashboard"){?>class="active"<?}?>><a  href="<?=_SPPATH;?>mydashboard">My Dashboard</a></li>
                    <li>
                        <a href="<?=_SPPATH;?>apps/make">Make App</a>
                    </li>

                    <li><a href="<?=_SPPATH;?>logout">Logout</a></li>
                <?}else{?>
                    <li <? if($_GET['url']=="register"){?>class="active"<?}?>><a  href="<?=_SPPATH;?>register">Register</a></li>
                    <li <? if($_GET['url']=="loginpage"){?>class="active"<?}?>><a  href="<?=_SPPATH;?>loginpage">Login</a></li>
                <?}?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<? } ?>
<div id="maincontent">
<?= $content; ?>
</div>
<? if($ok){?>
<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-inline">
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="#about">About</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="<?=_SPPATH;?>pricing">Pricing</a>
                    </li>
                    <li class="footer-menu-divider">&sdot;</li>
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
                <p class="copyright text-muted small">Copyright &copy; Your Company 2014. All Rights Reserved</p>
            </div>
        </div>
    </div>
</footer>
<? } ?>
<?
global $modalReg;
$modalReg->printCropperModal();
?>

<?// Cropper::createModal("bannID","Banner","info_banner","542:400",array("mbannerImg","bannID_prev")); ?>
<?// Cropper::createModal("logoID","Profile Picture","info_profilepic","400:400",array("mlogoImg","logoID_prev")); ?>

<?/*
<script src="<?=_SPPATH;?>js/modernizr.js"></script>
*/?>

<script>
//paste this code under head tag or in a seperate js file.
// Wait for window load
$(window).load(function() {
// Animate loader off screen
$(".se-pre-con").fadeOut("slow");
});


var $loading = $('#loadingmobile').hide();
$(document)
    .ajaxStart(function () {
        $loading.show();
    })
    .ajaxStop(function () {
        $loading.hide();
    });

</script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=_SPPATH._THEMEPATH;?>/js/bootstrap.min.js"></script>
<script src="<?=_SPPATH._THEMEPATH;?>/js/pricing3.js"></script> <!-- Resource jQuery -->

<script src="<?= _SPPATH; ?>themes/adminlte2/dist/cropper.js"></script>
<script src="<?= _SPPATH; ?>js/bootstrap-colorpicker.js"></script>
<script type="text/javascript">
    function gEBI(id) {
        return document.getElementById(id);
    }

    var italicApplier, boldApplier, smallApplier, bigApplier;

    function toggleItalic() {
        italicApplier.toggleSelection();
    }

    function toggleBold() {
        boldApplier.toggleSelection();
    }

    function toggleSmall() {
        smallApplier.toggleSelection();
    }
    function toggleBig() {
        bigApplier.toggleSelection();
    }

    window.onload = function() {
        rangy.init();

        // Enable buttons
        var classApplierModule = rangy.modules.ClassApplier;

        // Next line is pure paranoia: it will only return false if the browser has no support for ranges,
        // selections or TextRanges. Even IE 5 would pass this test.
        if (rangy.supported && classApplierModule && classApplierModule.supported) {


            italicApplier = rangy.createClassApplier("extra", {
                elementTagName : "i",
                tagNames: ["i"]
            });

            boldApplier = rangy.createClassApplier("extra", {
                elementTagName : "b",
                tagNames: ["b"]
            });

            smallApplier = rangy.createClassApplier("extra", {
                elementTagName : "small",
                tagNames: ["small"]
            });

            bigApplier = rangy.createClassApplier("extra", {
                elementTagName : "big",
                tagNames: ["big"]
            });



        }
    };

    //strip tag
    function strip(html)
    {
        var tmp = document.createElement("DIV");
        tmp.innerHTML = html;
        return tmp.textContent || tmp.innerText || "";
    }

</script>


<style>
    .nav-pills.nav-wizard > li {
        position: relative;
        overflow: visible;
        border-right: 15px solid #fff;
        border-left: 15px solid #fff;
    }
    .nav-pills.nav-wizard > li:first-child {
        border-left: 0;
    }
    .nav-pills.nav-wizard > li:first-child a {
        border-radius: 5px 0 0 5px;
    }
    .nav-pills.nav-wizard > li:last-child {
        border-right: 0;
    }
    .nav-pills.nav-wizard > li:last-child a {
        border-radius: 0 5px 5px 0;
    }
    .nav-pills.nav-wizard > li a {
        border-radius: 0;
        background-color: #eee;
    }
    .nav-pills.nav-wizard > li .nav-arrow {
        position: absolute;
        top: 0px;
        right: -19px;
        width: 0px;
        height: 0px;
        border-style: solid;
        border-width: 18px 0 19px 19px;
        border-color: transparent transparent transparent #eee;
        z-index: 150;

    }
    .nav-pills.nav-wizard > li .nav-wedge {
        position: absolute;
        top: 0px;
        left: -19px;
        width: 0px;
        height: 0px;
        border-style: solid;
        border-width: 18px 0 19px 19px;
        border-color: #eee #eee #eee transparent;
        z-index: 150;
    }
    .nav-pills.nav-wizard > li:hover .nav-arrow {
        border-color: transparent transparent transparent #aaa;
    }
    .nav-pills.nav-wizard > li:hover .nav-wedge {
        border-color: #aaa #aaa #aaa transparent;
    }
    .nav-pills.nav-wizard > li:hover a {
        background-color: #aaa;
        color: #fff;
    }
    .nav-pills.nav-wizard > li.active .nav-arrow {
        border-color: transparent transparent transparent lightseagreen;
    }
    .nav-pills.nav-wizard > li.active .nav-wedge {
        border-color: lightseagreen lightseagreen lightseagreen transparent;
    }
    .nav-pills.nav-wizard > li.active a {
        background-color: lightseagreen;
    }

    a.lsg{
        color: lightseagreen;
        font-size: 12px;
    }

    li.active a.lsg{
        color: white;
    }
</style>
</body>

</html>
