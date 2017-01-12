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
<link href="<?=_SPPATH."themes/startbs";?>/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="<?=_SPPATH."themes/startbs";?>/css/landing-page.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="<?=_SPPATH."themes/startbs";?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<?/*<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
*/?>
<!-- pricing -->
<?/* <link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>*/ ?>

<link rel="stylesheet" href="<?=_SPPATH;?>css/animate.css">

<!-- pure drawer -->
<link rel="stylesheet" href="<?=_SPPATH;?>css/pure-drawer.css"/>

<!-- jQuery -->
<script src="<?=_SPPATH."themes/startbs";?>/js/jquery.js"></script>
<script src="<?=_SPPATH."themes/startbs";?>/js/modernizr.js"></script>



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
body,.pure-pusher,#maincontent{
    font-weight: normal;
    background-color: #FFFFFF;
    color: #73879C;
}



.nav-primary {
    margin: 0;
    padding: 100px 0 0 0;
    border-bottom: 1px solid #24323d;
}

.nav-primary li {
    border-top: 1px solid #24323d;
    border-bottom: 1px solid #3f566a;
}

.nav-primary li a {
    display: block;
    color: #f0f0f0;
    padding: 10px 15px;
}

.nav-primary li a:hover {
    background-color: #555264;
}

@media only screen and (min-width: 64.063em) {
    [data-position="top"] .nav-primary {
        padding: 25px 0;
        border: none;
    }
    [data-position="top"] .nav-primary li {
        display: inline;
        border: none;
        margin-right: 10px;
    }
    [data-position="top"] .nav-primary li a {
        display: inline-block;
    }
}

.row.collapse .columns {
    padding-left: 0;
    padding-right: 0;
}

.pure-toggle-label{
    width: 50px;
    height: 50px;
}
.pure-toggle-label .pure-toggle-icon, .pure-toggle-label .pure-toggle-icon:before, .pure-toggle-label .pure-toggle-icon:after{
    width: 20px;
    top: 55%;
}

#attratas{
    text-align: right;
    margin-bottom: 20px;
    margin-right: 15px;
}


.stats{
    background-color: #F7F7F7;
    min-height: 120px;
    text-align: center;
    border: 1px solid #dedede;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #73879C;
}
.green{
    color: #73879C;
    /*#73879C*/
}
.stats_text{
    font-style: italic;
}
.stats_number_big{
    font-size: 50px;
}
.stats_money{
    font-weight: bold;
    font-size: 20px;
    /*color: #009688;*/
}

.btn-abu{
    background-color:#C5C7CB; border-color: #C5C7CB;
}

.btn-abu:hover{
    background-color: #73879C; border-color: #73879C;
}
.slidercolor{
    color: #374c5d;
}
.appear_logo_pages{

}
hr{
    border-color: #C5C7CB;
    color: #C5C7CB;
}

.strike {
    display: block;
    text-align: center;
    overflow: hidden;
    white-space: nowrap;
    padding-top: 20px;
    padding-bottom: 20px;
}

.strike > span {
    position: relative;
    display: inline-block;
    color: #73879C;
    font-size: 20px;
}

.strike > span:before,
.strike > span:after {
    content: "";
    position: absolute;
    top: 50%;
    width: 9999px;
    height: 1px;
    background: #73879C;
}

.strike > span:before {
    right: 100%;
    margin-right: 15px;
}

.strike > span:after {
    left: 100%;
    margin-left: 15px;
}

.back_to_button{
    margin-top: 5px;
    text-align: right;
}
a{
    color: #005c32;
}

.btn-appeargreen {
    color: #fff;
    background-color: #008247;
    border-color: #008247;
}
.btn-appeargreen:hover,.btn-appeargreen:focus{
    background-color: #00a157;
    border-color: #00a157;
}
#maincontent{
    padding-bottom: 100px;
}


/*tambahan*/
#popup_dalam,#popup_dalam_2,#popup_dalam_3{
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 1002;
}

#popup_dalam_2{
    z-index: 1102;
}
#popup_dalam_3{
    z-index: 1202;
}

.daleman{
    margin: auto;
    margin-top: 30px;
    /*background-color: #FFFFFF;*/
    min-height: 300px;

}

@media (max-width: 768px) {

    .monly {
        display: initial;
    }

    .donly {
        display: none;
    }

    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
        padding-left: 0px;
        padding-right: 0px;

    }

    .container{
        margin: 10px;
    }

    .appear_logo_pages{
        text-align: right;
        margin-top: 15px;
        margin-bottom: 15px;
        margin-right: 10px;
    }
    .appear_logo_pages img{
        width: 60%;

    }
    .berpadding{
        margin-left: 15px; margin-right: 15px;
    }
    #popup_dalam,#popup_dalam_2,#popup_dalam_3{
        /*width: 100%;*/
        /*height: 100%;*/
        padding: 30px;
    }

    .daleman{
        /*margin: auto;*/

        /*background-color: #FFFFFF;*/
        /*min-height: 500px;*/
        height: 100%;
        margin: 0px;
        padding-left: 0px;
        padding-right: 0px;
        overflow: auto;
    }

}

@media (min-width: 768px) {
    .monly {
        display: none;
    }

    .donly {
        display: initial;
    }

    .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
        padding-left: 0px;
        padding-right: 0px;

    }
    .appear_logo_pages{
        text-align: center;
        margin-top: 25px;
        margin-bottom: 25px;
    }
    .appear_logo_pages img{
        width: 250px;

    }
    .form-horizontal .control-label{
        padding-right: 10px;
    }


}
</style>

<style>
    <?
    //load custon css
    echo ThemeReg::mod("custom_css","","text");
    ?>
</style>

<script>
    function OnImageLoad(evt, sq) {


        var img = evt.currentTarget;


        // what's the size of this image and it's parent

        var w = img.width;

        var h = img.height;

        var tw = sq;

        var th = sq;


        // compute the new size and offsets

        var result = ScaleImage(w, h, tw, th, false);


        // adjust the image coordinates and size

        img.width = result.width;

        img.height = result.height;

        //alert(result.targetleft);

        img.style.marginLeft = result.targetleft + "px"

        img.style.marginTop = result.targettop + "px"

        // img.setStyle({left: result.targetleft});

        // img.setStyle({top: result.targettop});

    }

    function resizeAndJustify(id, sq) {


        var img = document.getElementById(id);


        // what's the size of this image and it's parent

        var w = img.width;

        var h = img.height;

        var tw = sq;

        var th = sq;


        // compute the new size and offsets

        var result = ScaleImage(w, h, tw, th, false);


        // adjust the image coordinates and size

        img.width = result.width;

        img.height = result.height;

        //alert(result.targetleft);

        img.style.marginLeft = result.targetleft + "px"

        img.style.marginTop = result.targettop + "px"

        // img.setStyle({left: result.targetleft});

        // img.setStyle({top: result.targettop});

    }


    function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {


        var result = {width: 0, height: 0, fScaleToTargetWidth: true};


        if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {

            return result;

        }


        // scale to the target width

        var scaleX1 = targetwidth;

        var scaleY1 = (srcheight * targetwidth) / srcwidth;


        // scale to the target height

        var scaleX2 = (srcwidth * targetheight) / srcheight;

        var scaleY2 = targetheight;


        // now figure out which one we should use

        var fScaleOnWidth = (scaleX2 > targetwidth);

        if (fScaleOnWidth) {

            fScaleOnWidth = fLetterBox;

        }

        else {

            fScaleOnWidth = !fLetterBox;

        }


        if (fScaleOnWidth) {

            result.width = Math.floor(scaleX1);

            result.height = Math.floor(scaleY1);

            result.fScaleToTargetWidth = true;

        }

        else {

            result.width = Math.floor(scaleX2);

            result.height = Math.floor(scaleY2);

            result.fScaleToTargetWidth = false;

        }

        result.targetleft = Math.floor((targetwidth - result.width) / 2);

        result.targettop = Math.floor((targetheight - result.height) / 2);


        return result;

    }
</script>

<!-- Bootstrap Core JavaScript -->
<script src="<?=_SPPATH."themes/startbs";?>/js/bootstrap.min.js"></script>

<script src="<?=_SPPATH;?>js/jqueryui_new.js"></script>
<?/*
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyp-FS8fjqi7tU71GyE6xObvyRw_vUOic&callback=initMap"
            type="text/javascript"></script>*/?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyp-FS8fjqi7tU71GyE6xObvyRw_vUOic"></script>
</head>

<body>
<script>

    var popuphistory = [];
    var popupmode = "";
    function removeBGBlack(){
        $('.bgblack').hide();
        $('#popup_ss').hide();
//        alert("ha");
//        var obj = {};
//        var title = 'back';
//        var url = '?t=1';
//        history.replaceState(obj, title, url);

        if(popupmode == "edu_video"){
            $('#popup_isi').html(" ");
        }
        $('#popup_isi').html(" ");
    }

    function loadPopUp(url,id,mode){
        $('.bgblack').show();
        $('#loadingtop').show();
        $('#popup_ss').show();
        popupmode = mode;
        $.get(url,function(data){

            $('#popup_isi').html(data);
            $('#loadingtop').hide();

//            var obj = {'pop_id': id, 'url': url,'mode':mode};
//            var title = mode+id;
//            var url = '?st=' + id+'&mode='+mode;
//            history.replaceState(obj, title, url);


        });
    }

    //scrool

    function scrolltoTop(){

        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;

    }


    //addon utk 3 layer

    function removeBGBlack2(){
        $('.bgblack2').hide();
        $('#popup_ss_2').hide();
//        alert("ha");
//        var obj = {};
//        var title = 'back';
//        var url = '?t=1';
//        history.replaceState(obj, title, url);

        if(popupmode == "edu_video"){
            $('#popup_isi_2').html(" ");
        }
        $('#popup_isi_2').html(" ");
    }

    function removeBGBlack3(){
        $('.bgblack3').hide();
        $('#popup_ss_3').hide();
//        alert("ha");
//        var obj = {};
//        var title = 'back';
//        var url = '?t=1';
//        history.replaceState(obj, title, url);

        if(popupmode == "edu_video"){
            $('#popup_isi_3').html(" ");
        }
        $('#popup_isi_3').html(" ");
    }


    function loadPopUp2(url,id,mode){
        $('.bgblack2').show();
        $('#loadingtop').show();
        $('#popup_ss_2').show();
        popupmode = mode;
        $.get(url,function(data){

            $('#popup_isi_2').html(data);
            $('#loadingtop').hide();

//            var obj = {'pop_id': id, 'url': url,'mode':mode};
//            var title = mode+id;
//            var url = '?st=' + id+'&mode='+mode;
//            history.replaceState(obj, title, url);


        });
    }

    function loadPopUp3(url,id,mode){
        $('.bgblack3').show();
        $('#loadingtop').show();
        $('#popup_ss_3').show();
        popupmode = mode;
        $.get(url,function(data){

            $('#popup_isi_3').html(data);
            $('#loadingtop').hide();

//            var obj = {'pop_id': id, 'url': url,'mode':mode};
//            var title = mode+id;
//            var url = '?st=' + id+'&mode='+mode;
//            history.replaceState(obj, title, url);


        });
    }
</script>
<style>
    #popup_ss{

    }
    .bgblack,.bgblack2,.bgblack3{
        background-color: rgba(0,0,0,0.7);
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 1001;
    }
    .bgblack2{
        background-color: rgba(0,0,0,0.8);
        z-index: 1101;
    }
    .bgblack3{
        background-color: rgba(0,0,0,0.9);
        z-index: 1201;
    }

    #popup_isi{

    }
</style>
<div class="bgblack" style="display: none;"></div>
<div id="loadingpopup" style="text-align: center; display:none;position: fixed; width: 100%; margin-top: 100px; z-index:1005;"><img src="<?=_SPPATH;?>images/greenpreloader.gif"></div>

<div id="popup_ss" style="display: none;">
    <div onclick="removeBGBlack();" style="position: fixed; z-index: 1003; right: 0px; top: 0px; cursor:pointer;  color: #FFFFFF; padding:10px;">
        <i  class="glyphicon glyphicon-remove"></i>
    </div>

    <div  id="popup_dalam">
        <div class="container daleman ">

            <div id="popup_isi"></div>
        </div>
    </div>
</div>

<div class="bgblack2" style="display: none;"></div>
<div id="popup_ss_2" style="display: none;">
    <div onclick="removeBGBlack2();" style="position: fixed; z-index: 1103; right: 0px; top: 0px; cursor:pointer;  color: #FFFFFF; padding:10px;">
        <i  class="glyphicon glyphicon-remove"></i>
    </div>

    <div  id="popup_dalam_2">
        <div class="container daleman ">

            <div id="popup_isi_2"></div>
        </div>
    </div>
</div>

<div class="bgblack3" style="display: none;"></div>
<div id="popup_ss_3" style="display: none;">
    <div onclick="removeBGBlack3();" style="position: fixed; z-index: 1203; right: 0px; top: 0px; cursor:pointer;  color: #FFFFFF; padding:10px;">
        <i  class="glyphicon glyphicon-remove"></i>
    </div>

    <div  id="popup_dalam_3">
        <div class="container daleman ">

            <div id="popup_isi_3"></div>
        </div>
    </div>
</div>



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

<? if(Auth::isLogged()){?>
    <div class="logoutbtn">
        <input type="hidden" id="backbutton_url">
        <div style="position: absolute; left: 0px;top: 0px; padding-left: 10px; height: 40px; line-height: 40px;">
            <a style="display: none;cursor: pointer;" id="gotoback" onclick="gotoback();"><i class=" glyphicon glyphicon-arrow-left"></i></a>
        </div>
        <div style="position: absolute; right: 0px; top: 0px; padding-right: 10px; height: 40px; line-height: 40px;">
            <a title="My Apps" href="<?=_SPPATH;?>myapps"><i class="glyphicon glyphicon-phone"></i> </a> &nbsp; <a href="<?=_SPPATH;?>logout" title="Log Out"><i class="glyphicon glyphicon-log-out"></i></a>
        </div>
        <span class="pagetitle"><? global $template; echo $template->pagetitle; ?></span>
        <!--    <img height="20px" src="--><?//=_SPPATH;?><!--images/logobridgewhite.png">-->
    </div>
    <script>
        function gotoback(){
            var id = $('#backbutton_url').val();
            var url = data_of_pages[id].url;
            var pagetitle = data_of_pages[id].pagetitle;
            var back_id = data_of_pages[id].back_id;
            if(id!="")
                addPage(id,url,pagetitle,back_id);
        }
        function sethistoryback(id){
            $('#gotoback').show();
            $('#backbutton_url').val(id);
        }
        function hidebackbutton(){
            $('#gotoback').hide();
            $('#backbutton_url').val("");
        }
    </script>
    <style>
        .logoutbtn{
            background-color: #E65100;
            padding: 10px;
            text-align: center;
            height: 40px;

            color: white;
        }
        .logoutbtn a{
            color: white;
            text-decoration: none;
        }
        .pagetitle{
            font-size: 17px;
        }
    </style>
<? } ?>
<div class="container">
    <?= $content; ?>
</div>

<script>
    var $loading = $('#loadingtop').hide();
    $(document)
        .ajaxStart(function () {
            $loading.show();
        })
        .ajaxStop(function () {
            $loading.hide();
        });




</script>
<?
global $modalReg;
$modalReg->printCropperModal();
?>

<?// Cropper::createModal("bannID","Banner","info_banner","542:400",array("mbannerImg","bannID_prev")); ?>
<?// Cropper::createModal("logoID","Profile Picture","info_profilepic","400:400",array("mlogoImg","logoID_prev")); ?>

<?/*
<script src="<?=_SPPATH;?>js/modernizr.js"></script>
*/?>
<script src="<?= _SPPATH; ?>themes/adminlte2/dist/cropper.js"></script>
<style>
    .pure-drawer{
        background-color: #484654;
    }

    .pure-toggle[data-toggle='left']:checked ~ .pure-toggle-label[data-toggle-label='left'], .pure-toggle[data-toggle='right']:checked ~ .pure-toggle-label[data-toggle-label='right'], .pure-toggle[data-toggle='top']:checked ~ .pure-toggle-label[data-toggle-label='top']{
        border-color: #848196;
        color: #848196;
    }
    .pure-toggle-label .pure-toggle-icon, .pure-toggle-label .pure-toggle-icon:before, .pure-toggle-label .pure-toggle-icon:after{
        background: #848196;
    }

    .pure-toggle-label:hover .pure-toggle-icon, .pure-toggle-label:hover .pure-toggle-icon:before, .pure-toggle-label:hover .pure-toggle-icon:after{
        background: #848196;
    }
    .pure-toggle-label:hover{
        /*background: #C5C7CB;*/
        border: 2px solid #848196;
    }
    .pure-toggle-label:focus,.pure-toggle-label:visited,.pure-toggle-label:link{
        border: 2px solid #848196;
    }
    .pure-toggle-label{
        border: 2px solid #848196;
    }

</style>

</body>

</html>
