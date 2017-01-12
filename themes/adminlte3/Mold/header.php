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
        float: left;
        margin-left: 1px;
        margin-right: 1px;
        padding-left: 10px;
        padding-right: 10px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        font-size: 14px;
        height: 35px;
        margin-top: 5px;
        line-height: 30px;
    }

    .hiddenmenu {
        background: #fff url(<?=_SPPATH;?>images/tabbg.jpg) repeat-x bottom left;
        position: absolute;
        top: 40px;
        left: 0;
        width: 100%;
        height: 40px;
        z-index: 100;
    }

    .menuinside {
        float: left;
        margin-left: 10px;
        margin-right: 10px;
    }

    .tabselected {
        font-weight: normal;
        background-color: white;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        color: #777;
    }
</style>
<script type="text/javascript">
    //init Tabs
    var leapheadertabs = [];
    var leapheadertabs_contents = [];
    var leapheadertabs_contents_links = [];
</script>
<div class="header">
    <div class="logo">
    </div>
    <? foreach ($arrTabs as $tabs) { ?>
        <div class="menu" id="Tab_<?= $tabs; ?>">
            <?= Lang::t($tabs); ?>
        </div>
        <div id="MenuTab_<?= $tabs; ?>" class="hiddenmenu">
            <? $tt = $arrDomain[$tabs];
            foreach ($tt as $id => $tabclick) { ?>
                <div class="menuinside" id="TabInside_<?= $id; ?>">
                    <?= Lang::t($id); ?>
                </div>
                <script type="text/javascript">
                    // push small tabs menu
                    leapheadertabs_contents.push('<?=$id;?>');
                    leapheadertabs_contents_links.push('<?=$tabclick;?>');
                    $("TabInside_<?=$id;?>").onClick(function () {
                        openLw('<?=$id;?>', '<?=_SPPATH;?><?=$tabclick;?>', 'fade');
                    });
                </script>
            <? } ?>
        </div>
        <script type="text/javascript">
            //push all big tabs menu
            leapheadertabs.push("<?=$tabs;?>");
            $("Tab_<?=$tabs;?>").onClick(function () {
                changeTabMenu("<?=$tabs;?>");
            });
        </script>
    <? } ?>
</div>
<script type="text/javascript">
    //init fistTab
    changeTabMenu(leapheadertabs[0]);
    openLw(leapheadertabs_contents[0], leapheadertabs_contents_links[0], 'fade');
    function changeTabMenu(id) {
        hideAllTabs();
        $("MenuTab_" + id).fade('in');
        $("Tab_" + id).addClass('tabselected');
    }
    function hideAllTabs() {
        for (var key = 0; key < leapheadertabs.length; key++) {
            $("MenuTab_" + leapheadertabs[key]).hide();
            $("Tab_" + leapheadertabs[key]).removeClass('tabselected');
        }
    }
</script><?php


