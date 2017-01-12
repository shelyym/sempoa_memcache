<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 7/4/16
 * Time: 10:13 AM
 */

class AppContentHelper {

    public static function checkApp($app_id,$acc_id){

        if($app_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }

        if($acc_id==""){
            $json['status_code'] = 0;
            $json['status_message'] = "No value for ID";
            echo json_encode($json);
            die();
        }
        $pp = new AppAccount();
        $pp->getByID($app_id);

        if($pp->app_client_id != $acc_id){
            $json['status_code'] = 0;
            $json['status_message'] = "Mismatched";
            echo json_encode($json);
            die();
        }

        return $pp;
    }

    public static function checkPush($app_id,$acc_id,$camp_id){

    }

    public static function createJSON($app_id,$json){


        $fp = fopen(_PHOTOPATH.'json/'.$app_id.'.json', 'w');
        $status = fwrite($fp, json_encode($json));
        fclose($fp);

        return $status;

    }

    public static function loadJSON($app_id){
        $jsonstr = file_get_contents(_PHOTOPATH.'json/'.$app_id.'.json');
        return json_decode($jsonstr);
    }

    public static function doCURLPost($url,$fields){

        //extract data from the post
//set POST variables
//        $url = 'http://domain.com/get-post.php';
//        $fields = array(
//            'lname' => urlencode($_POST['last_name']),
//            'fname' => urlencode($_POST['first_name']),
//            'title' => urlencode($_POST['title']),
//            'company' => urlencode($_POST['institution']),
//            'age' => urlencode($_POST['age']),
//            'email' => urlencode($_POST['email']),
//            'phone' => urlencode($_POST['phone'])
//        );

        $fields_string = "";
//url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

//open connection
        $ch = curl_init();

//set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//execute post
        $result = curl_exec($ch);

//close connection
        curl_close($ch);

        return $result;
    }
} 