<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/7/16
 * Time: 3:56 PM
 */

class MyOrders {

    public static function myorderspage(){

        $arrPaymentStatus = array(
            "1"=> array("settlement","success"),
            "2"=> array("success","success"),
            "3"=> array("challenge","failed"),
            "4"=> array("pending","pending"),
            "5"=> array("deny","denied"),
            "6"=> array("cancel","canceled")
        );
        ?>
        <style>

            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }



            }

        </style>
        <style>
            .heading_earning{
                font-size: 17px;
                font-style: italic;
            }
            .heading_amount{
                font-size: 40px;
            }

            .inside{
                padding: 20px;
            }
            .selectMonth{
                /*padding-left: 10px;*/
            }
            .payout{
                color: #95abc2;
            }
            .money{
                font-size: 22px;
                color: #73879C;
            }
            .big{
                font-size: 25px;
                color: #73879C;
            }
            .rev_item{
                background-color: #ffffff;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .order_id{
                font-size: 20px;
                color: #73879C;
            }
            .pdate{
                color: #73879C;
                font-style: italic;
            }
            .heading_amount{
                font-size: 30px;
                text-align: right;
                padding-bottom: 100px;
            }
            .heading_amount_Sales{
                font-size: 18px;
                text-align: right;
                /*padding-bottom: 20px;*/
            }

            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                .selectMonth{
                    padding-left: 0px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #CCCCCC;
                }
                .rightborder{
                    border-bottom: 1px solid #CCCCCC;
                }
                .leftborder{
                    border-top: 1px solid #CCCCCC;
                }
                .inside{
                    padding: 10px;
                }
                .tarmob{
                    /*text-align: right;*/
                }

            }

            @media (min-width: 768px) {
                .monly {
                    display: none;
                }

                .donly {
                    display: initial;
                }

                .leftborder{
                    border-left: 1px solid #CCCCCC;
                    min-height: 120px;
                }

                .rightborder{
                    border-right: 1px solid #CCCCCC;
                }
            }
        </style>
        <div class="container attop"  >
            <div class="col-md-12">
                <div class="appear_logo_pages">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-order.png" >
                    </a>
                </div>
                <?
                $orders = new VpTransaction();
                $arrOrder = $orders->getWhere("order_acc_id = '".Account::getMyID()."' ORDER BY order_date DESC");

                if(count($arrOrder)>0){


                    foreach($arrOrder as $num=>$orders){

                        $app = new AppAccount();
                        $app->getByID($orders->order_app_id);

                        $paket = new Paket();
                        $paket->getByID($orders->order_paket_id);
                        ?>
                        <div class="rev_item col-md-12">
                            <div class="col-md-5 ">
                                <div class="inside">
                                    <div class="payout col-md-6 col-sm-6 col-xs-6">
                                        <div class="rev_details2">
                                            <small>Order ID</small>
                                            <div class="order_id"><?=$orders->order_id;?></div>
                                        </div>
                                    </div>
                                    <div class="payout col-md-6 col-sm-6 col-xs-6">
                                        <div class="rev_details">
                                            Date : <?=date("F j, Y, g:i a",strtotime($orders->order_date));?>
                                        </div>
                                        <div class="rev_details">
                                            App : <?=$app->app_name;?>
                                        </div>

                                        <div class="rev_details">
                                            Paket  : <?=$paket->paket_name;?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>



                            <div class="col-md-3 payout leftborder rightborder">
                                <div class="inside">
                                    <div class="komisi tarmob">
                                        Order Value
                                        <div class="order_id"> IDR <?=idr($orders->order_value);?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="inside tarmob">
                                    <small>Status</small>
                                    <div class="money big"><?=$arrPaymentStatus[$orders->order_status][1];?></div>
                                    <? if($orders->order_status == "1" || $orders->order_status== "2"){

                                        ?>
                                        <a href="<?= _SPPATH; ?>PaymentWeb/receipt?order_id=<?= $orders->order_id; ?>">receipt</a>
                                    <?

                                    }?>
                                    <? if($orders->order_status!= "1" && $orders->order_status!= "2" && $orders->order_status!= "4"){
                                        if($app->app_active == 0) {
                                            ?>
                                            <a href="<?= _SPPATH; ?>PaymentWeb/pay?app_id=<?= $app->app_id; ?>">pay again using different method</a>
                                        <?
                                        }
                                    }?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <? } ?>
                    <div class="clearfix"></div>


                <? }else{
                    ?>
                    <h1>No orders has been made yet</h1>
                <?
                } ?>
            </div>
        </div>
    <?
    }
} 