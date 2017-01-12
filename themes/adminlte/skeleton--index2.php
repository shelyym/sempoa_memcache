<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $metaKey; ?>
    <?= $metaDescription; ?>
    <? $this->getHeadfiles(); ?>
    <!-- Loading Bootstrap -->
    <link href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon"
	      type="image/png"
	      href="<?= _SPPATH; ?>kcfinder/favicon.ico" />

    <style>
        body {
            padding-top: 10px;
            padding-bottom: 40px;
            background-color: #75863f;
            color: white;
            font-size: 18px;
            <?         
            $active_theme = ThemeItem::getTheme();
            global $themepath;
            $sem = $themepath;
            $themepath = $active_theme;
            $bgcolor = ThemeReg::mod("index_bodybg", "#ffffff","color"); 
            $bgimage = ThemeReg::mod("index_bodybgimage", _SPPATH."images/forrest.jpg","image"); 
            $strbgimage = '';
            if($bgimage!=""){
                $strbgimage = 'background-image: url("'.$bgimage.'"); background-repeat: repeat;
        background-attachment: fixed;';
            }
            
        
        ?>
            background-image: url('<?=_SPPATH;?>images/forrest.jpg');
            background-repeat: repeat;
            background-attachment: fixed;
            background-position: center;
        }

        .form-signin {
            max-width: 300px;
            padding: 15px;
            margin: 0 auto;
        }

        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }

        .form-signin .checkbox {
            font-weight: normal;
        }

        .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
        }

        .form-signin .form-control:focus {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        html {
            position: relative;
            min-height: 100%;
        }

        body {
            /* Margin bottom by footer height */
            margin-bottom: 40px;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 40px;
            /*background-color: #305029;*/
            text-align: center;
            color: white;
            line-height: 40px;
            font-size: 13px;
            letter-spacing: 2px;
        }

        label.checkbox {
            display: block;
            text-align: center;
        }

        /* Toggle Styles */

        #wrapperLeft {
            padding-left: 0;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapperLeft.toggled {
            padding-left: 250px;
        }

        #sidebar-wrapper {
            z-index: 1000;
            position: fixed;
            left: 250px;
            width: 0;
            height: 100%;
            margin-left: -250px;
            overflow-y: auto;
            background: #000;
            -webkit-transition: all 0.5s ease;
            -moz-transition: all 0.5s ease;
            -o-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }

        #wrapper.toggled #sidebar-wrapper {
            width: 250px;
        }

        #page-content-wrapper {
            width: 100%;
            padding: 15px;
        }

        #wrapper.toggled #page-content-wrapper {
            position: absolute;
            margin-right: -250px;
        }

        

        .btn-primary {
            <?
            $bgcolor1 = ThemeReg::mod("index_button_color", "#305029","color"); 
            $bgcolor2 = ThemeReg::mod("index_button_color_border", "#75863f","color"); 
            ?>
            background-color: <?=$bgcolor1;?> !important;
            border-color: <?=$bgcolor2;?>;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.active, .open .dropdown-toggle.btn-primary {
            <?
            $bgcolor = ThemeReg::mod("index_button_color_hover", "#305029","color"); 
            $themepath = $sem;
            ?>
            background-color: <?=$bgcolor;?>;
        }
        label.checkbox {
            text-align: left;
            letter-spacing: 3px;
        }

        .checkboxspan {
            text-align: left;
        }
    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body <?= $onLoad; ?>>
    <div style="position: absolute; top:0; left:0; width: 300px; z-index: 2;">
        <img src="<?=_SPPATH;?>images/kananatas.png" style="width: 60%; margin-left: 10px; margin-top: 20px;" >
    </div>
    <div style="position: absolute; top:0; right:0; width: 300px;" align="right">
        <img src="<?=_SPPATH;?>images/atassatunya.png" style="width: 65%; margin-right: 10px; margin-top: 20px;" >
    </div>
<div class="container">
    <div style=" text-align: center; margin-top: 100px; margin-bottom: 50px;" class="col-md-6 col-md-offset-3">

            <?
            $bgimage =  _SPPATH."images/logo-hybris.png";
            ?>
        <img src='<?=$bgimage; ?>' style="width: 100%;">
        <h3 style="text-align: center; letter-spacing: 2px;"><?=Efiwebsetting::getData("backend_title");?></h3>
        </div>
    <?= $content; ?>
</div>
<div class="footer">
    <div class="container">
        &copy; www.leap-systems.com
    </div>
</div>
<!-- /.container -->


<!-- Load JS here for greater good =============================-->
<script src="<?= _SPPATH; ?>js/jquery-1.11.1.js"></script>
<script src="<?= _SPPATH; ?><?= _THEMEPATH; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _SPPATH; ?>js/viel-windows-jquery.js"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57533726-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>