<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 8/31/16
 * Time: 3:12 PM
 */

class InboxWeb extends WebService{

    function readbyID(){

        $id = addslashes($_GET['id']);

        $inb = new SempoaInboxModel();
        $inb->getByID($id);

        ?>
        <div class="btn btn-default" style="margin-left: 10px;" onclick="openLw('my_inbox','<?=_SPPATH;?>InboxWeb/my_inbox','fade');">Go To Inbox</div>
        <div style="background-color: #FFFFFF; margin: 10px; padding: 30px;">
        <h1 style="border-bottom: 1px dashed #cccccc; margin-top: 0px; padding-bottom: 20px;"><?=stripslashes($inb->inbox_title);?></h1>
        <div style="font-size: 15px;"><?=stripslashes($inb->inbox_msg);?></div>

        </div>
            <?

        $inb->inbox_read = 1;
        $inb->save();

        ?>
        <script>
            $( document ).ready(function() {
                $.get("<?=_SPPATH;?>InboxWeb/updateInboxNumber",function(data){
                    $('#menu_inbox_sempoa').html(data);
                });
                lwrefresh("my_inbox");
            });
        </script>

        <?
    }
    function updateInboxNumber(){
        $inb = new SempoaInboxModel();
        $nr =$inb->getJumlah("inbox_org_id = '".AccessRight::getMyOrgID()."' AND inbox_read = 0 ");

        $arrInbox =$inb->getWhere("inbox_org_id = '".AccessRight::getMyOrgID()."' ORDER BY inbox_date DESC LIMIT 0,10");


        ?>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <? if($nr>0){?>
                <span class="label label-success"><?=$nr;?></span>
            <? } ?>
        </a>
        <ul class="dropdown-menu">
            <li class="header">You have <?=$nr;?> new messages</li>
            <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <? foreach($arrInbox as $ib){
                        $org = new SempoaOrg();
                        $org->getByID($ib->inbox_sender_id);
                        ?>
                        <li <? if($ib->inbox_read == 1)echo "class='inbox_dibaca'";?>><!-- start message -->
                            <a  onclick="openLw('inbox_<?=$ib->inbox_id;?>','<?=_SPPATH;?>InboxWeb/readbyID?id=<?=$ib->inbox_id;?>','fade');">
                                <!--                                <div class="pull-left">-->
                                <!--                                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                                <!--                                </div>-->
                                <h4>
                                    <?=$org->nama;?>
                                    <small><i class="fa fa-clock-o"></i> <?=ago(strtotime($ib->inbox_date));?></small>
                                </h4>
                                <p><?=$ib->inbox_title;?></p>
                            </a>
                        </li>
                        <!-- end message -->
                    <? } ?>

                </ul>
            </li>
            <li class="footer"><a  onclick="openLw('my_inbox','<?=_SPPATH;?>InboxWeb/my_inbox','fade');">See All Messages</a></li>
        </ul>

        <?

    }
    function my_inbox(){



        $inb = new SempoaInboxModel();
        $nr =$inb->getJumlah("inbox_org_id = '".AccessRight::getMyOrgID()."' ");

        $arrInbox =$inb->getWhere("inbox_org_id = '".AccessRight::getMyOrgID()."' ORDER BY inbox_date DESC LIMIT 0,100");

        ?>
        <style>
            .inbox_dibaca_dlm{
                background-color: #e4e4e4 !important;
            }
            .inbox_item:hover{
                background-color: #FFFFFF !important;
            }
            .inbox_item{
                padding: 10px;
                border-bottom: 1px dashed #cccccc;
            }
            .inbox_item b{
                font-size: 18px;
            }
        </style>
        <div class="content-wrapper2">
        <!-- Content Header (Page header) -->
        <section class="content-header">


        <h1 style="margin-bottom: 20px;">
            Inbox
        </h1>
        </section>

        <div style=" padding: 0px;">
            <? foreach($arrInbox as $ib){
                $org = new SempoaOrg();
                $org->getByID($ib->inbox_sender_id);
                ?>
                <div  onclick="openLw('inbox_<?=$ib->inbox_id;?>','<?=_SPPATH;?>InboxWeb/readbyID?id=<?=$ib->inbox_id;?>','fade');" style="background-color: #f6f6f6;cursor: pointer; " class='inbox_item <? if($ib->inbox_read == 1)echo "inbox_dibaca_dlm";?>'><!-- start message -->

                        <!--                                <div class="pull-left">-->
                        <!--                                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->
                        <!--
                                                       </div>-->
                    <div class="pull-right" style="width: 100px; text-align: right;"><small><i class="fa fa-clock-o"></i> <?=ago(strtotime($ib->inbox_date));?></small>
                    </div>
                        <b>
                            <?=$org->nama;?></b><br>

                        <div><?=$ib->inbox_title;?></div>

                </div>
                <!-- end message -->
            <? } ?>
        </div>
        </div>
   <?
    }
} 