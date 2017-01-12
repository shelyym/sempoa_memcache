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

?>

<style>
    .skin-blue .treeview-menu > li.activkanMenu > a{
        font-weight: bold;
        color:black;
    }
</style>
    <ul class="sidebar-menu" style="cursor: pointer;">

        <!--<li>
        <a onclick="openLw('Home','<?= _SPPATH; ?>EfiHome/homeLoad','fade');">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>-->
        <? foreach ($arrR as $domainname => $arrList) {
            
            //cari apakah subdomain yang dicari ada dibawah ini
            $st = $_GET['st'];
            $active = "";
            if(array_key_exists($st, $arrList)){
                $active = "active";
            }
            ?>
            <li class="treeview <?=$active;?>">
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span><?= Lang::t($domainname); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <? foreach ($arrList as $id => $tabclick) { ?>
                    <li id="RegistorMenu_<?= $id; ?>" <? if($id == $st){?>class="activkanMenu"<?}?>><a><i
                                    class="fa fa-angle-double-right"></i>  <?= Lang::t($id); ?></a></li>
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
        <? /*foreach($arrTabs as $tabs){?>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span><?=Lang::t($tabs);?></span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <? $tt = $arrDomain[$tabs]; foreach($tt as $id=>$tabclick){?>
            <li id="TabInside_<?=$id;?>"><a ><i class="fa fa-angle-double-right"></i>  <?=Lang::t($id);?></a></li>
            <script type="text/javascript">
            $("#TabInside_<?=$id;?>").click(function(){
                openLw('<?=$id;?>','<?=_SPPATH;?><?=$tabclick;?>','fade');
            });
            </script>
            <? } ?>           
        </ul>
    </li>
    <? } */
        ?>


    </ul>
    <!--
<div class="row" style="margin-top:10px;">
    
<div class="col-md-12 col-md-offset-0">
    <div class="form-group">
    
    <div class="input-group">
      <div class="input-group-addon">L</div>
      <? //Selection::languageSelector(Lang::getLang());?>
    </div>
  </div> 
</div>    
</div> -->
<?php



