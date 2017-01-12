<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 12/22/15
 * Time: 9:52 AM
 */

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
// SDK Configuration
function getApiContext() {


    // Define the location of the sdk_config.ini file
    if (!defined("PP_CONFIG_PATH")) {
        define("PP_CONFIG_PATH", dirname(__DIR__));
    }

    $apiContext = new ApiContext(new OAuthTokenCredential(
        'Ae4Ei9j6g7qmmgReoXO89gyCDLYi2iH7pab4iRCHKdm3Nebt40M1HDwQd2CkqWJ1n1tzfyRt-2FqNZjR',
        'EBR92U28yCFHj-wShMDWHg7jXenRrWyZof5x6_4jhL9oeEOoCs3UUy6rSA3ED_Dwq6o-kphJmtHEUmM-'
    ));


    // Alternatively pass in the configuration via a hashmap.
    // The hashmap can contain any key that is allowed in
    // sdk_config.ini
    /*
    $apiContext->setConfig(array(
        'http.ConnectionTimeOut' => 30,
        'http.Retry' => 1,
        'mode' => 'sandbox',
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'INFO'
    ));
    */
    return $apiContext;
}