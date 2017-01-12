<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 4/20/16
 * Time: 10:48 AM
 */

class Dokuweb extends WebService{

    /*
     * Prepare application for responding to MYSHORTCART V e r i f y Process.
     *  Eg: http://www.yourwebsite.com/verify.php?STOREID=0015DTVA&TRANSIDMERCHANT=000001&AMOUNT=300000& WORDS= febc0f139e58fa8b7ca7c04c9ddc22f0aed92e6d Make sure TRANSIDMERCHANT
     * (also same as Invoice No or Order Number) is really generated from merchant, and also the amount of transaction. If match, just echo/print “Continue”. If not, “Stop”.
3. Prepare application for responding to MYSHORTCART N o t i f y Process. Eg: http://www.yourwebsite.com/notify.php?TRANSIDMERCHANT=000001&RESULT=Success&AMOUNT=300000. Do
4. PrepareapplicationforrespondingtoMYSHORTCART R e d i r e c t Process.Eg: http://www.yourwebsite.com/redirect.php?TRANSIDMERCHANT=000001&STATUS_CODE=00&TRANSDATE=2012- 06- 16&PTYPE=Creditcard&AMOUNT=120000&RESULT=Success&EXTRAINFO=xlk01
5. Prepare an URL to handle C a n c e l Process. This URL will be called if Cancel Button on Payment page are executed. And it will redirected back to Merchant’s site.
     */
    function verify(){


        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

        $txt = "Verify Called On ".date("Y-m-d h:i:s")."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_GET)."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_POST)."\n\n";
        fwrite($myfile, $txt);

        fclose($myfile);

        //cek di database apakah transID dan amount dan key sesuai

        echo "Continue"; //atau Stop kalau gagal lihat tutorial hal 13

    }

    function notify(){
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

        $txt = "Notify Called On ".date("Y-m-d h:i:s")."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_GET)."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_POST)."\n\n";
        fwrite($myfile, $txt);

        fclose($myfile);

        echo "Continue"; //OR Stop
    }

    function redirect(){
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

        $txt = "Redirect Called On ".date("Y-m-d h:i:s")."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_GET)."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_POST)."\n\n";
        fwrite($myfile, $txt);

        fclose($myfile);


    }

    function cancel(){
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

        $txt = "Cancel Called On ".date("Y-m-d h:i:s")."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_GET)."\n";
        fwrite($myfile, $txt);

        $txt = serialize($_POST)."\n\n";
        fwrite($myfile, $txt);

        fclose($myfile);
    }
} 