<style>
    .mainmenutbs{
        <?
        $bgcolor = ThemeReg::mod("mainmenu_bgcolor", "#e8e9d7","color");
        ?>
        background-color:<?=$bgcolor;?>;
    }
</style>
<div id="headerdesktop" class="donly">
    <div id="mainheader">
        <div class='container'>
            <div class="admin-button2" style="float: right;">
                    
                    <span
                        title="<?= PortalHierarchy::getMyLevelName(); ?> at <?= PortalHierarchy::getMyOrganizationName(); ?>">
                        <?= Account::getMyName(); ?>
                    </span>
                    <a title="My Profile" style="color:white; margin-top: 3px; margin-left:5px;" href="<?= _SPPATH; ?>myprofile">
                        <i class="glyphicon glyphicon-user"></i>
                    </a>
                    <a title="<?= PortalHierarchy::getMyOrganizationName(); ?> Page" style="margin-left:5px;color:white; margin-top: 3px;" href="<?= _SPPATH; ?>mydepartment">
                        <i class="glyphicon glyphicon-tree-deciduous"></i>
                    </a>

            <?
            if (Role::hasRole("admin")) {
                ?> &nbsp;
                <a title="Administrator Site" style="color:white; margin-top: 3px; " href="<?= _SPPATH; ?>EfiHome/home">
                    <i class="glyphicon glyphicon-tasks"></i>
                </a>
            <? } ?>
            &nbsp;
            <a title="Log Out" style="color:white; margin-top: 3px;" href="<?= _SPPATH; ?>logout">
                <i class="glyphicon glyphicon-log-out"></i>
            </a>
        </div>
            <div class='logo' style="height:130px; line-height: 130px;">
                <?
                $bgimage = ThemeReg::mod("logo_desktop", _SPPATH."images/logo-hybris.png","image");
                ?>
                <img src='<?=$bgimage; ?>'>
            </div>
        </div>
    </div>
    <div id="mainmenu" class="mainmenutbs">
        <div class="container" style="padding-left: 0px;">
            <? PortalTemplate::printMenu(); ?>
        </div>
    </div>
</div>