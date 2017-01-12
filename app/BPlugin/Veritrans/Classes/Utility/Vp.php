<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 2/17/16
 * Time: 1:43 PM
 */

class Vp extends WebApps{

//    public static $key_used = "VT-server-3UfrS7tn0EDT99S2B18TnUh_"; //real
    public static $key_used = "VT-server-ngIq9u7Q_-pT_cs6b0-m-Zun"; //sandbox
    public static $isProduction = false;

    var $access_pay = "normal_user";
    var $isProd = false;

    function getKeyUsed(){
        if(Efiwebsetting::getData('veritrans_isProduction') == "yes"){
            $this->isProd = true;
            return Efiwebsetting::getData("veritrans_key_production");

        }else{
            $this->isProd = false;
            return Efiwebsetting::getData("veritrans_key_sandbox");
        }
    }

    function pay(){
        $app_id = addslashes($_GET['app_id']);

        $app = new AppAccount();
        $app->getByID($app_id);

        AppAccount::checkOwnership($app);

        $paket_id = addslashes($_GET['paket']);

        $paket = new Paket();
        $paket->getByID($paket_id);

        global $db;


        //create new order
        $vpt = new VpTransaction();
        $vpt->order_id =  mt_rand().$app->app_id. Account::getMyID();
        $vpt->order_acc_id = Account::getMyID();
        $vpt->order_app_id = $app->app_id;
        $vpt->order_date = leap_mysqldate();
        $vpt->order_paket_id = $paket->paket_id;
        $vpt->order_value = $paket->paket_price;
        $vpt->order_status = 0;
        $vpt->order_status_from = 0;

        //hapus yang blom ada action apa2
        $q = "DELETE FROM {$vpt->table_name} WHERE order_app_id = '{$app->app_id}' AND order_status = '0' AND order_status_from = '0'";
        $db->query($q,0);

        $arrVpt = $vpt->getWhere("order_app_id = '{$app->app_id}' AND order_status = '0' AND order_status_from != '0' ");
        if(count($arrVpt)>0){
            die("Please wait for the payment response");
        }


        if($vpt->save()) {


//        pr($paket);

//        pr($app);


            try {
                // Set our server key
                //live
//            Veritrans_Config::$serverKey = 'VT-server-3UfrS7tn0EDT99S2B18TnUh_';
                //sandbox
                Veritrans_Config::$serverKey = $this->getKeyUsed();
            } catch (Exception $e) {
                echo $e->getMessage();
            }


            if($this->isProd) {
                // Uncomment for production environment
                Veritrans_Config::$isProduction = true;

                // Uncomment to enable sanitization
                Veritrans_Config::$isSanitized = true;

                // Uncomment to enable 3D-Secure
                Veritrans_Config::$is3ds = true;
            }

            $acc = Account::getAccountObject();
            $exp = explode(" ", $acc->admin_nama_depan);

            $billing_address = array(
                'first_name' => $exp[0],
                'last_name' => $exp[1],
                'phone' => $acc->admin_phone,
                'country_code' => 'IDN'
            );


            $customer_details = array(
                'first_name' => $exp[0],
                'last_name' => $exp[1],
                'email' => $acc->admin_email,
                'phone' => $acc->admin_phone,
                'billing_address' => $billing_address
            );

            $item1_details = array(
                'id' => $app->app_id,
                'price' => $paket->paket_price,
                'quantity' => 1,
                'name' =>  $app->app_name." ".$paket->paket_name." 1 year"
            );

            $item_details = array($item1_details);

            $transaction = array(
                'transaction_details' => array(
                    'order_id' => $vpt->order_id,
                    'gross_amount' => $paket->paket_price, // no decimal allowed for creditcard
                ),
                'customer_details' => $customer_details,
                'item_details' => $item_details
            );

            try {
                // Redirect to Veritrans VTWeb page
                header('Location: ' . Veritrans_VtWeb::getRedirectionUrl($transaction));
            } catch (Exception $e) {
                echo $e->getMessage();
                if (strpos($e->getMessage(), "Access denied due to unauthorized")) {
                    echo "<code>";
                    echo "<h4>Please set real server key from sandbox</h4>";
                    echo "In file: " . __FILE__;
                    echo "<br>";
                    echo "<br>";
                    echo htmlspecialchars('Veritrans_Config::$serverKey = \'<your server key>\';');
                    die();
                }

            }
        }else{//if save
            die("Please contact admin");

        }
    }

    //this is a test pay function
    function tp(){
        try {
            // Set our server key
            //live
//            Veritrans_Config::$serverKey = 'VT-server-3UfrS7tn0EDT99S2B18TnUh_';
            //sandbox
            Veritrans_Config::$serverKey = 'VT-server-ngIq9u7Q_-pT_cs6b0-m-Zun';
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

         // Uncomment for production environment
//        Veritrans_Config::$isProduction = true;

        // Uncomment to enable sanitization
//         Veritrans_Config::$isSanitized = true;

        // Uncomment to enable 3D-Secure
//         Veritrans_Config::$is3ds = true;

        // Fill transaction data
        $transaction = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000, // no decimal allowed for creditcard
            )
        );

//        $vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);

// Redirect
        try {
            // Redirect to Veritrans VTWeb page
            header('Location: ' . Veritrans_VtWeb::getRedirectionUrl($transaction));
        }
        catch (Exception $e) {
            echo $e->getMessage();
            if(strpos ($e->getMessage(), "Access denied due to unauthorized")){
                echo "<code>";
                echo "<h4>Please set real server key from sandbox</h4>";
                echo "In file: " . __FILE__;
                echo "<br>";
                echo "<br>";
                echo htmlspecialchars('Veritrans_Config::$serverKey = \'<your server key>\';');
                die();
            }

        }

    }
    function testpay(){



        echo 1;
        // Set our server key
        Veritrans_Config::$serverKey = VeritransPay::$serverKeyReal;
        echo 2;
        // Uncomment for production environment
//        Veritrans_Config::$isProduction = true;

        // Uncomment to enable sanitization
//        Veritrans_Config::$isSanitized = true;

        // Uncomment to enable 3D-Secure
//        Veritrans_Config::$is3ds = true;
        echo 3;
// Fill transaction data
        $transaction = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000, // no decimal allowed for creditcard
            )
        );
        echo 4;
        $vtweb_url = Veritrans_Vtweb::getRedirectionUrl($transaction);
        pr($vtweb_url);
//        echo $vtweb_url.5;
        // Redirect
        header('Location: ' . $vtweb_url);
        die();

    }


    function success(){

        $order_id = addslashes($_GET['order_id']);
        $status_code = addslashes($_GET['status_code']);
        $transaction_status = addslashes($_GET['transaction_status']);

        $vpt = new VpTransaction();
        $vpt->getByID($order_id);

        $app = new AppAccount();
        $app->getByID($vpt->order_app_id);


        AppAccount::checkOwnership($app);

        $vpt->order_status_from = $status_code;
        $vpt->save();
        ?>
        <div class="container attop"  >
        <div class="col-md-8 col-md-offset-2">

        <div style="text-align: center; padding: 20px;">
            <a href="<?=_SPPATH;?>">
                <img src="<?=_SPPATH;?>images/appear-icontext.png" style="max-width: 300px;">
            </a>
        </div>
        <?
//    ini success    success?order_id=88168&status_code=200&transaction_status=capture
//order_id=652125822&status_code=201&transaction_status=capture  ini challenge kayaknya...coba cek status 201 means
//        pr($_POST);
//        pr($_GET);

        if($status_code == "200") {
            ?>

            <h1>Success</h1>
            <p>Your App will be processed immediately</p>
            <p>Android App will take up to 2 working days</p>
            <p>
                iOS App will take up to 3 weeks.
            </p>
            <a class="btn btn-default" href="<?=_SPPATH;?>PaymentWeb/receipt?order_id=<?=$order_id;?>">Receipt</a>
            <a class="btn btn-default" href="<?=_SPPATH;?>myApps">back to my Apps</a>
        <?
        }
        if($status_code == "201") {
            ?>

            <h1>Your payment status is challenged</h1>
            <p>Please wait up to 2 working days for the transaction to be verified</p>
            <? /*<p>Credit card transaction is marked as suspicious transaction by Veritrans Fraud Detection System.
                Merchant has to manually Accept or Deny the transaction through Veritrans Dashboard.</p>
            <p>Android App will take up to 2 working days</p>
            <p>
                iOS App will take up to 3 weeks.
            </p>
            <a class="btn btn-default" href="<?=_SPPATH;?>vp/receipt?order_id=<?=$order_id;?>">Receipt</a>
            <a class="btn btn-default" href="<?=_SPPATH;?>myApps">back to my Apps</a>
         */
        }
        ?>
        </div>
        </div>
    <?

    }

    function failed(){
        $order_id = addslashes($_GET['order_id']);
        $status_code = addslashes($_GET['status_code']);
        $transaction_status = addslashes($_GET['transaction_status']);

        $vpt = new VpTransaction();
        $vpt->getByID($order_id);

        $app = new AppAccount();
        $app->getByID($vpt->order_app_id);


        AppAccount::checkOwnership($app);

        $vpt->order_status_from = $status_code;
        $vpt->save();
        ?>
        <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">

                <div style="text-align: center; padding: 20px;">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-icontext.png" style="max-width: 300px;">
                    </a>
                </div>
                <?

                    ?>

                    <h1>Failed</h1>
                    <p>Your Payment Failed</p>

                    <p>
                        Please <a href="<?=_SPPATH;?>contact">contact us</a> for more details.
                    </p>

                    <a class="btn btn-default" href="<?=_SPPATH;?>myApps">back to my Apps</a>
                <?

                ?>
            </div>
        </div>
    <?
    }

    function handling(){

        echo 1;
        if($this->isProd) {
            Veritrans_Config::$isProduction = true;
        }
        echo 3;
        Veritrans_Config::$serverKey = $this->getKeyUsed();
        echo 4;

        $raw_notification = "";

        try {
            $notif = new Veritrans_Notification();

            $input_source = "php://input";
            $raw_notification = file_get_contents($input_source);
        }
        catch(Exception $e) {
            echo "<h2>".$e->getMessage()."</h2>";
        }

        echo "<h1>jahahaa</h1>";

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $vpt = new VpTransaction();
        $vpt->getByID($order_id);

        //dataemail
        $dataemail = new DataEmail();

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card'){
                if($fraud == 'challenge'){
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id ." is challenged by FDS";
                    $vpt->order_message = "Transaction order_id: " . $order_id ." is challenged by FDS";
                    $vpt->order_status = 3;
                    $vpt->save();

                    //notify User
                    $app = new AppAccount();
                    $app->getByID($vpt->order_app_id);

                    $acc = new Account();
                    $acc->getByID($app->app_client_id);
                    $dataemail->appPaymentMode($acc->admin_email,$acc->admin_username,$app->app_name,$fraud);
                }
                else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;

                    $vpt->order_message = "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                    $vpt->order_status = 2;
                    $vpt->save();

                    //notify User
                    //update active di app
                    $app = new AppAccount();
                    $app->getByID($vpt->order_app_id);
                    $app->app_contract_start = date("Y-m-d");
                    $app->app_contract_end = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
                    $app->app_active = 1;
                    $app->app_paket_id = $vpt->order_paket_id;
                    $app->save();

                    //notify Admins kalau ada app active

                    $dataemail->appBisaDibuat($app->app_name,$app->app_id,$transaction);

                    //notify User
                    $acc = new Account();
                    $acc->getByID($app->app_client_id);
                    $dataemail->appPaymentSuccess($acc->admin_email,$acc->admin_username,$app->app_name);

                    //hitung komisi
                    //ini belum bener
                    //TODO 31 maret 2016
                    KomisiModel::log($app,$vpt);

                    //email dapat komisi
                }
            }
        }
        else if ($transaction == 'settlement'){
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;

            $oldstatus = $vpt->order_status;

            $vpt->order_message = "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
            $vpt->order_status = 1;
            $vpt->save();

            if($oldstatus != 2) {
                //update active di app
                $app = new AppAccount();
                $app->getByID($vpt->order_app_id);
                $app->app_contract_start = date("Y-m-d");
                $app->app_contract_end = date('Y-m-d', strtotime(date("Y-m-d", mktime()) . " + 365 day"));
                $app->app_active = 1;

                $app->app_paket_id = $vpt->order_paket_id;
                $app->save();

                //notify Admins kalau ada app active

                $dataemail->appBisaDibuat($app->app_name, $app->app_id, $transaction);

                //notify User
                $acc = new Account();
                $acc->getByID($app->app_client_id);
                $dataemail->appPaymentSettle($acc->admin_email, $acc->admin_username, $app->app_name);

                //hitung komisi
                //TODO 31 maret 2016
                KomisiModel::log($app,$vpt);

                //email dpt komisi
            }

        }
        else if($transaction == 'pending'){
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;

            $vpt->order_message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $vpt->order_status = 4;
            $vpt->save();

            //notify User
            $app = new AppAccount();
            $app->getByID($vpt->order_app_id);

            $acc = new Account();
            $acc->getByID($app->app_client_id);
            $dataemail->appPaymentMode($acc->admin_email,$acc->admin_username,$app->app_name,$transaction);
        }
        else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";

            $vpt->order_message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $vpt->order_status = 5;
            $vpt->save();

            //notify User
            $app = new AppAccount();
            $app->getByID($vpt->order_app_id);

            $acc = new Account();
            $acc->getByID($app->app_client_id);
            $dataemail->appPaymentMode($acc->admin_email,$acc->admin_username,$app->app_name,"denied");
        }
        else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";

            $vpt->order_message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
            $vpt->order_status = 6;
            $vpt->save();

            //notify User
            $app = new AppAccount();
            $app->getByID($vpt->order_app_id);

            $acc = new Account();
            $acc->getByID($app->app_client_id);
            $dataemail->appPaymentMode($acc->admin_email,$acc->admin_username,$app->app_name,"canceled");
        }


        $vp = new VpData();
        $vp->vp_date = leap_mysqldate();
        $vp->vp_obj = serialize($notif)." ||| ".$raw_notification;
        $vp->approval_code = $notif->approval_code;
        $vp->order_id = $notif->order_id;
        $vp->status_code = $notif->status_code;
        $vp->transaction_status = $notif->transaction_status;
        $vp->status_message = $notif->status_message;
        $vp->transaction_id = $notif->transaction_id;
        $vp->masked_card = $notif->masked_card;
        $vp->gross_amount = $notif->gross_amount;
        $vp->payment_type = $notif->payment_type;
        $vp->transaction_time = $notif->transaction_time;
        $vp->fraud_status = $notif->fraud_status;
        $vp->approval_code = $notif->approval_code;
        $vp->signature_key = $notif->signature_key;
        $vp->bank = $notif->bank;
        $vp->eci = $notif->eci;
        $vp->save();

        pr($notif);

        /*
         * Veritrans_Notification Object
(
    [response:Veritrans_Notification:private] => stdClass Object
        (
            [status_code] => 200
            [status_message] => Success, transaction found
            [transaction_id] => a293ec21-9572-4333-9a41-640a6789b713
            [masked_card] => 518323-9790
            [order_id] => 1084599542
            [gross_amount] => 10000.00
            [payment_type] => credit_card
            [transaction_time] => 2016-02-17 15:20:37
            [transaction_status] => capture
            [fraud_status] => accept
            [approval_code] => T08489
            [signature_key] => 12a2c1d52cdd03326727b1ee0cc8a9f658146dbaedac46490f269183291885772e5a31a121c94ebde9f501733c8e7802cf74c3bb839ad687188456c3bf0d45e0
            [bank] => bni
            [eci] => 02
        )

)

         */

        die();

    }

    function error(){
        $order_id = addslashes($_GET['order_id']);
        $status_code = addslashes($_GET['status_code']);
        $transaction_status = addslashes($_GET['transaction_status']);

        $vpt = new VpTransaction();
        $vpt->getByID($order_id);

        $app = new AppAccount();
        $app->getByID($vpt->order_app_id);


        AppAccount::checkOwnership($app);

        $vpt->order_status_from = $status_code;
        $vpt->save();
        ?>
        <div class="container attop"  >
            <div class="col-md-8 col-md-offset-2">

                <div style="text-align: center; padding: 20px;">
                    <a href="<?=_SPPATH;?>">
                        <img src="<?=_SPPATH;?>images/appear-icontext.png" style="max-width: 300px;">
                    </a>
                </div>
                <?

                ?>

                <h1>Error</h1>
                <p>Your Payment Error</p>

                <p>
                    Please <a href="<?=_SPPATH;?>contact">contact us</a> for more details.
                </p>

                <a class="btn btn-default" href="<?=_SPPATH;?>myApps">back to my Apps</a>
                <?

                ?>
            </div>
        </div>
        <?
        /*
         * Array
(
    [url] => vp/error
    [order_id] => 70872981
    [status_code] => 202
    [transaction_status] => deny
)
         */

    }


} 