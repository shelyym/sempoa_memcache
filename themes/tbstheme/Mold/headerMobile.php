<nav class="navbar navbar-default navbar-custom navbar-fixed-top monly">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div style="position: absolute; top: 5px; left: 5px;">
                <a href="<?= _SPPATH; ?>">
                    <?
                $bgimage = ThemeReg::mod("logo_mobile", _SPPATH._THEMEPATH."/images/h3bg.jpg","image");
                ?>
                    <img height="40px" src="<?= $bgimage; ?>">
                </a>
            </div>
            <!--<a class="navbar-brand" href="<?= _SPPATH; ?>"><img style="height: 20px;" src="<?= _SPPATH; ?>images/logo2.png"></a>-->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <? PortalTemplate::printMenuMobile(); ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>