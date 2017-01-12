<style>
    .mainmenutbs{
        <?
        $bgcolor = ThemeReg::mod("mainmenu_bgcolor", "#e8e9d7","color");
        ?>
        background-color:<?=$bgcolor;?>;
    }
    <? if($_COOKIE['headerSlide']){?>
    body{
        margin-top:30px;
    }
    <?}?>
</style>
<div id="headerdesktop" class="donly">
    <div id="mainheader" <? if($_COOKIE['headerSlide']){echo "style='display:none;'";}?>>
        <div id="headerdesktop_container" class='container'>
            <div style="float:right;" >
            <div class="admin-button2" >
                
                    <span
                        title="<?= PortalHierarchy::getMyLevelName(); ?> at <?= PortalHierarchy::getMyOrganizationName(); ?>">
                        <?= Account::getMyName(); ?>
                    </span>
                    <a title="My Profile" style="color:white; margin-top: 3px; margin-left:5px;" href="<?= _SPPATH; ?>myprofile">
                        <i class="glyphicon glyphicon-user"></i>
                    </a>
                    <a title="Search" style="color:white; margin-top: 3px; margin-left:5px;cursor: pointer;" onclick="$('#searchbox').toggle();">
                        <i class="glyphicon glyphicon-search"></i>
                    </a>
                    <div style="width: 250px; position: absolute; margin-top: 3px; <? if($_GET['url']!="search"){?> display: none;<?}?> padding: 5px; background-color: #fff;" id="searchbox">
                        <div class="input-group">
                            <input value="<?=$_GET['s'];?>" id="searchtext" type="text" class="form-control input-sm">
                          <span class="input-group-btn">
                              <button id="searchbutton" class="btn btn-default btn-sm" type="button">Go!</button>
                          </span>
                        </div><!-- /input-group -->   
                      </div>
                      <script>
                    $("#searchbutton").click(function(){
                       var t =  encodeURI($("#searchtext").val());
                       if(t!="")
                       document.location = '<?=_SPPATH;?>search?s='+t;
                       else
                           alert('<?=Lang::t('Please insert search text');?>');
                    });
                    $("#searchtext").keyup(function (event) {
                        if (event.keyCode == 13) { //on enter
                           var t =  encodeURI($("#searchtext").val());
                           if(t!="")
                           document.location = '<?=_SPPATH;?>search?s='+t;
                           else
                           alert('<?=Lang::t('Please insert search text');?>');
                       }
                    });
                 </script> 
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
            <div style=" height: 100px; text-align: right;">
	            <div style="height: 20%;"></div>
                <img src="<?=_SPPATH;?>images/kananatas.png" style="height: 60%;">
            </div>
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
                    <a title="Search" style="color:white; margin-top: 3px; margin-left:5px;cursor: pointer;" onclick="$('#searchbox2').toggle();">
                        <i class="glyphicon glyphicon-search"></i>
                    </a>
                    <div style="width: 250px; position: absolute; margin-top: 3px; <? if($_GET['url']!="search"){?> display: none;<?}?> padding: 5px; background-color: #fff; z-index: 3;" id="searchbox2">
                        <div class="input-group">
                            <input value="<?=$_GET['s'];?>" id="searchtext2" type="text" class="form-control input-sm">
                          <span class="input-group-btn">
                              <button id="searchbutton2" class="btn btn-default btn-sm" type="button">Go!</button>
                          </span>
                        </div><!-- /input-group -->   
                      </div>
                <script>
                    $("#searchbutton2").click(function(){
                       var t =  encodeURI($("#searchtext2").val());
                       if(t!="")
                       document.location = '<?=_SPPATH;?>search?s='+t;
                       else
                           alert('<?=Lang::t('Please insert search text');?>');
                    });
                    $("#searchtext2").keyup(function (event) {
                        if (event.keyCode == 13) { //on enter
                           
                           var t =  encodeURI($("#searchtext2").val());
                           if(t!="")
                           document.location = '<?=_SPPATH;?>search?s='+t;
                           else
                           alert('<?=Lang::t('Please insert search text');?>');
                       }
                    });
                 </script>   
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
            $('body').animate({ marginTop: '30px' }, 300);
        });
    }
    function doSlideDownHeader(){
        if(!chatMode){
            $("#slideUpAdmin").slideUp( "slow", function() {
        // Animation complete.
                $('#mainheader').slideDown("fast");
                leap_setCookie("headerSlide",0,365);
                $('body').animate({ marginTop: '160px' }, 300);
            });
        }else{
            alert("<?=Lang::t('You can slide header out not in chat mode');?>");
        }
    }
    /*
$( window ).resize(function() {
  $('body').animate({ marginTop: '0px' }, 100);
});
*/
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