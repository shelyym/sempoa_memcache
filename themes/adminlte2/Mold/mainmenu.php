<style>
    .mainmenubox {

    }

    .mainmenubox div {
        padding: 10px;
        margin: 5px;
        text-align: center;
        background-color: #efefef;
        border-radius: 5px;
        cursor: pointer;
    }

    .bottom {
        height: 63px;
        background: #fff url('<?=_SPPATH;?>images/bottom.jpg') repeat-x top left;
        position: absolute;
        width: 100%;
    }
</style>
<?
$t = time();
//$leap = new EfiHome();
//$arrTabs =$leap->loadedDomains4Role[Account::getMyRole()];
//$arrDomain = $leap->domains;
global $template;

pr($template);

foreach ($arrTabs as $tabs) {
    ?>

    <? $tt = $arrDomain[$tabs];
    foreach ($tt as $id => $tabclick) { ?>
        <div class="col-md-3 col-sm-4 col-xs-6 mainmenubox">
            <div id="MainMenuInside_<?= $id; ?><?= $t; ?>"><?= Lang::t($id); ?></div>
            <script type="text/javascript">
                $("#MainMenuInside_<?=$id;?><?=$t;?>").click(function () {
                    openLw('<?=$id;?>', '<?=_SPPATH;?><?=$tabclick;?>', 'fade');
                });
            </script>
        </div>
    <? } ?>

<? } 