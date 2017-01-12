<style type="text/css">
    .header {
        width: 100%;
        height: 40px;
        line-height: 40px;
        background: #3ebeff url(<?=_SPPATH;?>images/logo_icon_murid_bg.jpg) repeat-x top left;
    }

    .logo {
        float: left;
        height: 40px;
        line-height: 40px;
        width: 40px;
        background: #3ebeff url(<?=_SPPATH;?>images/logo_icon_murid.jpg) repeat-x top left;
    }

    .menu {
        padding-left: 10px;
        padding-right: 10px;
        color: black;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        height: 35px;
        margin-top: 5px;
        line-height: 30px;
    }

    .hiddenmenu {
        display: none;
    }

    .menuinside {
    }

    /
    /
    mobile
    .tabmobile {
        display: none;
        position: absolute;
        z-index: 1000000;
        width: 100%;

        background-color: #3ebeff;
        left: 0;

    }
</style>

<div class="header">
    <div class="logo" id="Tab_button" onclick="slidetabOpen();">
    </div>
    Leap Systems
</div>
<div id="TabsMobile" class="tabmobile">
    <? foreach ($arrTabs as $tabs) { ?>
        <div class="menu" id="Tab_<?= $tabs; ?>" onclick="$('MenuTab_<?= $tabs; ?>').fade();">
            <?= Lang::t($tabs); ?>
        </div>
        <div id="MenuTab_<?= $tabs; ?>" class="hiddenmenu">
            <? $tt = $arrDomain[$tabs];
            foreach ($tt as $id => $tabclick) { ?>
                <div class="menuinside" id="TabInside_<?= $id; ?>">
                    <?= Lang::t($id); ?>
                </div>
                <script type="text/javascript">
                    $("TabInside_<?=$id;?>").onClick(function () {
                        slidetabOpen();
                        openLw('<?=$id;?>', '<?=_SPPATH;?><?=$tabclick;?>', 'fade');
                    });
                </script>
            <? } ?>
        </div>
    <? } ?>
</div>
<script type="text/javascript">
    function slidetabOpen() {

        if (document.getElementById("TabsMobile").style.display == "block") {
            document.getElementById("TabsMobile").style.display = "none";
            document.getElementById("lw_content").style.display = "block";
        }
        else {
            document.getElementById("lw_content").style.display = "none";
            document.getElementById("TabsMobile").style.display = "block";
            // $('content_utama').show();
        }
    }
    //$('Tab_button').onClick(slidetabOpen);
</script><?php


