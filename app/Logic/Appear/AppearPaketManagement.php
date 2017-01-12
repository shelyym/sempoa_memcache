<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/8/16
 * Time: 10:18 AM
 */

class AppearPaketManagement {

    public static function loadPaketForPay($app){

        $paketBerlaku = Efiwebsetting::getData('PaketBerlaku');


        if($paketBerlaku != "1,2") {
            $paket1 = new Paket();
            $paket1->getByID(3); //paket android iOS
        }

        $paket2 = new Paket();
        $paket2->getByID(2); // paket android



        ?>
        <style>

            .paketmanagement{
                padding: 20px;
                /*border-top:1px solid #CCCCCC;*/
                background-color: #f6f6f6;
            }
            .paket_inside{
                padding: 10px;
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }
                .paketmanagement{
                    padding: 10px;

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
        <div class="paketmanagement">
        <div style="padding-bottom: 20px; font-weight: bold;">Select Package</div>
        <div class="clearfix"></div>

            <? if($paketBerlaku != "1,2") { ?>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="paket_inside">
            <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
            <small>what you get</small>
            </div>
        </div>
            <? } ?>
        <div class="col-md-6 col-sm-6 col-xs-6 <? if($paketBerlaku == "1,2") { ?>col-md-offset-3 col-sm-offset-3 col-xs-offset-3<?}?>">
            <div class="paket_inside">
            <img style="cursor: pointer;" id="paket2" onclick="setPaket(2);" src="<?=_SPPATH;?>images/paket-android-2.png"  width="100%">
            <small>what you get</small>
            </div>
        </div>
        <div class="clearfix"></div>
        <script>
    <? if($paketBerlaku != "1,2") { ?>
            var paket_selected = 3;
            $(document).ready(function(){
                setPaket(1);
            });
        <? }else{ ?>
            var paket_selected = 2;
            $(document).ready(function(){
                setPaket(2);
            });
        <? } ?>
            function setPaket(x){
                if(x == 1){
                    $('#paket2').attr("src","<?=_SPPATH;?>images/paket-android-2.png");
                    $('#paket1').attr("src","<?=_SPPATH;?>images/paket-android-ios.png");
                    $('#paketprice').html("IDR <?=idr($paket1->paket_price);?> / year");
                    paket_selected = 3;
                    $('#paybuttonpaket3').show();
                    $('#paybuttonpaket2').hide();
                }else{
                    $('#paket2').attr("src","<?=_SPPATH;?>images/paket-android.png");
                    $('#paket1').attr("src","<?=_SPPATH;?>images/paket-android-ios-2.png");
                    $('#paketprice').html("IDR <?=idr($paket2->paket_price);?> / year");
                    paket_selected = 2;
                    $('#paybuttonpaket2').show();
                    $('#paybuttonpaket3').hide();
                }
            }
        </script>

        <div class="clearfix"></div>
        </div>

        <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">IDR <?=idr($paket1->paket_price);?> / year</div>

        <div style="padding: 20px;background-color: #f6f6f6;">
            <a id="paybuttonpaket3" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=3" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>
            <a id="paybuttonpaket2" style="display: none;" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=2" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>

            <!--            <a href="--><?//=_SPPATH;?><!--VeritransPay/pay?app_id=--><?//=$app->app_id;?><!--" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>-->
        </div>


    <?
    }
} 