<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/21/15
 * Time: 2:35 PM
 */

class PaymentWeb extends WebApps{

    var $access_payfor = "normal_user";
    function payfor(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        $paket = new Paket();
        $paket->getByID($app->app_paket_id);

        ?>
        <div class="container attop" style="text-align: center;" >
            <div class="col-md-8 col-md-offset-2">
            <div style="text-align: center; padding: 20px;">
                <a href="<?=_SPPATH;?>">
                    <img src="<?=_SPPATH;?>images/appear-payment.png" style="max-width: 300px;">
                </a>
            </div>

            <div class="app" style="background-color: #dedede;">
                <div style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 20px;">Payment For</div>
                <div class="col-md-3 col-sm-3 col-xs-3" style="text-align: center; min-height: 270px;  padding: 10px; background-color: #FFFFFF;">
                    <b >App Details</b><br><br>
                    <img src="<?=$app->app_icon;?>" width="80%">
                    <?=$app->app_name;?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9" style="text-align: center; padding: 10px;background-color: #dedede;">
                    <div style="padding-bottom: 20px; font-weight: bold;">Package Details</div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
                        <small>what you get</small>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <img style="cursor: pointer;" id="paket2" onclick="setPaket(2);" src="<?=_SPPATH;?>images/paket-android-2.png"  width="100%">
                        <small>what you get</small>
                    </div>
                    <div class="clearfix"></div>
                    <script>
                        function setPaket(x){
                            if(x == 1){
                                $('#paket2').attr("src","<?=_SPPATH;?>images/paket-android-2.png");
                                $('#paket1').attr("src","<?=_SPPATH;?>images/paket-android-ios.png");
                                $('#paketprice').html("IDR 9.000.000 / year");
                            }else{
                                $('#paket2').attr("src","<?=_SPPATH;?>images/paket-android.png");
                                $('#paket1').attr("src","<?=_SPPATH;?>images/paket-android-ios-2.png");
                                $('#paketprice').html("IDR 6.000.000 / year");
                            }
                        }
                    </script>
                </div>
                <div class="clearfix"></div>
                <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">IDR 9.000.000 / year</div>
            </div>

            <div style="padding: 20px;">
            <a class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>
            </div>


                <h4 style="margin-bottom: 0px; padding-bottom: 0px;" class="hype">Payment For</h4>
                <h1 class="hype" style="margin-bottom: 20px; margin-top: 10px;"><?=$app->app_name;?></h1>
                <h1 style="background-color: #efefef; padding: 10px; margin: 10px;" class="hype">Total : Rp.<?=idr($paket->paket_price*12);?> </h1>
                <small><a href="">upgrade package</a></small>
                <h3 style="margin-top: 50px;" class="hype">Please Choose Payment Method to complete App Registration</h3>

                <a href="<?=_SPPATH;?>VeritransPay/pay?app_id=<?=$app->app_id;?>" style="width: 100%; margin: 5px;" class="btn btn-info btn-lg">Pay with Veritrans (Credit Card, ATM, Klikpay, dll)</a>
                 <a href="javascript:$('#cc').fadeToggle();" style="width: 100%; margin: 5px;" class="btn btn-info btn-lg">Credit card</a>
                <div id="cc" style="display: none; background-color: #efefef; padding: 30px; ">

                    <form accept-charset="UTF-8"  autocomplete="off" class="form-horizontal" role="form"  id="new_cc" method="post" novalidate="novalidate">

                        <input type="hidden" name="appprice" value="<?=ceil($paket->paket_price*12/14000);?>">
                        <input type="hidden" name="appdescr" value="Payment StageCom Paket <?=$paket->paket_name;?> ID : <?=$app->app_id;?>">
                        <input type="hidden" name="appid" value="<?=$app->app_id;?>">
                        <div style="margin:0;padding:0;display:inline">
                            <input name="utf8" type="hidden" value="&#x2713;" />
                            <input name="authenticity_token" type="hidden" value="vpVuNuIt9fRZzLm0eE0gk4h249k0nZPB/WEXWn9ETwg=" />
                        </div>


                        <p>Your credit card information is stored safely with PayPal.</p>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="user_credit_card_name">
                                <abbr title="required">*</abbr> Name</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="user_credit_card_name" name="user[credit_card][name]" size="150" type="text" value="<?=Account::getMyName();?>" />

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="user_credit_card_type">
                                <abbr title="required">*</abbr> Type</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="user_credit_card_type" name="user[credit_card][type]">
                                    <option value=""></option>
                                    <option value="visa" selected>visa</option>
                                    <option value="mastercard">mastercard</option>
                                    <option value="discover">discover</option>
                                    <option value="amex">amex</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-4" for="user_credit_card_number">
                                <abbr title="required">*</abbr> Number</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="user_credit_card_number" name="user[credit_card][number]" size="50" type="text" value="4417119669820331" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4"  for="user_credit_card_cvv2">Cvv2</label>
                            <div class="col-sm-8">
                                <input class="form-control" id="user_credit_card_cvv2" name="user[credit_card][cvv2]" size="50" type="text" value="012" /></div></div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" class="select required control-label" for="user_credit_card_expire_month"><abbr title="required">*</abbr> Expire month</label>

                            <div class="col-sm-8">
                                <select class="form-control" id="user_credit_card_expire_month" name="user[credit_card][expire_month]">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option selected value="11">11</option>
                                    <option value="12">12</option></select></div></div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="user_credit_card_expire_year">
                                <abbr title="required">*</abbr> Expire year</label>

                            <div class="col-sm-8">
                                <select class="form-control"  id="user_credit_card_expire_year" name="user[credit_card][expire_year]"><option value=""></option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option selected value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option></select></div></div>
                        <div class='form-actions'>
                            <input class="btn btn btn-primary" name="commit" type="button" id="add_cc" value="Add CC" />
                            <input class="btn btn btn-primary" name="commit" type="submit" value="Pay" />
                        </div>
                    </form>
                    <script>
                        $( "#add_cc" ).click(function( event ) {

                            $(".err").hide();


                            var $form = $("#new_cc");
                            var url = "<?=_SPPATH;?>PaypalWeb/addCard";

                            $(".err").hide();

                            // Send the data using post
                            var posting = $.post(url, $form.serialize(), function (data) {
                                console.log(data);
                                alert(data);
//                                if (data.bool) {
//                                    //kalau success masuk ke check your email....
//                                    document.location = "<?//=_SPPATH;?>//PaypalWeb/confirm?app_id="+data.app_id;
//                                }
//                                else {
//                                    if(data.all!="") {
//                                        $("#resultajax").show();
//                                        $("#resultajax").html(data.all);
//                                    }
//                                    var obj = data.err;
//                                    var tim = data.timeId;
//                                    //console.log( obj );
//                                    for (var property in obj) {
//                                        if (obj.hasOwnProperty(property)) {
//                                            $( "#"+property ).css( "border-color", "red");
//                                            $( "#"+property ).next(".err").css( "color", "red").show().empty().append(obj[property]).fadeIn('slow');
//                                        }
//                                    }
//                                }
                            });




                            event.preventDefault();
                        });

                        $( "#new_cc" ).submit(function( event ) {

                            $(".err").hide();


                            var $form = $(this);
                            var url = "<?=_SPPATH;?>PaypalWeb/placeOrder";

                            $(".err").hide();

                            $(".se-pre-con2").fadeIn("slow");
                            // Send the data using post
                            var posting = $.post(url, $form.serialize(), function (data) {
                                console.log(data);

                                $(".se-pre-con2").fadeOut("slow");

                                if(data.paystate){
                                    document.location = "<?=_SPPATH;?>myOrders";
                                }else{
                                    alert(data.err);
                                }
//                                if (data.bool) {
//                                    //kalau success masuk ke check your email....
//                                    document.location = "<?//=_SPPATH;?>//PaypalWeb/confirm?app_id="+data.app_id;
//                                }
//                                else {
//                                    if(data.all!="") {
//                                        $("#resultajax").show();
//                                        $("#resultajax").html(data.all);
//                                    }
//                                    var obj = data.err;
//                                    var tim = data.timeId;
//                                    //console.log( obj );
//                                    for (var property in obj) {
//                                        if (obj.hasOwnProperty(property)) {
//                                            $( "#"+property ).css( "border-color", "red");
//                                            $( "#"+property ).next(".err").css( "color", "red").show().empty().append(obj[property]).fadeIn('slow');
//                                        }
//                                    }
//                                }
                            }, 'json');




                            event.preventDefault();
                        });
                    </script>

                </div>
<!--                <a href="" style="width: 100%; margin: 5px;" class="btn btn-info btn-lg">Paypal</a>-->

                <a href="javascript:$('#banktt').fadeToggle();" style="width: 100%; margin: 5px;" class="btn btn-info btn-lg">Bank Transfer</a>

                <div id="banktt" style="display: none; background-color: #efefef; padding: 30px; text-align: left; ">
                Silahkan melakukan pembayaran melalui
                    <ul>
                        <li>
                            <b>Bank BCA</b>
                            <p>
                                a/n PT Indo Mega Byte<br>
                                no Rek : 82018912812<br>
                                App ID : <?=$app->app_id;?> <br>
                                keterangan : <i>Payment Stagecom App ID : <?=$app->app_id;?></i>

                            </p>


                        </li>
                        <li>
                            <b>Bank Permata</b>
                            <p>
                                a/n PT Indo Mega Byte<br>
                                no Rek : 82018912812<br>
                                App ID : <?=$app->app_id;?> <br>
                                keterangan : <i>Payment Stagecom App ID : <?=$app->app_id;?></i>

                            </p>


                        </li>
                    </ul>
                    <p>
                        Setelah melakukan pembayaran, jangan lupa untuk melakukan <a href="<?=_SPPATH;?>PaymentWeb/confirmpayment?app_id=<?=$app->app_id;?>" >konfirmasi pembayaran</a>.
                    </p>
                    </div>
                <br><br> Atau jika anda sudah melakukan pembayaran melalui bank transfer
                <a href="<?=_SPPATH;?>PaymentWeb/confirmpayment?app_id=<?=$app->app_id;?>" class="btn btn-success">confirm payment</a>
            </div>
        </div>
<style>
    #banktt ul{
        padding: 0px;
        margin: 0px;
    }
    #banktt ul li{
        padding: 0px;
        margin: 0px;
        margin-top: 20px;
    }
</style>
    <?
    }

    var $access_confirmpayment = "normal_user";
    function confirmpayment(){
$id = addslashes($_GET['app_id']);

$acc = new App2Acc();


$apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

if(count($apps)<1){
    die("hacking attempt");
}else{
    $app = $apps[0];
}

$paket = new Paket();
$paket->getByID($app->app_paket_id);

?>
        <style>
            .helper{
                font-size: 12px;
                padding-top: 5px;
                color:#999999;
            }
            .foto100{
                width: 100px;
                height: 100px;
                overflow: hidden;
            }
            .foto100 img{
                height: 100px;
            }
            .err{
                display: none;
            }
        </style>
<div class="container attop" style="text-align: center;" >
    <div class="col-md-8 col-md-offset-2">
        <h1>Payment Confirmation for <?=$app->app_name;?></h1>
        <hr>
        <div id="resultajax" style="display: none;"></div>
        <form id="paymentconfirm" class="form-horizontal" role="form">
            <input type="hidden" name="appid" value="<?=$app->app_id;?>">
            <div class="form-group">
                <label class="control-label col-sm-4" for="ttdate">Date :
                    <div class="helper">max 30 chars</div>
                </label>
                <div class="col-sm-8">
                    <input name="ttdate" type="date" class="form-control" id="ttdate" >
                    <div class="err"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="ttname">Sender Name :
                    <div class="helper">max 80 chars</div>
                </label>
                <div class="col-sm-8">
                    <input name="ttname" type="text" class="form-control" id="ttname" >
                    <div class="err"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="ttamount">Amount Transfered :
                    <div class="helper">max 80 chars</div>
                </label>
                <div class="col-sm-8">
                    <input name="ttamount" type="number" class="form-control" id="ttamount" value="<?=$paket->paket_price*12;?>" >
                    <div class="err"></div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4" for="ttto">Payment To :
                    <div class="helper">max 80 chars</div>
                </label>
                <div class="col-sm-8">
                    <select id="ttto" name="ttto" class="form-control">
                        <option value="bca">BCA</option>
                        <option value="permata">Permata</option>
                    </select>
                    <div class="err"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="appicon">Receipt File:
                    <div class="helper">optional</div>
                </label>
                <div class="col-sm-8">
                    <?
                    $foto = new \Leap\View\InputFoto("ttfile","ttfile","");
                    $foto->p();

                    ?>

                 </div>
            </div>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2">
                    <button type="submit" style="width: 100%;" class="btn btn-lg btn-success">Submit</button>
                    <a href="<?=_SPPATH;?>PaymentWeb/payfor?app_id=<?=$app->app_id;?>" style="width: 100%; margin-top: 10px;" class="btn btn-lg btn-default">Cancel</a>
                </div>
            </div>
        </form>
        </div>
    </div>
        <script>
            $( "#paymentconfirm" ).submit(function( event ) {

                $(".err").hide();

//                        alert("benar semua1");
                var $form = $(this);
                var url = "<?=_SPPATH;?>PaymentWeb/addConfirm";

                $(".err").hide();

                // Send the data using post
                var posting = $.post(url, $form.serialize(), function (data) {
                    console.log(data);
                    if (data.bool) {
                        //kalau success masuk ke check your email....
                        document.location = "<?=_SPPATH;?>myOrders";
                    }
                    else {
                        if(data.all!="") {
                            $("#resultajax").show();
                            $("#resultajax").html(data.all);
                        }
                        var obj = data.err;
                        var tim = data.timeId;
                        //console.log( obj );
                        for (var property in obj) {
                            if (obj.hasOwnProperty(property)) {
                                $( "#"+property ).css( "border-color", "red");
                                $( "#"+property ).next(".err").css( "color", "red").show().empty().append(obj[property]).fadeIn('slow');
                            }
                        }
                    }
                }, 'json');




                event.preventDefault();
            });
        </script>

        <?
        /*
         *
Transaction Date *

Sender Name *

Amount Transferred *

Payment to *

Email *

Receipt File (optional)
Choose File
Fields marked with * are required.

         */
    }

    var $access_addConfirm = "normal_user";
    function addConfirm(){

        $err = array();
        $json['bool'] = 0;
//       $json['err'] = array("apptitle"=>"harus diisi");

        $ttdate = addslashes($_POST['ttdate']);
        if($ttdate == ""){
            $err['ttdate'] = "Date must be filled";
        }


        $ttname = addslashes($_POST['ttname']);
        if($ttname == ""){
            $err['ttname'] = "Name must be filled";
        }


        $ttamount = addslashes($_POST['ttamount']);
        if($ttamount == ""){
            $err['ttamount'] = "Amount must be filled";
        }


        $ttto = addslashes($_POST['ttto']);
        if($ttto == ""){
            $err['ttto'] = "Bank Account must be filled";
        }





        if(count($err)>0){
            $json['bool'] = 0;
            $json['err'] = $err;
        }
        else{
            //save here

            $pc = new PaymentConfirm();
            $pc->confirm_app_id = addslashes($_POST['appid']);
            $pc->confirm_bank = $ttto;
            $pc->confirm_amount = $ttamount;
            $pc->confirm_create_date = leap_mysqldate();
            $pc->confirm_date = $ttdate;
            $pc->confirm_name = $ttname;
            $pc->confirm_receipt = addslashes($_POST['ttfile']);
            $pc->confirm_status = "not reviewed";
            $pc->confirm_user_id = Account::getMyID();
            $confirmID = $pc->save();



            if($confirmID) {
                $app = new AppAccount();
                $app->getByID($pc->confirm_app_id);
                $app->app_active = 2;
                $app->load = 1;
                $app->app_pulsa = 1000;
                $app->save();

                $paket = new Paket();
                $paket->getByID($app->app_paket_id);

                //add pporder
                $ppo = new PaypalOrder();
                $ppo->payment_id = $confirmID;
                $ppo->payment_type = "banktt";
                $ppo->amount = $pc->confirm_amount;
                $ppo->currency = "IDR";
                $ppo->created_time = leap_mysqldate();
                $ppo->state = "pending";
                $ppo->user_id = Account::getMyID();
                $ppo->description = "Payment ".$app->app_name." Paket ".$paket->paket_name." ID : ".$app->app_id;
                $succ = $ppo->save();


                if($succ) {
                    $json['bool'] = 1;
                    $json['order_id'] = $succ;
                }else{
                    $json['bool'] = 0;
                    $json['all'] = "Saving PPO Error";
                }
            }else{
                $json['bool'] = 0;
                $json['all'] = "Saving PConfirm Error";
            }
        }

        echo json_encode($json);
        die();
    }


    var $access_pay = "normal_user";
    function pay(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        if($app->app_active){
            header("Location:"._SPPATH."myapps");
            die();
        }

        AppAccount::checkOwnership($app);



        $activeAcc = Account::getAccountObject();


        ?>
        <style>
            .app_details{
                padding: 20px;

            }
            .app_details_img img{
                width: 120px;
            }
            .app_details_name{
                font-weight: bold;
                padding-top: 10px;

            }
            .app_details_heading{
                display: none;
            }
            .paket_details{

            }
            .free_apply{
                text-align: center;
                background-color: #ffffff;
                padding: 20px;
                margin-top: 20px;
            }
            .free_details{
                font-style: italic;
                padding-bottom: 15px;
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }
                .app_details{
                    padding: 10px;
                }
                .container{
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


            }
        </style>
        <div class="container attop" style="text-align: center;" >
        <div class="col-md-6 col-md-offset-3">

        <div class="appear_logo_pages">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-payment.png" >
            </a>
        </div>

        <div class="app" style="background-color: #ffffff; ">
            <div style=" padding: 5px; text-align: center; font-size: 16px; font-weight: bold;">Payment For</div>
            <div class="app_details" >
                <div class="app_details_heading">App Details</div>
                <div class="app_details_img">
                    <img src="<?=$app->app_icon;?>">
                </div>
                <div class="app_details_name"><?=$app->app_name;?></div>
            </div>
            <div class="paket_details ">
                <? AppearPaketManagement::loadPaketForPay($app);?>
            </div>
        </div>




        <div class="free_apply">
            <div class="free_details">
                We support education, social, spiritual and other non-profit organization. <br>If this App is for one of the above purposes.
                </div>

            <a href="<?=_SPPATH;?>apply_free?id=<?=$app->app_id;?>" class="btn btn-default">Apply FREE apps</a>
            <br>
            <small>what you get</small>
        </div>

        <div class="back_to_button">
            <a href="<?=_SPPATH;?>myapps">I will finish the payment later. Go back to My Apps.</a>
        </div>


    <?
    }

    var $access_pay_old = "master_admin";
    function pay_old(){

    $id = addslashes($_GET['app_id']);

    $acc = new App2Acc();


    $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

    if(count($apps)<1){
        die("hacking attempt");
    }else{
        $app = $apps[0];
    }

    if($app->app_active){


        header("Location:"._SPPATH."myapps");
        die();
    }

    AppAccount::checkOwnership($app);

    $paket = new Paket();
    $arrPaket = $paket->getWhere("paket_active = 1 AND paket_id > 1 ORDER BY paket_id ASC");

    $paket2 = new Paket();
    $paket2->getByID(2); // paket android

    $paket1 = new Paket();
    $paket1->getByID(3); //paket android iOS


    $paymentResponse = 0;
    $paymentText = "";

    $vpt = new VpTransaction();
    $arrVpt = $vpt->getWhere("order_app_id = '{$app->app_id}' AND order_status = '0' AND order_status_from != '0' ");
    if(count($arrVpt)>0){
        $vpt = $arrVpt[0];
        $paymentResponse = $vpt->order_status_from;

        if($paymentResponse == "200"){
            //sucess
            $paymentText = "Your Payment is Success";
        }
        if($paymentResponse == "201"){
            //sucess
            $paymentText = "Your Payment is Pending/Challenge";
        }
        if($paymentResponse == "202"){
            //denied
            $paymentText = "Your Payment is denied";
        }
        if($paymentResponse == "103"){
            //error
            $paymentText = "Error Response by payment";
        }
        if($paymentResponse == "102"){
            //failed
            $paymentText = "Failed Response by payment";
        }
        if($paymentResponse == "300"){
            //error
            //Move Permanently, current and all future requests should be directed to the new URL
            $paymentText = "Error, new URL needed";
        }
        if($paymentResponse >= 400){
            //error
            //Validation Error, merchant sent bad request data example; validation error, invalid transaction type, invalid credit card format, etc.
            $paymentText = "Validation Error";
        }
        if($paymentResponse >=500){
            //error
            //Internal Server Error
            $paymentText = "Internal Server Error";
        }

    }
    ?>
<div class="container attop" style="text-align: center;" >
<div class="col-md-8 col-md-offset-2">

    <div class="appear_logo_pages">
        <a href="<?=_SPPATH;?>">
            <img src="<?=_SPPATH;?>images/appear-payment.png" >
        </a>
    </div>

    <div class="app" style="background-color: #dedede;">
        <div style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 20px;">Payment For</div>
        <div class="col-md-3 " style="text-align: center; min-height: 270px;  padding: 10px; background-color: #FFFFFF;">
            <b >App Details</b><br><br>
            <img src="<?=$app->app_icon;?>" width="80%"><br>
            <?=$app->app_name;?>
        </div>
        <div class="col-md-9 " style="text-align: center; padding: 10px;background-color: #dedede;">
            <div style="padding-bottom: 20px; font-weight: bold;">Package Details</div>
            <div class="clearfix"></div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
                <small>what you get</small>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <img style="cursor: pointer;" id="paket2" onclick="setPaket(2);" src="<?=_SPPATH;?>images/paket-android-2.png"  width="100%">
                <small>what you get</small>
            </div>
            <div class="clearfix"></div>
            <script>
                var paket_selected = 3;
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
        </div>
        <div class="clearfix"></div>
        <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">IDR <?=idr($paket1->paket_price);?> / year</div>
    </div>

    <div style="padding: 20px;">
        <a id="paybuttonpaket3" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=3" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>
        <a id="paybuttonpaket2" style="display: none;" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=2" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>

        <!--            <a href="--><?//=_SPPATH;?><!--VeritransPay/pay?app_id=--><?//=$app->app_id;?><!--" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>-->
    </div>

    <hr>
    <div style="text-align: center; ">
        <i>We support education, social, spiritual and other non-profit organization. <br>If this App is for one of the above purposes.</i><br>
        <a href="<?=_SPPATH;?>apply_free?id=<?=$app->app_id;?>" class="btn btn-default">apply as FREE apps</a>
        <br>
        <small>what you get</small>
    </div>
    <hr>
    <div style="text-align: center; margin-bottom: 100px;">
        <a href="<?=_SPPATH;?>myapps">I will finish the payment later. Go back to My Apps.</a>
    </div>


<?
}

    var $access_upgrade = "normal_user";
    function upgrade(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        if($app->app_active<1){


            header("Location:"._SPPATH."myapps");
            die();
        }
        if($app->app_paket_id == 3){



            die("Paket sudah tertinggi");
        }

        AppAccount::checkOwnership($app);

        $paket = new Paket();
        $arrPaket = $paket->getWhere("paket_active = 1 AND paket_id > 1 ORDER BY paket_id ASC");

        $paket2 = new Paket();
        $paket2->getByID(2);

        if($app->app_paket_id == 1) {
            $paket1 = new Paket();
            $paket1->getByID(5);
            $next = 5;
        }else{
            $paket1 = new Paket();
            $paket1->getByID(4);
            $next = 4;
        }



        ?>
        <div class="container attop" style="text-align: center;" >
        <div class="col-md-8 col-md-offset-2">
    <div class="appear_logo_pages">
        <a href="<?=_SPPATH;?>">
            <img src="<?=_SPPATH;?>images/appear-payment.png" >
        </a>
    </div>

        <div class="app" style="background-color: #dedede;">
            <div style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 20px;">Upgrade For</div>
            <div class="col-md-6 " style="text-align: center; min-height: 270px;  padding: 10px; background-color: #FFFFFF;">
                <b >App Details</b><br><br>
                <img src="<?=$app->app_icon;?>" width="80%"><br>
                <?=$app->app_name;?>
            </div>
            <div class="col-md-6 " style="text-align: center; padding: 10px;background-color: #dedede;">
                <div style="padding-bottom: 20px; font-weight: bold;">Upgrade Package To</div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
                    <small>what you get</small>
                </div>
<!--                <div class="col-md-6 col-sm-6 col-xs-6">-->
<!--                    <img style="cursor: pointer;" id="paket2"  src="--><?//=_SPPATH;?><!--images/paket-android-2.png"  width="100%">-->
<!--                    <small>what you get</small>-->
<!--                </div>-->
                <div class="clearfix"></div>
                <script>
                    var paket_selected = 3;
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
            </div>
            <div class="clearfix"></div>
            <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">IDR <?=idr($paket1->paket_price);?> / year</div>
        </div>

        <div style="padding: 20px;">
            <a id="paybuttonpaket3" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=<?=$next;?>" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>
            <a id="paybuttonpaket2" style="display: none;" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=2" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>

            <!--            <a href="--><?//=_SPPATH;?><!--VeritransPay/pay?app_id=--><?//=$app->app_id;?><!--" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>-->
        </div>


        <hr>
        <div style="text-align: center; margin-bottom: 100px;">
            <a href="<?=_SPPATH;?>myapps">I will finish the payment later. Go back to My Apps.</a>
        </div>


    <?
    }

    var $access_extend_paket_1 = "normal_user";
    function extend_paket_1(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        if($app->app_active<1){


            header("Location:"._SPPATH."myapps");
            die();
        }
    if($app->app_paket_id != 1){



        die("Paket bukan paket FREE");
    }

        AppAccount::checkOwnership($app);

        $paket = new Paket();
        $arrPaket = $paket->getWhere("paket_active = 1 AND paket_id > 1 ORDER BY paket_id ASC");

        $paket2 = new Paket();
        $paket2->getByID(2);

        $paket1 = new Paket();
        $paket1->getByID(3);

    $prevPaket = new Paket();
    $prevPaket->getByID($app->app_paket_id);

        ?>
        <div class="container attop" style="text-align: center;" >
        <div class="col-md-8 col-md-offset-2">
    <div class="appear_logo_pages">
        <a href="<?=_SPPATH;?>">
            <img src="<?=_SPPATH;?>images/appear-free.png" >
        </a>
    </div>


        <div class="app" style="background-color: #dedede;">
            <div style="background-color: #cccccc; padding: 5px; text-align: center; font-size: 15px;">
                Previous Package : <?=$prevPaket->paket_name;?><br>
                Contract End : <?=date("d-m-Y",strtotime($app->app_contract_end));?> in <?=dateDifference(date("Y-m-d",strtotime($app->app_contract_end)),date("Y-m-d"));?> days
            </div>
            <div style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 20px;">Extendsion For</div>
            <div class="col-md-6 " style="text-align: center; min-height: 270px;  padding: 10px; background-color: #FFFFFF;">
                <b >App Details</b><br><br>
                <img src="<?=$app->app_icon;?>" width="80%"><br>
                <?=$app->app_name;?>
            </div>
            <div class="col-md-6 " style="text-align: center; padding: 10px;background-color: #dedede;">
                <div style="text-align: center; ">
                    <i>We support education, social, spiritual and other non-profit organization. <br>If this App is for one of the above purposes.</i><br>
                    <a href="<?=_SPPATH;?>apply_free?id=<?=$app->app_id;?>" class="btn btn-default">Extend as FREE apps</a>
                    <br>
                    <small>what you get</small>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">FREE</div>
            <div style="background-color: #cccccc; padding: 5px; text-align: center; font-size: 15px;">

                This will renew the contract until <?=date("d-m-Y",strtotime($app->app_contract_end." + 1 year"));?>
            </div>
        </div>





        <hr>
        <div style="text-align: center; margin-bottom: 100px;">
            <a href="<?=_SPPATH;?>myapps">I will finish the payment later. Go back to My Apps.</a>
        </div>


    <?
    }

    var $access_extend = "normal_user";
    function extend(){

        $id = addslashes($_GET['app_id']);

        $acc = new App2Acc();


        $apps = $acc->getWhereFromMultipleTable("ac_admin_id = '".Account::getMyID()."' AND ac_app_id = app_id AND ac_app_id = '$id' ",array("AppAccount"));

        if(count($apps)<1){
            die("hacking attempt");
        }else{
            $app = $apps[0];
        }

        if($app->app_active<1){


            header("Location:"._SPPATH."myapps");
            die();
        }
        if($app->app_paket_id < 2){

            die("Paket bukan paket PAID");
        }
        $prevPaket = new Paket();
        $prevPaket->getByID($app->app_paket_id);

        AppAccount::checkOwnership($app);

        $paket = new Paket();
        $arrPaket = $paket->getWhere("paket_active = 1 AND paket_id > 1 ORDER BY paket_id ASC");

        $paket2 = new Paket();
        $paket2->getByID(2);

        $paket1 = new Paket();
        $paket1->getByID(3);

        $next = 3;


        ?>
        <div class="container attop" style="text-align: center;" >
        <div class="col-md-8 col-md-offset-2">
    <div class="appear_logo_pages">
        <a href="<?=_SPPATH;?>">
            <img src="<?=_SPPATH;?>images/appear-payment.png" >
        </a>
    </div>

        <div class="app" style="background-color: #dedede;">
            <div style="background-color: #cccccc; padding: 5px; text-align: center; font-size: 15px;">
                Previous Package : <?=$prevPaket->paket_name;?><br>
                Contract End : <?=date("d-m-Y",strtotime($app->app_contract_end));?> in <?=dateDifference(date("Y-m-d",strtotime($app->app_contract_end)),date("Y-m-d"));?> days
            </div>

            <div style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 20px;">Payment For</div>
            <div class="col-md-3 " style="text-align: center; min-height: 270px;  padding: 10px; background-color: #FFFFFF;">
                <b >App Details</b><br><br>
                <img src="<?=$app->app_icon;?>" width="80%"><br>
                <?=$app->app_name;?>
            </div>
            <div class="col-md-9 " style="text-align: center; padding: 10px;background-color: #dedede;">
                <div style="padding-bottom: 20px; font-weight: bold;">Package Details</div>
                <div class="clearfix"></div>
                <? if($app->app_paket_id != 5){?>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
                    <small>what you get</small>
                </div>
                <? }else{
                    $paket1 = new Paket();
                    $paket1->getByID(5);
                    $next = 5;
                    ?>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <img style="cursor: pointer;" id="paket1" onclick="setPaket(1);" src="<?=_SPPATH;?>images/paket-android-ios.png" width="100%">
                        <small>what you get</small>
                    </div>
                <? } ?>
                <? if($app->app_paket_id == 2){?>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <img style="cursor: pointer;" id="paket2" onclick="setPaket(2);" src="<?=_SPPATH;?>images/paket-android-2.png"  width="100%">
                    <small>what you get</small>
                </div>
                <? } ?>

                <div class="clearfix"></div>
                <script>
                    var paket_selected = 3;
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
            </div>
            <div class="clearfix"></div>
            <div id="paketprice" style="background-color: #f6f6f6; padding: 5px; text-align: center; font-size: 30px;">IDR <?=idr($paket1->paket_price);?> / year</div>
            <div style="background-color: #cccccc; padding: 5px; text-align: center; font-size: 15px;">

                This will renew the contract until <?=date("d-m-Y",strtotime($app->app_contract_end." + 1 year"));?>
            </div>
        </div>

        <div style="padding: 20px;">
            <a id="paybuttonpaket3" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=<?=$next;?>" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>
            <a id="paybuttonpaket2" style="display: none;" href="<?=_SPPATH;?>Vp/pay?app_id=<?=$app->app_id;?>&paket=2" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>

            <!--            <a href="--><?//=_SPPATH;?><!--VeritransPay/pay?app_id=--><?//=$app->app_id;?><!--" class="btn btn-danger btn-lg">PAY NOW USING VERITRANS</a>-->
        </div>


        <hr>
        <div style="text-align: center; margin-bottom: 100px;">
            <a href="<?=_SPPATH;?>myapps">I will finish the payment later. Go back to My Apps.</a>
        </div>


    <?
    }

    var $access_receipt = "normal_user";
    function receipt(){
        $order_id = addslashes($_GET['order_id']);

        $order = new VpTransaction();
        $order->getByID($order_id);


//        pr($order);

        //TODO : harus dibikin

        if($order->order_acc_id != Account::getMyID() && !in_array("master_admin",Account::getMyRoles())){
            die("hacking attempt");
        }

        $app = new AppAccount();
        $app->getByID($order->order_app_id);

        if($app->app_active ==0){
            die("App not active");
        }
        $acc = new Account();
        $acc->getByID($app->app_client_id);

        $paket = new Paket();
        $paket->getByID($order->order_paket_id);

        $vpData = new VpData();
        $arr = $vpData->getWhere("order_id = '$order_id' LIMIT 0,1");
        if(count($arr)>0){
            $data = $arr[0];
        }else{
            $data = new VpData();
        }

        if($acc->admin_marketer != ""){
            $arrAg = $acc->getWhere("admin_username = '{$acc->admin_marketer}' LIMIT 0,1");
            if(count($arrAg)>0){
                $agent = $arrAg[0];
            }
        }
//        pr($arr);
        ?>
        <style>
            h1{
                font-size: 25px;
                padding-top: 30px;
            }
            h3{
                font-size: 20px;
                font-style: italic;
            }
            h4{
                font-size: 17px;
                margin-top: 20px;
                margin-bottom: 30px;
            }
            .billings td{
                padding-right: 20px;
                padding-bottom: 10px;
            }
            @media (max-width: 768px) {

                .monly {
                    display: initial;
                }

                .donly {
                    display: none;
                }

                h1{
                    font-size: 20px;
                }
                h3{
                    font-size: 17px;
                    font-style: italic;
                }
                h4{
                    font-size: 14px;
                    margin-bottom: 30px;
                }
                .billings td{
                    padding-bottom: 10px;
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
            @media print {
                .pure-toggle-label[data-toggle-label='left']{
                    display: none;
                }
                #printme{
                    display: none;
                }
                body{
                    background-color: #ffffff;
                }
            }
        </style>
        <div class="container attop"  >
                <div class="col-md-8 col-md-offset-2">


                    <div style="text-align: center; background-color: #ffffff; padding: 20px; min-height: 800px;  margin-top: 20px; padding-top: 20px; padding-bottom: 20px; ">
                        <img src="<?=_SPPATH;?>images/header_appear.jpg" width="100%">

                        <h1>PAYMENT RECEIPT</h1>
                        <h3>Your payment has been completed successfully</h3>
                        <div class="receipt" style=" margin-top: 30px;">
                        <h4>TRANSACTION DETAILS</h4>
                        <table class="billings" align="center" style="text-align: left;">
                            <tr>
                                <td>ORDER ID</td>
                                <td><?=$order_id;?></td>
                            </tr>
                            <tr>
                                <td>PAYMENT DATE / TIME</td>
                                <td><?=date("F j, Y, g:i a",strtotime($order->order_date));?></td>
                            </tr>
                            <tr>
                                <td>PACKAGE NAME</td>
                                <td><?=$paket->paket_name;?></td>
                            </tr>
                            <tr>
                                <td>APP ID</td>
                                <td><?=$app->app_id;?></td>
                            </tr>
                            <tr>
                                <td>ACCOUNT ID</td>
                                <td><?=$acc->admin_nama_depan;?></td>
                            </tr>
                            <tr>
                                <td>AMOUNT</td>
                                <td>IDR <?=idr($paket->paket_price);?></td>
                            </tr>
                            <tr>
                                <td>STATUS</td>
                                <td><?=$data->transaction_status;?></td>
                            </tr>
                            <tr>
                                <td>PAYMENT TYPE</td>
                                <td><?=$data->payment_type;?></td>
                            </tr>
                            <tr>
                                <td>BANK NAME</td>
                                <td><?=$data->bank;?></td>
                            </tr>
                            <?if(count($arrAg)>0){?>
                            <tr>
                                <td>AGENT ID</td>
                                <td><?=$agent->admin_username;?></td>
                            </tr>
                            <?} ?>
                        </table>
                        </div>


                    </div>
                    <div id="printme" style="text-align: right; margin-top: 5px; margin-bottom: 100px;" >
                         <a href="#" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> print</a> |
                        <a href="<?=_SPPATH;?>myOrders">back to my transactions</a>
                    </div>
                </div>
            </div>
        <?
    }
} 