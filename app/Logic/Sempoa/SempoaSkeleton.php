<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/22/16
 * Time: 3:05 PM
 */

class SempoaSkeleton {

    public static function header_notif(){

        ?>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        <? if(Role::hasRole('admin')){ ?>
        <li class="dropdown home-menu">
            <a href="<?=_SPPATH;?>PushHome/home"  class="dropdown-toggle" >
                <i class="fa fa-exchange"></i>
                <!--                <span class="label label-success">4</span>-->
            </a>

        </li>
        <? } ?>
        <? if(AccessRight::getMyOrgType() ==  KEY::$TC){?>
        <li class="dropdown home-menu">
            <a style="cursor: pointer;" onclick="openLw('dashboard_tc', '<?=_SPPATH;?>TcWeb/dashboard_tc', 'fade'); activkanMenuKiri('dashboard_tc');" class="dropdown-toggle" >
                <i class="fa fa-home"></i>
<!--                <span class="label label-success">4</span>-->
            </a>

        </li>
        <? } ?>
        <?
        $inb = new SempoaInboxModel();
        $nr =$inb->getJumlah("inbox_org_id = '".AccessRight::getMyOrgID()."' AND inbox_read = 0");

        $arrInbox =$inb->getWhere("inbox_org_id = '".AccessRight::getMyOrgID()."' ORDER BY inbox_date DESC LIMIT 0,10");
        ?>
        <style>
            .inbox_dibaca2{
                background-color: #f6f6f6;
            }
        </style>
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu" id="menu_inbox_sempoa">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <? if($nr>0){?>
                <span class="label label-success"><?=$nr;?></span>
                <? } ?>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have <?=$nr;?> new messages</li>
                <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                        <? foreach($arrInbox as $ib){
                            $org = new SempoaOrg();
                            $org->getByID($ib->inbox_sender_id);
                            ?>
                        <li <? if($ib->inbox_read == 1)echo "class='inbox_dibaca2'";?>><!-- start message -->
                            <a style="cursor: pointer;"  onclick="openLw('inbox_<?=$ib->inbox_id;?>','<?=_SPPATH;?>InboxWeb/readbyID?id=<?=$ib->inbox_id;?>','fade');">

                                <b>
                                    <?=$org->nama;?></b>
                                    <small style="color: #666666;"><i class="fa fa-clock-o"></i> <?=ago(strtotime($ib->inbox_date));?></small>
                                <br>
                                <i style="color: #777777;"><?=$ib->inbox_title;?></i>
                            </a>
                        </li>
                        <!-- end message -->
                        <? } ?>

                    </ul>
                </li>
                <li class="footer"><a style="cursor: pointer;" onclick="openLw('my_inbox','<?=_SPPATH;?>InboxWeb/my_inbox','fade');">See All Messages</a></li>
            </ul>
        </li>


        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<!--                <img src="--><?//=_SPPATH.Account::getMyFoto();?><!--" class="user-image" alt="User Image">-->
                <span class="hidden-xs"><?=substr(Account::getMyName(),0,25); ?></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
<!--                    <img src="--><?//=_SPPATH.Account::getMyFoto();?><!--" class="img-circle" alt="User Image">-->

                    <p>
                        <?=substr(Account::getMyName(),0,25); ?>
<!--                        <small>Member since Nov. 2012</small>-->
                    </p>
                </li>
                <!-- Menu Body -->
<!--                <li class="user-body">
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
                     /.row 
                </li>-->
                <!-- Menu Footer-->
                <li class="user-footer">
<!--                    <div class="pull-left">
                        <a href="#" onclick="openLw('myProfile','<?=_SPPATH;?>AccountLoginWeb/myProfile','fade');" class="btn btn-default btn-flat">Profile</a>
                    </div>-->
                    <div class="pull-right">
                        <a href="<?=_SPPATH;?>logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
<!--        <li>-->
<!--            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
<!--        </li>-->
        </ul>
        </div>
        <?
    }

    public static function leftmenu(){

        // get my accessrights
        $myrole = Account::getMyRole();


//        pr(Account::getMyRoles());
        $arr = AccessRight::getMyAR($myrole);
//        pr($arr);

        ?>
        <section class="sidebar">

            <!-- search form -->
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" value="<?=$_GET['q'];?>" name="q" id="searchtextmenu" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button  name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>

            <script>
                $('#search-btn').click(function(event){
                    event.preventDefault();

                    var slc = encodeURIComponent($('#searchtextmenu').val());
//        alert("halo"+slc);
                    openLw('searchMenu','<?=_SPPATH;?>SearchMenuRoleAR/search?q='+slc,'fade');
//                    $('#isi_search_text').val($('#searchtextmenu').val());
                });

                $('#searchtextmenu').keypress(function (e) {
                    if (e.which == 13) {
//                        event.preventDefault();

                        var slc = encodeURIComponent($('#searchtextmenu').val());
//        alert("halo"+slc);
//                        $('#isi_search_text').val($('#searchtextmenu').val());
                        openLw('searchMenu','<?=_SPPATH;?>SearchMenuRoleAR/search?q='+slc,'fade');
                        return false;    //<---- Add this line
                    }
                });
            </script>

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>
                <?
                $folder = "";
                $st = $_GET['st'];
                foreach($arr as $num=>$ar){

                $active = "";
                if($st == $ar->ar_name && AccessRight::getRightURLShow($st)!=""){
                    $active = "active";

                    ?>
                    <script>

                        $(document).ready(function () {
                            $('#<?=hash('ripemd160',$ar->ar_folder_name);?>').addClass('active');
                        });

                    </script>
                    <?
                }

                    $pindah = 0;
                    if($folder!=$ar->ar_folder_name){

                        $symbol = "fa-dashboard";
                        if($ar->ar_symbol!="")
                            $symbol = $ar->ar_symbol;

                        $pindah = 1;
                        if($folder!=""){



                        ?>
                        </ul>
                        </li>
                        <? } ?>
                <li id="<?=hash('ripemd160',$ar->ar_folder_name);?>" class="treeview">
                    <a href="#">
                        <i class="fa <?=$symbol;?>"></i> <span><?=$ar->ar_folder_name;?></span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                        <ul class="treeview-menu">
                    <?
                    //pindah folder
                    $folder = $ar->ar_folder_name;
                    }

                    $id = $ar->ar_name;
                    $tabclick = $ar->ar_cname."/".$ar->ar_name;
                    ?>
                            <li id="RegistorMenu_<?= $id; ?>" class="<? if($id == $st){?>activkanMenu<?}?> clickable"><a>
                                    <i class="fa fa-circle-o"></i>  <?= Lang::t($ar->ar_display_name); ?></a></li>
                            <script type="text/javascript">
                                $("#RegistorMenu_<?=$id;?>").click(function () {
                                    openLw('<?=$id;?>', '<?=_SPPATH;?><?=$tabclick;?>'<?if (strpos($id, 'create') !== false) {?>+'?now='+$.now()<?}?>, 'fade');
                                    activkanMenuKiri('<?=$id;?>');
                                });
                                registerkanMenuKiri('<?=$id;?>');
                            </script>

                        <?


                }
                ?>
            </ul>
            <ul class="sidebar-menu" style="display: none !important;">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                        <li class="active"><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Layout Options</span>
                        <span class="label label-primary pull-right">4</span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                        <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                        <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                        <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/widgets.html">
                        <i class="fa fa-th"></i> <span>Widgets</span>
                        <small class="label pull-right bg-green">new</small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-pie-chart"></i>
                        <span>Charts</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                        <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                        <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                        <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-laptop"></i>
                        <span>UI Elements</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                        <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                        <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                        <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                        <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                        <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>Forms</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                        <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                        <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Tables</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                        <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                    </ul>
                </li>
                <li>
                    <a href="pages/calendar.html">
                        <i class="fa fa-calendar"></i> <span>Calendar</span>
                        <small class="label pull-right bg-red">3</small>
                    </a>
                </li>
                <li>
                    <a href="pages/mailbox/mailbox.html">
                        <i class="fa fa-envelope"></i> <span>Mailbox</span>
                        <small class="label pull-right bg-yellow">12</small>
                    </a>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>Examples</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                        <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                        <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                        <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                        <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                        <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                        <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                        <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                        <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span>Multilevel</span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                        <li>
                            <a href="#"><i class="fa fa-circle-o"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                <li>
                                    <a href="#"><i class="fa fa-circle-o"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                    <ul class="treeview-menu">
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    </ul>
                </li>
                <li><a href="documentation/index.html"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
                <li class="header">LABELS</li>
                <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
                <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            </ul>
        </section>
        <?
    }

    public static function control_sidebar(){

        ?>
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
        <?
    }

    public static function redirectOpenLWSempoa ()
    {
        $st = $_GET['st'];
        if($st!=""){
//            echo $st;
            $url = AccessRight::getRightURLShow($st);
//            echo "<br>".$url;
            if($url !=""){
                $ar = AccessRight::getRightObjectShow($st);
                ?>
                <script type="text/javascript">
                    $(document).ready(function () {
                        openLw('<?=$ar->ar_name;?>', '<?=_SPPATH;?><?=$ar->ar_cname."/".$ar->ar_name;?>', 'fade');
                    });
                </script>
                <?
            }
        }

    }
} 