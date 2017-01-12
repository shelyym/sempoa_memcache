<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/22/16
 * Time: 4:17 PM
 */

class DataEmail {

    function registrationSuccessWithOutVerify($email,$uname){


        $emailModel = new EmailModel();
        $emailModel->getByID("registrationSuccessWithOutVerify");

//        pr($emailModel);
        return $emailModel->sendEmail($email,array("uname"=>$uname,"email"=>$email));

        /*
        $judul = "It's Official: You're On The Appear Team";

        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH.'images/registration.png" alt="Appear Registration" />
            <h1>Thank you for registering with us.</h1>
            <h2>OUR MISSION IS CLEAR: APPEAR IS THE APP FOR YOUR BUSINESS.</h2>
            <p>Here are your registration credentials:</p>
        </td>
    </tr>
    <tr>
        <td>';

        $message .= '<table rules="all" width="100%" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Username:</strong> </td><td>" . strip_tags($uname) . "</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
        $message .= "</table>";

        $message .= '</td>
    </tr>
</table>';


        $message .= "</body></html>";


        $isi = "Thank you for registering with us.\nOUR MISSION IS CLEAR: APPEAR IS THE APP FOR YOUR BUSINESS.\nHere are your registration credentials:
Username : $uname
Email : $email
";

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($email,$judul,$isi,$message);

        return $hasil->success();

//        $hasil->success() && var_dump($hasil->getData());
        //array(1) { ["Sent"]=> array(1) { [0]=> array(2) { ["Email"]=> string(23) "elroy.hardoyo@gmail.com" ["MessageID"]=> int(18858860444541457) } } }
        */
    }


    function registrationSuccessWithVerify($email,$uname,$hash){

        $emailModel = new EmailModel();
        $emailModel->getByID("registrationSuccessWithVerify");

        return $emailModel->sendEmail($email,array("link"=>"<a href='" . _BPATH . "verify?mid={$uname}&token={$hash}'>Verify My Account Now</a>"));

        /*
        $judul = "It's Official: You're On The Appear Team";
        $isi = "<h1>Thank you for registering with us!!</h1>
                <br>
                <a href='" . _BPATH . "verify?mid={$uname}&token={$hash}'>Verify My Account Now</a> <br>
                or open this link " . _BPATH . "verify?mid={$uname}&token={$hash}
                ";

        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH.'images/registration.png" alt="Appear Registration" />
            <h1>Thank you for registering with us.</h1>
            <h2>OUR MISSION IS CLEAR: APPEAR IS THE APP FOR YOUR BUSINESS.</h2>
            <p>Please verify to maximize your Appear Experience</p>
            <h1><a href="'. _BPATH . 'verify?mid='.$uname.'&token='.$hash.'">Verify My Account Now</a></h1>
        </td>
    </tr>
</table>';


        $message .= "</body></html>";

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($email,$judul,$isi,$message);

        return $hasil->success();*/
    }


    function registrationSuccessToMarketer($email,$uname,$marketer_username){

        $emailModel = new EmailModel();
        $emailModel->getByID("registrationSuccessToMarketer");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"email"=>$email,"marketer"=>$marketer_username));



    }

    function appBisaDibuat($app_id,$app_name,$mode){

        $email = Efiwebsetting::getData("DeveloperNotificationEmail");

        $emailModel = new EmailModel();
        $emailModel->getByID("appBisaDibuat");

        return $emailModel->sendEmail($email,array("app_id"=>$app_id,"app_name"=>$app_name,"mode"=>$mode));



    }

    function appPaymentSuccess($email,$uname,$app_name){


        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentSuccess");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }
    function freeAppAccepted($email,$uname,$app_name){


        $emailModel = new EmailModel();
        $emailModel->getByID("freeAppAccepted");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }

    function agentAccepted($email,$uname){


        $emailModel = new EmailModel();
        $emailModel->getByID("agentAccepted");

        return $emailModel->sendEmail($email,array("uname"=>$uname));


    }
    function agentRejected($email,$uname){


        $emailModel = new EmailModel();
        $emailModel->getByID("agentRejected");

        return $emailModel->sendEmail($email,array("uname"=>$uname));


    }

    function forgotPassword($email,$uname,$link){


        $emailModel = new EmailModel();
        $emailModel->getByID("forgotPassword");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"link"=>$link));


    }

    function appPaymentSettle($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentSettle");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }

    function appPaymentCancel($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentCancel");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }

    function freeRequestRejected($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("freeRequestRejected");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }
    function freeRequestRejectedAgent($email,$uname,$app_name,$agent_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("freeRequestRejectedAgent");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name,"agent"=>$agent_name));


    }

    function appPaymentFailure($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentFailure");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }
    function appPaymentChallenged($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentChallenged");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }
    function appPaymentPending($email,$uname,$app_name){



        $emailModel = new EmailModel();
        $emailModel->getByID("appPaymentPending");

        return $emailModel->sendEmail($email,array("uname"=>$uname,"app_name"=>$app_name));


    }

    function appPaymentMode($email,$uname,$app_name,$mode){



        $judul = "Your Payment for $app_name was $mode";

        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH.'images/registration.png" alt="Appear Registration" />
            <h1>We are sorry .</h1>
            <h2>We will process your App immediately.</h2>
            <p>Your Android App will be ready in 2 working days.</p>
            <p>If your Order includes an iOS App, the iOS App will be ready in 3 weeks.</p>
        </td>
    </tr>

</table>';


        $message .= "</body></html>";


        $isi = "Thank you for your payment.\nWe will process your App immediately
        Your Android App will be ready in 2 working days.
        If your Order includes an iOS App, the iOS App will be ready in 3 weeks.
";

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($email,$judul,$isi,$message);

        return $hasil->success();

//        $hasil->success() && var_dump($hasil->getData());
        //array(1) { ["Sent"]=> array(1) { [0]=> array(2) { ["Email"]=> string(23) "elroy.hardoyo@gmail.com" ["MessageID"]=> int(18858860444541457) } } }
    }

    function dapatKomisi($email,$commision_value,$isPending,$client_username,$isAgent){



        $text = '';
        if(!$isAgent){
            $text = "Please complete your Agent registration <a href='"._BPATH."marketer'>here</a>.";
        }
        $pendingText = '';
        if($isPending){
            $pendingText = "To complete the pair, please deal paid Apps";
        }

        $emailModel = new EmailModel();
        $emailModel->getByID("dapatKomisi");

        return $emailModel->sendEmail($email,array("commision_value"=>$commision_value,"is_Agent"=>$text,"is_Pending_Free"=>$pendingText,"link_more_sales"=>_BPATH."link_more_sales"));

        /*
        $judul = "You've earned IDR ".idr($commision_value)." Commisions!!";

        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH.'images/registration.png" alt="Appear Registration" />
            <h1>Congratulations !! You\'ve earned IDR '.idr($commision_value).'</h1>
            <h2>'.$text.'</h2>
            <h3>'.$pendingText.'</h3>
            <p>To increase your sales read here</p>
        </td>
    </tr>

</table>';


        $message .= "</body></html>";


        $isi = "Congratulations !! You've earned IDR ".idr($commision_value)." $text $pendingText
";

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($email,$judul,$isi,$message);

        return $hasil->success();

//        $hasil->success() && var_dump($hasil->getData());
        //array(1) { ["Sent"]=> array(1) { [0]=> array(2) { ["Email"]=> string(23) "elroy.hardoyo@gmail.com" ["MessageID"]=> int(18858860444541457) } } }
        */
    }

    function dapatKomisiTingTong($email,$commision_value,$isPending,$client_username,$isAgent){



        $text = '';
        if(!$isAgent){
            $text = "Please complete your Agent registration <a href='"._BPATH."marketer'>here</a>.";
        }
        $pendingText = '';
        if($isPending){
            $pendingText = "To complete the pair, please deal paid Apps";
        }

        $emailModel = new EmailModel();
        $emailModel->getByID("dapatKomisiTingTong");

        return $emailModel->sendEmail($email,array("commision_value"=>$commision_value,"is_Agent"=>$text,"is_Pending_Free"=>$pendingText,"link_more_sales"=>_BPATH."link_more_sales"));



    }
} 