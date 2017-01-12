<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PortalTemplate
 *
 * @author User
 */
class PortalTemplate {

    public static $menus = array (
        "home"  => "home",
        "pages" => "pages",
        "shop"  => "shop",
        "tools" => "tools"

    );
     public function printIcons ()
    {
         
         
         
        ?>
        <style>
            .icon-float {
                width: 25%;
                float: left;
                height: 94px;
                cursor: pointer;
            }

            .icon-float img {
                width: 100%;

            // vertical-align : middle;
            // margin : auto;
            }

            @media (max-width: 768px) {
                .icon-float {

                    height: auto;
                }
            }
        </style>
        <?
        $bgcolor = ThemeReg::mod("mail_icon_bgcolor", "#6c6143","color"); 
        $bgimage = ThemeReg::mod("mail_icon", _SPPATH._THEMEPATH."/images/mail-icon.jpg","image");
        ?>
        <div onclick="window.open('<?=_SPPATH;?>tools?mode=email','_blank');" class="icon-float icon-mail" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage;?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("learn_icon_bgcolor", "#7a8b69","color"); 
        $bgimage = ThemeReg::mod("learn_icon", _SPPATH._THEMEPATH."/images/learn-icon.jpg","image");
        
        if($_SESSION['account']->admin_type == '2'){
            $sid = 8;
        }else{
            $sid = 22;
        }
        ?>
        <div onclick="document.location='<?=_SPPATH;?>webapps?id=<?=$sid;?>';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("apps_icon_bgcolor", "#75863f","color"); 
        $bgimage = ThemeReg::mod("apps_icon", _SPPATH._THEMEPATH."/images/apps-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>webapps';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("wiki_icon_bgcolor", "#305029","color"); 
        $bgimage = ThemeReg::mod("wiki_icon", _SPPATH._THEMEPATH."/images/wiki-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>tools?mode=wikipedia';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        <?
        
        $ads = new AdsPortal();
         $arr = $ads->getWhere("ads_active = 1 AND ads_type = 'homeAds' ORDER BY ads_urutan DESC");
         foreach($arr as $ad){
             
             $url = $ad->ads_url;
             $pos = strpos($url, "http");
             //echo $pos." ".$url." = ".strpos($url, "http");
             if ($pos !== false) {
                   // echo "The string '$findme' was found in the string '$mystring'";
                    //    echo " and exists at position $pos";
               } else {
                   $url = _SPPATH.$url;
                //    echo "The string '$findme' was not found in the string '$mystring'";
               }
        ?>
       <!-- ads --> 
        <div class="ads" style="margin-bottom: 0px;">
            <a href="<?=$url;?>">
            <img src="<?= _SPPATH._PHOTOURL.$ad->ads_pic; ?>" width="100%">
            </a>
        </div>
         <? } ?>
       
    <?
    }
    public function printIcons_OLD ()
    {
        ?>
        <style>
            .icon-float {
                width: 25%;
                float: left;
                height: 94px;
                cursor: pointer;
            }

            .icon-float img {
                width: 100%;

            // vertical-align : middle;
            // margin : auto;
            }

            @media (max-width: 768px) {
                .icon-float {

                    height: auto;
                }
            }
        </style>
        <?
        $bgcolor = ThemeReg::mod("mail_icon_bgcolor", "#6c6143","color"); 
        $bgimage = ThemeReg::mod("mail_icon", _SPPATH._THEMEPATH."/images/mail-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>tools?mode=email';" class="icon-float icon-mail" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage;?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("learn_icon_bgcolor", "#7a8b69","color"); 
        $bgimage = ThemeReg::mod("learn_icon", _SPPATH._THEMEPATH."/images/learn-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>km';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("apps_icon_bgcolor", "#75863f","color"); 
        $bgimage = ThemeReg::mod("apps_icon", _SPPATH._THEMEPATH."/images/apps-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>webapps';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        <?
        $bgcolor = ThemeReg::mod("wiki_icon_bgcolor", "#305029","color"); 
        $bgimage = ThemeReg::mod("wiki_icon", _SPPATH._THEMEPATH."/images/wiki-icon.jpg","image");
        ?>
        <div onclick="document.location='<?=_SPPATH;?>tools?mode=wikipedia';" class="icon-float" style="background-color:<?=$bgcolor;?>;">
            <img src="<?=$bgimage; ?>">
        </div>
        
       <!-- ads --> 
        <div class="ads">
            <img src="<?= _SPPATH; ?>props/home-banner-2.jpg" width="100%">
        </div>
        <div class="ads">
            <img src="<?= _SPPATH; ?>props/2.jpg" width="100%">
        </div>
        <div class="ads" style="cursor:pointer;" onclick="document.location='<?=_SPPATH;?>km';">
            <img src="<?= _SPPATH; ?>props/3.jpg" width="100%">
        </div>
    <?
    }

    public static function printMenu ()
    {

        ?>
        <style>
            a.submenu{
                color:#305029;
            }
            .topmenu:hover a.submenu{
                color:#305029;
            }
        </style>    
        <?
        $menu = self::$menus;
        //pr($menu);
        $menu2 = array_reverse($menu);
        foreach ($menu as $text => $m) {
            $active = "";
            if ($_GET['url'] == $text) {
                $active = "topmenu_active";
            }
            if ($_GET['url'] == "km" || $_GET['url'] == "webapps") {
                if($text == "tools")
                $active = "topmenu_active";
            }
            ?>
        <div style="cursor:pointer;" <? if($m!="tools" && $m!="pages"){?>onclick="document.location='<?= _SPPATH . $m; ?>';"<? } ?> class="topmenu <?= $active; ?> dropdown">

                <a <? if($m=="tools"){?>id="dropdownMenu1" data-toggle="dropdown"<? } ?>  <? if($m=="pages"){?>id="dropdownMenu2" data-toggle="dropdown"<? } ?> href="<?= _SPPATH . $m; ?>">
                    <? if ($m == "home") { ?><i class="glyphicon glyphicon-home"></i><? } ?>
                    <? if ($m == "shop") { ?><i class="glyphicon glyphicon-shopping-cart"></i><? } ?>
                    <? if ($m == "tools") { ?><i class="glyphicon glyphicon-cog"></i><? } ?>
                    <? if ($m == "pages") { ?><i class="glyphicon glyphicon-hdd"></i><? } ?>
                    <?= $text; ?> 
                    <? if($m=="tools"||$m=="pages"){?>
                    <span <? if($m=="tools"){?>id="dropdownMenu1" data-toggle="dropdown"<? } ?><? if($m=="pages"){?>id="dropdownMenu2" data-toggle="dropdown"<? } ?> class="caret"></span>
                    <? } ?>
                </a>
                <? if($m=="tools"){?>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation"><a class="submenu" role="menuitem" tabindex="-1" target="_blank" href="<?=_SPPATH;?>tools?mode=email">TBS Email</a></li>
                    <li role="presentation"><a class="submenu" role="menuitem" tabindex="-1" href="<?=_SPPATH;?>tools?mode=wikipedia">TBS Wikipedia</a></li>
                    <li role="presentation"><a class="submenu" role="menuitem" tabindex="-1" href="<?=_SPPATH;?>km">TBS Knowledge</a></li>
                    <li role="presentation"><a class="submenu" role="menuitem" tabindex="-1" href="<?=_SPPATH;?>webapps">TBS Apps</a></li>
                    
                </ul>
                <? } ?>
             <? if($m=="pages"){?>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                    <?
                    $arrG = PageContainer::getActiveSession();
                    foreach($arrG as $gg){
                    ?>
                    <li role="presentation"><a class="submenu" role="menuitem" tabindex="-1" href="<?=_SPPATH;?>pagecontainer?mode=<?=$gg->container_id;?>"><?=$gg->container_name;?></a></li>
                    <? } ?>
                    
                </ul>
                <? } ?>
            </div>
        
        <?
        }
    }

    public static function printMenuMobile ()
    {
        ?>
        <style>
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus{
                color:#fff;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > li > a{
                color:#fff;
            }
        </style>    
        <?

        $menu = self::$menus;
        //pr($menu);
        $menu2 = array_reverse($menu);
        foreach ($menu as $text => $m) {
            if($m != "tools"){
            ?>
            <li>
                <a href="<?= _SPPATH . $m; ?>"><?= $text; ?></a>
            </li>
            <? }else{ ?>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= $text; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="<?=_SPPATH;?>tools?mode=email">TBS Email</a></li>
              <li><a href="<?=_SPPATH;?>tools?mode=wikipedia">TBS Wikipedia</a></li>
              <li><a href="<?=_SPPATH;?>km">TBS Knowledge</a></li>
              <li><a href="<?=_SPPATH;?>webapps">TBS Apps</a></li>
            </ul>
          </li>
            <? } ?>
        <? } ?>
        <?
        if (Role::hasRole("admin")) {
            ?>
            <li>
                <a class="admin-button-mobile" href="<?= _SPPATH; ?>EfiHome/home"><?= Lang::t('Admin'); ?></a>
            </li>
        <?
        }
    }
   
    public static function printBreadcrumbs($links){
        ?>
        <div class="breadcrumbs"><?=$links;?></div>
        <?
    }
}
