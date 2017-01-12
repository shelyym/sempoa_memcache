<?php
/**
 * Created by PhpStorm.
 * User: elroy
 * Date: 3/29/16
 * Time: 8:04 PM
 */

class EmailTemplate extends WebService{

    var $access_EmailModel = "admin";
    public function EmailModel()
    {
        //create the model object
        $cal = new EmailModel();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }
    var $access_EmailLog = "admin";
    public function EmailLog()
    {
        //create the model object
        $cal = new EmailLog();
        //send the webclass
        $webClass = __CLASS__;

        //run the crud utility
        Crud::run($cal, $webClass);

        //pr($mps);
    }

    var $access_EmailTest = "admin";
    public function EmailTest()
    {

        ?>
        To
        <input type="text" class="form-control" id="to">
        <hr>
        Subject
        <input type="text" class="form-control" id="subject">
        <hr>
        HTML
        <textarea class="form-control" rows="3" id="html"></textarea>
        Text
        <textarea class="form-control" rows="3" id="text"></textarea>
        <button class="btn btn-primary" id="send">Send</button>
        <script>
            $('#send').click(function(){
                $.post('<?=_SPPATH;?>EmailTemplate/sendTest',{
                    to : $('#to').val(),
                    subject : $('#subject').val(),
                    html : $('#html').val(),
                    text : $('#text').val()
                },function(data){
                   alert(data);
                });
            });
        </script>
        <?


    }
    var $access_sendTest = "admin";
    public function sendTest(){
        $lep = new Leapmail2();
        $hasil = $lep->sendHTMLEmail($_POST['to'],$_POST['subject'],$_POST['text'],$_POST['html']);
        echo json_encode($hasil);
        die();
    }
} 