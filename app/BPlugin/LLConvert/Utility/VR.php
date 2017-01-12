<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VR
 *
 * @author Elroy Hardoyo<elroy.hardoyo@leap-systems.com>
 */
class VR {
    
    public static function run($url,$xml,$json = 1){

//        $url = 'http://123.231.241.42:8280/'.$url;
        //$url = 'http://123.231.241.42:8281/PROD/'.$url;
// IP lokal production
        //$url = 'http://192.168.0.35:8280/PROD/'.$url;
        // IP international production
//        $url = 'http://123.231.241.42:8281/PROD/'.$url;

        //$url = 'https://tbs.webservices.visibleresults.net/LLWebService/'.$url;
        $url = Efiwebsetting::getData('LL_URL').$url;


        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, "$xml" );
        $result = curl_exec($ch);

        // Check for errors and display the error message
        if($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
//            echo "cURL error ({$errno}):\n {$error_message}";
            $json['status_code'] = 0;
            $json['status_message'] = Efiwebsetting::getData('Constant_ll_failed');
            echo json_encode($json);
            die();
        }

        curl_close($ch);
        
        if($json == 1)
            return Request::toJson($result, 0);
        elseif($json == 2)
            return simplexml_load_string($result);
        elseif($json == 3)
        {
            $xmlDoc = new DOMDocument();
            $xmlDoc->load($result);
            return $xmlDoc;
        }
        else {
            return $result;
        }
    }

    
}
