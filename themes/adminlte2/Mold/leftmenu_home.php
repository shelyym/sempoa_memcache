<?

/*$leap = new EfiHome();
$arrTabs =$leap->loadedDomains4Role[Account::getMyRole()];
$arrDomain = $leap->domains;
*/
//pr(Registor::getRoles());
//global $template;
//pr($template);
//pr($template->adminMenu);
//pr($template->domainMenu);

$arrR = Registor::getAllAdminMenuByRoles(Account::getMyRoles());
//pr($arrR);

/*
 * list of icons
 * fa fa-dashboard
 * fa fa-files-o
 * fa fa-th
 * fa fa-pie-chart
 * fa fa-laptop
 * fa fa-edit
 * fa fa-table
 * fa fa-calendar
 * fa fa-envelope
 * fa fa-envelope
 * fa fa-share
 * fa fa-book
 * fa fa-bar-chart-o
 * fa-wrench
 */
$arrDomainName2Icon = array(
    "Appear"=>"fa fa-eye",
    "Appearance"=>"fa fa-tint",
    "Capsule"=>"fa fa-bullhorn",
    "Content"=>"fa fa-bookmark",
    "Developer"=>"fa fa-tasks",
    "Email"=>"fa fa-envelope-o",
    "Finance"=>"fa fa-money",
    "Komisi"=>"fa fa-dollar",
    "PageCategories"=>"fa fa-university",
    "PaketManagement"=>"fa fa-dribbble",
    "Payment"=>"fa fa-diamond",
    "PushNot"=>"fa fa-share",
    "Setting"=>"fa fa-edit",
    "UserAndRoles"=>"fa fa-users"
);
//pr($arrDomainName2Icon);
?>
    <style>
        .skin-blue .treeview-menu > li.activkanMenu > a{
            font-weight: bold;
            color:white;
        }
        ul.treeview-menu li.activkanMenu a{
            font-weight: bold;
            color:#FFFFFF !important;
        }
    </style>
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">

            <img id="leftMainPicMenu" onclick="openLw('myProfile','<?=_SPPATH;?>AccountLoginWeb/myProfile','fade');" src="<?=_SPPATH.Account::getMyFoto();?>" class="img-circle" alt="User Image">

        </div>
        <div class="pull-left info">
            <p><?=substr(Account::getMyName(),0,25); ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" id="searchtextmenu" class="form-control" placeholder="Search...">
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
            openLw('searchMenu','<?=_SPPATH;?>SearchAdminMenu/search?q='+slc,'fade');

        });
    </script>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <? foreach ($arrR as $domainname => $arrList) {

            //cari apakah subdomain yang dicari ada dibawah ini
            $st = $_GET['st'];
            $active = "";
            if(array_key_exists($st, $arrList)){
                $active = "active";
            }

            $icons = $arrDomainName2Icon[$domainname];

            if($icons == ""){
                $icons = "fa fa-bar-chart-o";
            }
            ?>
            <li class="treeview <?=$active;?>">
                <a href="#">
                    <i class="<?=$icons;?>"></i>
                    <span><?= Lang::t($domainname); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <? foreach ($arrList as $id => $tabclick) { ?>
                        <li id="RegistorMenu_<?= $id; ?>" <? if($id == $st){?>class="activkanMenu"<?}?>><a><i
                                    class="fa fa-circle-o"></i>  <?= Lang::t($id); ?></a></li>
                        <script type="text/javascript">
                            $("#RegistorMenu_<?=$id;?>").click(function () {
                                openLw('<?=$id;?>', '<?=_SPPATH;?><?=$tabclick;?>', 'fade');
                                activkanMenuKiri('<?=$id;?>');
                            });
                            registerkanMenuKiri('<?=$id;?>');
                        </script>
                    <? } ?>
                </ul>
            </li>
        <? } ?>
    </ul>
<?php



