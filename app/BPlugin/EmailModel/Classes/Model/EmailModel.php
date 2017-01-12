<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 6:56 PM
 */

class EmailModel extends Model{

    var $table_name = "appear__email";
    var $main_id = "email_id";

///Default Coloms for read
    public $default_read_coloms = "email_id,email_subject,email_img_header";

//allowed colom in CRUD filter
    public $coloumlist = "email_id,email_subject,email_template_html,email_template_text,email_img_header,email_footer";
    public $email_id;
    public $email_subject;
    public $email_template_html;
    public $email_template_text;
    public $email_img_header;
    public $email_footer;

    public function overwriteForm ($return, $returnfull)
    {
        $return  = parent::overwriteForm($return, $returnfull);

        $return['email_template_html'] = new Leap\View\InputTextArea("email_template_html","email_template_html",$this->email_template_html);

        $return['email_template_text'] = new Leap\View\InputTextArea("email_template_text","email_template_text",$this->email_template_text);
        $return['email_footer'] = new Leap\View\InputTextArea("email_footer","email_footer",$this->email_footer);
        $return['email_img_header'] = new Leap\View\InputFoto("email_img_header","email_img_header",$this->email_img_header);

        return $return;
    }

    public function setVar($arr){

        $str = stripslashes($this->email_template_html);
        $text = stripslashes($this->email_template_text);
        $judul = stripslashes($this->email_subject);
        foreach($arr as $var=>$replacement) {
            $str = str_replace("[".$var."]",$replacement,$str);
            $text = str_replace("[".$var."]",$replacement,$text);
            $judul = str_replace("[".$var."]",$replacement,$judul);
        }
        $this->email_template_text = $text;
        $this->email_template_html = $str;
        $this->email_subject = $judul;
    }

    public function addTable(){
        $message = '<html><body>';
        $message .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <img src="'._BPATH._PHOTOURL.$this->email_img_header.'" alt="'.$this->email_subject.'" />
            '.$this->email_template_html.'
        </td>
    </tr>
</table>';
        $message .= "</body></html>";
        $this->email_template_html = $message;
    }

    public function sendEmail($to,$arrReplace){

        $this->setVar($arrReplace);
        $this->addTable();

        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($to,$this->email_subject,$this->email_template_text,$this->email_template_html);

        $suc =  $hasil->success();

        //should we log this ?
        $ml = new EmailLog();
        $ml->log_date = leap_mysqldate();
        $ml->log_email_id = $to;
        $ml->log_status = $suc;
        $ml->log_template = $this->email_id;
        $ml->save();

        return $suc;
    }
} 