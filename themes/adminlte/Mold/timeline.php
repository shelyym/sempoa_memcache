<style>
    .widget {
        background-color: #cee2ec;
        border-radius: 5px;
        padding: 10px;
        color: #074d72;
        margin-bottom: 10px;
    }

    .widgethead h3 {
        border-bottom: 0px solid #074d72;
        padding: 0;
        margin: 0;
        font-size: 23px;
    }

    .widgethead {

    }

    .widget hr {
        border-bottom: 1px solid #074d72;
        padding: 0;
        margin: 0;
        margin-top: 5px;
    }

    .widgetBig {
        background-color: white;
        padding: 10px;
        clear: both;
        margin-bottom: 10px;
    }
</style>
<div class="row">
    <div class="col-md-8">

        <?
        if (Account::getMyRole() == "murid") {
            ?>
            <div id="myClassWall" class="widgetBig">
                <?
                $mw = new Muridweb();
                $mw->myClassWall($timeline = 1);
                ?>
            </div>
        <?

        } else {
            ?>
            <div id="all_class_wall" class="widgetBig">
                <?
                $wall = new Wallweb();
                $wall->limit = 10;
                $wall->schoolwall(1);
                ?>
            </div>
        <?

        }?>
    </div>
    <div class="col-md-4 visible-md-block visible-lg-block">
        <?
        if (Account::getMyRole() == "murid") {
            ?>
            <div id="myHomeroomTeacher" class="widget visible-md-block visible-lg-block">
                <?
                $wid = new Widget();
                $wid->myHomeroomTeacher();
                ?>
            </div>
        <? } ?>

        <?
        if (Account::getMyRole() == "murid") {
            ?>
            <div id="myClassmate" class="widgetBig">
                <?
                $mw = new Muridweb();
                $mw->myClassmate(4);
                ?>
            </div>
        <?
        }?>


        <div id="mySchoolCalendarWidget" class="widget visible-md-block visible-lg-block">
            <?
            $wid = new Widget();
            $wid->mySchoolCalendarWidget();
            ?>
        </div>
        <? if (Account::getMyRole() == "murid") { ?>
            <div id="myAbsensiWidget" class="widget visible-md-block visible-lg-block">
                <?
                $wid = new Widget();
                $wid->myAbsensiWidget();
                ?>
            </div>
        <? } ?>


    </div>

</div>

<?php

