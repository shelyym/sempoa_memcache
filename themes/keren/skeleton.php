<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= $title; ?></title>
<?= $metaKey; ?>
<?= $metaDescription; ?>

<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<link href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/css/bootstrap.min.css" rel="stylesheet">
<script src="<?= _SPPATH; ?>js/jquery-1.11.1.js"></script>
<? $this->getHeadfiles(); ?>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->
  
<style>
 <? 
 //load custon css
 echo ThemeReg::mod("custom_css","","text");
 ?>

</style>
</head>
<body>
<? Mold::plugin("FacebookLogin","facebookjs"); ?>


<? Mold::theme("afterBodyJS"); ?>
<? Mold::theme("ajaxLoader"); ?>
<div class="container">

      <!-- Static navbar -->
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li <? if($_GET['url']=="index"||$_GET['url']==""){?>class="active"<?}?> ><a href="<?=_SPPATH;?>index">Home</a></li>



              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <? if(Auth::isLogged()){?>
                    <li <? if($_GET['url']=="mydashboard"){?>class="active"<?}?>><a  href="<?=_SPPATH;?>mydashboard">My Dashboard</a></li>
                    <li><a href="<?=_SPPATH;?>logout">Logout</a></li>
                <?}else{?>
                    <li <? if($_GET['url']=="loginpage"){?>class="active"<?}?>><a  href="<?=_SPPATH;?>loginpage">Loginpage</a></li>
                <?}?>
<!--              <li class="active"><a href="./">Default <span class="sr-only">(current)</span></a></li>-->
<!--              <li><a href="../navbar-static-top/">Static top</a></li>-->
<!--              <li><a href="../navbar-fixed-top/">Fixed top</a></li>-->
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        
        
        <div id="lw_content" class="row" ></div>

        <div id="content_utama">
            <?= $content; ?>
        </div>
      </div>

    </div> <!-- /container -->

<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>

   


<? Mold::theme("modalLoader"); ?>
<!-- Load JS here for greater good =============================-->

<script src="<?= _SPPATH; ?><?= _THEMEPATH; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= _SPPATH; ?>js/viel-windows-jquery.js"></script>
</body>
</html>