<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/20/16
 * Time: 10:59 AM
 */

class Dokuform extends WebApps{

     const  storeID = "00165465";
     const  shareKey = "t6s8f9Y5Z7b8";

    function buy(){
        $amount = "75000.00";
        $tranID = time();

        $key =  $amount . self::shareKey . $tranID;
        echo $key."<br>";
        $sha1 =  sha1($key);
        echo $sha1;

        //https://apps.myshortcart.com/payment/request-payment/
        ?>
        <FORM NAME="order" METHOD="Post" ACTION="https://apps.myshortcart.com/payment/request-payment/" >
            <input type=hidden name="BASKET" value="Gold,70000.00,1,70000.00;Administration fee,5000.00,1,5000.00">
            <input type=hidden name="STOREID" value="<?=self::storeID;?>">
            <input type=hidden name="TRANSIDMERCHANT" value="<?=$tranID;?>">
            <input type=hidden name="AMOUNT" value="<?=$amount;?>">
            <input type=hidden name="URL" value="http://www.appear.tech/ ">
            <input type=hidden name="WORDS" value="<?=$sha1;?>">
            <input type=hidden name="CNAME" value="Ismail Danuarta">
            <input type=hidden name="CEMAIL" value="efindi.ongso@gmail.com">
            <input type=hidden name="CWPHONE" value="0210000011">
            <input type=hidden name="CHPHONE" value="0210980901">
            <input type=hidden name="CMPHONE" value="081298098090">
            <input type=hidden name="CCAPHONE" value="02109808009">
            <input type=hidden name="CADDRESS" value="Jl. Jendral Sudirman Plaza Asia Office Park Unit 3">
            <input type=hidden name="CZIPCODE" value="12345">
            <input type=hidden name="SADDRESS" value="Pengadegan Barat V no 17F">
            <input type=hidden name="SZIPCODE" value="12217">
            <input type=hidden name="SCITY" value="JAKARTA">
            <input type=hidden name="SSTATE" value="DKI">
            <input type=hidden name="SCOUNTRY" value="784">
            <input type=hidden name="BIRTHDATE" value="1988-06-16">
            <input type="submit">
        </FORM>

        <?
    }

    function post(){
        $amount = "75000.00";
        $tranID = "000001";

        $key =  $amount . self::shareKey . $tranID;
        echo $key."<br>";
        $sha1 =  sha1($key);
        echo $sha1;

        //extract data from the post
//set POST variables
        $url = 'https://apps.myshortcart.com/payment/request-payment/';
        $fields = array(
            'BASKET' => "Gold,70000.00,1,70000.00;Administration fee,5000.00,1,5000.00",
            'STOREID' => self::storeID,
            'TRANSIDMERCHANT' => $tranID,
            'AMOUNT' => $amount,
            'URL' => "http://www.appear.tech/",
            'WORDS' => $sha1,
            'CNAME' => "Sendy",
            'CEMAIL' => "elroy.hardoyo@gmail.com",
            'CWPHONE' => "02122210269",
            'CHPHONE' => "02122210269",
            'CMPHONE' => "081915311981"


        );

//url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

//open connection
        $ch = curl_init();

//set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
        $result = curl_exec($ch);

//close connection
        curl_close($ch);

        pr($result);
    }
} 