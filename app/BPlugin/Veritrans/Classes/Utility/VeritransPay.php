<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/28/15
 * Time: 11:06 AM
 */

class VeritransPay extends WebService{

    static $serverKey = "VT-server-ngIq9u7Q_-pT_cs6b0-m-Zun";
    public static $serverKeyReal = "VT-server-3UfrS7tn0EDT99S2B18TnUh_";






    function pay(){

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

        $dibayarkan = $paket->paket_price*12;


        //veritrans config
        Veritrans_Config::$serverKey = self::$serverKey;

        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => $dibayarkan, // no decimal allowed for creditcard
        );

        $item1_details = array(
            'id' => $app->app_id,
            'price' => $dibayarkan,
            'quantity' => 1,
            'name' => "Payment for ".$app->app_name
        );

        $item_details = array ($item1_details);

        $ac = Account::getAccountObject();
        $exp = explode(" ",Account::getMyName());
        $lastname = array_pop($exp);

        $billing_address = array(
            'first_name'    => implode(" ",$exp),
            'last_name'     => $lastname,
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );


        $customer_details = array(
            'first_name'    => implode(" ",$exp),
            'last_name'     => $lastname,
            'email'         => $ac->admin_email,
            'phone'         => "081122334455",
            'billing_address'  => $billing_address
        );

        $transaction = array(
//            "vtweb" => array (
//                "enabled_payments" => array("credit_card"),
//                "credit_card_3d_secure" => true,
//            ),
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

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

    function checkout(){

        Veritrans_Config::$serverKey = self::$serverKey;

        echo "haha";

        // Uncomment for production environment
// Veritrans_Config::$isProduction = true;

// Uncomment to enable sanitization
// Veritrans_Config::$isSanitized = true;

// Uncomment to enable 3D-Secure
// Veritrans_Config::$is3ds = true;

// Required
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 1545000, // no decimal allowed for creditcard
        );

// Optional
        $item1_details = array(
            'id' => 'kb1',
            'price' => 1500000,
            'quantity' => 1,
            'name' => "Apple"
        );

// Optional
        $item2_details = array(
            'id' => 'a2',
            'price' => 45000,
            'quantity' => 1,
            'name' => "Orange"
        );

// Optional
        $item_details = array ($item1_details, $item2_details);

// Optional
        $billing_address = array(
            'first_name'    => "Efindi",
            'last_name'     => "Litani",
            'address'       => "Mangga 20",
            'city'          => "Jakarta",
            'postal_code'   => "16602",
            'phone'         => "081122334455",
            'country_code'  => 'IDN'
        );

// Optional
        $shipping_address = array(
            'first_name'    => "Obet",
            'last_name'     => "Supriadi",
            'address'       => "Manggis 90",
            'city'          => "Jakarta",
            'postal_code'   => "16601",
            'phone'         => "08113366345",
            'country_code'  => 'IDN'
        );

// Optional
        $customer_details = array(
            'first_name'    => "Andri",
            'last_name'     => "Litani",
            'email'         => "andri@litani.com",
            'phone'         => "081122334455",
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

// Fill transaction details
        $transaction = array(
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        );

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

        echo "hihi";

    }
} 