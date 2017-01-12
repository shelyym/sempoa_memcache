<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <?= $metaKey; ?>
    <?= $metaDescription; ?>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/bootstrap/css/bootstrap.min.css">

    <? /*
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/ionicons/2.0.1/css/ionicons.min.css">

   */?>
 <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">



    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=_SPPATH._THEMEPATH;?>/dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/css/jqueryui.css">

    <link rel="stylesheet" href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/dist/cropper.css">
    <!-- Morris charts -->
    <link rel="stylesheet" href="<?= _SPPATH; ?><?= _THEMEPATH; ?>/plugins/morris/morris.css">

    <!--set all paths as javascript-->
    <? $this->printPaths2JS();?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <!-- jQuery 2.1.4 -->
    <script src="<?=_SPPATH._THEMEPATH;?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?= _SPPATH; ?>js/ckeditor_plus3/ckeditor/ckeditor.js"></script>
    <script src="<?= _SPPATH; ?>js/priceformat.js"></script>
    <script>
        /*
         * untuk menu kiri
         */
        var registorMenuKiri = [];
        function registerkanMenuKiri(id){
            registorMenuKiri.push(id);
        }
    </script>
    <? $this->getHeadfiles(); ?>

    <style>
        .h1, h1 {
            font-size: 26px;
            margin-bottom: 20px;

        }
        .CrudViewPagebutton {
            cursor:pointer;
            padding:10px;
            margin:1px;
            border-radius:5px;
            background-color:#dedede;
        }

        .lw_alert{
            padding: 10px;
        }
    </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">


<div id="loadingtop" style="display:none; opacity: 0.3; position: fixed; width:100%; top:40%;z-index:200000000;">
    <div id="loadingtop2"
         style="text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #5c6e7d; font-weight: bold; margin:0 auto;">
        <img style="margin-bottom:10px;" src="<?= _SPPATH; ?>images/leaploader.gif"/>

        <div><?= Lang::t('lang_loading'); ?></div>
    </div>
</div>


<div id="oktop" style="display:none;opacity: 0.3; position: fixed; width:100%; top:40%;z-index:20000000;">
    <div id="oktop2"
         style="text-align:center; padding: 10px; width:100px; border-radius:10px; color: white; background-color: #7db660; font-weight: bold; margin:0 auto;">
        <img style="margin-bottom:10px;" src="<?= _SPPATH; ?>images/ok.gif"/>

        <div style='font-size:48px;'><?= Lang::t('OK'); ?></div>
    </div>
</div>


<div class="wrapper">

<header class="main-header">

<!-- Logo -->
<a href="<?=_SPPATH;?>mydashboard" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><?=substr(Efiwebsetting::getData("backend_title"),0,3);?></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><?=substr(Efiwebsetting::getData("backend_title"),0,18);?></span>
</a>

<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
</a>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
<ul class="nav navbar-nav">
<!-- Messages: style can be found in dropdown.less-->
<li class="dropdown messages-menu">
    <!--    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
    <!--        <i class="fa fa-envelope-o"></i>-->
    <!--        <span class="label label-success">4</span>-->
    <!--    </a>-->
    <ul class="dropdown-menu">
        <li class="header">You have 4 messages</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li><!-- start message -->
                    <a href="#">
                        <div class="pull-left">
                            <img src="<?=_SPPATH._THEMEPATH;?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                    </a>
                </li>
                <!-- end message -->
                <li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="<?=_SPPATH._THEMEPATH;?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="<?=_SPPATH._THEMEPATH;?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="<?=_SPPATH._THEMEPATH;?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <div class="pull-left">
                            <img src="<?=_SPPATH._THEMEPATH;?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="footer"><a href="#">See All Messages</a></li>
    </ul>
</li>
<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
        <a href="<?=_SPPATH;?>mydashboard" >
            <i class="fa fa-exchange"></i>
<!--            <span class="label label-warning">10</span>-->
        </a>
    <ul class="dropdown-menu">
        <li class="header">You have 10 notifications</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li>
                    <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                        page and may cause design problems
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                </li>
            </ul>
        </li>
        <li class="footer"><a href="#">View all</a></li>
    </ul>
</li>
<!-- Tasks: style can be found in dropdown.less -->
<li class="dropdown tasks-menu">
    <!--    <a href="#" class="dropdown-toggle" data-toggle="dropdown">-->
    <!--        <i class="fa fa-flag-o"></i>-->
    <!--        <span class="label label-danger">9</span>-->
    <!--    </a>-->
    <ul class="dropdown-menu">
        <li class="header">You have 9 tasks</li>
        <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li><!-- Task item -->
                    <a href="#">
                        <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                        </h3>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">20% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                    <a href="#">
                        <h3>
                            Create a nice theme
                            <small class="pull-right">40%</small>
                        </h3>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">40% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                    <a href="#">
                        <h3>
                            Some task I need to do
                            <small class="pull-right">60%</small>
                        </h3>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">60% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                    <a href="#">
                        <h3>
                            Make beautiful transitions
                            <small class="pull-right">80%</small>
                        </h3>
                        <div class="progress xs">
                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only">80% Complete</span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- end task item -->
            </ul>
        </li>
        <li class="footer">
            <a href="#">View all tasks</a>
        </li>
    </ul>
</li>
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <img id="PPimage1" src="<?=_SPPATH.Account::getMyFoto();?>" class="user-image" alt="User Image">
        <span class="hidden-xs"><?= Account::getMyName(); ?></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
            <img id="PPimage2" src="<?=_SPPATH.Account::getMyFoto();?>" class="img-circle" alt="User Image">

            <p>
                <?= Account::getMyName(); ?> - <?= Account::getMyRole(); ?>
                <small>Last Update <?= date('l jS \of F Y h:i:s A',
                        strtotime(Account::getMyLastUpdate())); ?></small>
            </p>
        </li>
        <!-- Menu Body -->
        <!--<li class="user-body">
            <div class="row">
                <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                </div>
            </div>

        </li>-->
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="javascript:openLw('myProfile','<?=_SPPATH;?>AccountLoginWeb/myProfile','fade');" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="<?= _SPPATH; ?>logout" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>
<!-- Control Sidebar Toggle Button -->
<!--<li>-->
<!--    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--</li>-->
</ul>
</div>

</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <? Mold::theme("leftmenu_home"); ?>

    </section>
    <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- baru dari roy 17 dec 2015 -->
    <div id="success_permanent" class="lw_alert" style="display: none;">
    <div id="success_permanent_alert" class="alert alert-success">
        <a href="#" class="close" data-hide="alert" aria-label="close">&times;</a>
        <span id="success_permanent_span"></span>
    </div>
    </div>

    <div id="info_permanent" class="lw_alert" style="display: none;">
    <div  id="info_permanent_alert" class="alert alert-info">
        <a href="#" class="close" data-hide="alert" aria-label="close">&times;</a>
        <span id="info_permanent_span"></span>
    </div>
        </div>

    <div id="warning_permanent" class="lw_alert" style="display: none;">
    <div id="warning_permanent_alert" class="alert alert-warning">
        <a href="#" class="close" data-hide="alert" aria-label="close">&times;</a>
        <span id="warning_permanent_span"></span>
    </div>
        </div>

    <div id="danger_permanent" class="lw_alert" style="display: none;">
    <div id="danger_permanent_alert" class="alert alert-danger">
        <a href="#" class="close" data-hide="alert" aria-label="close">&times;</a>
        <span id="danger_permanent_span"></span>
    </div>
     </div>
    <!--end baru dari roy 17 dec 2015 -->

    <div id="lw_content" style="padding-top: 20px;"></div>
    <div id="content_utama" >
        <?= $content; ?>


    </div>

    <div class="clearfix" style="padding-bottom: 30px;"></div>
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">

    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.1
    </div>
    <strong>Copyright &copy; 2014-<?=date("Y");?> PT. Indo Mega Byte</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript::;">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->

        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript::;" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

</div>

<div class="modal fade" id="cropper-example-2-modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div id="cropper-example-2">
                    <img id="cropperimg" src="/edcom2/uploads/289.jpg" alt="Picture">
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ./wrapper -->
<!-- jQuery UI 1.10.3 -->
<script src="<?= _SPPATH; ?>js/jqueryui.js"></script>

<!-- Bootstrap 3.3.5 -->
<script src="<?=_SPPATH._THEMEPATH;?>/bootstrap/js/bootstrap.min.js"></script>

<!-- Morris.js charts -->
<script src="<?=_SPPATH._THEMEPATH;?>/js/raphael-min.js"></script>
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/morris/morris.min.js"></script>

<!-- FastClick -->
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=_SPPATH._THEMEPATH;?>/dist/js/app.js"></script>
<!-- Sparkline -->
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS 1.0.1 -->
<script src="<?=_SPPATH._THEMEPATH;?>/plugins/chartjs/Chart.min.js"></script><?/*
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>*/?>
<?/*
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=_SPPATH._THEMEPATH;?>/dist/js/pages/dashboard2.js"></script>
*/?>
<!-- AdminLTE for demo purposes -->
<script src="<?=_SPPATH._THEMEPATH;?>/dist/js/demo.js"></script>

<script src="<?= _SPPATH; ?><?= _THEMEPATH; ?>/dist/cropper.js"></script>


<!-- add new -->
<script src="<?= _SPPATH; ?>js/viel-windows-jquery.js?t=<?= time(); ?>"></script>

<script>
    function activkanMenuKiri(id){
        kosongkanMenuKiri();
        $("#RegistorMenu_"+id).addClass('activkanMenu');
    }

    function kosongkanMenuKiri(){
        console.log(registorMenuKiri);
        for(var key in registorMenuKiri){
            var id = registorMenuKiri[key];
            $("#RegistorMenu_"+id).removeClass('activkanMenu');
        }
    }

    (function ($) {

        /**
         * @function
         * @property {object} jQuery plugin which runs handler function once specified element is inserted into the DOM
         * @param {function} handler A function to execute at the time when the element is inserted
         * @param {bool} shouldRunHandlerOnce Optional: if true, handler is unbound after its first invocation
         * @example $(selector).waitUntilExists(function);
         */

        $.fn.waitUntilExists    = function (handler, shouldRunHandlerOnce, isChild) {
            var found       = 'found';
            var $this       = $(this.selector);
            var $elements   = $this.not(function () { return $(this).data(found); }).each(handler).data(found, true);

            if (!isChild)
            {
                (window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
                    window.setInterval(function () { $this.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 500)
                ;
            }
            else if (shouldRunHandlerOnce && $elements.length)
            {
                window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
            }

            return $this;
        }

    }(jQuery));
</script>
<style>
    .clickable{
        cursor: pointer;
    }
</style>

<?// BLogger::addLog();?>
</body>
</html>
