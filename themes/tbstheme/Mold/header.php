<style>
    .mainmenutbs{
        <?
        $bgcolor = ThemeReg::mod("mainmenu_bgcolor", "#e8e9d7","color");
        ?>
        background-color:<?=$bgcolor;?>;
    }
</style>
<div id="headerdesktop" class="donly">
    <div id="mainheader" <? if($_COOKIE['headerSlide']){echo "style='display:none;'";}?>>
        <div id="headerdesktop_container" class='container'>
            <div class="admin-button2" style="float: right;">
                    
                    <span
                        title="<?= PortalHierarchy::getMyLevelName(); ?> at <?= PortalHierarchy::getMyOrganizationName(); ?>">
                        <?= Account::getMyName(); ?>
                    </span>
                    <a title="My Profile" style="color:white; margin-top: 3px; margin-left:5px;" href="<?= _SPPATH; ?>myprofile">
                        <i class="glyphicon glyphicon-user"></i>
                    </a>
                    <a title="<?= PortalHierarchy::getMyOrganizationName(); ?> Page" style="margin-left:5px;color:white; margin-top: 3px;" href="<?= _SPPATH; ?>mydepartment">
                        <i class="glyphicon glyphicon-briefcase"></i>
                    </a>
               

            <?
            if (Role::hasRole("admin")) {
                ?> &nbsp;
                <a title="Administrator Site" style="color:white; margin-top: 3px; " href="<?= _SPPATH; ?>EfiHome/home">
                    <i class="glyphicon glyphicon-tasks"></i>
                </a>
            <? } ?>
                 <a title="hide header" style="margin-left:5px;color:white; margin-top: 3px;cursor: pointer;" onclick="doSlideHeader();">
                        <i class="glyphicon glyphicon-chevron-up"></i>
                    </a>
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
            <div id="slideUpAdmin" class="admin-button2" style="float: right; <? if(!$_COOKIE['headerSlide']){?>display: none;<? }?>">
                    
                    <span
                        title="<?= PortalHierarchy::getMyLevelName(); ?> at <?= PortalHierarchy::getMyOrganizationName(); ?>">
                        <?= Account::getMyName(); ?>
                    </span>
                    <a title="My Profile" style="color:white; margin-top: 3px; margin-left:5px;" href="<?= _SPPATH; ?>myprofile">
                        <i class="glyphicon glyphicon-user"></i>
                    </a>
                    <a title="<?= PortalHierarchy::getMyOrganizationName(); ?> Page" style="margin-left:5px;color:white; margin-top: 3px;" href="<?= _SPPATH; ?>mydepartment">
                        <i class="glyphicon glyphicon-briefcase"></i>
                    </a>
                

            <?
            if (Role::hasRole("admin")) {
                ?> &nbsp;
                <a title="Administrator Site" style="color:white; margin-top: 3px; " href="<?= _SPPATH; ?>EfiHome/home">
                    <i class="glyphicon glyphicon-tasks"></i>
                </a>
            <? } ?>
                <a title="hide header" style="margin-left:5px;color:white; margin-top: 3px;cursor: pointer;" onclick="doSlideDownHeader();">
                        <i class="glyphicon glyphicon-chevron-down"></i>
                    </a>
            &nbsp;
            <a title="Log Out" style="color:white; margin-top: 3px;" href="<?= _SPPATH; ?>logout">
                <i class="glyphicon glyphicon-log-out"></i>
            </a>
        </div>
            <? PortalTemplate::printMenu(); ?>
        </div>
    </div>
</div>
<script>
    var chatMode = 0;
    function doSlideHeader(){
        $("#mainheader").slideUp( "fast", function() {
    // Animation complete.
            $('#slideUpAdmin').slideDown("slow");
            leap_setCookie("headerSlide",1,365);
            //save preference on cookie
        });
    }
    function doSlideDownHeader(){
        if(!chatMode){
            $("#slideUpAdmin").slideUp( "slow", function() {
        // Animation complete.
                $('#mainheader').slideDown("fast");
                leap_setCookie("headerSlide",0,365);
            });
        }else{
            alert("<?=Lang::t('You can slide header out not in chat mode');?>");
        }
    }


function leap_setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
function leap_getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
}
function leap_checkCookie() {
    var username=leap_getCookie("username");
    if (username!="") {
        alert("Welcome again " + username);
    }else{
        username = prompt("Please enter your name:", "");
        if (username != "" && username != null) {
            setCookie("username", username, 365);
        }
    }
}
</script>
<style>
    #mainheader a:hover,#slideUpAdmin a:hover{
        text-decoration: none;
    }
</style>