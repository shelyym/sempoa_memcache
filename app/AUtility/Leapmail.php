<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Leapmail
 *
 * @author User
 */
class Leapmail {
    public $senderMail = "Leap Systems <info@leap-systems.com>";

    /*
     * Native function from mailjet
     */

    function sendEmailWithAttachments ()
    {
        $mj = new Mailjet();
        $params = array (
            "method"     => "POST",
            "from"       => "ms.mailjet@example.com",
            "to"         => "mr.mailjet@example.com",
            "subject"    => "Hello World!",
            "text"       => "Greetings from Mailjet.",
            "attachment" => array ("@/path/to/first/file.txt", "@/path/to/second/file.txt")
        );

        echo "success - email sent";

        return $mj->sendEmail($params);
    }

    function sendEmailWithInlineAttachments ()
    {
        $mj = new Mailjet();
        $params = array (
            "method"           => "POST",
            "from"             => "ms.mailjet@example.com",
            "to"               => "mr.mailjet@example.com",
            "subject"          => "Hello World!",
            "html"             => "<html>Greetings from Mailjet <img src=\"cid:photo1.jpg\"><img src=\"cid:photo2.jpg\"></html>",
            "inlineattachment" => array ("@/path/to/photo1.jpg", "@/path/to/photo2.jpg")
        );

        echo "success - email sent";

        return $mj->sendEmail($params);
    }

    function listContacts ()
    {
        $mj = new Mailjet();
        print_r($mj->contact());
    }

    function createList ($Lname)
    {
        $mj = new Mailjet();
        $params = array (
            "method" => "POST",
            "Name"   => $Lname
        );

        echo "success - created list " . $Lname;

        return $mj->contactslist($params);
    }

    function getList ($listID)
    {
        $mj = new Mailjet();
        $params = array (
            "method" => "VIEW",
            "ID"     => $listID
        );

        echo "success - get list " . $listID;

        return $mj->contactslist($params);
    }

    function createContact ($Cemail)
    {
        $mj = new Mailjet();
        $params = array (
            "method" => "POST",
            "Email"  => $Cemail
        );

        echo "success - created contact " . $Cemail;

        return $mj->contact($params);
    }

    function addContactToList ($listID, $contactID)
    {
        $mj = new Mailjet();
        $params = array (
            "method"    => "POST",
            "ContactID" => $contactID,
            "ListID"    => $listID
        );

        echo "success - contact " . $contactID . " added to the list " . $listID;

        return $mj->listrecipient($params);
    }

    function viewProfileInfo ()
    {
        $mj = new Mailjet();
        print_r($mj->myprofile());
    }

    function updateProfileInfo ()
    {
        $mj = new Mailjet();
        $params = array (
            "method"      => "PUT",
            "AddressCity" => "New York"
        );

        echo "success - field AddressCity changed";

        return $mj->myprofile($params);
    }

    function deleteList ($listID)
    {
        $mj = new Mailjet();
        $params = array (
            "method" => "DELETE",
            "ID"     => $listID
        );

        echo "success - deleted list " . $listID;

        return $mj->contactslist($params);
    }

    public function sendByID ($id, $judul, $msg)
    {
        $acc = new Account();
        $acc->getByID($id);

        if (!filter_var($acc->admin_email, FILTER_VALIDATE_EMAIL)) {
            return 0;
        } else {
            return $this->sendEmail($acc->admin_email, $judul, $msg);
        }
    }

    /*
     * sendByID
     */

    function sendEmail ($email, $judul, $isi)
    {
        $mj = new Mailjet();
        $params = array (
            "method"  => "POST",
            "from"    => $this->senderMail,
            "to"      => $email,
            "subject" => $judul,
            "text"    => $isi,
            "isHTML"  => TRUE
        );

        //echo "success - email sent";

        return $mj->sendEmail($params);
    }

}
