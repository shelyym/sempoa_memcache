<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 6/21/16
 * Time: 4:36 PM
 */

class MyApps2 {

    static function getMyApps(){

        $acc = Account::getAccountObject();
        global $template;
        $template->pagetitle = "My Apps";


        ?>
        <style>
            body{
                background-color: #eeeeee;
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }


                .container {
                    padding-right: 0px;
                    padding-left: 0px;
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }
                .attop{
                    margin-top: 30px;
                }
            }
        </style>
        <div class="container attop"  >
    <div class="col-md-8 col-md-offset-2">


        <?

            $acc = new App2Acc();
            //AND app_active = 1
            $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id ORDER BY app_create_date DESC",array("AppAccount"));


        if(count($apps)>0){
            ?>
            <div id="app_icons">
                <?
                foreach($apps as $num=>$ap){


                    $parsed = parse_url($ap->app_icon);
                    if (empty($parsed['scheme'])) {
                        if($ap->app_icon == ""){
                            $ap->app_icon = _SPPATH."images/noimage2.png";
                        }else
                        $ap->app_icon = _SPPATH._PHOTOURL.$ap->app_icon;
                    }

                    ?>
                    <div class="col-md-3 col-sm-6 col-xs-6 myapp">

                        <div id="app_<?=$num;?>" class="app_icon" >
                            <a target="_blank" href='<?=_SPPATH;?>MyApp/editbridge?id=<?=$ap->app_id;?>'>
                            <img width="100%" src="<?=$ap->app_icon;?>">
                            </a>
                            <div class="app_text">

                                <div class="app_name2 truncate">
                                    <a target="_blank" href='<?=_SPPATH;?>MyApp/editbridge?id=<?=$ap->app_id;?>'>
                                    <?=$ap->app_name;?>
                                    </a>
                                </div>
                                <div class="app_detail2">
                                    Status : <?=$ap->app_active;?>
                                </div>

                                <div class="app_detail2">

                                    <? if($ap->app_active>0 && $ap->app_type == 0){?>
                                      <?  echo '<div class="app_contract">Expired : '.date("d-m-Y",strtotime($ap->app_contract_end)).'</div>'; ?>
                                    <? } ?>
                                   </div>

                            </div>

                        </div>
                    </div>
                <? } ?>

                <style>
                    .app_icon{
                        margin: 5px;
                        border: 1px solid #dedede;
                        background-color: white;
                        border-radius: 6px;
                        overflow: hidden;
                    }
                    .app_name2 a{
                        font-size: 16px;
                        color: #484654;
                    }
                    .app_text{
                        padding: 5px;
                        padding-left: 10px;
                    }

                    .truncate {

                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    .app_detail2{
                        font-size: 12px;
                        height: 17px;
                    }


                </style>
            </div>
            <div class="clearfix"></div>

            <style>
                .table{
                    background-color: white;
                }
            </style>

            </div>
            <div class="clearfix" style="margin-bottom: 100px;"></div>

            </div>
        <?
        }else {

            ?>
            <div style="text-align: center; font-size: 15px; padding: 10px;">
            No Apps Yet, Please download Appear Bridge below to create Apps
            </div>
            <?

        }
    }
} 