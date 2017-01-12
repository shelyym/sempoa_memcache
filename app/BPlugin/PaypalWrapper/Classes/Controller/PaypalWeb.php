<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/15
 * Time: 10:01 AM
 */

class PaypalWeb extends WebService{

    var $access_addCard = "normal_user";
    function addCard(){
//        echo "in";
//        pr($_POST);

        try {
            $creditCardId = NULL;
            // If CVV2 is not required, we need to remove it. We cannot keep it empty or '' as it is considered your CVV2 is set to ''
            if (isset($_POST['user']['credit_card']['cvv2']) && trim($_POST['user']['credit_card']['cvv2']) == '') {
                unset($_POST['user']['credit_card']['cvv2']);
            }
            // User can configure credit card info later from the
            // profile page or can use paypal as his funding source.
            if(trim($_POST['user']['credit_card']['number']) != "") {
                $paypal = new PaypalWrap();
                $creditCardId = $paypal->saveCard($_POST['user']['credit_card']);
            }
            $acc = new Account();
            $acc->getByID(Account::getMyID());
            $acc->admin_creditcardID = $creditCardId;
            $acc->load = 1;
            $acc->save();
//            $userId = addUser($_POST['user']['email'], $_POST['user']['password'], $creditCardId);
        } catch(\PayPal\Exception\PPConnectionException $ex){
            $errorMessage = $ex->getData() != '' ? parseApiError($ex->getData()) : $ex->getMessage();
        } catch (Exception $ex) {
            $errorMessage = $ex->getMessage();
        }
//        echo $errorMessage;
        $json['err'] = $_POST;
        $json['cc'] = $creditCardId;
        echo json_encode($json);
        die();
    }

    function confirm(){

    }

    var $access_daftarkanCC = "normal_user";
    function daftarkanCC(){
        $creditCardId = NULL;

        try {

            // If CVV2 is not required, we need to remove it. We cannot keep it empty or '' as it is considered your CVV2 is set to ''
            if (isset($_POST['user']['credit_card']['cvv2']) && trim($_POST['user']['credit_card']['cvv2']) == '') {
                unset($_POST['user']['credit_card']['cvv2']);
            }
            // User can configure credit card info later from the
            // profile page or can use paypal as his funding source.
            if(trim($_POST['user']['credit_card']['number']) != "") {
                $paypal = new PaypalWrap();
                $creditCardId = $paypal->saveCard($_POST['user']['credit_card']);

                $acc = new Account();
                $acc->getByID(Account::getMyID());
                $acc->admin_creditcardID = $creditCardId;
                $acc->load = 1;
                $acc->save();
            }

//            $userId = addUser($_POST['user']['email'], $_POST['user']['password'], $creditCardId);
        } catch(\PayPal\Exception\PPConnectionException $ex){
            $errorMessage = $ex->getData() != '' ? parseApiError($ex->getData()) : $ex->getMessage();
        } catch (Exception $ex) {
            $errorMessage = $ex->getMessage();
        }
        return $creditCardId;
    }

    var $access_placeOrder = "normal_user";

    function placeOrder(){
        //sementara semua credit card
        //$order = $_REQUEST['order'];
        //$order['payment_method'] == 'credit_card';
        $json['paystate'] = 0;

        //langkah pertama daftarkan cc
        $creditCardId = $this->daftarkanCC();
        $currency = 'USD';
        $amount = addslashes($_POST['appprice']);
        $descr = addslashes($_POST['appdescr']);
        $app_id = addslashes($_POST['appid']);

        if($creditCardId!= NULL){
            try {


                $paypal = new PaypalWrap();
                $payment = $paypal->makePaymentUsingCC($creditCardId,$amount , $currency, $descr);
//                pr($payment);

                $order = new PaypalOrder();
                $order->amount = $amount;
                $order->created_time = leap_mysqldate();
                $order->currency = $currency;
                $order->description = $descr;
                $order->user_id = Account::getMyID();
                $order->payment_id = $payment->getId();
                $order->state = $payment->getState();
                $orderId = $order->save();


                $state = $order->state;
                if($state == "approved"){
                    $json['paystate'] = 1;

                    //update paket active
                    $app = new AppAccount();
                    $app->getByID($app_id);
                    $app->app_active = 1;
                    $app->app_contract_start = leap_mysqldate();
                    $app->app_pulsa = 1000;
                    $app->app_contract_end = date('Y-m-d', strtotime('+1 year'));
                    $app->load = 1;
                    $app->save();
                }

                $message = "Your order has been placed successfully. Your Order id is <b>$orderId</b>";
                $messageType = 1;

            } catch (\PayPal\Exception\PPConnectionException $ex) {
                $message = parseApiError($ex->getData());
                $messageType = 0;
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $messageType = 0;
            }

        }else{
            $messageType = 0;
            $message = "credit card ID registration error";
        }

        $json['bool'] = $messageType;
        $json['err'] = $message;
        echo json_encode($json);
        die();


//        if($_SERVER['REQUEST_METHOD'] == 'POST') {
//
//            try {
//                if($order['payment_method'] == 'credit_card') {
//
//                    // Make a payment using credit card.
//                    $user = getUser(getSignedInUser());
//                    $payment = makePaymentUsingCC($user['creditcard_id'], $order['amount'], 'USD', $order['description']);
//                    $orderId = addOrder(getSignedInUser(), $payment->getId(), $payment->getState(),
//                        $order['amount'], $order['description']);
//                    $message = "Your order has been placed successfully. Your Order id is <b>$orderId</b>";
//                    $messageType = "success";
//
//                } else if($order['payment_method'] == 'paypal') {
//
//                    $orderId = addOrder(getSignedInUser(), NULL, NULL, $order['amount'], $order['description']);
//                    // Create the payment and redirect buyer to paypal for payment approval.
//                    $baseUrl = getBaseUrl() . "/order_completion.php?orderId=$orderId";
//                    $payment = makePaymentUsingPayPal($order['amount'], 'USD', $order['description'],
//                        "$baseUrl&success=true", "$baseUrl&success=false");
//                    updateOrder($orderId, $payment->getState(), $payment->getId());
//                    header("Location: " . getLink($payment->getLinks(), "approval_url") );
//                    exit;
//                }
//            } catch (\PayPal\Exception\PPConnectionException $ex) {
//                $message = parseApiError($ex->getData());
//                $messageType = "error";
//            } catch (Exception $ex) {
//                $message = $ex->getMessage();
//                $messageType = "error";
//            }
//        }

    }
} 