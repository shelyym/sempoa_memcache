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

    <link rel="stylesheet" href="<?=_SPPATH;?>css/animate.css">

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
            background-color: #EDEDED;
            color: #73879C;
        }



    </style>

    <style>
        <?
        //load custon css
        echo ThemeReg::mod("custom_css","","text");
        ?>
    </style>

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


<? Mold::theme("afterBodyJS"); ?>
<? Mold::theme("ajaxLoader"); ?>
<!-- Navigation -->

<div id="maincontent">
    <?= $content; ?>
</div>

<?
global $modalReg;
$modalReg->printCropperModal();
?>

<?// Cropper::createModal("bannID","Banner","info_banner","542:400",array("mbannerImg","bannID_prev")); ?>
<?// Cropper::createModal("logoID","Profile Picture","info_profilepic","400:400",array("mlogoImg","logoID_prev")); ?>

<?/*
<script src="<?=_SPPATH;?>js/modernizr.js"></script>
*/?>

<!-- Bootstrap Core JavaScript -->
<script src="<?=_SPPATH._THEMEPATH;?>/js/bootstrap.min.js"></script>

</body>

</html>
